<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      初始化, 引导程序
 *      $Id: Bootstrap.php 2014-07-27 13:48:46 codejm $
 */

class Bootstrap extends \Yaf_Bootstrap_Abstract {

    // 配置初始化
    public function _initConfig(\Yaf_Dispatcher $dispatcher) {
        // 加载默认定义
        \Yaf_Loader::import(APP_PATH.'/conf/defines.inc.php');
	}


    // 是否显示错误提示
    public function _initError(\Yaf_Dispatcher $dispatcher) {
        $config = \Yaf_Application::app()->getConfig();
        if($config['application']['showErrors']) {
            error_reporting(-1);
        } else {
            error_reporting(0);
        }
    }

    // 注册插件
    public function _initPlugin(\Yaf_Dispatcher $dispatcher) {
        // 初始化模版引擎 twig
        $Twig = new TwigPlugin();
        $dispatcher->registerPlugin($Twig);
    }

    // 路由
    public function _initRoute(\Yaf_Dispatcher $dispatcher) {
        $router = Yaf_Dispatcher::getInstance()->getRouter();

        $route['backend'] = new Yaf_Route_Rewrite(
            '/(backend|backend/)$',
            array(
                'controller' => 'index',
                'action' => 'index',
                'module' => 'backend'
            )
        );

        //使用路由器装载路由协议
        foreach ($route as $k => $v) {
            $router->addRoute($k, $v);
        }
        Yaf_Registry::set('rewrite_route', $route);
    }

    /**
     * 初始化多语言包，判断优先级：GET参数 > COOKIE > 浏览器ACCEPT_LANGUAGE > 默认zh_CN
     * @param Yaf_Dispatcher $dispatcher
     */
    public function _initI18n(Yaf_Dispatcher $dispatcher) {
        $lang_map = array(
            'zh-cn' => 'zh_CN',
            'zh-tw' => 'zh_TW',
            'en-us' => 'en_US',
        );

        //检查GET参数中的lang
        if(isset($_GET['lang']) && isset($lang_map[$_GET['lang']])) {
            $lang = $lang_map[$_GET['lang']];
            if((isset($_COOKIE['lang']) && $_GET['lang'] != $_COOKIE['lang']) || !isset($_COOKIE['lang'])) {
                //若设置了lang，则写入cookie
                Tools_help::setcookie('lang', $_GET['lang'], 86400*365);
            }
        }

        //若没有，检查COOKIE中的lang
        if(!isset($lang) && isset($_COOKIE['lang'])) {
            $lang = $lang_map[$_COOKIE['lang']];
        }

        //若没有，检查浏览器传的ACCEPT_LANGUAGE中首选
        if(!isset($lang) && isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            //"zh-cn,zh;q=0.8,en-us;q=0.5,en;q=0.3"
            $arr = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
            foreach($arr as $item) {
                $temp = explode(';',$item);
                if (isset($temp[0]) && isset($lang_map[$temp[0]])) {
                    $lang = $lang_map[$temp[0]];
                }
                break;
            }
        }

        //没有则设置为zh_CN
        if (!isset($lang) || !in_array($lang, array_values($lang_map))) {
            $lang = $lang_map['zh-cn'];
        }

        // 加载对应语言包
        $lang_arr = require APP_PATH.'conf/lang/'.$lang.'.php';
        Yaf_Registry::set('lang_arr', $lang_arr);

        // 记录
        Yaf_Registry::set('lang', $lang);
    }

    /**
     * 系统级错误跳转到首页
     * @param int errorCode
     * @param string error detail
     *
     */
    public static function errorHandler($error, $errstr) {
        die($errstr);
    }

    /**
     * 设定异常捕获
     * application.dispatcher.throwException=0
     * application.dispatcher.catchException=0
     *
     */
    public function _initErrorHandler(\Yaf_Dispatcher $dispatcher) {
        $dispatcher->setErrorHandler(array(get_class($this), "errorHandler"));
    }


}

?>
