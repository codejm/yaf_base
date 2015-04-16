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
        switch($exception->getCode()){
        case YAF_ERR_NOTFOUND_MODULE:
        case YAF_ERR_NOTFOUND_CONTROLLER:
        case YAF_ERR_NOTFOUND_ACTION:
        case YAF_ERR_NOTFOUND_VIEW:
            header('HTTP/1.1 404 Not Found');
            header("status: 404 Not Found");
            $this->_exit();
            break;
        default:
            header('HTTP/1.0 500 Internal Server Error');
            break;
        }
        if(is_string($exception))
            echo $exception;
        else
            echo $exception->getMessage();
        $this->_exit();
	}
}

?>
