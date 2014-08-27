<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *
 *      $Id: Captcha.php 2014-07-29 22:08:52 codejm $
 */

class CaptchaController extends \Core_BaseCtl {

    public function createAction() {
        Captcha_Captcha::generate(4);
        exit();
    }

}

?>
