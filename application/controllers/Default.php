<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      首页
 *      $Id: Default.php 2014-07-27 18:10:47 codejm $
 */

class DefaultController extends \Core_BaseCtl {

    // 默认Action
    public function indexAction() {

    }


    public function testAction() {
        echo $this->getg('id').'_'.$this->getg('name');
        phpinfo();
        exit;
    }
}

?>
