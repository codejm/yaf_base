<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *
 *      $Id: client.php 2014-08-28 15:58:19 codejm $
 */

function callback($retval, $callinfo) {
     echo '<pre>'; var_dump($retval); echo '</pre>';
}

function error_callback($type, $error, $callinfo) {
    error_log("error".$error);
}

Yar_Concurrent_Client::call('http://127.0.0.1/user/api3/', 'some_method', array('parameters1'), 'callback');
Yar_Concurrent_Client::call('http://127.0.0.1/user/api3/', 'some_method', array('parameters2'));   // if the callback is not specificed,
// callback in loop will be used
Yar_Concurrent_Client::call('http://127.0.0.1/user/api3/', 'some_method', array('parameters3'), 'callback', 'error_callback', array(YAR_OPT_PACKAGER => 'json'));
//this server accept json packager
Yar_Concurrent_Client::call('http://127.0.0.1/user/api3/', 'some_method', array('parameters4'), 'callback', 'error_callback', array(YAR_OPT_TIMEOUT=>1));
//custom timeout
Yar_Concurrent_Client::loop('callback', 'error_callback'); //send the requests,


?>
