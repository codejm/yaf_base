<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *
 *      $Id: FirstJob.php 2015-08-28 16:09:37 codejm $
 */

class JobFirst extends \Core_CJob {

    public function perform() {
        parent::perform();
        echo '<pre>'; var_dump($this->args); echo '</pre>';
        echo "\n".$this->job->payload['id'].':first job....';
        sleep(10);
    }
}

?>
