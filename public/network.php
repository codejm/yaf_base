#! /usr/bin/php
<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *
 *      $Id: network.php 2016-09-23 09:31:43 codejm $
 */

$pdata = array(
    'newMobile'=>'1',
    'is_guest'=>'0',
    'os_platform'=>'macintel',
    'browser'=>'Chrome 53.0.278',
    'UrlAscid'=>''
);
$header = array(
    'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/53.0.2785.116 Safari/537.36',
    'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8',
    'Referer' => 'http://192.168.32.11/a/mobile/wel.html',
    'Cookie' => 'PHPSESSID=g9h27dvv5ljm45ajbaec284gp5'
);
$result = getpost('http://192.168.32.11/a/ajax.php?tradecode=getdeviceinfoprocess&gettype=ipgetmac', $pdata, 0, $header);

preg_match('/"DeviceID": \'(\d+)\'/', $result, $match);
if(isset($match[1])){
    $deviceid = $match[1];
} else {
    die();
}

getget('http://192.168.32.11/a/ajax.php?tradecode=get_authflag&newMobile=1&deviceid='.$deviceid);
getget('http://192.168.32.11/a/ajax.php?tradecode=net_auth&type=Guest&NewMobile=1&deviceid='.$deviceid);


$result = getpost('http://192.168.32.11/a/ajax.php?tradecode=mobileresult', array(
    'deviceid'=>$deviceid,
    'itemsid'=>'',
    'checkres'=>'',
    'is_safecheck'=>0,
    'roleid'=>2,
    'LastAuthID'=>0,
    'firsturl'=>'',
    'ascid'=>''
), 0, $header);

echo iconv('GBK', 'UTF-8//IGNORE', $result);
/**
 *  curl方式post数据  $arr数组用来设置要post的字段和数值 help::getpost("http://www.123.com",$array);
 *  $array = array('name'=>'good','pass'=>'wrong');
 *
 */
function getpost($URL, $arr, $build=1, $header=false) {
    if($build){
        $arr = http_build_query($arr);
    }

    $ch = curl_init();
    if($header){
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    }
    curl_setopt($ch, CURLOPT_URL, $URL);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);      //设置返回信息的内容和方式
    curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);       //发送post数据
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);            //设置30秒超时
    $result = curl_exec($ch);                         //进行数据传输
    curl_close($ch);                                  //关闭
    return $result;
}

function getget($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);            //设置30秒超时
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}
?>
