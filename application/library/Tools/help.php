<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *
 *      $Id: Tools_help.php 2014-07-29 17:24:01 codejm $
 */

class Tools_help {

    /**
     * 使用反斜线引用数据 防注入 前端xss过滤 (使用pdo, 省略addslashes过滤)
     */
    public static function filter($string, $force = 1, $allow='') {
        if($force) {
            if(is_array($string)) {
                foreach ($string as $key => $val) {
                    $string[$key] = self::filter($val, $force, $allow);
                }
            } else {
                $string = self::remove_xss($string, $allow);
                //$string = htmlspecialchars($string);
                //$string = addslashes($string);
            }
        }
        return $string;
    }

    /**
     * 移除HTML中的危险代码，如iframe和script
     * @param $val
     * @return unknown_type
     */
    public static function remove_xss($content,$allow='') {
        $danger = 'javascript,vbscript,expression,applet,meta,xml,blink,link,style,script,embed,object,iframe,frame,frameset,ilayer,layer,bgsound,title,base';
        $event = 'onabort|onactivate|onafterprint|onafterupdate|onbeforeactivate|onbeforecopy|onbeforecut|onbeforedeactivate|onbeforeeditfocus|'.
        'onbeforepaste|onbeforeprint|onbeforeunload|onbeforeupdate|onblur|onbounce|oncellchange|onchange|onclick|oncontextmenu|oncontrolselect|'.
        'oncopy|oncut|ondataavailable|ondatasetchanged|ondatasetcomplete|ondblclick|ondeactivate|ondrag|ondragend|ondragenter|ondragleave|'.
        'ondragover|ondragstart|ondrop|onerror|onerrorupdate|onfilterchange|onfinish|onfocus|onfocusin|onfocusout|onhelp|onkeydown|onkeypress|'.
        'onkeyup|onlayoutcomplete|onload|onlosecapture|onmousedown|onmouseenter|onmouseleave|onmousemove|onmouseout|onmouseover|onmouseup|'.
        'onmousewheel|onmove|onmoveend|onmovestart|onpaste|onpropertychange|onreadystatechange|onreset|onresize|onresizeend|onresizestart|'.
        'onrowenter|onrowexit|onrowsdelete|onrowsinserted|onscroll|onselect|onselectionchange|onselectstart|onstart|onstop|onsubmit|onunload';

        if(!empty($allow)) {
            $allows = explode(',',$allow);
            $danger = str_replace($allow,'',$danger);
        }
        $danger = str_replace(',','|',$danger);
        //替换所有危险标签
        $content = preg_replace("/<\s*($danger)[^>]*>[^<]*(<\s*\/\s*\\1\s*>)?/is",'',$content);
        //替换所有危险的JS事件
        $content = preg_replace("/<([^>]*)($event)\s*\=([^>]*)>/is","<\\1 \\3>",$content);
        return $content;
    }

    /**
     * 获取完整上传地址
     *
     */
    public static function fbu($url='') {
        $config = \Yaf_Application::app()->getConfig()->toArray();
        $uploaddir = $config['application']['site']['uploadUri'];

        $uploadBaseUrl = rtrim('http://' . $_SERVER['HTTP_HOST']) . '/'.$uploaddir.'/';

        if (empty($url)) {
            return $uploadBaseUrl;
        } else {
            return (stripos($url, 'http://') === 0) ? $url : $uploadBaseUrl . ltrim($url, '/');
        }
    }

    /**
     * 获取完整系统地址
     *
     */
    public static function sfbu($url='') {
        $config = \Yaf_Application::app()->getConfig()->toArray();
        $uploaddir = $config['application']['site']['uploadUri'];

        if(empty($url)){
            return PUBLIC_PATH.$uploaddir.'/';
        } else {
            return PUBLIC_PATH.$uploaddir.'/'.$url;
        }
    }

