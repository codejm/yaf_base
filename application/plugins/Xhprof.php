<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      Xhprof php 性能分析
 *      $Id: Xhprof.php 2015-08-25 11:54:23 codejm $
 */

class XhprofPlugin extends Yaf_Plugin_Abstract {
    public function routerStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
        xhprof_enable(XHPROF_FLAGS_NO_BUILTINS | XHPROF_FLAGS_CPU | XHPROF_FLAGS_MEMORY);
    }


    public function dispatchLoopShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response) {
        // stop profiler
        $xhprof_data = xhprof_disable();

        include_once BASE_PATH . '/xhprof_lib/utils/xhprof_lib.php';
        include_once BASE_PATH . '/xhprof_lib/utils/xhprof_runs.php';
        // save raw data for this profiler run using default
        // implementation of iXHProfRuns.
        $xhprof_runs = new XHProfRuns_Default();

        // save the run under a namespace "xhprof"
        $run_id = $xhprof_runs->save_run($xhprof_data, 'xhprof');

        echo '<p><a href="http://xhprof/index.php?run='.$run_id.'&source=xhprof" target="_blank">Xhprof</a></p>';
    }
}


?>
