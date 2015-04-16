<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      rbac 权限判断
 *      $Id: Rbac_core.php 2015-04-07 14:39:57 codejm $
 */

class Rbac_Core {
    private static $_rbac = null;

    public static function getInstance() {/*{{{*/
        if (null === self::$_rbac) {
            $configarr = \Yaf_Registry::get('configarr');
            $config = array(
            'host' => $configarr['database']['host'],
            'adapter' => 'pdo_mysql',
            'dbname' => $configarr['database']['dbname'],
            'tablePrefix' => $configarr['database']['pre'].'rbac_',
            'user' => $configarr['database']['username'],
            'pass' => $configarr['database']['password'],
            );
            self::$_rbac = new PhpRbac\Rbac('', $config);
        }

        return self::$_rbac;
    }/*}}}*/

    public static function getRoles(){
        $rbac = self::getInstance();
        return $rbac->Roles;
    }

    public static function getPermissions(){
        $rbac = self::getInstance();
        return $rbac->Permissions;
    }
}
