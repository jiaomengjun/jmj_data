# **Nginx**

###**安装简介：**

1. 有两个版本

   - **Mainline版:**

     包含最新的特性和bug修改，并且总是保持更新。可靠，但可能会包含实验性的模块，以及一定数量的新 bug

   - **Stable版:**

     不包含新特性，但包含关键 bug 修复。推荐使用该版用于生产环境

### **安装：**

####**源码编译安装 **

​	更为灵活，可以添加特定的模块，包含添加第三方的模块，或者应用最新的安全补丁

1. **安装Nginx之前需要先安装nginx的依赖库**

   - **PCRE**库 ： nginx 的 **core** 和 **rewrite**模块依赖 PCRE 库。它提供对于正则表达式的支持：

     ```
     > wget ftp://ftp.csx.cam.ac.uk/pub/software/programming/pcre/pcre-8.39.tar.gz
     > tar -zxf pcre-8.39.tar.gz
     > cd pcre-8.38
     > ./configure
     > make
     > sudo make install
     ```

   - **zlib**库：nginx 的 **gzip** 模块依赖 **zlib** 库。用于对 **HTTP headers** 进行压缩：

     ```
     > wget http://zlib.net/zlib-1.2.11.tar.gz
     > tar -zxf zlib-1.2.11.tar.gz
     > cd zlib-1.2.8
     > ./configure
     > make
     > sudo make install
     ```

   - **OpenSSL** 库 ：nginx 的 **SSL** 模块依赖该库，用于支持 **HTTPS** 协议

     ```
     > wget https://www.openssl.org/source/openssl-1.1.0e.tar.gz
     > tar -zxf openssl-1.1.0e.tar.gz
     > cd openssl-1.0.2f
     > ./config  --prefix=/usr/local/openssl
     > make
     > sudo make install
     ```
     **如果系统已经默认安装了openssl，则执行一下命令删除掉:**
     ```
	 mv /usr/bin/openssl /usr/bin/openssl.OFF  
	 mv /usr/include/openssl /usr/include/openssl.OFF
	 mv /usr/bin/openssl /usr/bin/openssl.OFF  
	 mv /usr/include/openssl /usr/include/openssl.OFF  
	 ln -s /usr/local/openssl/bin/openssl /usr/bin/openssl  
	 ln -s /usr/local/openssl/include/openssl /usr/include/openssl  
	 echo "/usr/local/openssl/lib">>/etc/ld.so.conf
	 ldconfig -v
     ```
	**查看版本**
	```
	openssl version -a
	```
2. **下载nginx源码tarball**

   下载地址：http://nginx.org/en/download.html

   - ***mainline* 版**

     ```
     > wget http://nginx.org/download/nginx-1.9.4.tar.gz
     > tar zxf nginx-1.11.1.tar.gz
     > cd nginx-1.9.4
     ```

   - **stable 版**

     ```
     > wget http://nginx.org/download/nginx-1.10.1.tar.gz
     > tar zxf nginx-1.10.1.tar.gz
     > cd nginx-1.10.1
     ```

3. **编译安装(默认安装)**

   ```
   > ./configure --with-http_ssl_module	# 添加SSL支持模块,HTTPS必须的
   > make
   > sudo make install
   ```

####**yum安装**

1. **先安装nginx的依赖库**

   - **PCRE**库：

     ```
     > yum install -y pcre pcre-devel
     # pcre-devel是使用PCRE做二次开发时所需要的开发库，包括头文件等，这也是编译Nginx所必须使用的
     ```

   - **zlib**库：

     ```
     > yum install -y zlib zlib-devel
     # zlib是直接使用的库，zlib-devel是二次开发所需要的库
     ```

   - **OpenSSL** 库:

     ```
     > yum install -y openssl openssl-devel
     ```

