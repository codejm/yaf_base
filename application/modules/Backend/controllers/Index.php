<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      后台主页
 *      $Id: Index.php 2014-07-27 18:51:50 codejm $
 */

class IndexController extends \Core_BackendCtl {

    /**
     * 后台主页
     *
     */
    public function indexAction() {
        $this->_view->assign('pageTitle', '后台主页');
    }

}

?>
