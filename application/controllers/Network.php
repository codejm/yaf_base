<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *
 *      $Id: Network.php 2016-09-23 09:29:22 codejm $
 */

class NetworkController extends \Core_BaseCtl {

    /**
     *
     */
    public function indexAction() {
        /* {{{ */
        /* }}} */
    }

    public function httpsAction() {
        /* {{{ */
        $url = 'https://app.qdgxjzw.com/iparking-api-app-qd/pay/';
        echo Tools_help::getget($url); exit;
        /* }}} */
    }

}

?>
