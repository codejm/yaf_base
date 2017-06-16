<?php

/**
 *      [CodeJm!] Author CodeJm[codejm@163.com].
 *
 *      主页
 *      $Id: Index.php 2014-07-27 18:51:50 codejm $
 */

class DefaultController extends \Core_BaseCtl {

    /**
     * 后台主页
     *
     */
    public function indexAction() {
        header('HTTP/1.1 403 Forbidden');
        die();
    }


    public function testCacheAction() {
        /* {{{ */
        $config = $this->config['cache'];
        $cache = Cache_Cache::create($config, Cache_Cache::TYPE_MEMCACHE);
        $result = $cache->set('name', 'codejm', 3600);
        echo $cache->get('name');
        exit;
        /* }}} */
    }

    public function testSessionAction() {
        /* {{{ */
        foreach (range(1, 1000) as $value) {
            $v = Tools_help::getSession('i', 0);
            Tools_help::setSession('i', $v+1);
        }
        echo Tools_help::getSession('i');
        echo ' <!DOCTYPE HTML> <html> <head> <meta http-equiv="content-type" content="text/html; charset=utf-8"> <title>SessionTest</title> </head> <body> <script language="JavaScript"> function myrefresh(){ window.location.reload(); } setTimeout("myrefresh()",100); //指定1秒刷新一次 </script> </body> </html> ';
        exit;
        /* }}} */
    }
    public function testAction() {
        /* {{{ */
        $type=$this->getg('type');
        $randtime=rand(2000,3000);
        $str = $this->getp('str');
        $url = $this->getp('url'); //先获取到两个POST变量

        parse_str(parse_url(htmlspecialchars_decode(urldecode($url)),PHP_URL_QUERY ),$query);//解析url地址
        $biz = $query['__biz'];//得到公众号的biz
        ////file_put_contents('myfile2017041806', var_export($query,TRUE),FILE_APPEND);
        /*$mplistsModel=new MplistsModel();
        $MparticlesModel=new MparticlesModel();
        $mpInfo = $mplistsModel->select(array('where' => array('biz' => $biz )));
        if(!isset($mpInfo['biz'])){
            $tempInsertData=array();
            $tempInsertData['biz']=$biz;
            $tempInsertData['status']='-1';
            //$tempInsertData['status']='1';
            $tempInsertData['create_time']=time();
            $tempInsertData['collect_time']=0;
            $mp_id=$mplistsModel->insert($tempInsertData);
            $mp_name='';
        }else{
            $mp_id=$mpInfo['id'];
            $mp_name=$mpInfo['name'];
        }*/
        if($type=='json'){
            $str=str_replace("\\", "", $str);
            ////file_put_contents('myfile2017041802', var_export($json,TRUE),FILE_APPEND);
            ////file_put_contents('myfile2017041800', var_export($url,TRUE),FILE_APPEND);
        }
        $json = json_decode($str,true);//首先进行json_decode
        if(empty($json)) {
            $json = json_decode(htmlspecialchars_decode($str), true);//如果不成功，就增加一步htmlspecialchars_decode
        }
        if($json=='NULL'||var_export($url,TRUE)=='NULL'){
            //$mplistsModel->update(array('biz'=>$biz),array('status'=>0));
        }
        $geng=0;
        $json = array (
  'list' =>
  array (
    0 =>
    array (
      'comm_msg_info' =>
      array (
        'id' => 1000000315,
        'type' => 49,
        'datetime' => 1494165787,
        'fakeid' => '2391578458',
        'status' => 2,
        'content' => '',
      ),
      'app_msg_ext_info' =>
      array (
        'title' => '【宜阳家校在线】《父母课堂》读后感—— 教子心得',
        'digest' => '转眼之间，孩子已经上六年级了。现在生孩子容易，养孩子难，怎样教育孩子更是难上加难，教育一直是家长老师乃至教育',
        'content' => '',
        'fileid' => 511149810,
        'content_url' => 'http:\\\\/\\\\/mp.weixin.qq.com\\\\/s?__biz=MjM5MTU3ODQ1OA==&amp;mid=2658633460&amp;idx=1&amp;sn=f2f75efd9751912ea9f52f3b320befa3&amp;chksm=bd3046c18a47cfd716c9d7c3e0e1a491297f0a845158048277cdfcd65876e0162129b8a16348&amp;scene=27#wechat_redirect',
        'source_url' => '',
        'cover' => 'http:\\\\/\\\\/mmbiz.qpic.cn\\\\/mmbiz_jpg\\\\/dOEOXa3fUQFNpBSF3CO8YeFo0mAJBGicS6zOjgdvspheSwDth7LydBOicmFdLZWR95Cp3SibOGZSwaibaUGk7Z1OaQ\\\\/0?wx_fmt=jpeg',
        'subtype' => 9,
        'is_multi' => 0,
        'multi_app_msg_item_list' =>
        array (
        ),
        'author' => '',
        'copyright_stat' => 100,
      ),
    ),
    1 =>
    array (
      'comm_msg_info' =>
      array (
        'id' => 1000000314,
        'type' => 49,
        'datetime' => 1494072171,
        'fakeid' => '2391578458',
        'status' => 2,
        'content' => '',
      ),
      'app_msg_ext_info' =>
      array (
        'title' => '【宜阳《父母课堂》读后感】和孩子一起共同努力开创美好的未来',
        'digest' => '&nbsp;现代社会中孩子在一个家庭中是宝贝，重中之重，但怎样才能将自己的孩子教育好，培养得更加出色呢？我觉得应在培养',
        'content' => '',
        'fileid' => 511149807,
        'content_url' => 'http:\\\\/\\\\/mp.weixin.qq.com\\\\/s?__biz=MjM5MTU3ODQ1OA==&amp;mid=2658633457&amp;idx=1&amp;sn=3b053c80304b8892ad359d5d90b199b0&amp;chksm=bd3046c48a47cfd29c7956437eb6008d024875ffd09f6c175f54dc5b07c039f14f236db54373&amp;scene=27#wechat_redirect',
        'source_url' => '',
        'cover' => 'http:\\\\/\\\\/mmbiz.qpic.cn\\\\/mmbiz_jpg\\\\/dOEOXa3fUQHtibzkic0icSAFOCYuIk330RymFfAp2TUYfCRbxFOEHsqySTeU2GXEfezOibmp69m4qSBh5YAhOsBJDA\\\\/0?wx_fmt=jpeg',
        'subtype' => 9,
        'is_multi' => 0,
        'multi_app_msg_item_list' =>
        array (
        ),
        'author' => '',
        'copyright_stat' => 100,
      ),
    ),
    2 =>
    array (
      'comm_msg_info' =>
      array (
        'id' => 1000000313,
        'type' => 49,
        'datetime' => 1493894752,
        'fakeid' => '2391578458',
        'status' => 2,
        'content' => '',
      ),
      'app_msg_ext_info' =>
      array (
        'title' => '【宜阳工会在线】宜人教师工作坊实践类培训之“指尖上的创‘皂’”',
        'digest' => '&nbsp;&nbsp;&nbsp;&nbsp;今天下午，宜人教师工作坊进行了实践类培训，开展了“指尖上的创‘皂’”手工皂DIY制作活动，60名教师',
        'content' => '',
        'fileid' => 511149799,
        'content_url' => 'http:\\\\/\\\\/mp.weixin.qq.com\\\\/s?__biz=MjM5MTU3ODQ1OA==&amp;mid=2658633454&amp;idx=1&amp;sn=16399ed8e421b5919c3ca476ae072b19&amp;chksm=bd3046db8a47cfcd53e032656ff7b314374e3fe35d8f84b0b230d73800ce7656b3a909147dce&amp;scene=27#wechat_redirect',
        'source_url' => '',
        'cover' => 'http:\\\\/\\\\/mmbiz.qpic.cn\\\\/mmbiz_jpg\\\\/dOEOXa3fUQFGFDIccS8gNe0JPKsW3icgcmX94g4Zs7vjXsWHRSXglL47zwUo6ia4qxGwymEoPNvmUcwo5ias0gd2g\\\\/0?wx_fmt=jpeg',
        'subtype' => 9,
        'is_multi' => 0,
        'multi_app_msg_item_list' =>
        array (
        ),
        'author' => '',
        'copyright_stat' => 100,
      ),
    ),
    3 =>
    array (
      'comm_msg_info' =>
      array (
        'id' => 1000000312,
        'type' => 49,
        'datetime' => 1493812403,
        'fakeid' => '2391578458',
        'status' => 2,
        'content' => '',
      ),
      'app_msg_ext_info' =>
      array (
        'title' => '【宜阳教学在线】现场备课比拼&nbsp;&nbsp;助力教师成长——新教师限时教学设计比赛亮出真本事',
        'digest' => '为有效检验新教师对教材的理解和把握能力，引导教师养成潜心备课的习惯，今天下午，我校组织了“宜阳新星&nbsp;&nbsp;超越自',
        'content' => '',
        'fileid' => 511149794,
        'content_url' => 'http:\\\\/\\\\/mp.weixin.qq.com\\\\/s?__biz=MjM5MTU3ODQ1OA==&amp;mid=2658633446&amp;idx=1&amp;sn=abb5eec9219924bc8d00133141c5f41e&amp;chksm=bd3046d38a47cfc5d0e3dc40fb7f40412998fa93eadd863cdd65b47395ba1601c62d5e36753e&amp;scene=27#wechat_redirect',
        'source_url' => '',
        'cover' => 'http:\\\\/\\\\/mmbiz.qpic.cn\\\\/mmbiz_jpg\\\\/dOEOXa3fUQFUMyLeyNzz06H3Y9Q0rt133GZokyp7agicA9mjNOZ8BKqWu5AibWgtgllQKU5icFM9k7EviagvWeglQw\\\\/0?wx_fmt=jpeg',
        'subtype' => 9,
        'is_multi' => 0,
        'multi_app_msg_item_list' =>
        array (
        ),
        'author' => '',
        'copyright_stat' => 100,
      ),
    ),
    4 =>
    array (
      'comm_msg_info' =>
      array (
        'id' => 1000000311,
        'type' => 49,
        'datetime' => 1493727050,
        'fakeid' => '2391578458',
        'status' => 2,
        'content' => '',
      ),
      'app_msg_ext_info' =>
      array (
        'title' => '【宜阳科技在线】七巧科技画美图——3-6年级校赛掠影',
        'digest' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;今天中午，学校分五个赛场举行了3-6年级的七巧板美画板比赛。&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;我校去年参加了',
        'content' => '',
        'fileid' => 511149789,
        'content_url' => 'http:\\\\/\\\\/mp.weixin.qq.com\\\\/s?__biz=MjM5MTU3ODQ1OA==&amp;mid=2658633441&amp;idx=1&amp;sn=4e7a9347887c1808cef780871f170bb3&amp;chksm=bd3046d48a47cfc2c1b0c04d29dc38a7b93123fde8e4cc40b79d73717f72db23c65a0c075b38&amp;scene=27#wechat_redirect',
        'source_url' => '',
        'cover' => 'http:\\\\/\\\\/mmbiz.qpic.cn\\\\/mmbiz_jpg\\\\/dOEOXa3fUQGCVm2icmxMCz5uY3Zz35iaEzJFKaiaWZOFDKEO9tNfwXYQsGhJV5KdhicFgzQylImL80oqpU6VOibF9GQ\\\\/0?wx_fmt=jpeg',
        'subtype' => 9,
        'is_multi' => 0,
        'multi_app_msg_item_list' =>
        array (
        ),
        'author' => '',
        'copyright_stat' => 100,
      ),
    ),
    5 =>
    array (
      'comm_msg_info' =>
      array (
        'id' => 1000000310,
        'type' => 49,
        'datetime' => 1493633721,
        'fakeid' => '2391578458',
        'status' => 2,
        'content' => '',
      ),
      'app_msg_ext_info' =>
      array (
        'title' => '【宜阳节庆在线】我劳动，我快乐，人人争当劳动小能手——之四年级篇',
        'digest' => '五一劳动节是一个重要的节日，为了让孩子了解和懂得尊重他人的劳动，培养孩子的劳动意识和劳动能力，我们级部',
        'content' => '',
        'fileid' => 511149787,
        'content_url' => 'http:\\\\/\\\\/mp.weixin.qq.com\\\\/s?__biz=MjM5MTU3ODQ1OA==&amp;mid=2658633436&amp;idx=1&amp;sn=fa1267fb303c0b3259a225f976f17f57&amp;chksm=bd3046e98a47cfffeccd43fedba47a8a50e3e4f2dd2222957024a1fe44a01208fcf0e36bf7cc&amp;scene=27#wechat_redirect',
        'source_url' => '',
        'cover' => 'http:\\\\/\\\\/mmbiz.qpic.cn\\\\/mmbiz_jpg\\\\/dOEOXa3fUQGYyHGiarw0vDcEMTjRDt3R0abXibbPJAIibXqia4mbR411QQR4KVBV63LS7qvInQ7Yv64qx2Wo9cByFA\\\\/0?wx_fmt=jpeg',
        'subtype' => 9,
        'is_multi' => 0,
        'multi_app_msg_item_list' =>
        array (
        ),
        'author' => '',
        'copyright_stat' => 100,
      ),
    ),
    6 =>
    array (
      'comm_msg_info' =>
      array (
        'id' => 1000000309,
        'type' => 49,
        'datetime' => 1493552362,
        'fakeid' => '2391578458',
        'status' => 2,
        'content' => '',
      ),
      'app_msg_ext_info' =>
      array (
        'title' => '【宜阳节庆在线】我的快乐五一&nbsp;之三年级篇',
        'digest' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;春光明媚的五一小长假，尽管时间有点短，来不及出远门，但三年级的孩子们还是走出了家门，跟随着爸爸妈',
        'content' => '',
        'fileid' => 511149770,
        'content_url' => 'http:\\\\/\\\\/mp.weixin.qq.com\\\\/s?__biz=MjM5MTU3ODQ1OA==&amp;mid=2658633427&amp;idx=1&amp;sn=f613ba7dadf9a80f323c023e598935d4&amp;chksm=bd3046e68a47cff00116b0268efa202c4d9a0956f38b5e1b4e1ffcd68c6bd1fef2e6805dc3c7&amp;scene=27#wechat_redirect',
        'source_url' => '',
        'cover' => 'http:\\\\/\\\\/mmbiz.qpic.cn\\\\/mmbiz_jpg\\\\/dOEOXa3fUQGCCZvxnicMYBrSwzXotKzQiaSXJeUG5nLTiasI89RWKOvs9WibzSTo6owh6SaG01WegoaEJr5dicO9lbg\\\\/0?wx_fmt=jpeg',
        'subtype' => 9,
        'is_multi' => 0,
        'multi_app_msg_item_list' =>
        array (
        ),
        'author' => '',
        'copyright_stat' => 100,
      ),
    ),
    7 =>
    array (
      'comm_msg_info' =>
      array (
        'id' => 1000000308,
        'type' => 49,
        'datetime' => 1493475160,
        'fakeid' => '2391578458',
        'status' => 2,
        'content' => '',
      ),
      'app_msg_ext_info' =>
      array (
        'title' => '【宜阳节庆在线】我的快乐五一之二年级篇',
        'digest' => '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;为庆祝“五一”国际劳动节，让学生树立爱劳动，会劳动的思想，我们二年级开展了“我是劳动小达人',
        'content' => '',
        'fileid' => 511149756,
        'content_url' => 'http:\\\\/\\\\/mp.weixin.qq.com\\\\/s?__biz=MjM5MTU3ODQ1OA==&amp;mid=2658633417&amp;idx=1&amp;sn=fee5cb8396ee3806cebc3a1197976d2c&amp;chksm=bd3046fc8a47cfea1c99dd6a5bdba7c49b380285fa6afa85492d73e2bd38eaf130fe23193b6d&amp;scene=27#wechat_redirect',
        'source_url' => '',
        'cover' => 'http:\\\\/\\\\/mmbiz.qpic.cn\\\\/mmbiz_jpg\\\\/dOEOXa3fUQE86TmI5tjqZZ4HMbbxwUcmmVYCRibpWicS6mJMEZzibx8LXlkFWwEHQ6icaZ0jztoLWdpoWibSlTDYtsA\\\\/0?wx_fmt=jpeg',
        'subtype' => 9,
        'is_multi' => 0,
        'multi_app_msg_item_list' =>
        array (
        ),
        'author' => '',
        'copyright_stat' => 100,
      ),
    ),
    8 =>
    array (
      'comm_msg_info' =>
      array (
        'id' => 1000000307,
        'type' => 49,
        'datetime' => 1493367143,
        'fakeid' => '2391578458',
        'status' => 2,
        'content' => '',
      ),
      'app_msg_ext_info' =>
      array (
        'title' => '【宜阳安全在线】五一小长假&nbsp;安全不放假',
        'digest' => '小编的话：各位家长朋友，为了让全校学生度过一个平安、快乐、充实而有意义的五一假期，学校为家长和同学们送上温',
        'content' => '',
        'fileid' => 511149753,
        'content_url' => 'http:\\\\/\\\\/mp.weixin.qq.com\\\\/s?__biz=MjM5MTU3ODQ1OA==&amp;mid=2658633403&amp;idx=1&amp;sn=17f79fa45863525c9cec6eb8af9afefb&amp;chksm=bd30468e8a47cf98c4babeeb633a5a7fd4d358e68c8cbda0f51b098fbccaf9b75a28e13c9761&amp;scene=27#wechat_redirect',
        'source_url' => '',
        'cover' => 'http:\\\\/\\\\/mmbiz.qpic.cn\\\\/mmbiz_jpg\\\\/dOEOXa3fUQFtoq1ibcFDgIA6LFmHzZicHFGsWX05AufBVB56XZbXbt91cxKMrREbGUiaFcqiaWyyN4St6pia4kY5FyA\\\\/0?wx_fmt=jpeg',
        'subtype' => 9,
        'is_multi' => 0,
        'multi_app_msg_item_list' =>
        array (
        ),
        'author' => '',
        'copyright_stat' => 100,
      ),
    ),
    9 =>
    array (
      'comm_msg_info' =>
      array (
        'id' => 1000000306,
        'type' => 49,
        'datetime' => 1493284206,
        'fakeid' => '2391578458',
        'status' => 2,
        'content' => '',
      ),
      'app_msg_ext_info' =>
      array (
        'title' => '【宜阳培训在线】学校邀请邵守刚律师做《校园伤害事故的归责和应对》讲座',
        'digest' => '今天下午，学校邀请了青岛市教育局法律顾问、北京市盈科（青岛）律师事务所邵守刚律师为全体教师做了题为《校园伤害',
        'content' => '',
        'fileid' => 511149749,
        'content_url' => 'http:\\\\/\\\\/mp.weixin.qq.com\\\\/s?__biz=MjM5MTU3ODQ1OA==&amp;mid=2658633400&amp;idx=1&amp;sn=7014b11d4e582e456d80d5afb49e63c8&amp;chksm=bd30468d8a47cf9b741de44c38c59fe23602f5c54023e506620a4ca8c4a121bbd77943e47863&amp;scene=27#wechat_redirect',
        'source_url' => '',
        'cover' => 'http:\\\\/\\\\/mmbiz.qpic.cn\\\\/mmbiz_jpg\\\\/dOEOXa3fUQGtkFkTfMAddgPtez8eLlGJGVpjLyx0ZRovRgVS31As13UdR5LEhibmyR61qjnJBNkiaCia3VV6qopUQ\\\\/0?wx_fmt=jpeg',
        'subtype' => 9,
        'is_multi' => 0,
        'multi_app_msg_item_list' =>
        array (
        ),
        'author' => '',
        'copyright_stat' => 100,
      ),
    ),
  ),
);
        if($json) {

            foreach ($json['list'] as $k => $v) {
                $type = $v['comm_msg_info']['type'];
                if ($type == 49) {//type=49代表是图文消息
                    $dataArticle=array();
                    $dataArticle['create_time'] = $v['comm_msg_info']['datetime'];//图文消息发送时间
                    $dataArticle['is_multi'] = $v['app_msg_ext_info']['is_multi'];//是否是多图文消息
                    $dataArticle['url'] = str_replace("\\", "", htmlspecialchars_decode($v['app_msg_ext_info']['content_url']));//获得图文消息的链接地址
                    $dataArticle['field_id'] = $v['app_msg_ext_info']['fileid'];//一个微信给的id
                    $dataArticle['title'] = $v['app_msg_ext_info']['title'];//文章标题
                    $dataArticle['title_encode'] = urlencode(str_replace("&nbsp;", "", $dataArticle['title']));//建议将标题进行编码，这样就可以存储emoji特殊符号了
                    $dataArticle['digest'] = $v['app_msg_ext_info']['digest'];//文章摘要
                    $dataArticle['content_source_url'] = str_replace("\\", "", htmlspecialchars_decode($v['app_msg_ext_info']['source_url']));//阅读原文的链接
                    $dataArticle['thumb_url'] = str_replace("\\", "", htmlspecialchars_decode($v['app_msg_ext_info']['cover']));//封面图片
                    $dataArticle['is_top'] = 1;
                    $dataArticle['biz'] = $biz;
                    $dataArticle['mp_id'] = 1;
                    $dataArticle['mp_name'] = '111';
                    $id=$this->baseArticle($dataArticle);
                    $id>0?$geng++:0;
                    if($dataArticle['is_multi']==1){//循环后面的图文消息
                        foreach ($v['app_msg_ext_info']['multi_app_msg_item_list'] as $kk => $vv) {
                            $dataArticle=array();
                            $dataArticle['create_time'] = $v['comm_msg_info']['datetime'];//图文消息发送时间
                            $dataArticle['is_multi'] = $v['app_msg_ext_info']['is_multi'];//是否是多图文消息
                            $dataArticle['url'] = str_replace("\\", "", htmlspecialchars_decode($vv['content_url']));//图文消息链接地址
                            $dataArticle['field_id'] = $vv['fileid'];//一个微信给的id
                            $dataArticle['title'] = $vv['title'];//文章标题
                            $dataArticle['title_encode'] = urlencode(str_replace("&nbsp;", "", $dataArticle['title']));//建议将标题进行编码，这样就可以存储emoji特殊符号了
                            $dataArticle['digest'] = $vv['digest'];//文章摘要
                            $dataArticle['content_source_url'] = str_replace("\\", "", htmlspecialchars_decode($vv['source_url']));//阅读原文的链接
                            $dataArticle['thumb_url'] = str_replace("\\", "", htmlspecialchars_decode($vv['cover']));//封面图片
                            $dataArticle['is_top'] = 0;
                            $dataArticle['is_multi'] =0;
                            $dataArticle['biz'] = $biz;
                            $dataArticle['mp_id'] = $mp_id;
                            $dataArticle['mp_name'] = $mp_name;
                            $id=$this->baseArticle($dataArticle);
                            $id>0?$geng++:0;

                        }
                    }
                }
            }

            if(count($json['list'])<10||$geng<1){

                $mplistsModel->update(array('biz'=>$biz),array('status'=>1,'collect_time'=>time()));
                /*
                $resultNextJs=$this->getNextBiz($biz);
                echo "<script> setTimeout(function(){".$resultNextJs['str']."},".$resultNextJs['randtime'].");</script>";
                return false; */
            }

        }
        return false;
        /* }}} */
    }

    public function baseArticle($dataArticle){
        $write=false;
        if($dataArticle['url']){
            parse_str(parse_url(htmlspecialchars_decode(urldecode($dataArticle['url'] )),PHP_URL_QUERY ),$query);
            $dataArticle['sn']=$query['sn'];
        }

        /*$MparticlesModel=new MparticlesModel();
        if($dataArticle['sn']){
            $result=$MparticlesModel->select(array('where' => array('biz' => $dataArticle['biz'],'sn'=>$dataArticle['sn'] )));
            !isset($result['id'])?$write=true:1;
        }else{
            $result=$MparticlesModel->select(array('where' => array('biz' => $dataArticle['biz'],'url'=>"%".$dataArticle['url']."%" )));

            !isset($result['id'])?$write=true:1;
        }*/
        $dataArticle['media_id']=md5($dataArticle['url']);

        $id=$write?$MparticlesModel->insert($dataArticle):0;
        if($id>0){
            $link=array();
            $link['site_id'] =1;
            $link['site_url_id'] =1;
            $link['id'] =$id;
            $link['url'] =$dataArticle['url'];
            $link['urlType'] = 'content';
            $link['count'] = 0;
            //$this->setlist($link);
        }
        return $id;

    }
}

?>
