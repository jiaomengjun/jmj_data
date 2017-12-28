# Cmake编译安装MySQL&多配置文件部署MySQL多实例方案
**上一节已经简单介绍过MySQL多实例、应用场景、优缺点以及两种实施方案，本文主要介绍第一种即多配置文件部署多实例MySQL,单一配置文件部署方案会在下一节进行实战。**

####**说明：**

- 本文参考老男孩MySQL教程,为本人实战操作记录
- 以创建2个为例

####**MySQL二进制包和源码包的区分**

- 二进制格式的包名字很长，都带有版本号、适应平台、适应的硬件类型等
- mysql-5.0.45.tar.gz 是源码包 （编译安装）
- 源码格式仅仅就是一个版本号的tar包
- mysql-5.0.45-linux-x86_64-glibc23.tar.gz 是二进制包

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


##1.4部署多实例的MySQL数据库
###1.创建多实例目录
```
> mkdir -pv /data/{3306,3307}/data
> tree data
```
###2.为不同的实例创建创建配置文件（文章结尾附配置文件）
```
> vim /data/3306/my.cnf
> vim /data/3307/my.cnf
```
###3.创建MySQL多实例启动文件（文章结尾附启动文件）
```
> vim /data/3306/mysql
> vim /data/3307/mysql
```
###4.授权mysql用户目录权限
```
> chown -R mysql.mysql /data

1.将my.cnf文件权限设置成644
> chmod 644 /data/3306/my.cnf
> chmod 644 /data/3307/my.cnf

2.由于mysql脚本中保存了登录数据库的密码，需要将文件权限设置成700，只允许root,mysql访问
> chmod 700 /data/3306/mysql
> chmod 700 /data/3307/mysql
```
###5.配置MySQL命令全局使用路径
**如果不为MySQL的命令配置全局路径，就无法直接在命令行输入mysql,这样只能用全路径/application/msyq/bin/mysql 这样带着路径输出会比较麻烦**
```
1.确认mysql命令所在路径
	> ll /data/mysql/bin/mysql

2.修改PATH路径
	#修改文件
	> vim /etc/profile
	#添加如下一行
	> export PATH=/data/mysql/bin:$PATH
	#让其生效
	> source /etc/profile

3.检查PATH是否生效
	> echo $PATH

4.确认上个命令的输出是否有/mysql/bin:(Mysql安装的bin目录)
```

###6.初始化数据库
```
> cd /usr/local/mysql/scripts/

1.注意5.5和MySQL 5.1的路径不同，MySQL 5.1 不在mysql/bin下
	> ./mysql_install_db --basedir=/usr/local/mysql --datadir=/data/3306/data/ --user=mysql
	> ./mysql_install_db --basedir=/usr/local/mysql --datadir=/data/3307/data/ --user=mysql

2.每个初始化出现两个ok则说明成功
```
###7.启动、关闭MySQL
```
> /data/3306/mysql start
> /data/3307/mysql start
> /data/3306/mysql stop
> /data/3307/mysql stop
```
###8.检查是否启动成功
```
	> ps -ef | grep mysqld
或者
	> netstat -anp | grep 3306
```
###9.为用户增加密码，修改密码
```
> mysqladmin -S /data/3306/mysql.sock -u root password '123.asd'
```
###10.多实例数据库的登陆
```
本地登陆：
	> mysql -u root -p -S /data/3306/mysql.sock
远程登录：mysql –h主机名 -u用户名 –p密码 –P3306
	> system mysql -u root -p -S /data/3307/mysql.sock
```


----------


##1.5添加实例（比如3308,ruguo ）
```
> mkdir -p /data/3308/data

#下面的两步操作注意文件中的端口号
> vim /data/3308/my.cnf
> vim /data/3308/mysql
> chown -R mysql.mysql /data
> chmod 644 /data/3308/my.cnf
> chmod 700 /data/3308/mysql
> cd /usr/local/mysql/scripts/
> ./mysql_install_db --basedir=/usr/local/mysql --datadir=/data/3308/data/ --user=mysql
> /data/3308/mysql start
> mysqladmin -S /data/3308/mysql.sock -u root password '123.asd'
```


