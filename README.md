yaf base framework from codejm
====================================================================================================

## 运行环境
    - 运行环境:php(5.3及以上)+mysql web服务器推荐使用nginx
    - 框架:yaf(需安装php扩展)
    - composer(生产环境优化自动加载：composer dump-autoload --optimize)

## nginx 配置

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


## coding

### 后台代码生成[根据ace模版生成,public 目录提供ace模版]
* 修改 ./data/crud-admin/src/crud.php 数据库配置
* $ php crud.php
* 复制对应文件到程序对应目录

### cache code
```
        $config = \Yaf_Application::app()->getConfig()->cache->toArray();
        $cache = \Cache_Cache::create($config);
        $cache->set('adminUser', $data);
        echo '<pre>'; var_dump($cache->get('adminUser')); echo '</pre>';exit;
```
###
