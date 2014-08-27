<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      整个程序Contrller父类
 *      $Id: BaseController.php 2014-07-27 20:16:16 codejm $
 */

class Core_BaseCtl extends \Yaf_Controller_Abstract {
    public $moduleName;
    public $controllerName;
    public $actionName;
    public $curr_url;
    public $lang_arr;

    /**
     * 初始化
     *
     */
    public function init() {
        $this->moduleName = \Yaf_Dispatcher::getInstance()->getRequest()->getModuleName();
        $this->controllerName = \Yaf_Dispatcher::getInstance()->getRequest()->getControllerName();
        $this->actionName = \Yaf_Dispatcher::getInstance()->getRequest()->getActionName();
        $this->curr_url = \Yaf_Dispatcher::getInstance()->getRequest()->getRequestUri();
        $this->lang_arr = \Yaf_Registry::get('lang_arr');

        $this->_view->assign("config", \Yaf_Application::app()->getConfig()->toArray());
        $this->_view->assign("curcontroller", $this->controllerName);
        $this->_view->assign("curaction", $this->actionName);
        $this->_view->assign("langArr", $this->lang_arr);
    }

    /**
     * 应用程序结束
     *
     */
    protected function _exit(){
        exit();
    }

    /**
     *
     *
     */
    protected function errorStr($msg, $start='<div class="alert alert-danger">', $stop='</div>') {
        return $start.$msg.$stop;
    }

    /**
     * 返回上一页并显示错误
     *
     */
    protected function error($msg, $type='ErrorMessage') {
        // 验证失败
        Tools_help::setSession($type, $msg);
        if(isset($_SERVER['HTTP_REFERER'])) {
            header ("Location: ".$_SERVER['HTTP_REFERER']);
        } else {
            $url = Tools_help::url(strtolower($this->moduleName).'/'.strtolower($this->controllerName).'/index');
            header ("Location: ".$url);
        }
        $this->_exit();
    }

    /**
     * get
     *
     */
    protected function getg($name, $default = ''){
        $value = $this->getRequest()->get($name, $default);
        $value = Tools_help::filter($value);
        return $value;
    }

    /**
     * post
     *
     */
    protected function getp($name, $default = ''){
        $value = $this->getRequest()->getPost($name, $default);
        $value = Tools_help::filter($value);
        return $value;
    }

    /**
     * request
     *
     */
    protected function getParam($name, $default = '') {
        $value = $this->getRequest()->getParam($name, $default);
        $value = Tools_help::filter($value);
        return $value;
    }

    /**
     * getallpost
     *
     */
    protected function getAllPost() {
        return $_POST;
    }
}

?>
