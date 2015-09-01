<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      首页
 *      $Id: Index.php 2014-07-27 18:10:47 codejm $
 */

class IndexController extends \Core_BaseCtl {

    // 默认Action
    public function indexAction() {
        Resque::setBackend($this->config['resque']['redis']['host']);
        $args = array(
            'time' => time(),
            'argarr' => array(
                'test' => 'test'
            )
        );
        $jobId = Resque::enqueue('default', 'JobFirst', $args, true); // JobFirst 任务处理类, 返回任务id
        echo 'Queued job:'.$jobId;
        phpinfo();
        exit;
    }

}

?>
