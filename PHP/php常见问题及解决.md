##### php脚本文件修改之后不能立即生效

- 原因：可能是因为安装了Opcache扩展并默认开启了
- 解决办法:找到Opcache的配置参数把 `opcache.enable=1` 的值改为0即可
- 注意：有的扩展配置不在`php.ini`中，可能有专门存放扩展配置文件的地方,可通过使用`phpinfo()`函数查看详情，在页面当中搜索`Additional .ini files parsed`，这里放的都是php扩展的配置文件所在位置

---

##### 启用OpenSSL
openssl扩展使用openssl加密扩展包，封装了多个用于加密解密相关的PHP函数，极大地方便了对数据的加密解密

1. 定位到 extension=php_openssl.dll，删除前面的分号，取消注释，从而启用OpenSSL插件。
2. 下载CA证书：[https://curl.haxx.se/ca/cacert.pem](https://curl.haxx.se/ca/cacert.pem) 全复制保存文件为cacert.pem，把文件保存到PHP\extras\ssl文件夹下
3. 定位到;`openssl.cafile=   `删去分号，取消注释，设置CA证书为刚才cacert.pem保存的路径（高版本可能没有，有没有都可）
4. 将php[根目录]下的`ssleay32.dll`和`libeay32.dll`文件，以及`php/ext`下的`php_openssl.dll` 这三个文件复制，然后粘贴到：C:/[WINDOWS]文件夹下

---

##### 启用curl扩展，防止curl报错
用来访问网页的,获取网页内容,获取其他网站数据,模拟用户访问网页
1. php.ini搜索extension=php_curl.dll   去掉前面的分号，取消注释
2. 在php.ini中设置extension_dir 指向e:\php5.4\ext; 查看该php下的ext文件夹里面是否有php_curl.dll，没有的话下载一个放进去
3. 设置windows系统环境变量，phpext, 指向e:\php5.4\ext，PHPRC指向e:\php5.4
4. 设置path环境变量，添加e:\php5.4（php主目录）
5. 重新启动apache
6. 测试curl是否设置成功
7. 如果测试还是找不到curl_init（），就将php目录下的ext目录里的php_curl.dll，和php目录下的libeay32.dll，php5ts.dll，ssleay32.dll

---

##### 错误提示
1. display_errors = Off 		默认值是 Off，关闭错误提示，改为On
2. error_reporting = E_ALL		默认值是 E_ALL,提示所有错误，改为E_ALL & ~E_NOTICE

---

##### Win7支持curl
下载地址:
- http://curl.haxx.se/download/curl-7.33.0-win64-ssl-sspi.zip
- http://curl.haxx.se/download/?C=M;O=D

1. 根据自己的操作系统位数和是否需要SSL下载相应的版本
2. 下载完成之后解压到需要使用curl命令的目录
3. 可以给Windows增加curl命令的环境变量，增加CURL_HOME环境变量，给PATH环境变量加上%CURL_HOME%; 这样就可以在命令窗口的任意目录下使用curl命令了。


---

##### xdebug安装
- 官网地址：https://xdebug.org/download.php
1. 下载官方源码包
   ```
    > wget https://xdebug.org/files/xdebug-2.5.0.tgz
   ```
2. 解压并进入目录进行编译
   ```
     > tar -zxvf xdebug-2.5.0.tgz
     > phpize
     #必须保证 /usr/local/php/bin/php-config   存在
     > ./configure --with-php-config=/usr/local/php/bin/php-config     
     > make && make install
   ```
3. 在php.ini文件中添加扩展
   ```
     # 路径视具体情况而定
     > vim /usr/local/php/etc/php.ini
     //添加下面这一句到文件中,xdebug.so所在目录视具体情况而定
     [xDebug]
     zend_extension=/usr/local/php/lib/php/extensions/no-debug-non-zts-20151012/xdebug.so
   ```
4. 重启服务即可




















------
