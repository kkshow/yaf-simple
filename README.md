## 项目简介 
基于 `Yaf` 稍加修改之后的一个框架，可以直接拉下来使用

## 项目提供的内容

- `Jquery v1.11.0`	：	JS组件
- `UEditor`			：	开源的文本编辑器
- `Medoo`			：	使用很简单的DB类，[文档地址](http://medoo.in/doc)
- `Csv`				：	一个加载CSV文件的类

## 部署方法

- APACHE

vhost.conf文件中配置内容如下

    <VirtualHost *:81>

    	DocumentRoot "/你的项目路径/项目名称/public"
     
    	ServerName 你的域名
     
    </VirtualHost>


- NGINX

vhost.conf文件中配置内容如下

	server {    
		listen 80;
		server_name 你的域名;
        set $root /你的项目路径/项目名称/public;
    
		root $root;
    
		location / {
			index index.php;
			try_files $uri /index.php?$args;
		}
    
        location ~ \.php$ {
	        fastcgi_pass   127.0.0.1:9000;
	        fastcgi_index  index.php;
	        fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
	        includefastcgi_params;
        }
    
        location ~ /\.ht {
    		deny  all;
        }
	}
