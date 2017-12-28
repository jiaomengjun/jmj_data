# 安装PHP  redis扩展
###### 我们需要确保已经安装了 redis 服务，接下来让我们安装 PHP redis 驱动。
### Linux

- 下载地址为:[https://github.com/phpredis/phpredis/releases]

1. #### 编译安装

   ###### 以下操作需要在下载的 phpredis 目录中完成

   ```
     > wget https://github.com/phpredis/phpredis/archive/2.2.4.tar.gz
     > tar xzf phpredis-2.2.4				 # 解压
     > cd phpredis-2.2.4                      # 进入 phpredis 目录
     > /usr/local/php/bin/phpize              # 执行phpize命令,
     > ./configure --with-php-config=/usr/local/php/bin/php-config
     > make && make install
   ```

    > 如果你是 PHP7 版本，则需要下载指定分支：
    >
    > ```
    > git clone -b php7 https://github.com/phpredis/phpredis.git
    > ```

2. #### 修改php.ini文件

   ```
    > vi /usr/local/php/lib/php.ini
   ```

   增加如下内容:
    注意:文件目录和名称

   ```
     extension_dir = "/usr/local/php/lib/php/extensions/no-debug-zts-20131226"

     extension=redis.so
   ```

3. 安装完成后重启php-fpm 或 apache。查看phpinfo信息，就能看到redis扩展。

------
### Windows

下载地址为:

- [http://windows.php.net/downloads/pecl/snaps/redis/](http://windows.php.net/downloads/pecl/snaps/redis/)
- [http://windows.php.net/downloads/pecl/releases/igbinary/](http://windows.php.net/downloads/pecl/releases/igbinary/)

1. 首先注意的是根据phpinfo()查看php编译环境，Compiler的信息是MSVC6/MSVC9/MSVC11，到上面的两个链接里面分别下载MSVC对应版本的文件

2. 拷贝下载解压得到的两个扩展文件到PHP安装目录下的 ext 文件夹下

   ```
     php_redis.dll
     php_redis.pdb

     php_igbinary.dll
     php_igbinary.pdb
   ```

3. 在php.ini 文件下添加配置、

   **注意：**php_igbinary.dll 在前

   ```
     extension=php_igbinary.dll
     extension=php_redis.dll
   ```

4. 重启`apache`,通过`phpinfo()`函数查看安装情况，或者在DOS界面执行 `php.exe -m` 直接查看