2. **安装 nginx**

   - 从默认的 Red Hat/CentOS 仓库安装nginx(版本较低)

     1. 安装 EPEL 仓库：

        ```
        > sudo yum install epel-release
        ```

     2. 更新仓库，并安装 nginx：

        ```
        > sudo yum update
        ```

     3. 验证所安装的 nginx 版本：

        ```
        > sudo nginx -v nginx version: nginx/1.6.3
        ```

   - nginx repo 安装 nginx

     1. 设置 yum 仓库：

        ```
        > cd /etc/yum.repos.d $ sudo vi /etc/yum.repos.d/nginx.repo
        ```

     2. 根据实际情况添加内容：

        ```
        [nginx] name=nginx repo
        baseurl=http://nginx.org/packages/mainline/OS/OSRELEASE/$basearch/
        gpgcheck=0
        enabled=1

        # “OS” 是 rhel 或者 centos
        # “OSRELEASE” 为系统版本：5, 5.x, 6, 6.x, 7, 7.x
        # “/mainline” 是最新的 mainline 版。删除 “/mainline” 是安装最新的 stable 版

        eg:为 CentOS 7.0 获取最新的 mainline package:

        [nginx]
        name=nginx repo
        baseurl=http://nginx.org/packages/mainline/centos/7/$basearch/
        gpgcheck=0
        enabled=1
        ```

     3. 保存退出，更新仓库，并安装 nginx:

        ```
        > sudo yum update
        > yum -y install nginx
        ```

### **Nginx相关操作命令**

- 启动、停止、重启等命令必须进入Nginx安装目录的sbin目录下执行

- **启动**

   ```
   > nginx
   ```

- **停止（立即关闭）**

   ```
   > nginx -s stop
   ```

- **优雅的停止（会等进程执行完才关闭）**

   ```
   > nginx -s quit
   ```

- **重启（只是重新加载了配置文件）**

   ```
   > nginx -s reload
   ```



### **常见问题及解决办法**
#### **Pcre编译报错**: configure: error: You need a C++ compiler for C++ support
```
yum -y install gcc-c++
```

#### **80端口被占用**

   - 只需要查看是哪个服务占用了端口,把端口改掉或者杀死进程即可

   - nginx有一个历史版本是先监听了ipv4的80端口之后又监听了ipv6的80端口，于是就重复占用了，如果是这种情况去编辑nginx的配置文件把原来占用两个80端口的地方改成以下再启动nginx即可

     ```
     listen 80;
     listen [::]:80 ipv6only=on default_server;
     ```

##### **权限配置不正确**
      ​ 这个是nginx出现403 forbidden最常见的原因。为了保证文件能正确执行，nginx既需要文件的读权限,又需要文件所有父目录的可执行权限。

####**403报错**

   - 网站禁止特定的用户访问所有内容，例：网站屏蔽某个ip访问。
   - 访问禁止目录浏览的目录，例：设置autoindex off后访问目录。
   - 用户访问只能被内网访问的文件。

	**目录索引设置错误（index指令配置）**

	      修改配置文件:
```
      > vim /var/local/nginx/conf/nginx.conf
```

##### **1.修改index值**

```
         # index默认只有index.html
         location / {
               root   /var/web/blog/;
               index  index.htm index.html index.php;
         }
```


##### **2.如果第一种办法还是不行，查看fastcgi_index配置是否正确**

```
         location ~ \.php$ {
                     root           /var/web/blog/;
                     fastcgi_pass   127.0.0.1:9000;
                     fastcgi_index  index.php;
                     fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
                     include        fastcgi_params;
                 }
```

#### **make出错：**
> ./configure: error: SSL modules require the OpenSSL library.

> You can either do not enable the modules, or install the OpenSSL library

> into the system, or build the OpenSSL library statically from the source

> with nginx by using --with-openssl=<path> option.

**ubuntu下解决办法:**

> apt-get install openssl
> apt-get install libssl-dev

**centos下解决办法:**
> yum -y install openssl openssl-devel


