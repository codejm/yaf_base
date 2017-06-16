<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *
 *      $Id: Upload.php 2014-08-25 10:58:47 codejm $
 */

class UploadController extends \Core_BaseCtl {

    /**
     * 删除文件处理
     *
     */
    public function uploadAction() {
        $dir = 'default';
        $fileName = $this->getp('filename');
        if(!empty($fileName)){
            $_FILES['image']['name'] = $fileName;
        }

        // 处理图片等特殊数据
        $imageInfo = Tools_help::upload('image', $dir);
        $data = array();
        if(!empty($imageInfo)) {
            $data['error'] = 0;
            $data['url'] = Tools_help::fbu($imageInfo);
        }
        echo json_encode($data);
        $this->_exit();
    }

    public function picAction() {
        /* {{{ */
        $url = 'http://pic.qingdaonews.com/upload/upload.php';
        $filepath = '/Users/codejm/Pictures/ubuntu/harp_seal_pup.jpg';
        $data = array(
            'pw' => substr(md5('hiaoyezhuupload'),8,16),
            'un' => urlencode('yezhupicusers'),
            'mark' => '1',
            'max' => 600,
            'md5' => '1',
            'Filedata'=>new CURLFile(realpath($filepath))
        );

        $result = $this->getpost($url, $data);
        echo '<pre>'; var_dump($result); echo '</pre>'; die();
        /* }}} */
    }

    public function getpost($URL, $arr) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $URL);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);      //设置返回信息的内容和方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $arr);       //发送post数据
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);            //设置30秒超时
        $result = curl_exec($ch);                         //进行数据传输
        curl_close($ch);                                  //关闭
        return $result;
    }

}

?>
