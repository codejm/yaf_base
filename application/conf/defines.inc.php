<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      默认定义
 *      $Id: defines.inc.php 2014-07-27 17:05:52 codejm $
 */

class ConstDefine{

    // 后台菜单数组
    public static $backendMenu = array(
        array(
            'name' => '后台主页',
            'url' => 'backend/index/index',
            'controller' => 'Index',
        ),
        array(
            'name' => '用户管理',
            'url' => '',
            'controller' => array('Members', 'role'),
            'sub' => array(
                array(
                    'name' => '用户列表',
                    'url' => 'backend/members/index',
                    'action' => 'Index',
                ),
                array(
                    'name' => '添加用户',
                    'url' => 'backend/members/add',
                    'action' => 'Add',
                ),
            ),
        ),
        array(
            'name' => '新闻管理',
            'url' => '',
            'controller' => array('News'),
            'sub' => array(
                array(
                    'name' => '新闻列表',
                    'url' => 'backend/news/index',
                    'action' => 'Index',
                ),
                array(
                    'name' => '添加新闻',
                    'url' => 'backend/news/add',
                    'action' => 'Add',
                ),
            ),
        ),
    );
}

?>