    /**
     * url 生成
     * @param string $route 路由
     * @param array  $param 参数数组
     *
     * @return string $url
     */
    public static function url($route, $params = array()) {

        $moduleName = \Yaf_Dispatcher::getInstance()->getRequest()->getModuleName();
        $controllerName = \Yaf_Dispatcher::getInstance()->getRequest()->getControllerName();
        $actionName = \Yaf_Dispatcher::getInstance()->getRequest()->getActionName();

        // 当前url
        if($route == 'curr_url') {
            $route = $moduleName.'/'.$controllerName.'/'.$actionName;
            $arr = \Yaf_Dispatcher::getInstance()->getRequest()->getParams();

            // backend sort 处理
            if(isset($arr['sort'])){
                $sort = explode(".", $arr['sort']);
                if($params['sort']  == $sort[0])
                    unset($params['sort']);
                else
                    unset($arr['sort']);
            }
            $params = array_merge($arr, $params);
            if(isset($params['sort'])){
                if(stripos($params['sort'], '.desc') !== false){
                    $params['sort'] = str_ireplace('.desc', '', $params['sort']);
                } else {
                    $params['sort'] = $params['sort'].'.desc';
                }
            }

        } elseif($route[0]  == '/') {
            // 合并参数
            $arr = \Yaf_Dispatcher::getInstance()->getRequest()->getParams();
            $params = array_merge($arr, $params);
            if(isset($params['page'])) {
                unset($params['page']);
                $params['page'] = '';
            }
            $route = $moduleName.'/'.$controllerName.'/'.$actionName;
        }
        $config = \Yaf_Application::app()->getConfig()->toArray();
        $url = $config['application']['site']['baseUri'];
        $url = $url.$route;
        $url = rtrim($url, '/');
        foreach ($params as $key=>$value) {
            if(empty($value) && $key!='page')
                continue;
            $url .= '/'.$key.'/'.$value;
        }

        return $url;
    }

    /**
     * 获取当前语言获取字符串对应的语言
     * @param string 字符串
     * @return 对应字符串
     */
    public static function lang($str, $args=array()) {
        $lan_arr = Yaf_Registry::get('lang_arr');
        return vsprintf($lan_arr[$str], $args);
    }

    /**
     * 设置Session值
     * @param mixed $key
     * @param mixed $value
     */
    public static function setSession($key, $value) {
        Yaf_Session::getInstance()->set($key, $value);
    }

    /**
     * 获取Session值
     * @param mixed $key Usually a string, right ?
     * @return mixed
     */
    public static function getSession($key, $value = "") {
        $val = Yaf_Session::getInstance()->get($key);
        if(empty($val))
            $val = $value;
        return $val;
    }

    /**
     * 获取cookie数据 getcookie($p);
     */
    public static function setCookie($key, $value, $time) {
        $config = \Yaf_Application::app()->getConfig()->toArray();
        $pre = $config['application']['cookie']['pre'];

        $key = $pre.$key;
        if(is_array($value))
            $value = json_encode($value);
        setcookie($key, $value, time()+$time, '/');
    }

    /**
     * 获取cookie数据 getcookie($p);
     */
    public static function getCookie($key, $value = "") {
        $config = \Yaf_Application::app()->getConfig()->toArray();
        $pre = $config['application']['cookie']['pre'];

        $key = $pre.$key;
        $value = isset($_COOKIE[$key]) ? $_COOKIE[$key] : $value;
        $value = json_decode($value, true);
        return $value;
    }


    /**
     * 加密方式
     *
     */
    public static function hash($password) {
        return md5($password);
    }

    /**
     * 字段输出
     *
     */
    public static function arraytofields($array) {
        return '`'.implode('`,`', $array ).'`';
    }

