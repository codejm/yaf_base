<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      验证方法类
 *      $Id: Validator.php 2014-08-21 21:04:53 codejm $
 */

class Validation_Validation {
    /**
     * 必填
     */
    public static function required($input = null) {
        if(is_array($input)){
            if(!empty($input))
                return true;
        } else {
            $input = $input.'';
            if(isset($input{0})){
                return true;
            }
        }
        return false;
        //return empty($input) ? false : true;
    }

    /**
     * 日期格式
     */
    public static function date($input = null, $format = 'MM/DD/YYYY') {
        if (empty($input)) {
            return true;
        }

        switch($format) {
        case 'YYYY/MM/DD':
        case 'YYYY-MM-DD':
            list($y, $m, $d) = preg_split('/[-\.\/ ]/', $input);
            break;

        case 'YYYY/DD/MM':
        case 'YYYY-DD-MM':
            list($y, $d, $m) = preg_split('/[-\.\/ ]/', $input);
            break;

        case 'DD-MM-YYYY':
        case 'DD/MM/YYYY':
            list($d, $m, $y) = preg_split('/[-\.\/ ]/', $input);
            break;

        case 'MM-DD-YYYY':
        case 'MM/DD/YYYY':
            list($m, $d, $y) = preg_split('/[-\.\/ ]/', $input);
            break;

        case 'YYYYMMDD':
            $y = substr($input, 0, 4);
            $m = substr($input, 4, 2);
            $d = substr($input, 6, 2);
            break;

        case 'YYYYDDMM':
            $y = substr($input, 0, 4);
            $d = substr($input, 4, 2);
            $m = substr($input, 6, 2);
            break;

        default:
            throw new \InvalidArgumentException("Invalid Date Format");
        }
        return checkdate($m, $d, $y);
    }

    /**
     * 最小长度
     */
    public static function minlength($input = null, $length = 0) {
        if (empty($input)) {
            return true;
        }

        return strlen(trim($input)) >= (int) $length ? true : false;
    }

    /**
     * 最大长度
     */
    public static function maxlength($input = null, $length = 0) {
        if (empty($input)) {
            return true;
        }

        return strlen(trim($input)) <= (int) $length ? true : false;
    }

    /**
     * 必须恰好是多少长度
     */
    public static function exactlength($input = null, $length = 0) {
        if (empty($input)) {
            return true;
        }

        return strlen(trim($input)) == (int) $length ? true : false;
    }

    /**
     * 必须大于
     */
    public static function greaterthan($input = null, $min = 0) {
        if (empty($input)) {
            return true;
        }

        return (float) $input > (float) $min ? true : false;
    }

    /**
     * 最大不能超过
     */
    public static function lessthan($input = null, $max = 0) {
        if (empty($input)) {
            return true;
        }

        return (float) $input < (float) $max ? true : false;
    }

    /**
     * 只有字母
     */
    public static function alpha($input = null) {
        if (empty($input)) {
            return true;
        }

        return (bool) preg_match('/^([a-z])+$/i', $input);
    }

    /**
     * 只有字母和数字
     */
    public static function alphanumeric($input = null) {
        if (empty($input)) {
            return true;
        }

        return (bool) preg_match('/^([a-z0-9])+$/i', $input);

    }

    /**
     * 是否为整形数字
     */
    public static function integer($input = null) {
        if (empty($input)) {
            return true;
        }

        if (filter_var($input, FILTER_VALIDATE_INT) !== false) {
            return true;
        }

        return false;
    }

    /**
     * 是否为float
     */
    public static function float($input = null) {
        if (empty($input)) {
            return true;
        }

        if (filter_var($input, FILTER_VALIDATE_FLOAT) !== false) {
            return true;
        }

        return false;
    }

    /**
     * 是否为数字验证
     */
    public static function numeric($input = null) {
        if (empty($input)) {
            return true;
        }

        return is_numeric($input) ? true : false;
    }

    /**
     * 邮箱验证
     */
    public static function email($input = null) {
        if (empty($input)) {
            return true;
        }

        if (filter_var($input, FILTER_VALIDATE_EMAIL) !== false) {
            return true;
        }

        return false;
    }

