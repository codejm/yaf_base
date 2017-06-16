<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *
 *      $Id: Xiaoshuo.php 2016-07-28 07:18:49 codejm $
 */

class XiaoshuoController extends \Core_BaseCtl {

    public function init() {
    }

    /**
     * 文本文件处理
     */
    public function indexAction() {
        Yaf_Dispatcher::getInstance()->disableView();
        /* {{{ */
        $file = '/Users/codejm/Downloads/六道仙尊.txt';
        $this->readLine($file);
        /* }}} */
    }

    /**
     * 读取小说
     *
     */
    public function readLine($filename) {
        /* {{{ */
        $bline = 0;
        $line = 0;
        $splits = array();
        $fp = fopen($filename, 'r+');
        while (!feof($fp)) {
            $line ++ ;
            $txt = fgets($fp);
            $txt = iconv('gb2312', 'utf-8//IGNORE', $txt);
            $pat = $this->getSplitBookRegular();
            if (preg_match_all($pat, $txt, $split)) {
                //$line = ftell($fp);
                if($line-$bline<10) {
                    array_pop($splits);
                }
                $splits[$line] = $split;
                $bline = $line;
            }
            //echo $txt."<br/>";
        }

        foreach ($splits as $line=>$value) {
            echo $line.' '.trim($value[0][0])."\n";
        }
        //echo '<pre>'; var_dump($splits); echo '</pre>'; die();
        /* }}} */
    }

    /**
     * 小说正则格式:
     * 格式一:章一 绯色之夜;章二 站着沉默;
     * /章(零|一|二|三|四|五|六|七|八|九|十|百|千){0,10}\s+(\S+)\s/
     *
     * 格式二:第一章【走向外面的世界】;第五百八十五章 【大结局】
     * /第(零|一|二|三|四|五|六|七|八|九|十|百|千){0,10}章\s+(\S+)\s/;
     */
    public function getSplitBookRegular($split_role = 2) {
        switch ($split_role) {
            case '1':
                return '/章(零|一|二|两|三|四|五|六|七|八|九|十|百|千){1,10}\s+(\S+){0,20}?\s/';
                break;
            case '2':
                return '/第(零|一|二|两|三|四|五|六|七|八|九|十|百|千){1,10}章\s+(\S+){0,20}?\s/';
                break;
        }
    }
}
