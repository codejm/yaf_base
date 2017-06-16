<?php
header("Content-type: text/html; charset=utf-8");

function curl($img) {

    $ch  = curl_init();
    $url = 'http://apis.baidu.com/apistore/idlocr/ocr'; //百度ocr api
    $header = array(
        'Content-Type:application/x-www-form-urlencoded',
        'apikey:69c2ace1ef297ce88869f0751cb1b618',
    );

    $data_temp = file_get_contents($img);
    $data_temp = urlencode(base64_encode($data_temp));
    //封装必要参数
    $data = "fromdevice=pc&clientip=127.0.0.1&detecttype=LocateRecognize&languagetype=CHN_ENG&imagetype=1&image=".$data_temp;

    curl_setopt($ch, CURLOPT_HTTPHEADER , $header); // 添加apikey到header
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // 添加参数
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch , CURLOPT_URL , $url); // 执行HTTP请求
    $res = curl_exec($ch);
    if ($res === FALSE) {
        echo "cURL Error: " . curl_error($ch);
    }
    curl_close($ch);

    $temp_var = json_decode($res,true);
    return $temp_var;

}

$wordArr = curl('/Users/codejm/Downloads/timg.jpeg');
echo '<pre>'; var_dump($wordArr); echo '</pre>'; die();
if($wordArr['errNum'] == 0) {
    var_dump($wordArr);
} else {
    echo "识别出错:".$wordArr["errMsg"];
}
