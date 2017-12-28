#OS X 上安装Nginx+MySQL+PHP
以下为详细步骤：
### 安装brew
brew是OS X上一个优秀的命令行包管理工具，用它来安装一系列软件非常方便。
```
  /usr/bin/ruby -e "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install)"
```

### 安装MySQL
##### 首先我们来安装MySQL，因为它最容易安装
```
  brew install mysql
```
安装完成后为MySQL设置密码 首先无密码登录，用户名为root
```
  mysql -u root
```

##### 在MySQL中操作
```
  > update mysql.user set authentication_string="new password" where User='root'；
  > flush privileges；
  > quit
```

### 安装PHP
安装PHP7.0
```
  brew install homebrew/php/php70 homebrew/php/php70-mcrypt homebrew/php/php70-gmagick homebrew/php/php70-opcache homebrew/php/php70-xdebug
```

##### 接下来在命令行中输入
```
  export PATH="/usr/local/sbin:$PATH"  
  echo 'export PATH="/usr/local/sbin:$PATH"' >> ~/.bash_profile  
```

##### 最后输入`php -v`和`php-fpm -v`都应该显示PHP版本号7.0.x
##### 启动php-fpm
```
  sudo php-fpm
```

##### 结束php-fpm
```
  sudo pkill php-fpm
```

##### 注意:  
在终端中启动php-fpm之后未结束前不要关闭窗口，若输入其他命令应该新建窗口，非正常关闭重新启动将显示端口被占用，此时需要修改默认的端口9000为其他端口。修改方法在介绍完Nginx的安装之后在说明，因为其中涉及到Nginx的相关设置。

### 安装Nginx
最后安装Nginx，这一步有很多关键的设置，务必认真。
##### 安装
```
  brew install --with-http2 nginx
```

##### 安装后进行相关设置，打开设置文件
```
  vim /usr/local/etc/nginx/nginx.conf
```

##### 根据需要做如下修改
```
  server {
      listen       8080; #默认端口为8080
      server_name  localhost; #网站地址

      #charset koi8-r;

      #access_log  logs/host.access.log  main;

      #如果想使用80端口，需要给予权限，添加下面两行并参考下一个步骤，不需要则可以跳过
      ssl_certificate ssl/nginx.crt;
      ssl_certificate_key ssl/nginx.key;

      location / {
          root   html; #html为网站根目录，可以自己修改
          index  index.html index.htm; #添加index.php
      }
```

##### 生成密钥给予权限以使用80端口
```
  sudo mkdir /usr/local/etc/nginx/ssl/  
  sudo openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /usr/local/etc/nginx/ssl/nginx.key -out /usr/local/etc/nginx/ssl/nginx.crt
```

##### 设置Nginx支持php 在刚才的配置文件中找到以下几行，去掉前面的井号，即使注释内容生效。并做相应修改
```
  location ~ \.php$ {
      root           html; #此处的根目录应与上面的设置的一致
      fastcgi_pass   127.0.0.1:9000; #此处可以设置php-fpm默认端口
      fastcgi_index  index.php;
      fastcgi_param  SCRIPT_FILENAME  /scripts$fastcgi_script_name; #此处将/scripts$fastcgi_script_name修改为根目录$fastcgi_script_name
      include        fastcgi_params; #将此行代码与上一行对调位置
  }
```

##### 至此设置完成。
###### 启动Nginx
```
  sudo nginx
```

###### 结束/重载（配置文件）Nginx
```
  sudo nginx -s stop/reload
```

##### 关于修改php-fpm默认端口的说明
在前面Nginx配置文件注释中已经有提到一处`php-fpm`默认端口的修改，这是在Nginx中进行设置，接下来只需在`php-fpm`的配置文件中另外修改即可。文件路径``/usr/local/etc/php/7.0/php-fpm.d/www.conf`，在文件中找到`listen = 127.0.0.1:9000`进行修改即可。

---

### 参考资料： 
[yangtai的博客](http://yangtai.blog.51cto.com/334569/213861)