    /**
     * 分页函数
     * @param $cur int  当前页码
     * @param $total int  总条数
     * @param $size int 每页条数
     * @param $url string  URL
     * @param $url_suffix string  URL后缀
     *
     */
    public static function pager($cur, $total, $size, $url, $url_suffix='') {
        if ($cur <= 0) {
            $cur = 1;
        }

        if ($total == 0 || $total < $size){
            $page_num = 0;
        } else {
            $page_num = floor($total / $size);
        }

        if (($total % $size) > 0) {
            $page_num++;
        }

        if ($cur > $page_num) {
            $cur = $page_num;
        }

        $cur > 5 ? $page_start = $cur - 4 : $page_start = 1;

        if ($page_start > ($page_num - 9)) {
            $page_start = $page_num - 8;
        }

        if ($page_start < 1) {
            $page_start = 1;
        }

        $cur < 5 ? $page_end = 10 : $page_end = $cur + 5;
        if ($page_end > $page_num) {
            $page_end = $page_num + 1;
        }

        $cur > 1 ? $pagestr = '<li class="prev"><a href="'.$url.'1'.$url_suffix.'"><i class="fa fa-angle-double-left"></i></a></li><li class="prev"><a href="'.$url.($cur - 1).$url_suffix.'"><i class="fa fa-angle-left"></i></a></li>' : $pagestr = '<li class="prev disabled"><a href="#"><i class="fa fa-angle-double-left"></i></a></li><li class="prev disabled"><a href="#"><i class="fa fa-angle-left"></i>';

        for ($i = $page_start; $i < $page_end; $i++){
            $pagestr .= ($i == $cur) ? '<li class="active"><a href="#">'.$cur.'</a></li>' : '<li><a href="'.$url.$i.$url_suffix.'">'.$i.'</a></li>';
        }

        if ($total == 0) {
            $pagestr .= '<li class="active"><a href="#">1</a></li>';
        }

        $cur < $page_num ? $pagestr .= '<li class="next"><a href="'.$url.($cur+1).$url_suffix.'"><i class="fa fa-angle-right"></i></a></li><li class="next"><a href="'.$url.$page_num.$url_suffix.'"><i class="fa fa-angle-double-right"></i></a></li>' : $pagestr .= '<li class="next disabled"><a href="#"><i class="fa fa-angle-right"></i></a></li><li class="next disabled"><a href="#"><i class="fa fa-angle-double-right"></i></a></li>';
        return $pagestr;
    }

    /**
     * 图片上传接口
     * @param string $input 表单名称
     * @param string $dir 路径
     * @param string $size 大小
     *
     */
    public static function upload($input, $dir, $type="image", $size="10M") {
        if(empty($_FILES[$input]['tmp_name'])){
            return false;
        }
        $subdir1 = date ('Ym');
        $subdir2 = date ('d');
        $subdir = $dir.'/'.$subdir1.'/'.$subdir2.'/';
        $dir = self::sfbu().$subdir;
        self::make_dir($dir);

        $fileUpload = new Files_FileUpload();
        $fileUpload->setInput($input);
        $fileUpload->setDestinationDirectory($dir);
        $fileUpload->setAllowMimeType($type);
        $fileUpload->setMaxFileSize($size);
        $fileUpload->setAutoFilename();
        $fileUpload->save();
        $fileInfo = $fileUpload->getInfo();
        if($fileUpload->getStatus()) {
            return $subdir.$fileInfo->filename;
        }
        return false;
    }

    /**
     * 检查文件是否存在, 否则就建立
     *
     * @param  $dir string
     * @param  $index boolean是否创建index文件
     * @return 创建结果
     */
    public static function make_dir($dir, $index = true) {
        if(!is_dir($dir)) {
            if(!self::make_dir(dirname($dir))) {
                return false;
            }
            if(!@mkdir($dir,0777)) {
                return false;
            }
            $index && @touch($dir . '/index.htm');
        }
        return true;
    }