----------


##附：
###1.MySQL多实例的配置文件(标注的地方需要注意,每个实例的端口要修改)
```
[client]
port=	3306     
socket =  /data/3306/mysql.sock

[mysql]
no-auto-rehash

[mysqld]
user= mysql
port= 3306
socket= /data/3306/mysql.sock
basedir = /usr/local/mysql
datadir = /data/3306/data
open_files_limit = 1024
back_log = 600
max_connections = 800
max_connect_errors = 3000
table_cache = 614
external-locking = FALSE
max_allowed_packet =8M
sort_buffer_size = 1M
join_buffer_size = 1M
thread_cache_size = 100
thread_concurrency = 2
query_cache_size = 2M
query_cache_limit = 1M
query_cache_min_res_unit = 2k
#default_table_type = InnoDB
thread_stack = 192K
#transaction_isolation = READ-COMMITTED
tmp_table_size = 2M
max_heap_table_size = 2M
long_query_time = 1
#log_long_format
#log-error = /data/3306/error.log
#log-slow-queries = /data/3306/slow.log
pid-file = /data/3306/mysql.pid
log-bin = /data/3306/mysql-bin
relay-log = /data/3306/relay-bin
relay-log-info-file = /data/3306/relay-log.info
binlog_cache_size = 1M
max_binlog_cache_size = 1M
max_binlog_size = 2M
expire_logs_days = 7
key_buffer_size = 16M
read_buffer_size = 1M
read_rnd_buffer_size = 1M
bulk_insert_buffer_size = 1M
#myisam_sort_buffer_size = 1M
#myisam_max_sort_file_size = 10G
#myisam_max_extra_sort_file_size = 10G
#myisam_repair_threads = 1
#myisam_recover

lower_case_table_names = 1
skip-name-resolve
slave-skip-errors = 1032,1062
replicate-ignore-db=mysql

server-id = 1

innodb_additional_mem_pool_size = 4M
innodb_buffer_pool_size = 32M
innodb_data_file_path = ibdata1:128M:autoextend
innodb_file_io_threads = 4
innodb_thread_concurrency = 8
innodb_flush_log_at_trx_commit = 2
innodb_log_buffer_size = 2M
innodb_log_file_size = 4M
innodb_log_files_in_group = 3
innodb_max_dirty_pages_pct = 90
innodb_lock_wait_timeout = 120
innodb_file_per_table = 0

[mysqldump]
quick
max_allowed_packet = 2M

[mysqld_safe]
log-error=/data/3306/mysql_3306.err
pid-file=/data/3306/mysqld.pid     
```

###2.MySQL多实例的启动文件(标注的地方需要注意,每个实例的端口要修改)
```
#init
port=3306
mysql_user="root"
mysql_pwd="yourpwd"
CmdPath="/usr/local/mysql/bin"
mysql_sock="/data/${port}/mysql.sock"
#startup function
function_start_mysql()
{
 if [ ! -e "$mysql_sock" ];then
     printf "Starting MySQL...\n"
     /bin/sh ${CmdPath}/mysqld_safe --defaults-file=/data/${port}/my.cnf 2>&1 > /dev/null &
   else
      printf "MySQL is running...\n"
      exit
    fi
}

#stop function
function_stop_mysql()
{
   if [ ! -e "$mysql_sock" ];then
      printf "MySQL is stopped...\n"
      exit
   else
      printf "Stoping MySQL...\n"
       ${CmdPath}/mysqladmin -u ${mysql_user} -p${mysql_pwd} -S /data/${port}/mysql.sock shutdown
   fi
}

#restart function
function_restart_mysql()
{
    printf "Restarting MySQL...\n"
   function_stop_mysql
    sleep 2
   function_start_mysql
}

case $1 in
start)
    function_start_mysql
;;
stop)
    function_stop_mysql
;;
restart)
    function_restart_mysql
;;
*)
    printf "Usage: /data/${port}/mysql {start|stop|restart}\n"
esac    
```