#### **oneinstack安装web环境时报错，yum源导致的**
1. 删除/etc/yum.repo.d/下面无用的yum源文件
2. 需要的话挂载光盘到/mnt/目录下
	```
		 #此处以虚拟机为例
		 mount /dev/cdrom /mnt/
	```
3. 重新缓存yum元数据
	```
		yum clean all
		yum makecache
	```


### **Nginx配置多端口访问多站点**

1. **首先要编辑 hosts 文件**

   ```
   > vim /etc/hosts
   # 添加一条  www.test.com为你想用的本地域名
   127.0.0.1 www.test.com
   ```

2. **修改nginx.conf配置文件,修改`server`节点的三个值**

   ```
   listen  8080;                #监听端口
   server_name  localhost;      #第一步设置的本地域名
   root  /usr/local/var/www;    #项目根目录
   ```

3. **如果需要配置多个,则重复执行上面的操作,在hosts文件中添加本地域名并修改每个server的三个值**



### **配置Nginx支持PHP**

1. **需要安装php-fpm**

   ```
   > yum -y install php-fpm    # php与nginx连接软件
   ```

2. **为了使PHP不出现中文乱码，可以安装上php-mbstring**

   ```
   > yum  -y install php-mbstring  # php的中文编码库
   ```

3. **可以装上php-xml，使得PHP可以解析XML**

   ```
   yum install php-xml    # php与xml连接软件
   ```

4. **启动php-fpm，并设置php-fpm开机自启**

   ```
   > service php-fpm start		# 如果系统版本过高  使用  systemctl start php-fpm.service
   > chkconfig php-fpm on		# 如果系统版本过高  使用  systemctl enable php-fpm.service
   ```

5. **在相应的目录下找到nginx.conf配置文件，这里是在默认目录下，开启Nginx支撑PHP的模块**

   ```
   > cd /usr/local/nginx/conf    # 进入Nginx配置目录
   ```

6. **修改Nginx配置文件**

   ```
   > vim nginx.conf 			  # 配置nginx.conf文件

   # 首先将注释，也就是#号去掉
   # 接着将fastcgi_param对应的/scripts$fastcgi_script_name改成$document_root$fastcgi_script_name

   修改前

   #location ~ \.php$ {

   #    root          html;

   #    fastcgi_pass  127.0.0.1:9000;

   #    fastcgi_index  index.php;

   #    fastcgi_param  SCRIPT_FILENAME  /scripts$fastcgi_script_name;

   #    include        fastcgi_params;

   修改后

   location ~ \.php$ {

     root          html;

     fastcgi_pass  127.0.0.1:9000;

     fastcgi_index  index.php;

     fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;

     include        fastcgi_params;

   }
   ```

7. **修改之后保存退出，重新加载一下Nginx配置文件即可**

   ```
   :wq
   service nginx reload
   ```

### **PHP-FPM升级**

```
> rpm -Uvh https://mirror.webtatic.com/yum/el6/latest.rpm
> rpm -Uvh http://dl.fedoraproject.org/pub/epel/6/i386/epel-release-6-8.noarch.rpm
> cd /etc/yum.repos.d
> curl -O http://rpms.famillecollet.com/enterprise/remi.repo
> yum install php-fpm php php-devel -y --enablerepo=remi-php56
> php-fpm -version
```

























### **附录：源码包编译安装可配置参数**

源码包中提供 configure 脚本用于在编译前定义 nginx 各方面的配置。执行 configure 脚本最后生成 Makefile，make 命令根据 Makefile 进行编译安装

**子目录**：

- 配置 nginx 文件安装路径
- 配置 nginx gcc 选项
- 指定 nginx 并发模型
- nginx 的模块
- 默认编译的模块
- 默认不编译的模块
- 第三方模块
- 静态链接模块和动态链接模块

**配置示例：**

