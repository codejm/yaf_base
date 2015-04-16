yaf base framework from codejm
====================================================================================================
## 功能
    - yaf 基础
    - twig模版(module模版放module里)
    - 缓存
    - 文件上传
    - 验证码
    - 后台crud生成
    - model属性验证
    - 多语言站点
    - send Mail
    - PHPExcel
    - 加密算法(Encrypt3des, Hashids)
    - ...(后期将继续添加)

## 安装

### 运行环境
    - 运行环境:php(5.3及以上)+mysql web服务器推荐使用nginx
    - 框架:yaf(需安装php扩展)
    - composer(生产环境优化自动加载：composer dump-autoload --optimize)

### 获取代码
``` shell
git clone https://github.com/codejm/yaf_base.git app
cd app
composer install
```

### nginx 配置

``` nginx
server
	{
		listen       80;
		server_name www.yaf.com;
		index index.php;
		root  /wwwroot/yaf/public;

		location ~ .*\.(php|php5)?$
			{
				try_files $uri =404;
				fastcgi_pass  unix:/tmp/php-cgi.sock;
				fastcgi_index index.php;
				include fcgi.conf;
			}

        if (!-e $request_filename) {
            rewrite ^/(.*\.(js|ico|gif|jpg|png|css|bmp|html|xls)$) /$1 last;
            rewrite ^/(.*) /index.php?$1 last;
        }

		access_log off;

	}
```

## CLI 模式
### 运行方式
``` php
php cli.php request_uri="/controller/action"
```

## coding

### 目录结构
    ▾ application/      -- 应用程序核心目录
      ▾ conf/           -- 配置文件目录
        ▸ lang/         -- 语言包
          application.ini*  -- 总配置
          defines.inc.php*  -- 系统公共常量
      ▸ controllers/    -- 默认模块controller
      ▾ library/        -- 组件目录
        ▸ Cache/        -- 缓存类
        ▸ Captcha/      -- 验证码
        ▸ Core/         -- 框架核心
        ▸ Files/        -- 文件相关:上传文件
        ▸ Tools/        -- 帮助类
        ▸ Validation/   -- 验证类
        ▸ vendor/       -- composer文件目录
      ▸ models/         -- model 目录
      ▸ modules/        -- 模块目录
      ▸ plugins/        -- 插件目录
      ▸ views/          -- 默认模块view
        Bootstrap.php*  -- 程序引导初始化文件
    ▸ data/             -- 数据生成工具
    ▸ public/           -- 站点目录
    ▸ runtime/          -- 运行时缓存
      composer.json*    -- composer 配置文件
      composer.lock*
      README.md*

### 后台代码生成[根据ace模版生成,public 目录提供ace模版]
* 修改 ./data/crud-admin/src/crud.php 数据库配置
* $ php crud.php
* 复制对应文件到程序对应目录

### cache code
``` php
$config = \Yaf_Application::app()->getConfig()->cache->toArray();
$cache = \Cache_Cache::create($config);
$cache->set('adminUser', $data);
echo '<pre>'; var_dump($cache->get('adminUser')); echo '</pre>';exit;
```
### send mail
``` php
$mail = new PHPMailer();
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.163.com;';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'codejm@163.com';                 // SMTP username
$mail->Password = 'password';                           // SMTP password
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465;                                    // TCP port to connect to

$mail->From = 'codejm@163.com';
$mail->FromName = 'codejm';
$mail->addAddress('codejm@qq.com', 'codejm');     // Add a recipient

$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}
```





## yaf 相关

### yaf安装
    - php官方 http://pecl.php.net/package/yaf
    - github https://github.com/laruence/php-yaf

### yaf帮助文档
    - http://cn2.php.net/manual/en/book.yaf.php
