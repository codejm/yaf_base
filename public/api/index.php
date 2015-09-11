<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *
 *      $Id: service.php 2014-08-28 15:57:52 codejm $
 */

class API {
    /**
     * the doc info will be generated automatically into service info page.
     * @params
     * @return
     */
    public function some_method($parameter, $option = 'foo') {
        $data = array(1, 2, 3, 4);
        return $data;
    }

    protected function client_can_not_see() {
    }
}

$service = new Yar_Server(new API());
$service->handle();

?>
