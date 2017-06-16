<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      福彩群英会抓取
 *      $Id: fcqyh.php 2017-03-29 11:19:09 codejm $
 */



header('Content-type: text/html; charset=utf-8');
$mem = new Memcache;
$memResult = $mem->connect('10.10.16.38', 11211);
$cacheKey = 'weiqing_zt_qdfucai_qyh';
$data = null; //$mem->get($cacheKey);
if(empty($data)) {
    $url = 'http://app.sdcp.cn/fccms/site/analyse/SubareaTrackQyh2_New.jsp';
    $html = getget($url);
    if(empty($html)) die();

    //$html = file_get_contents('/Users/codejm/Desktop/temp.txt');

    # 转为utf8编码
    $html = @mb_convert_encoding($html, 'UTF-8', 'GB2312');
    # 改页面中的编码为utf8
    $html = preg_replace("/<meta([^>]*)charset=([^>]*)>/is", '<meta charset="UTF-8">', $html);
    //$html = str_replace(array('css/style201691.css'), array('http://app.sdcp.cn/fccms/site/analyse/css/style201691.css'), $html);

    $html = Selector::select($html, "/html/body[@id='pageShow']/div[@id='wrapper']/div[@class='cont_box']/table[@id='container']");
    $tr = Selector::select($html, '//tr[@bgcolor="#D9D9FF"]');
    if(empty($tr)) die();

    $data = array();
    foreach ($tr as $key=>$value) {
        $data[$key]['qi'] = substr(Selector::select($value, '//td[1]'), -3);
        $data[$key]['haostr'] = Selector::select($value, '//td[2]');
        $haostr = Selector::select($value, '//td[2]');
        $data[$key]['hao1'] = substr(Selector::select($value, '//td[2]'), -7, 3);
        $data[$key]['hao2'] = substr(Selector::select($value, '//td[2]'), -3, 3);
        $hao = array_chunk(Selector::select($value, '//td[position()>=3]'), 20);
        $data[$key]['hao'] = $hao[0];
        $hao_class = array_chunk(Selector::select($value, '//td[position()>=3]/@class'), 20);
        $data[$key]['hao_class'] = $hao_class[0];
    }

    // 当前遗漏
    $tr = Selector::select($html, '//tr[last()-2]/td[position()>1]');
    foreach ($tr as $key=>$value) {
        if($key>=20)
            break;
        $data['curryl'][$key] = intval($value);
    }

    $mem->set($cacheKey, $data, 0, 180);
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


class Selector {
    public static $dom = null;
    public static $dom_auth = null;
    public static $xpath = null;
    public static $error = null;

    public static function select($html, $selector) {
        if (empty($html) || empty($selector)) {
            return false;
        }
        return self::_xpath_select($html, $selector);
    }

    /**
     * xpath选择器
     *
     * @param mixed $html
     * @param mixed $selector
     * @return void
     * @author seatle <seatle@foxmail.com>
     * @created time :2016-10-26 12:53
     */
    private static function _xpath_select($html, $selector, $remove = false) {
        if (!is_object(self::$dom)) {
            self::$dom = new DOMDocument('1.0', 'utf-8');
        }

        // 如果加载的不是之前的HTML内容，替换一下验证标识
        if (self::$dom_auth != md5($html)) {
            self::$dom_auth = md5($html);
            @self::$dom->loadHTML('<?xml encoding="UTF-8">' . $html);
            //@self::$dom->loadHTML($html);
            self::$xpath = new DOMXpath(self::$dom);
        }

        //libxml_use_internal_errors(true);
        //self::$dom->loadHTML('<?xml encoding="UTF-8">'.$html);
        //$errors = libxml_get_errors();
        //if (!empty($errors))
        //{
        //print_r($errors);
        //exit;
        //}

        $elements = @self::$xpath->query($selector);
        if ($elements === false) {
            self::$error = "the selector in the xpath(\"{$selector}\") syntax errors";
            return false;
        }

        $result = [];
        if (!is_null($elements)) {
            foreach ($elements as $element) {
                // 如果是删除操作，取一整块代码
                if ($remove) {
                    $content = self::$dom->saveXml($element);
                } else {
                    $nodeName = $element->nodeName;
                    $nodeType = $element->nodeType; // 1.Element 2.Attribute 3.Text
                    //$nodeAttr = $element->getAttribute('src');
                    //$nodes = util::node_to_array(self::$dom, $element);
                    //echo $nodes['@src']."\n";
                    // 如果是img标签，直接取src值
                    if ($nodeType == 1 && in_array($nodeName, ['img'])) {
                        $content = $element->getAttribute('src');
                    }
                    // 如果是标签属性，直接取节点值
                    elseif ($nodeType == 2 || $nodeType == 3 || $nodeType == 4) {
                        $content = $element->nodeValue;
                    } else {
                        // 保留nodeValue里的html符号，给children二次提取
                        $content = self::$dom->saveXml($element);
                        //$content = trim(self::$dom->saveHtml($element));
                        $content = preg_replace(["#^<{$nodeName}.*>#isU", "#</{$nodeName}>$#isU"], ['', ''], $content);
                    }
                }
                $result[] = $content;
            }
        }
        if (empty($result)) {
            return false;
        }
        // 如果只有一个元素就直接返回string，否则返回数组
        return count($result) > 1 ? $result : $result[0];
    }
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="user-scalable=no, initial-scale=0.69, maximum-scale=1.0, width=device-width">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta name="format-detection" content="telephone=no">
    <meta content="telephone=no" name="format-detection">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>群英会常规分布图</title>
    <link rel="stylesheet" href="http://app.sdcp.cn/fccms/site/analyse/css/style201691.css" type="text/css" media="screen" charset="utf-8">
</head>
<body>
<div style="text-align: center; color: red; font-size: 18px;"><span id="sTitle">群英会常规分布图</span></div>
<table class='table_box' cellSpacing=1 cellPadding=0 align=center border=0 id="container">
<tr class='tabbg'>
    <td rowspan='2' align=middle class='yqi'><Strong>期号</strong></td>
    <TD class=line_r colSpan=5>一区</TD>
    <TD class=line_r colSpan=5>二区</TD>
    <TD class=line_r colSpan=5>三区</TD>
    <TD class=line_r colSpan=5>四区</TD>
    <TD rowspan='2' >五行<br/>方位</TD>
  </tr>
  <tr class='tabbg'>
      <td align=center >01</td><td align=center >02</td><td align=center >03</td><td align=center >04</td><td align=center class='line_r'>05</td><td align=center>06</td><td align=center >07</td><td align=center >08</td><td align=center >09</td><td align=center class='line_r'>10</td><td align=center>11</td><td align=center >12</td><td align=center >13</td><td align=center >14</td><td class='line_r' >15</td><td align=center >16</td><td align=center >17</td><td align=center >18</td><td align=center >19</td><td class='line_r' >20</td>
  </tr>


<?php
$counts = array();
foreach ($data as $item) {
    if(empty($item['qi'])) continue;
    echo "<tr valign='middle' nobr bgcolor=#D9D9FF><td align=center class='yqi'>{$item['qi']}</td>";
    for($i=0; $i<20; $i++) {
        if(strpos($item['hao_class'][$i], 'yl01') === false) {
            if(empty($counts[$i])) $counts[$i] = 0;
            $counts[$i]++;
        }
        echo "<td class='{$item['hao_class'][$i]}'>{$item['hao'][$i]}</td>";
    }
    echo "<td align=center class=' line_r' >{$item['hao1']},{$item['hao2']}</td></tr>";
}
echo "<tr valign='middle' nobr bgcolor=#D9D9FF><td align=center class='yqi'>次数</td>";
foreach ($counts as $value) {
    echo "<td>{$value}</td>";
}
echo "<td></td></tr>";

echo "<tr valign='middle' nobr bgcolor=#D9D9FF><td align=center class='yqi'>遗漏</td>";
foreach ($data['curryl'] as $value) {
    echo "<td>{$value}</td>";
}
echo "<td></td></tr>";
?>

 </table>
<style>
td, th {text-align:center; padding:1px}
</style>
</body>
</html>
