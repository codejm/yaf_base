<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *
 *      $Id: test.php 2016-12-05 14:18:56 codejm $
 */

use PhpParser\Error;
use PhpParser\ParserFactory;

// 常用目录定义
/* {{{ */
date_default_timezone_set('PRC');
header('Content-type: text/html; charset=utf-8');
define('DS', '/');
define('PUBLIC_PATH', dirname(__FILE__).DS);
define('BASE_PATH', realpath(dirname(__FILE__).DS.'..').DS);
define('APP_PATH', realpath(dirname(__FILE__).DS.'..'.DS.'application').DS);
/* }}} */

// composer
require_once BASE_PATH.'vendor/autoload.php';
ini_set('xdebug.max_nesting_level', 3000);

$code = "<?php
echo 'Hi ';
getTarget();
";
$parser = (new ParserFactory)->create(ParserFactory::PREFER_PHP5);

try {
    $stmts = $parser->parse($code);
    // $stmts is an array of statement nodes
} catch (Error $e) {
    echo 'Parse Error: ', $e->getMessage();
}

echo '<pre>'; var_dump($stmts); echo '</pre>'; die();

exit;
class Test {
    public function async() {

        $start = microtime(true);
        $url = "http://waimai.baidu.com/waimai?qt=poisug";  //随意的一个接口
        $i = 50; //假设请求N次
        do {
            $gen[$i] = $this->_request($url);
            //实际应用中可能在多次请求之间有其他事情要处理，否则我们可以直接使用curl_multi
            //suppose i can do something here
            $i --;
        }while($i);

        $ret = $this->_dealGen($gen);
        var_dump($ret);
        $end = microtime(true);
        echo $end - $start;

    }

    protected function _request($url) {

        $mh = curl_multi_init();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 7);
        curl_multi_add_handle($mh, $ch);
        do {
            $mrc = curl_multi_exec($mh, $active);
            //可以看到很多参考代码这里是sleep(),其实浪费了程序执行的时间
            yield null;  //先去请求，不用等待结果
        } while ($active > 0);

        $raw = curl_multi_getcontent($ch);
        curl_multi_remove_handle($mh, $ch);
        curl_multi_close($mh);
        yield $raw;
    }

    protected function _dealGen($gens) {
        $ret = array();
        do {
            $running = false;
            foreach ($gens as $id => $gen) {
                if ($gen->valid()) {
                    //有任意没处理完的yield就继续进行处理
                    $running = true;
                    $gen->next();
                    $tmp = $gen->current();
                    if ($tmp !== null) {
                        $ret[$id] = $tmp;
                    }
                }
            }
        } while ($running);
        return $ret;
    }
}

$tclass = new Test();
$tclass->async();
exit;
echo strtoupper('1232aaaa123AAA'); exit;
$url = 'http://manager.i3618.com.cn/system/org/findClassOrgs';
$arr = array(
    'pageSize' => 1,
    'currentPage' => 1,
    'sessionId' => '624090c1-2a16-4db9-b027-03aeb555515b!121362464'
);
echo getpost($url, $arr, 1);
//$arr = http_build_query($arr);

//echo request($url, 'POST', $arr);

/**
 * Make a HTTP request.
 *
 * @param string $url
 * @param string $method
 * @param array  $params
 * @param array  $options
 *
 * @return array
 */
function request($url, $method = 'POST', $params = array(), $options = array()) {

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_HEADER, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 0);

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, 1);
    //curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));
    curl_setopt($curl, CURLOPT_POSTFIELDS, $params);

    $response = curl_exec($curl);

    return $response;
}


/**
 *  curl方式post数据  $arr数组用来设置要post的字段和数值 help::getpost("http://www.123.com",$array);
 *  $array = array('name'=>'good','pass'=>'wrong');
 *
 */
function getpost($URL, $arr, $build=1, $header=false) {
    if($build)
        $arr = http_build_query($arr);

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

?>
