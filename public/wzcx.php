<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      违章查询
 *      $Id: wzcx.php 2014-09-15 16:41:08 codejm $
 */

// 参数 不过滤
$num = $_GET['carnum'];
$evin = $_GET['evin'];

$dsn = 'mysql:host=localhost;dbname=codejm';
$username = 'root';
$password = '1234';
$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);

// url
$url = "http://mobile.auto.sohu.com/wzcx/common/api/queryByCity.at?appKey=pc&province=370000&city=370200&carNum=%E9%B2%81{$num}&ecarBelong=37&ecarPart={$num}&ecarType=02&evin={$evin}";

$result = array('status'=>0, 'message'=>'查询失败');
$content = getget($url);
if($content) {
    $data = json_decode($content, true);
    if($data) {
        $status = $data['STATUS'];
        if($status == 0 || $status == 2) {
            // 数据库连接
            $database = new PDO($dsn, $username, $password, $options);

            // 插入用户数据
            $sql = 'INSERT INTO wzcx_user (num, evin, dateline) VALUES(:num, :evin, :dateline) ON DUPLICATE KEY UPDATE dateline=:dateline';
            $result = $database->prepare($sql);
            $row = $result->execute(array(':num'=>$num, ':evin'=>$evin, ':dateline'=>time(), ':dateline'=>time()));
        }
    }
}

echo json_encode($result);

// curl
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
