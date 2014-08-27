<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *
 *      $Id: Upload.php 2014-08-25 10:58:47 codejm $
 */

class UploadController extends \Core_BackendCtl {

    /**
     * 删除文件处理
     *
     */
    public function uploadAction() {
        $dir = $this->getg('dir');
        $dirs = array('members', 'album', 'default');
        if(empty($dir) || !in_array($dir, $dirs)) {
            $dir = 'default';
        }
        $fileName = $this->getp('filename');
        if(!empty($fileName)){
            $_FILES['image']['name'] = $fileName;
        }

        // 处理图片等特殊数据
        $imageInfo = Tools_help::upload('image', $dir);
        $data = array();
        if(!empty($imageInfo)) {
            $data['url'] = Tools_help::fbu($imageInfo);
        }
        echo json_encode($data);
        $this->_exit();
    }

}

?>
