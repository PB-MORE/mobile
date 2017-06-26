<?php
// +----------------------------------------------------------------------
// | JuhePHP [ NO ZUO NO DIE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2010-2015 http://juhe.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: Juhedata <info@juhe.cn-->
// +----------------------------------------------------------------------

//----------------------------------
// 健康问答查询
// 在线接口文档：http://api.chinadatapay.com/medical/health/1572
//----------------------------------

header('Content-type:text/html;charset=utf-8');


//配置您申请的appkey
$appkey = "b7a3c46ea7ef7e567d910f980221d8e5";

$num=$_REQUEST['num'];
//************1.查询周边WIFI************
$url = "http://api.chinadatapay.com/medical/health/1572";
$params = array(
"page" => $num,//请求页数，默认page=1
"rows" => "10",//每页返回的条数，默认rows=20
"id" => "",//分类ID，默认返回的是全部。这里的ID就是指分类的ID
"key" => $appkey,//应用APPKEY(应用详细页查询)
"dtype" => "",//返回数据的格式,xml或json，默认json
);
$paramstring = http_build_query($params);
    $content = juhecurl($url,$paramstring);
//    echo $content;
    $result = json_decode($content,true);
if($result){
if($result['code']=='10000'){
    echo json_encode($result);
}else{
echo $result['code'].":".$result['reason'];
}
}else{
echo "请求失败";
}
//**************************************************




//************2.按城市查询WIFI************
//$url = "http://apis.juhe.cn/wifi/region";
//$params = array(
//"city" => "",//城市名urlencode utf8;
//"page" => "",//页数，默认1
//"key" => $appkey,//应用APPKEY(应用详细页查询)
//"dtype" => "",//返回数据的格式,xml或json，默认json
//);
//$paramstring = http_build_query($params);
//$content = juhecurl($url,$paramstring);
//$result = json_decode($content,true);
//if($result){
//if($result['error_code']=='0'){
//print_r($result);
//}else{
//echo $result['error_code'].":".$result['reason'];
//}
//}else{
//echo "请求失败";
//}
//**************************************************





/**
* 请求接口返回内容
* @param  string $url [请求的URL地址]
* @param  string $params [请求的参数]
* @param  int $ipost [是否采用POST形式]
* @return  string
*/
function juhecurl($url,$params=false,$ispost=0)
{
    $httpInfo = array();
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_USERAGENT, 'JuheData');
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    if ($ispost) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_URL, $url);
    } else {
        if ($params) {
            curl_setopt($ch, CURLOPT_URL, $url . '?' . $params);
        } else {
            curl_setopt($ch, CURLOPT_URL, $url);
        }
    }
    $response = curl_exec($ch);
    if ($response === FALSE) {
//echo "cURL Error: " . curl_error($ch);
        return false;
    }
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $httpInfo = array_merge($httpInfo, curl_getinfo($ch));
    curl_close($ch);
    return $response;
}