<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      首页
 *      $Id: Index.php 2014-07-27 18:10:47 codejm $
 */

class IndexController extends \Core_BaseCtl {

    // 默认Action
    public function indexAction() {
        echo 2; exit;
    }

    public function testAction() {
        echo $this->geta('name');
        exit;
    }
}

?>
