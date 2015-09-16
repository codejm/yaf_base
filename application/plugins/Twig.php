<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      注册Twig模板引擎
 *      $Id: Twig.php 2014-07-27 19:41:12 codejm $
 */

use \Suin\Yaf\Twig\Twig;

class TwigPlugin extends Yaf_Plugin_Abstract {
    public function routerStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
    }

    // 模板路径
    public function routerShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
        $config = \Yaf_Registry::get('configarr');
        $dispatcher= Yaf_Dispatcher::getInstance();
        $twig = '';
        // view 放在module 目录里
        if($request->module==$config['application']['dispatcher']['defaultModule']){
            $twig = new \Core_Twig(APP_PATH.'views', $config['twig']);
        } else {
            $twig = new \Core_Twig(APP_PATH.'modules/'.$request->module.'/views', $config['twig']);
        }

        $twig->twig->addFunction("url", new Twig_Function_Function("Tools_help::url"));
        // 语言对应
        $twig->twig->addFunction("lang", new Twig_Function_Function("Tools_help::lang"));
        // 图片路径
        $twig->twig->addFunction("fbu", new Twig_Function_Function("Tools_help::fbu"));
        // 数字验证
        $twig->twig->addFunction("is_numeric", new Twig_Function_Function("is_numeric"));

        // 处理错误提醒
        $session_key = array('ErrorMessageStop', 'ErrorMessage', 'Message');
        foreach ($session_key as $value) {
            $twig->assign($value, Tools_help::getSession($value));
            Tools_help::setSession($value, '');
        }

        $dispatcher->setView($twig);
    }
}



?>
