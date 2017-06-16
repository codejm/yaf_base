<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *
 *      $Id: sessionTest.php 2017-04-17 17:08:15 codejm $
 */


session_start();

foreach (range(1, 10000) as $value) {
    if(empty($_SESSION['i']))
        $_SESSION['i'] = 0;
    $_SESSION['i'] = $_SESSION['i']+1;
}
echo '<pre>'; var_dump($_SESSION['i']); echo '</pre>'; die();