    /**
     *  获取用户的ip，使用方法 : help:user_ip();
     */
    public static function getIp() {
        $ip = '';
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } elseif(isset($_SERVER['REMOTE_ADDR'])  && !empty($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } elseif(isset($_SERVER['HTTP_CLIENT_IP'])  && !empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
		return $ip;
    }

    /**
     * 获取客户端ip端口
     *
     */
    public static function getIpPort() {
        return (int) (getenv('REMOTE_PORT') ? getenv('REMOTE_PORT') : $_SERVER['REMOTE_PORT']);
    }


    /**
     *  curl方式post数据  $arr数组用来设置要post的字段和数值 help::getpost("http://www.123.com",$array);
     *  $array = array('name'=>'good','pass'=>'wrong');
     *
     */
    public static function getpost($URL, $arr) {
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

    /**
     * curl 方式 get数据 help::getget('http://www.123.com')
     *
     */
    public static function getget($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);            //设置30秒超时
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    /**
     * 数字转为汉字
     * @param $num_str
     * @return mixed
     */
    public static function num2han($num) {
        $number = array('〇','一','二','三','四','五','六','七','八','九');
        return str_replace(range(0,9), $number, $num);
    }

    /**
     * 根据格式获取当前时间
     *
     */
    public static function hdate($format='Y-m-d H:i:s', $time=0) {
        if(empty($time)){
            return date($format);
        }
        return date($format, $time);
    }

    /**
     * 根据参数获取当前时间戳
     *
     */
    public static function htime($date='') {
        if(empty($date)){
            return time();
        }
        return strtotime($date);
    }

    /**
     * 多久之前
     * @param $datetime
     * @return unknown_type
     */
    public static function howLongAgo($datetime) {
        $timestamp = strtotime($datetime);
        $seconds = time();

        // 年
        $time = date('Y', $seconds) - date('Y', $timestamp);
        if ($time > 0) {
            return self::hdate('Y-m-d H:i:s', $datetime);
        }

        // 月
        $time = date('m', $seconds) - date('m', $timestamp);
        if ($time > 0) {
            if ($time == 1) return '上月';
            else return self::hdate('Y-m-d H:i:s', $datetime);
        }

        // 天
        $time = date('d', $seconds) - date('d', $timestamp);
        if ($time > 0) {
            if ($time == 1) return '昨天';
            elseif ($time == 2) return '前天'; else return $time . '天前';
        }

        // 小时
        $time = date('H', $seconds) - date('H', $timestamp);
        if ($time >= 1) return $time . '小时前';

        // 分钟
        $time = date('i', $seconds) - date('i', $timestamp);
        if ($time >= 1) return $time . '分钟前';

        // 秒
        $time = date('s', $seconds) - date('s', $timestamp);
        return $time . '秒前';
    }

    /**
     * 根据生日中的月份和日期来计算所属星座*
     * @param int $birth_month
     * @param int $birth_date
     * @return string
     */
    static function get_constellation($birth_month, $birth_date) {
        //判断的时候，为避免出现1和true的疑惑，或是判断语句始终为真的问题，这里统一处理成字符串形式
        $birth_month = strval($birth_month);
        $constellation_name = array('水瓶座', '双鱼座', '白羊座', '金牛座', '双子座', '巨蟹座', '狮子座', '处女座', '天秤座', '天蝎座', '射手座', '摩羯座');
        if ($birth_date <= 22) {
            if ('1' !== $birth_month) {
                $constellation = $constellation_name[$birth_month - 2];
            } else {
                $constellation = $constellation_name[11];
            }
        } else {
            $constellation = $constellation_name[$birth_month - 1];
        }
        return $constellation;
    }

    /**
     * 根据生日中的年份来计算所属生肖
     *
     * @param int $birth_year
     * @return string
     */
    static function get_animal($birth_year, $format = '1') {
        //1900年是子鼠年
        if ($format == '2') $animal = array('子鼠', '丑牛', '寅虎', '卯兔', '辰龙', '巳蛇', '午马', '未羊', '申猴', '酉鸡', '戌狗', '亥猪');
        elseif ($format == '1') $animal = array('鼠', '牛', '虎', '兔', '龙', '蛇', '马', '羊', '猴', '鸡', '狗', '猪');
        $my_animal = ($birth_year - 1900) % 12;
        return $animal[$my_animal];
    }

    /**
     * 根据生日来计算年龄
     *
     * 用Unix时间戳计算是最准确的，但不太好处理1970年之前出生的情况
     * 而且还要考虑闰年的问题，所以就暂时放弃这种方式的开发，保留思想
     *
     * @param int $birth_year
     * @param int $birth_month
     * @param int $birth_date
     * @return int
     */
    static function get_age($birth_year, $birth_month, $birth_date) {
        $now_age = 1; //实际年龄，以出生时为1岁计
        $full_age = 0; //周岁，该变量放着，根据具体情况可以随时修改
        $now_year = date('Y', time());
        $now_date_num = date('z', time()); //该年份中的第几天
        $birth_date_num = date('z', mktime(0, 0, 0, $birth_month, $birth_date, $birth_year));
        $difference = $now_date_num - $birth_date_num;

        if ($difference > 0) {
            $full_age = $now_year - $birth_year;
        } else {
            $full_age = $now_year - $birth_year - 1;
        }
        $now_age = $full_age + 1;
        return $now_age;
    }
}

?>
