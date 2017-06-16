<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      File
 *      $Id: File.php 2014-07-27 18:10:47 codejm $
 */

class FileController extends \Core_BaseCtl {

    // 默认Action
    public function indexAction() {
        Yaf_Dispatcher::getInstance()->disableView();
        // 数据库延迟时间
        $filename =  Tools_help::sfbu('clublog20160803.log');
        $this->readLine($filename);

    }


    /**
     * 读取文件
     *
     */
    public function readLine($filename) {
        /* {{{ */
        $bline = 0;
        $line = 0;
        $data = array();
        $fp = fopen($filename, 'r+');
        while (!feof($fp)) {
            $line ++ ;
            $txt = trim(fgets($fp));
            if($txt) {
                $key = md5($txt);
                $data[$key] = $txt;
            }
        }

        foreach ($data as $value) {
            echo $value."\n";
        }
        /*}}}*/
    }


    public function clubtagAction() {
        /* {{{ */
        Yaf_Dispatcher::getInstance()->disableView();
        $filename = '/Users/codejm/Desktop/log2.txt';
        $bline = 0;
        $line = 0;
        $data = array();
        $fp = fopen($filename, 'r+');
        while (!feof($fp)) {
            $line ++ ;
            $txt = trim(fgets($fp));
            if(stripos($txt, '<?php') === false) {
                list($path) = explode("|", $txt);
                $data[$path] = $path;
                //echo $txt."\n";
            }
        }
        foreach ($data as $value) {
            echo $value."\n";
        }
        /* }}} */
    }

}

?>
