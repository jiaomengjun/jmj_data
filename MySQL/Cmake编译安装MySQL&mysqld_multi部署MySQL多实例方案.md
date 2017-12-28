#Cmake编译安装MySQL&mysqld_multi部署MySQL多实例方案
**官方自带的mysqld_multi部署MySQL多实例:使用单独的配置文件来实现多实例，这种方式定制每个实例的配置不太方面，优点是管理起来很方便，集中管理**
**推荐使用多个配置文件方式。实际应用中好，耦合性不强，配置方便，特别是主从复制的时候**


####**MySQL二进制包和源码包的区分**
- **二进制格式的包名字很长，都带有版本号、适应平台、适应的硬件类型等**
	mysql-5.0.45.tar.gz 是源码包 （编译安装）
- **源码格式仅仅就是一个版本号的tar包**
	mysql-5.0.45-linux-x86_64-glibc23.tar.gz 是二进制包

####**所有的操作根据实际情况而定**

- Camek下载：https://cmake.org/download/
- MySQL下载：https://dev.mysql.com/downloads/mysql/


----------


##1.1准备安装环境
###1.首先检查是否已经安装过mysql：
```
> rpm -qa | grep mysql
```
###2.有的话就卸载掉以前安装的mysql：
```
> rpm -e --nodeps xxx（xxx是搜索结果）
```
###3.并删除所有的相关文件：
```
> rm -f /etc/my.cnf
```


----------


##1.2下载cmake安装包编译安装cmake
###1.下载解压Cmake
```
> wget  https://cmake.org/files/v3.9/cmake-3.9.1.tar.gz
> tar zxf  cmake-3.9.1.tar.gz
```
###2.编译安装cmake
```
> cd cmake-3.9.1
> ./configure
> gmake
> echo $?      #编译但是未安装之前判断是否编译有错
> gmake install
```


----------


##1.3下载MySQL编译安装MySQL
###1.安装依赖包
```
> yum -y install libaio libaio-devel     
> yum -y install ncurses-devel    	   
```
###2.创建用户组 用户
```
> groupadd mysql
> useradd mysql -s /sbin/nologin -M -g mysql
```
###3.下载解压
```
> wget https://dev.mysql.com/get/Downloads/MySQL-5.5/mysql-5.5.57.tar.gz
> tar -zxf mysql-5.5.57.tar.gz
```
###4.cmake编译安装(编译时不能指定配置文件端口号mysql.sock地址等)
```
> cd mysql-5.5.57
> cmake \-DCMAKE_INSTALL_PREFIX=/usr/local/mysql5.5.57 -DMYSQL_UNIX_ADDR=/usr/local/mysql/tmp/mysql.sock -DMYSQL_DATADIR=/usr/local/mysql/data -DSYSCONFDIR=/etc/my.cnf  -DWITH_MYISAM_STORAGE_ENGINE=1 -DWITH_INNOBASE_STORAGE_ENGINE=1 -DWITH_MEMORY_STORAGE_ENGINE=1 -DWITH_READLINE=1 -DMYSQL_TCP_PORT=3306 -DENABLED_LOCAL_INFILE=1 -DWITH_PARTITION_STORAGE_ENGINE=1 -DEXTRA_CHARSETS=all
> make && make install
```
###5.检查是否安装成功
```
> echo $?
> 0
#（输出0表示成功）
```
###6.设置软链接及配置文件
```
> ln -s /usr/local/mysql55 /usr/local/mysql
```


----------


