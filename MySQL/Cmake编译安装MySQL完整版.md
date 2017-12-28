### **MySQL二进制包和源码包的区分**
- **二进制格式的包名字很长，都带有版本号、适应平台、适应的硬件类型等**
mysql-5.0.45.tar.gz 是源码包 （编译安装）
- **源码格式仅仅就是一个版本号的tar包**
mysql-5.0.45-linux-x86_64-glibc23.tar.gz 是二进制包

###**所有的操作根据实际情况而定**

- Camek下载：https://cmake.org/download/
- MySQL下载：https://dev.mysql.com/downloads/mysql/

## 1. 准备安装环境
#### 1）首先检查是否已经安装过mysql：
```
> rpm -qa | grep mysql
```
#### 2）有的话就卸载掉以前安装的mysql：
```
> rpm -e --nodeps xxx（xxx是搜索结果）
```
#### 3）并删除所有的相关文件：
```
> rm -f /etc/my.cnf
```

## 2.下载cmake安装包编译安装cmake
#### 1）下载解压Cmake
```
> wget  https://cmake.org/files/v3.9/cmake-3.9.1.tar.gz
> tar zxf  cmake-3.9.1.tar.gz
```
#### 2）编译安装
```
> cd cmake-3.9.1
> ./configure
> gmake
> echo $?      #编译但是未安装之前判断是否编译有错
> gmake install
```

## 3.下载MySQL编译安装MySQL
#### 1）安装依赖包
```
> yum -y install libaio libaio-devel     #Mysql依赖包
> yum -y install ncurses-devel    	   #Mysql依赖包
```
#### 2）创建用户组 用户
```
> groupadd mysql		#创建mysql用户组
> useradd mysql -s /sbin/nologin -M -g mysql		#创建mysql用户
```
#### 3）下载解压
```
> wget https://dev.mysql.com/get/Downloads/MySQL-5.5/mysql-5.5.57.tar.gz
> tar -zxf mysql-5.5.57.tar.gz
```
#### 4）cmake编译安装
```
> cd mysql-5.5.57
> cmake \-DCMAKE_INSTALL_PREFIX=/usr/local/mysql55 -DMYSQL_DATADIR=/usr/local/mysql/data -DSYSCONFDIR=/etc/my.cnf  -DWITH_MYISAM_STORAGE_ENGINE=1 -DWITH_INNOBASE_STORAGE_ENGINE=1 -DWITH_MEMORY_STORAGE_ENGINE=1 -DWITH_READLINE=1 -DMYSQL_UNIX_ADDR=/tmp/mysqld.sock -DMYSQL_TCP_PORT=3306 -DENABLED_LOCAL_INFILE=1 -DWITH_PARTITION_STORAGE_ENGINE=1 -DEXTRA_CHARSETS=all
> make && make install
```
#### 5）设置软链接及配置文件
```
>  ln -s /usr/local/mysql55 /usr/local/mysql
> cp mysql-5.5.32/support-files/my-small.cnf /etc/my.cnf
```

#####**以下是编译时每一个参数的解释**
```  
    # -DCMAKE_INSTALL_PREFIX=/usr/local/mysql56  \    #安装路径  
    # -DMYSQL_DATADIR=/usr/local/mysql/data      \    #数据文件存放位置  
    # -DSYSCONFDIR=/etc                         \    #my.cnf路径  
    # -DWITH_MYISAM_STORAGE_ENGINE=1            \    #支持MyIASM引擎  
    # -DWITH_INNOBASE_STORAGE_ENGINE=1          \    #支持InnoDB引擎  
    # -DWITH_MEMORY_STORAGE_ENGINE=1            \    #支持Memory引擎  
    # -DWITH_READLINE=1                         \    #快捷键功能(我没用过)  
    # -DMYSQL_UNIX_ADDR=/tmp/mysqld.sock        \    #连接数据库socket路径  
    # -DMYSQL_TCP_PORT=3306                     \    #端口  
    # -DENABLED_LOCAL_INFILE=1                  \    #允许从本地导入数据  
    # -DWITH_PARTITION_STORAGE_ENGINE=1         \    #安装支持数据库分区  
    # -DEXTRA_CHARSETS=all                      \    #安装所有的字符集  
    # -DDEFAULT_CHARSET=utf8                    \    #默认字符  
    # -DDEFAULT_COLLATION=utf8_general_ci  	  \    #默认的校对规则
```
## 4.配置mysql
#### 1）检查系统是否已经有mysql用户，如果没有则创建
```
> cat /etc/passwd | grep mysql  
> cat /etc/group | grep mysql  
```
#### 2）创建mysql用户（如果系统诶有mysql用户或组时,但是不能使用mysql账号登陆系统）
```
> groupadd mysql -s /sbin/nologin  
> useradd -g mysql mysql  
```
#### 3）修改权限
```
> chown -R mysql:mysql /usr/local/mysql
```
#### 4）完成后，继续下面的操作 （注意部分命令的.）
```

> cd /usr/local/mysql              # 进入目录
> chown -R mysql:mysql .           #这里最后是有个.的要注意,为了安全安装完成后请修改权限给root用户
> scripts/mysql_install_db --user=mysql     #先进行这一步再做如下权限的修改   

> chown -R root:mysql .        # 将权限设置给root用户，并设置给mysql组， 取消其他用户的读写执行权限，仅留给mysql "rx"读执行权限，其他用户无任何权限

> chown -R mysql:mysql ./data      #数据库存放目录设置成mysql用户mysql组   
> chmod -R ug+rwx  .          #赋予读写执行权限，其他用户权限一律删除仅给mysql用户权限
```
#### 5）下面的命令是将mysql的配置文件拷贝到/etc
```
> cp support-files/my-default.cnf  /etc/my.cnf  
> cp support-files/my-medium.cnf /etc/my.cnf  
#（5.6之前的版本是此操作，读者也可在此时自己进入support-files文件夹下面，看是配置文件的真正名称，那个存在，就拷贝那个。。）  
```
#### 6）修改my.cnf配置
```
> vi /etc/my.cnf  
#[mysqld] 下面添加：  
user=mysql  
datadir=/data/mysql  
default-storage-engine=MyISAM  
```
#### 7）将mysql的启动服务添加到系统服务中
```
> cp support-files/mysql.server  /etc/init.d/mysql
#现在可以使用下面的命令操作mysql   
> service mysql start          #启动mysql服务
> service mysql stop          #停止mysql服务   
> service mysql restart        #重启mysql服务
```
#### 8）看mysql是否成功
```
> netstat -tnl|grep 3306
```
#### 9）开机启动
```
> chkconfig --add mysql  
```
#### 10）修改默认root账户密码，默认密码为空
```
#修改密码 cd 切换到mysql所在目录  
> cd /usr/local/mysql  
> ./bin/mysqladmin -u root password  
#回车在接下来的提示中设置新密码即可。。  
#最后重启mysql服务器
> service mysql restart
```

#### 11）简单优化
```
> select user,host from mysql.user;
> delete from mysql.user where user = '';
> delete from mysql.user where host = '::1';
> delete from mysql.user where host = 'localhost.localdomain';
```
#####**只留下图示中的用户即可**
```
+------+-----------+
| user | host      |
+------+-----------+
| root | 127.0.0.1 |
| root | localhost |
+------+-----------+

```
#####**删掉test库没用**
```
> drop database test;
> Show databases;
```

#####**也可以直接把账号全部删除  添加额外管理员**
```
> delete from mysql.user;
> grant all privileges on *.* to system@’localhost’ identified by ‘username’ with grant option;
> flush privileges;
> select user,host from mysql.user
```
