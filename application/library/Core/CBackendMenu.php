<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      后台菜单生成
 *      $Id: CBackendMenu.php 2014-08-06 11:16:48 codejm $
 */

class Core_CBackendMenu {
    private $menuArr;
    private $controllerName;
    private $actionName;
    private $url;

    // 构造函数
    function __construct($menu_arr, $controller_name, $action_name) {
        $this->menuArr = $menu_arr;
        $this->controllerName = $controller_name;
        $this->actionName = $action_name;
        $this->url = $controller_name.'/'.$action_name;
    }

    // get
    public function get() {
        $menustr = '<ul class="nav nav-list">';
        foreach($this->menuArr as $menu) {
            if(is_array($menu['controller'])){
                foreach($menu['controller'] as $controller) {
                    if(strtolower($controller)  ==  strtolower($this->controllerName)){
                        $active = ' class="active"';
                        break;
                    } else {
                        $active = '';
                    }
                }
            } else {
                $active = strtolower($menu['controller'])  ==  strtolower($this->controllerName) ? ' class="active"' : '';
            }
            if(isset($menu['sub'])  && !empty($menu['sub'])) {
                $menustr .= '<li'.$active.'> <a href="#" class="dropdown-toggle"> <i class="menu-icon fa fa-desktop"></i> <span class="menu-text"> '.$menu['name'].'</span> <b class="arrow fa fa-angle-down"></b> </a> <b class="arrow"></b><ul class="submenu">';

                foreach($menu['sub'] as $submenu){
                    $active = '';
                    if(stripos($submenu['url'], $this->url) !== false){
                        $active = ' class="active"';
                    }
                    $menustr .= '<li'.$active.'> <a href="'.Tools_help::url($submenu['url']).'"> <i class="menu-icon fa fa-caret-right"></i> '.$submenu['name'].'</a> <b class="arrow"></b> </li>';
                }
                $menustr .= '</ul> </li>';
            } else {
                $menustr .= '<li'.$active.'><a href="'.Tools_help::url($menu['url']).'"><i class="menu-icon fa fa-tachometer"></i><span class="menu-text"> '.$menu['name'].'</span></a><b class="arrow"></b></li>';

            }
        }
        $menustr .= '</ul>';
        return $menustr;
    }
}

?>
