<?php
//----------------------------------
// 全国WIFI调用示例代码 － 聚合数据
// 在线接口文档：
//----------------------------------

header('Content-type:text/html;charset=utf-8');
$fangshi = $_REQUEST['fangshi'];

//配置您申请的appkey
$appkey = "aa1e502f8f8324564fb8b3dbc924af2d";
$lon = $_REQUEST['lon'];
$lat = $_REQUEST['lat'];
$r = $_REQUEST['r'];
$lon = $_REQUEST['lon'];


if($fangshi==="zhoubian") {
//************1.查询周边WIFI************
    $url = "http://apis.juhe.cn/wifi/local";
    $params = array(
        "lon" => "",//经纬(如:121.538123)
        "lat" => "",//纬度(如：31.677132)
        "gtype" => "",//所传递经纬类型 1：百度  2：谷歌 3：gps
        "r" => "",//搜索范围，单位M，默认3000
        "key" => $appkey,//应用APPKEY(应用详细页查询)
        "dtype" => "",//返回数据的格式,xml或json，默认json
    );
    $paramstring = http_build_query($params);
    $content = juhecurl($url, $paramstring);
    $result = json_decode($content, true);
    if ($result) {
        if ($result['error_code'] == '0') {
            print_r($result);
        } else {
            echo $result['error_code'] . ":" . $result['reason'];
        }
    } else {
        echo "请求失败";
    }
//**************************************************
}else {


//************2.按城市查询WIFI************
    $url = "http://apis.juhe.cn/wifi/region";
    $params = array(
        "city" => "",//城市名urlencode utf8;
        "page" => "",//页数，默认1
        "key" => $appkey,//应用APPKEY(应用详细页查询)
        "dtype" => "",//返回数据的格式,xml或json，默认json
    );
    $paramstring = http_build_query($params);
    $content = juhecurl($url, $paramstring);
    $result = json_decode($content, true);
    if ($result) {
        if ($result['error_code'] == '0') {
            print_r($result);
        } else {
            echo $result['error_code'] . ":" . $result['reason'];
        }
    } else {
        echo "请求失败";
    }
//**************************************************


}


/**
* 请求接口返回内容
* @param  string $url [请求的URL地址]
* @param  string $params [请求的参数]
* @param  int $ipost [是否采用POST形式]
* @return  string
*/
function juhecurl($url,$params=false,$ispost=0){
$httpInfo = array();
$ch = curl_init();

curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
curl_setopt( $ch, CURLOPT_USERAGENT , 'JuheData' );
curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 60 );
curl_setopt( $ch, CURLOPT_TIMEOUT , 60);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
if( $ispost )
{
curl_setopt( $ch , CURLOPT_POST , true );
curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
curl_setopt( $ch , CURLOPT_URL , $url );
}
else
{
if($params){
curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
}else{
curl_setopt( $ch , CURLOPT_URL , $url);
}
}
$response = curl_exec( $ch );
if ($response === FALSE) {
//echo "cURL Error: " . curl_error($ch);
return false;
}
$httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
$httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
curl_close( $ch );
return $response;
}