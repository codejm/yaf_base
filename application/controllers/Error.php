<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      错误提示页
 *      $Id: Error.php 2014-07-27 18:53:48 codejm $
 */

class ErrorController extends \Core_BaseCtl {

    // 错误信息输出
    public function errorAction($exception) {
        if(is_string($exception))
            $this->_view->assign("message", $exception);
        else
            $this->_view->assign("message", $exception->getMessage());
		return true;
	}

}

?>