```
> ./configure \
--sbin-path=/usr/local/nginx/nginx \
--conf-path=/usr/local/nginx/nginx.conf \
--pid-path=/usr/local/nginx/nginx.pid \
--with-pcre=../pcre-8.38 \
--with-zlib=../zlib-1.2.8 \
--with-http_ssl_module \
--with-stream \
--add-module=/usr/build/nginx-rtmp-module \
```

**配置 nginx 文件安装路径**

> 使用 configure 脚本可设置 nginx 的文件安装路径，包括 nginx 二进制文件和配置文件，以及设置依赖库如 PCRE 和 SSL 的源码所在路径（用于对其进行静态编译）。

**--prefix=path**   

> 定义 nginx 文件的安装路径。configure 的其他选项如果使用相对路径，那么以此路径为基础路径。(except for paths to libraries sources)。nginx.conf 文件中的相对路径也以此为基础路径。默认 `--prefix=/usr/local/nginx`

**--sbin-path=path**  

> 设置 nginx 二进制程序的路径名，这个名字只在安装期间使用。默认 `--sbin-path=prefix/sbin/nginx`

**--conf-path=path**  

> 设置 nginx.conf 的路径。nginx 可在启动时手动以 `-c file` 参数指定其他配置文件。默认 `--conf-path=prefix/conf/nginx.conf`

**--pid-path=path**  

> 设置 nginx.pid 文件的路径。安装nginx之后，可在 `nginx.conf` 文件中使用 pid 指令修改该路径。默认 `--pid-path=prefix/logs/nginx.pid`

**--error-log-path=path**   

> 设置 nginx 错误日志的路径。安装nginx之后，可在 `nginx.conf` 文件中使用 [error_log](http://nginx.org/en/docs/ngx_core_module.html#error_log) 指令修改该路径。默认 `--error-log-path=prefix/logs/error.log`

**--http-log-path=path**  

> 设置 nginx 访问日志的路径。安装nginx之后，可在 `nginx.conf` 文件中使用 [access_log](http://nginx.org/en/docs/ngx_core_module.html#error_log) 指令修改该路径。默认 `--http-log-path=prefix/logs/access.log`

**--user=name**

> 设置启动 worker 进程时所使用的非特权用户名。安装nginx之后，可在 `nginx.conf` 文件中使用 [user](http://nginx.org/en/docs/ngx_core_module.html#user) 指令修改用户名。默认 `--user=nobody`

**--group=name**   

> 设置启动 worker 进程时所使用的非特权用户组名。安装nginx之后，可在 `nginx.conf` 文件中使用 [user](http://nginx.org/en/docs/ngx_core_module.html#user) 指令修改用户组名。默认 `--group=nobody`

**--with-pcre=path**  

> 设置 PCRE 库的源码路径。首先需要下载和解压 [PCRE](http://www.pcre.org) 库。要求 PCRE 的版本范围为 4.4 — 8.38。设置之后，其余的就交给 ./configure 和 make 命令。nginx 使用 PCRE 库用于支持正则表达式。正则表达式在 [location](http://nginx.org/en/docs/http/ngx_http_core_module.html#location) 指令和 [rewrite](http://nginx.org/en/docs/http/ngx_http_rewrite_module.html) 模块中会用到。

**--with-pcre-jit**  

> 编译 PCRE 库时，加入 “just-in-time compilation” 支持 (1.1.12, the [pcre_jit](http://nginx.org/en/docs/ngx_core_module.html#pcre_jit) directive)

**--with-zlib=path**  

> 设置 zlib 库的源码路径。首先需要下载和解压 [zlib](http://zlib.net) 库。

> 要求 zlib 库的版本范围为 1.1.3 — 1.2.8，设置之后，其余的就交给 ./configure 和 make 命令。[gzip](http://nginx.org/en/docs/http/ngx_http_gzip_module.html) 压缩模块依赖 zlib 库。

**配置 nginx gcc 选项**
