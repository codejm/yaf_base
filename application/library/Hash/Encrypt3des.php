<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      Encrypt3des 加密 解密
 *      $Id: Encrypt3des.php 2014-09-04 17:13:12 codejm $
 */

class Hash_Encrypt3des {

    var $key = '22456213764332458492523474568754';
    var $iv ='12345678';

    /**
     * 初始化
     *
     */
    function __construct($key = NULL) {
        if(!empty($key)) {
            $this->key = $key;
        }
    }

    function pad($text) {
        $text_add = strlen($text) % 8;

        for($i = $text_add; $i < 8; $i++) {
            $text .= chr(8 - $text_add);
        }
        return $text;
    }

    function unpad($text) {
        $pad = ord($text{strlen($text)-1});
        if ($pad > strlen($text)) {
            return false;
        }
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) {
            return false;
        }
        return substr($text, 0, -1 * $pad);
    }

    /**
     * 加密
     *
     */
    function encrypt($key, $iv, $text) {
        $key = pack('H*',$key);
        $key = substr($key, 0, 16).substr($key, 0, 8);
        $text = $this->pad($text);
        $td = mcrypt_module_open(MCRYPT_3DES, '', MCRYPT_MODE_CBC, '');
        mcrypt_generic_init($td, $key, $iv);
        $encrypt_text = mcrypt_generic($td, $text);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return $encrypt_text;
    }

    /**
     * 解密
     *
     */
    function decrypt($key, $iv, $text) {
        $key = pack('H*',$key);
        $key = substr($key, 0, 16).substr($key, 0, 8);
        $td = mcrypt_module_open(MCRYPT_3DES, '', MCRYPT_MODE_CBC, '');
        mcrypt_generic_init($td, $key, $iv);
        $text = mdecrypt_generic($td, $text);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return $this->unpad($text);
    }

    /**
     * 加密
     *
     */
    public function encode($text) {
        $key = sha1($this->key);
        return base64_encode($this->encrypt($key, $this->iv, $text));
    }

    /**
     * 解密
     *
     */
    public function decode($text) {
        $text = str_replace(" ", "+", $text);
        $text = base64_decode($text);
        $key = sha1($this->key);
        return $this->decrypt($key, $this->iv, $text);
    }
}

?>
