# Memcached
## 解析:
#### 定义：分布式高速缓存系统
1. 分布式是说可以在多台服务器上同时安装memcached的服务，这样可以达到一个很好的集群效果
2. 高速是因为memcached所有的数据都是维护在内存中的，读取速度是要比存储在硬盘中的数据读取速度要快的多
#### 作用：
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;当应用访问量特别大的时候数据库的压力也会越来越大，memcached可以在我们的应用和数据库当中增加一个缓冲层，之前已经在数据库中读取过的数据，第二次或者之后的访问可以直接读取memcached去读取数据从而减轻数据库压力
#### 理解：
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;memcached相当于只有一张表的数据库，这张表有两个字段，分别是key和value,value是保存的数据，key就是这份数据的id,用来保证查找时的唯一性
#### Memcache使用场景：
1. 费持久化存储：对数据存储要求不高。
2. 分布式存储：不是和单机使用。
3. Key/Value存储：格式简单，不支持List、Array数据格式。

---

## 安装:
##### 安装前说明：
1. 编译安装,先安装Libevent,再编译安装Memcache,编译安装更灵活，但是出现问题解决复杂
2. 使用依赖管理工具yum、apt-get
3. 两个版本:Memcache/Memcached,memcached 是memcache的升级版本,在速度和稳定性上都会比memcache要好的多


### 一、服务端安装
1. 比较简单的依赖管理工具yum安装  
	1. 执行以下命令：
		```
			yum install -y memcached
			-y 表示自动应答，即默认安装所有需要用到的依赖包
		```
	2. 安装完成之后尝试启动memcached
		```
			/usr/bin/memcached -b -l 127.0.0.1 -p 11211 -m 150 -u root

			-b 守护进程模式（退出终端窗口之后使程序还在运行），-l 指定IP地址127.0.0.1 ，-p 指定端口号11211，-m 为memcached分配多少内存（单位：M），-u 指定使用哪个用户启动memcached
		```
	3. 查看memcached是否在运行：
		```
			ps -ef | grep memcached
			或
			pstree -p | grep memcached
		```

	4. 如果能够看到memcached进程，那就说明 memcached 服务端已经安装成功了

### 二、客户端安装
##### 客户端的安装又分为两步：
###### libmemcached 客户端库的安装；
###### 为PHP安装 php-memcached 扩展
1. 下载安装所需要的两个安装包
	 1. 我的所有源码包习惯放在该目录下
		```
			cd /usr/local/src   
		```
   2. 下载libmemcached源码包
		```
				wget https://launchpad.net/libmemcached/1.0/1.0.18/+download/libmemcached-1.0.18.tar.gz
		```
   3. 下载memcached源码包
		```
				wget http://pecl.php.net/get/memcached-2.2.0.tgz
				ls
		```
   4. 会看到如下两个压缩包
		```
			    libmemcached-1.0.18.tar.gz  memcached-2.2.0.tgz
		```
2. libmemcached 客户端库的安装：
   1. 首先解压 libmemcached-1.0.18.tar.gz
		```
			tar -zxvf libmemcached-1.0.18.tar.gz
			cd libmemcached-1.0.18/
		```
   2. 配置，–prefix 指定安装目录，该目录我们后面会用到
	 	```
			./configure --prefix=/usr/lib/libmemcached
		```
   3. 编译、安装
	 	```
			make && make install
		```
3. 为PHP安装 php-memcached 扩展
   1. 首先解压libmemcached-1.0.18.tar.gz
		```
			tar -zxvf memcached-2.2.0.tgz
			cd cd memcached-2.2.0
		```
	 2. 使用安装php时生成的 phpize 来生成 configure 配置文件  
			具体用哪个要取决于你的`phpize`文件所在的目录，这时你应该用 `whereis phpize` 来查看路径，如果php是默认安装的话，直接使用phpize即可
		```
			/usr/local/php/bin/phpize (或 /usr/bin/phpize)
		```
   3. 配置
			`-with-php-config` 指定 `php-config`，该文件与 `phpize` 所在目录相同，  `–with-libmemcached-dir` 指定 `libmemcached` 安装目录，就刚才我们 `–prefix` 那个目录 ，`–disable-memcached-sasl` 说明我们系统不支持sasl.h
		```
			./configure -with-php-config=/usr/bin/php-config --with-libmemcached-dir=/usr/lib/libmemcached --disable-memcached-sasl
		```
   4. 编译、安装
	  ```
				make && make install
	 	```
		如果安装成功，会提示：`Installing shared   extension:/usr/local/php/lib/extensions/no-debug-non-zts-20160524/` 等类信息


4. 编辑php配置文件php.ini,把 php-memcached 扩展加到配置文件
   1. 查看php.ini位置
		```
			whereis php.ini
		```
   2. 在 php.ini 中添加以下内容
	 	```
			extension=memcached.so
	  ```
5. 重启apache服务器，使配置生效
	```
		systemctl restart httpd.service
	```
	- 然后查看memcached扩展是否安装成功
	- 在脚本中用`phpinfo()`函数或者直接执行 `php -m` 命令查看




---
