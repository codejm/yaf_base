<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      rbac 权限判断
 *      $Id: Rbac_core.php 2015-04-07 14:39:57 codejm $
 */

class Rbac_Core extends \Core_CMode {
    public $roles_table = 'yaf_roles';
    public $permissions_table = 'yaf_permissions';
    public $rolepermissions_table = 'yaf_rolepermissions';

    // 初始化
    public function __construct() {
        parent::__construct();
        // 修改表名
    }

    // 检查权限
    public function check($rid, $permission) {
        $sql = 'select count(*) from '.$this->rolepermissions_table.' rp left join '.$this->permissions_table.' p on p.id=rp.pid where rp.rid=:rid and p.path=:path';
        $result = $this->db->prepare($sql);
        $result->execute(array(':rid'=>$rid, ':path'=>$permission));
        $row = $result->fetchColumn();
        $result->closeCursor();
        return $row;
    }

    // 赋值权限
    public function assign($rid, $permissions=null, $dateline=0) {
        $sql = 'insert into '.$this->rolepermissions_table.'(`rid`, `pid`, `dateline`) values(:rid, :pid, :dateline)';
        $this->db->beginTransaction();
        $result = $this->db->prepare($sql);

        if(is_array($permissions)){
            // 删除之前的权限添加
            $delsql = 'delete from '.$this->rolepermissions_table.' where rid=:rid';
            $delresult = $this->db->prepare($delsql);
            $delresult->execute(array(':rid'=>$rid));
            $delresult->closeCursor();

            // 循环添加
            foreach ($permissions as $item) {
                $result->execute(array(':rid'=>$rid, ':pid'=>$item, ':dateline'=>$dateline));
            }
        } else {
            // 直接添加
            $result->execute(array(':rid'=>$rid, ':pid'=>$permissions, ':dateline'=>$dateline));
        }
        $row = $this->db->commit();
        $result->closeCursor();
        return $row;
    }

    // 获取当前角色现有权限
    public function getRolePermissions($rid, $onlyId=true) {
        if(empty($rid))
            return $this->getPermissions();
        $sql = 'select * from '.$this->rolepermissions_table.' rp';
        $orderby = '';
        if(!$onlyId){
            $sql .= ' left join yaf_permissions p on rp.pid=p.id';
            $orderby = ' order by fid, ismenu asc';
        }
        $sql .= ' where rp.rid=:rid'.$orderby;
        $result = $this->db->prepare($sql);
        $result->execute(array(':rid'=>$rid));
        $data = $result->fetchAll(PDO::FETCH_ASSOC);
        $result->closeCursor();
        return $data;
    }

    // 获取单个权限
    public function getPermission($permission) {
        if(is_numeric($permission)){
            $sql = 'select * from '.$this->permissions_table.' where id=:permission';
        } else {
            $sql = 'select * from '.$this->permissions_table.' where path=:permission';
        }
        $result = $this->db->prepare($sql);
        $result->execute(array(':permissions'=>$permission));
        $data = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();
        return $data;
    }

    // 获取系统所有权限
    public function getPermissions() {
        $sql = 'select * from '.$this->permissions_table.' order by fid, ismenu asc, id asc';
        $result = $this->db->prepare($sql);
        $result->execute();
        $data = $result->fetchAll(PDO::FETCH_ASSOC);
        $result->closeCursor();
        return $data;
    }

    // 添加权限
    public function addPermission($permission) {
        $sql = 'insert into '.$this->permissions_table.'(`fid`, `name`, `path`, `ismenu`) values(:fid, :name, :path, :ismenu)';
        $result = $this->db->prepare($sql);
        $row = $result->execute(array(':fid'=>$permission['fid'], ':name'=>$permission['name'], ':path'=>$permission['path'], ':ismenu'=>$permission['ismenu']));
        $result->closeCursor();
        return $row;
    }

    // 删除权限
    public function delPermission($pid) {
        $sql = 'delete from '.$this->permissions_table.' where id=:id';
        $result = $this->db->prepare($sql);
        $row = $result->execute(array(':id'=>$pid));
        $result->closeCursor();
        return $row;
    }

    // 获取所有角色
    public function getRoles() {
        $sql = 'select * from '.$this->roles_table.' where status>0';
        $result = $this->db->prepare($sql);
        $result->execute();
        $data = $result->fetchAll(PDO::FETCH_ASSOC);
        $result->closeCursor();
        return $data;
    }

    // 获取角色
    public function getRole($role) {
        if(is_numeric($role)){
            $sql = 'select * from '.$this->roles_table.' where id=:role and status>0';
        } else {
            $sql = 'select * from '.$this->roles_table.' where name=:role and status>0';
        }
        $result = $this->db->prepare($sql);
        $result->execute(array(':role'=>$role));
        $data = $result->fetch(PDO::FETCH_ASSOC);
        $result->closeCursor();
        return $data;
    }

    // 添加角色
    public function addRole($name, $dateline, $status=1) {
        $sql = 'insert into '.$this->roles_table.'(`name`, `dateline`, `status`) values(:name, :dateline, :status)';
        $result = $this->db->prepare($sql);
        $row = $result->execute(array(':name'=>$name, ':dateline'=>$dateline, ':status'=>$status));
        $result->closeCursor();
        return $row;
    }

    // 删除角色
    public function delRole($rid) {
        $sql = 'update '.$this->roles_table.' set status=-1 where id=:id';
        $result = $this->db->prepare($sql);
        $row = $result->execute(array(':id'=>$rid));
        $result->closeCursor();
        return $row;
    }

    // 编辑角色
    public function editRole($rid, $name, $status=1) {
        $sql = 'update '.$this->roles_table.' set name=:name,status=:status where id=:id';
        $result = $this->db->prepare($sql);
        $row = $result->execute(array(':name'=>$name, ':status'=>$status, ':id'=>$rid));
        $result->closeCursor();
        return $row;
    }

    // 转菜单
    public function getMenu($rid, $onlyId=true) {
        $permissions = $this->getRolePermissions($rid, $onlyId);
        $menuArr = array();
        if($permissions){
            foreach ($permissions as $item) {
                if(!$item['ismenu'])
                    continue;
                $path = explode('/', $item['path']);
                $tmp = array(
                    'name' => $item['name'],
                    'url' => $item['path'],
                    'controller' => array(),
                    'sub' => array()
                );
                if($item['ismenu'] == -1){
                    $tmp['controller'][$path[1]] = true;
                    $menuArr[$item['id']] = $tmp;
                } else {
                    unset($tmp['sub'], $tmp['controller']);
                    $tmp['action'] = $path[2];
                    $menuArr[$item['fid']]['sub'][] = $tmp;
                    $menuArr[$item['fid']]['controller'][$path[1]] = true;
                }
            }
        }
        //echo '<pre>'; var_dump($menuArr); echo '</pre>'; die();
        return $menuArr;
    }
}