    /**
     * url验证
     */
    public static function url($input = null) {
        if (empty($input)) {
            return true;
        }

        if (filter_var($input, FILTER_VALIDATE_URL) !== false) {
            return true;
        }

        return false;
    }

    /**
     * 电话号码验证
     */
    public static function phone($input = null) {
        if (empty($input)) {
            return true;
        }

        return (bool) preg_match("/^13[0-9]{9}$|15[0-9]{9}$|18[0-9]{9}$/", $input);
    }

    /**
     * 邮政编码验证
     */
    public static function zipcode($input = null) {
        if (empty($input)) {
            return true;
        }

        return (bool) preg_match('/^\d{5}(-\d{4})?$/', $input);
    }

    /**
     * 必须已某个字符串开始
     */
    public static function startswith($input = null, $match = null) {
        if (empty($input)) {
            return true;
        }

        return (bool) preg_match('/^' . preg_quote($match) . '/', $input);
    }

    /**
     * 必须已某个字符串结束
     */
    public static function endswith($input = null, $match = null) {
        if (empty($input)) {
            return true;
        }

        return (bool) preg_match('/' . preg_quote($match) . '$/', $input);
    }

    /**
     * 是否包含某个字符串
     */
    public static function contains($input = null, $match = null) {
        if (empty($input)) {
            return true;
        }

        return (bool) preg_match('/' . preg_quote($match) . '/', $input);
    }

    /**
     * 正则验证
     */
    public static function regex($input = null, $regex = null) {
        if (empty($input)) {
            return true;
        }

        return (bool) preg_match($regex, $input);
    }

    /**
     * 是否保护在数组中
     */
    public static function inlist($input = null, $list = array()) {
        if (empty($input)) {
            return true;
        }

        return in_array($input, $list);
    }

    /**
     * 验证码验证
     */
    public static function captcha($input) {
        if (empty($input)) {
            return false;
        }
        $sys_captcha =  Tools_help::getSession('captcha');
        if(strtolower($input) !== $sys_captcha){;
        return false;
        }
        return true;
    }

    /**
     * ip 验证
     */
    public static function ip($input) {
        if(empty($input))
            return true;
        $result = filter_var($input, FILTER_VALIDATE_IP);
        return empty($result) ? false : true;
    }

    // PHP中身份证号的验证函数
    /**
     * * 检查身份账号的格式是否正确
     * @param  [type]  $id_card [description]
     * @return boolean          [description]
     */
    public static function checkIdentity($id_card){
        if(strlen($id_card)==18){
            return self::idcard_checksum18($id_card);
        }elseif((strlen($id_card)==15)){
            $id_card=self::idcard_15to18($id_card);
            return self::idcard_checksum18($id_card);
        }else{
            return false;
        }
    }

    // 计算身份证校验码，根据国家标准GB 11643-1999
    public static function idcard_verify_number($idcard_base){
        if(strlen($idcard_base)!=17){
            return false;
        }
        //加权因子
        $factor=array(7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2);
        //校验码对应值
        $verify_number_list=array('1','0','X','9','8','7','6','5','4','3','2');
        $checksum=0; for($i=0;$i<strlen($idcard_base);$i++){
            $checksum += substr($idcard_base,$i,1) * $factor[$i];
        }
        $mod=$checksum % 11;
        $verify_number=$verify_number_list[$mod]; return $verify_number;
    }

    //将15位身份证升级到18位
    public static function idcard_15to18($idcard){
        if(strlen($idcard)!=15){
            return false;
        }else{
            // 如果身份证顺序码是996 997 998 999，这些是为百岁以上老人的特殊编码
            if(array_search(substr($idcard,12,3),array('996','997','998','999')) !==false){
                $idcard=substr($idcard,0,6).'18'.substr($idcard,6,9);
            }else{
                $idcard=substr($idcard,0,6).'19'.substr($idcard,6,9);
            }
        }
        $idcard=$idcard.self::idcard_verify_number($idcard);
        return $idcard;
    }

    //18位身份证校验码有效性检查
    public static function idcard_checksum18($idcard){
        if(strlen($idcard)!=18){
            return false;
        }
        $idcard_base=substr($idcard,0,17);
        if(self::idcard_verify_number($idcard_base)!=strtoupper(substr($idcard,17,1))){
            return false;
        }else{
            return true;
        }
    }

}