##1.4配置MySQL多实例(mysqld_multi方式)
###1.创建多实例数据目录
```
> mkdir -pv /data/mysql/{3306,3307}
```
###2.设置访问权限
```
> chown -R mysql:mysql /data/mysql
```
###3.初始化数据库
```
> cd /usr/local/mysql/scripts/
> ./mysql_install_db --basedir=/usr/local/mysql --datadir=/data/mysql/3306 --user=mysql
> ./mysql_install_db --basedir=/usr/local/mysql --datadir=/data/mysql/3307 --user=mysql
```
###4.修改配置文件（注意路径和端口号）
```
[mysqld_multi]
mysqld=/usr/local/mysql/bin/mysqld_safe
mysqladmin=/usr/local/mysql/bin/mysqladmin
user=multi_admin
password=multi_password
[mysqld3306]
socket=/tmp/mysql3306.sock
port=3306
pid-file=/data/mysql/data3306/hostname3306.pid
datadir=/data/mysql/data3306
user=mysql
server-id=3306
[mysqld3307]
socket=/tmp/mysql3307.sock
port=3307
pid-file=/data/mysql/data3307/hostname3307.pid
datadir=/data/mysql/data3307
user=mysql
server-id=3307

[mysqld_multi]
mysqld = /usr/local/mysql/bin/mysqld_safe
mysqladmin = /usr/local/mysql/bin/mysqladmin

[mysqld1]
port = 3306
socket = /tmp/3306.sock
pid-file=/data/mysql/3306/3306.pid
datadir=/data/mysql/3306
user=mysql
server-id=3306
log-slow-queries=slow_query.txt
long_query_time=2
skip-external-locking
skip-name-resolve
skip-innodb
max_allowed_packet = 256M
query_cache_size=256M
max_connections=2000
max_connect_errors=10000
key_buffer_size=6000M
read_buffer_size=32M
read_rnd_buffer_size = 32M
myisam_sort_buffer_size=512M
tmp_table_size=1024M
old-passwords
interactive_timeout=60
wait_timeout=60
connect_timeout=60
table_cache=8192
thread_cache_size=512
sort_buffer_size=128M
back_log = 500
thread_concurrency=48
expire_logs_days=10
log-bin=mysql-bin

[mysqld2]
port = 3307
socket = /tmp/3307.sock
pid-file=/data/mysql/3307/3307.pid
datadir=/data/mysql/3307
user=mysql
server-id=3307
log-slow-queries=slow_query.txt
long_query_time=2
skip-external-locking
skip-name-resolve
skip-innodb
max_allowed_packet = 256M
query_cache_size=256M
max_connections=2000
max_connect_errors=10000
key_buffer_size=6000M
read_buffer_size=32M
read_rnd_buffer_size = 32M
myisam_sort_buffer_size=512M
tmp_table_size=1024M
old-passwords
interactive_timeout=60
wait_timeout=60
connect_timeout=60
table_cache=8192
thread_cache_size=512
sort_buffer_size=128M
back_log = 500
thread_concurrency=48
expire_logs_days=10
log-bin=mysql-bin

[mysqldump]
quick
max_allowed_packet = 512M

[mysql]
no-auto-rehash

[isamchk]
key_buffer = 512M
sort_buffer_size = 32M
read_buffer = 2M
write_buffer = 2M

[myisamchk]
key_buffer = 512M
sort_buffer_size = 32M
read_buffer = 2M
write_buffer = 2M

[mysqlhotcopy]
interactive-timeout
```



###5.通过bin下的工具mysqld_multi管理MySQL的多实例
```
#启动
	> /usr/local/mysql/bin/mysqld_multi start
	> /usr/local/mysql/bin/mysqld_multi start 1-2
	> /usr/local/mysql/bin/mysqld_multi start 1
#可查看运行状态
	> /usr/local/mysql/bin/mysqld_multi report
#关闭
	> /usr/local/mysql/bin/mysqld_multi stop
	> /usr/local/mysql/bin/mysqld_multi stop 1-2
	> /usr/local/mysql/bin/mysqld_multi stop 1
```
###6.检查是否启动成功
```
	> ps -ef | grep mysqld
#或者
	> netstat -anp | grep 3306
```

###7.连接数据库
```
1. 指定ip 端口号进入
	> mysql -u root -h 127.0.0.1 -P 3306
2. 指定socket登陆，适合在本机连接
	> mysql -u root -p -S /tmp/3306.sock
3. 输入密码即可进入
```
###8.初始化密码并且授权远程登录
**mysqladmin用户名和密码需要和/ect/my.cnf中保持一致，否则stop不了服务(每个实例都要执行)**
```
	> /usr/local/mysql/bin/mysqladmin -u root password "yourpassword" -S /tmp/3306.sock
	> /usr/local/mysql/bin/mysql -uroot -p -S /tmp/3306.sock
#输入密码进入
	mysql> grant all privileges on *.* to 'root'@'%' identified by '3306password' with grant option;
	mysql> flush privileges;
```
