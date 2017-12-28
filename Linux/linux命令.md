# Linux命令

###### tty 控制台终端`tty1-tty6`
- 一开始 进入的是图形界面:tty1 就是图形界面
- 图形界面切换到字符界面终端:Ctrl+Shift+Alt+F2-F6
- 重新切换成图形界面:Ctrl+F1

###### pts虚拟终端，伪终端
ssh工具链接上之后和在图形化界面打开一个终端一样都是pts虚拟终端
- 打开一个pts虚拟终端：Ctrl+Shift+T
- 切换终端窗口:Alt+1   Alt+2  ...
- 放大: Ctrl + Shift + +
- 缩小:Ctrl + -

###### shell提示符
```
  [ root@localhost ~ ]$
  [ 用户@主机名 当前工作目录名 ] 提示符        提示符root为#,普通用户为$
```

###### Bash Shell基本语法
Linux命令输入规律:
- 如何输入命令：格式：命令 [选项] ([参数])  [选项的值] ([参数的值])
- 注意：有空格，作为分割
- 常见选项（参数）：`-h	--help  ；特点：选项样子为：-字母      或   --加单词`

###### init
- 作用：切换系统运行级别
- 语法：init 0-6
  `0代表关机、1 单用户模式、2多用户、3多用户(字符界面)、4没有定义、5图形界面、6重启`
###### runlevel
- 作用：查看当前运行级别

###### 关机 (系统的关机、重启以及登出 )
1. 关闭系统(1)
    ```linux
      > shutdown -h now        		#立即关机
      > shutdown -h +10				#10分钟后关机
      > shutdown -h 10.00			#十点钟关机
    ```
2. 关闭系统(2)
    ```linux
    > init 0
    ```
3. 关闭系统(3)
    ```linux
    > telinit 0
    ```
4. 按预定时间关闭系统
    ```linux
    > shutdown -h hours:minutes &
    ```
5. 取消按预定时间关闭系统
    ```linux
    > shutdown -c
    ```
6. 重启(1)
    ```linux
    > shutdown -r 和 shutdown -h用法一样
    > shutdown -r now
    ```
7. 重启(2)
    ```linux
    > reboot
    ```
8. 注销
    ```linux
    > logout
    ```

###### diff
- 作用：比较两个文件是否一样
- 语法：diff 文件A 文件B

###### useradd/adduser
- 作用：添加用户
- 语法：useradd  用户名
- 参数：
  ```
  ​			-u		UID
  ​			-d		主目录
  ​			-g		所属组		 #只能有一个
  ​			-G		附加组		 #可以有多个
  ​			-s		登陆shell
  ```

###### userdel
- 作用：删除用户
- 语法：userdel  用户名
- 参数：
  ```
   ​	-r   		递归 ，连同用户目录一起删除
  ```

###### usermod
- 作用：修改用户信息
- 语法：usermod  用户名
- 参数：
  ```
   ​	-u   		修改uid

   ​	-d		主目录

   ​	-g		所属组		 #只能有一个

   ​	-G		附加组		 #可以有多个

   ​	-s		登陆shell
  ```

###### su
- 作用：切换用户
- 语法：su -  用户名
- 参数：
  ```
  ​		加上 - 		在切换时会把环境变量一起进行切换
  ​		不加 -		保留原本的环境变量
  ```

###### id
  ```
 ​		作用：显示用户的UID和GID信息

 ​		语法：id 用户名
  ```

###### w
- 作用：用于显示已经登录系统的用户列表，并显示正在执行的指令与程序

###### who
- 作用：显示目前登录系统的用户信息

###### whoami
- 作用：打印当前用户名称

###### top
- 作用：动态查看进程
- 使用说明：
  - 默认3s刷新一次
  - 空格 ：立即刷新。
  - q退出
  - M按内存排序
  - P按CPU排序
  - <>  翻页

###### kill
- 作用：控制（关闭）进程
- 语法：kill 信号 pid
- 常用信号：
  - 1  HUP   重新加载配置文件。类似重启。
  - 2  INT   和ctrl+c一样   一般用于通知前台进程组终止进程****
  - 9  KILL  强行中断
  - 19 STOP  和ctrl+z一样

###### killall/pkill
- 作用：通过程序的名字，直接杀死所有进程
- 语法：killall/pkill 程序名字

###### 解压缩命令
1.  打包   tar.gz
    ```linux
      > tar zcvf /var/www/html/iptv.tar.gz /var/www/html/iptv
    ```
2.  打包   tar.gz 	除了tomcat/libs不压缩
    ```linux
      > tar zcvf /var/www/html/iptv.tar.gz --exclude=tomcat/libs /var/www/html/iptv
    ````
3. 打包   tar.gz  	排除多个目录，增加 --exclude 即可
    ```linux
      > tar -zcvf tomcat.tar.gz --exclude=tomcat/logs --exclude=tomcat/libs --exclude=tomcat/xiaoshan.txt tomcat
    ```
4. 打包命令   tar.gz
    ```linux
      > tar  -zxvf   压缩文件名.tar.gz
      > tar -zxvf /tmp/etc.tar.gz etc/passwd
    ```
5. 查阅/tmp/etc.tar.gz有哪些文件
    ```linux
      > tar -ztvf /tmp/etc.tar.gz
    ```

###### 链接命令
1. 建立软连接	a 是源文件，b是链接文件名,其作用是当进入b目录，实际上是链接进入了a目录
    ```linux
    > ln -s a b
    ```
2. 删除软链接：    注意不是rm -rf  b/
    ```linux
      > rm -rf  b
    ```
3. 建立硬链接 	(没有-s)
    ```linux
      > ln  a b
    ```
- 软链接：
  1. 以路径的形式存在。类似于Windows操作系统中的快捷方式
  2. 可以 跨文件系统 ，硬链接不可以
  3. 可以对一个不存在的文件名进行链接
  4. 可以对目录进行链接
- 硬链接:
  1. 以文件副本的形式存在。但不占用实际空间。
  2. 不允许给目录创建硬链接
  3. 只有在同一个文件系统中才能创建

###### whereis
- 作用：查找可执行文件及相关文件
- 语法：whereis 可执行文件名称

###### 服务

  centos 7:
1. 查看所有服务
    ```linux
      > chkconfig --list
    ```
2. 查看服务状态命令(服务名:service)
    ```linux
      > systemctl status httpd.service
    ```
3. 列出某个服务的安装rpm包（mariadb为服务名）
    ```linux
      > rpm -qa | grep mariadb
    ```
4. 删除rpm包（mariadb-libs-5.5.44-1.el7_1.x86_64:rpm包名）
    ```linux
      > rpm -e mariadb-libs-5.5.44-1.el7_1.x86_64
    ```
5. 强制删除，不检查依赖：（mariadb-libs-5.5.44-1.el7_1.x86_64：rpm包名）
    ```linux
      > rpm -e --nodeps mariadb-libs-5.5.44-1.el7_1.x86_64
    ```
6. 卸载php
    ```linux
      > yum remove php php-common
    ```

###### 端口
1. 查看开启的端口(TCP)
    ```linux
      > netstat -ntpl
    ```
2. 查看端口是否被占用,21为端口号
    ```linux
      > lsof -i:21
    ```				
3. 查看端口流量
    ```linux
      > iftop -P  
    ```
4. 查看端口被谁占用,8080为端口号
    ```linux
      > netstat -pan | grep 8080		
    ```

###### find
- 作用：查找文件
- 语法：find 路径 参数 参数值 【-print 】【 -exec -ok command 】   {} \;
  - -print 				# 将查找到的文件输出到标准输出
  - -exec   command   {} \;      #将查到的文件执行command操作,		     
  - -ok 					# 和-exec相同，只不过在操作前要询用户
  - {} 和 \;           			# 是固定格式，之间有空格
  - command    			# 要对查找出的文件执行的命令
- 参数：
  - 按时间查找参数：
    ```
          -atime n 		# 将n*24小时内存取过的的文件列出来
          -ctime n 		# 将n*24小时内改变、新增的文件或者目录列出来  
          -mtime n		# 将n*24小时内修改过的文件或者目录列出来  
          -newer file 		# 把比file还要新的文件列出来
    ```
  - 用户及组查找参数：
    ```
     ​			-gid n       		# 寻找群组ID为n的文件  
     ​			-group name		# 寻找群组名称为name的文件  
     ​			-uid n			# 寻找拥有者ID为n的文件  
     ​			-user name		# 寻找用户者名称为name的文件  
     ​			-nogroup               # 寻找文件的属组在/etc/groups中不存在
     ​			-nouser                  # 寻找文件的属主在/etc/passwd中不存
    ```
  - 权限查找参数：
    ```
          -perm 0777		# 按执行权限来查找
    ```
  - 文件属性查找参数：
    ```
     ​			-size       n               # 查长度为n的文件  +n代表大于n  -n代表小于n
     ​			-depth                    # 使查找在进入子目录前先行查找完本目录
     ​			-name file		# 寻找文件名为file的文件（可以使用通配符）
    ```

###### 防火墙
1. 查看 iptables 状态
    ```linux
      > systemctl status iptables.service
    ```
2. 打开iptables服务
    ```linux
      > systemctl start iptables.service
    ```
3. 安装iptable
    ```linux
      > yum install iptables-services
    ```
4. 编辑防火墙配置文件
    ```linux
      > vi /etc/sysconfig/iptables
    ```
5. 编辑完配置文件要保存
    ```linux
      > service iptables save
    ```
6. 最后重启防火墙使配置生效
    ```linux
      > systemctl restart iptables.service
    ```
7. 设置防火墙开机启动
    ```linux
      > systemctl enable iptables.service
    ```

###### CentOS 7.0默认使用的是firewall作为防火墙，这里改为iptables防火墙：
1. 关闭firewall
    1. 停止firewall
        ```linux
      		> systemctl stop firewalld.service
        ```
    2. 禁止firewall开机启动
        ```linux
    		  > systemctl disable firewalld.service
        ```
2. 安装iptables防火墙
    1. 安装
        ```linux
    		  > yum install iptables-services
        ```
    2. 编辑防火墙配置文件
        ```linux
    		  > vi /etc/sysconfig/iptables
        ```
3. 保存、重启iptables
    1. 最后重启防火墙使配置生效
        ```linux
    		  > systemctl restart iptables.service
        ```
    2. 设置防火墙开机启动
        ```linux
    		  > systemctl enable iptables.service
        ```

###### 配置环境变量：
```linux
  > export PATH=/sbin:/usr/sbin:/usr/local/sbin:/usr/kerberos/sbin:$PATH
```

### linux禁ping和允许ping
1. 系统禁止ping
    ```linux
      > echo 1 >/proc/sys/net/ipv4/icmp_echo_ignore_all
    ```
2. 系统允许ping
    ```linux
      > echo 0 >/proc/sys/net/ipv4/icmp_echo_ignore_all
    ```
3. 查看是否允许被ping
    ```linux
      > cat /proc/sys/net/ipv4/icmp_echo_ignore_all
    ```

###### 图形化界面的设置默认界面
1. 查看默认界面指令：
    ```linux
      > systemctl get-default
    ```
2. 切换到运行级3：
    ```linux
      > rm /etc/systemd/system/default.target
      > ln -sf /lib/systemd/system/multi-user.target /etc/systemd/system/default.target
      > ln -sf /lib/systemd/system/runlevel3.target /etc/systemd/system/default.target
    ```
3. 切换到运行级5
    ```linux
      > rm /etc/systemd/system/default.target
      > ln -sf /lib/systemd/system/graphical.target /etc/systemd/system/default.target
      > ln -sf /lib/systemd/system/runlevel5.target /etc/systemd/system/default.target
    ```

###### apache相关
1. 查看apache加载的模块
    ```linux
      > apachectl -l
    ```
2. 测试配置文件语法有没有问题
    ```linux
      > apachectl configtest
    ```
  3. 把apache设置为系统服务
      1. 第一种方法：（路径按照自己apache服务器目录进行修改）
          ```linux
        		> vi /etc/rc.d/rc.local
          ```
            1. 增加：
                ```linux
            			/usr/local/httpd/bin/apachectl start
                ```
  		     2. 注册为Service
                ```linux
            			> cp /usr/local/httpd/bin/apachectl /etc/rc.d/init.d/httpd
                ```
            3. vi httpd  
          			找到：#!/bin/sh
                ```linux
          			> / #!/bin/sh
                ```
            4. 另起一行，增加：
                ```linux
            			# chkconfig: 35 70 30
            			# description: Apache
                ```
            5. 保存退出
                ```linux
            			> Esc
            			> :eq
                ```
            6. 然后注册服务：
                ```linux
            			> chkconfig --add httpd
                ```
      2. 执行
          ```linux
        		> cp /usr/local/apache2/bin/apachectl /etc/init.d/httpd
        		> vi /etc/init.d/httpd
          ```
            1. 再在#!/bin/sh后面加入下面两行
                ```linux
            			#chkconfig:345 85 15
            			#description: Start and stops the Apache HTTP Server.
                ```
            2. 然后
                ```linux
            			> chmod +x /etc/rc.d/init.d/httpd
            			> chkconfig --add httpd
                ```

###### mysql设为linux服务
```linux
	> cp /usr/local/mysql5/share/mysql/mysql.server /etc/init.d/mysqld
	> chkconfig --add mysqld
	> chkconfig --level 2345 mysqld on
	> chown mysql:mysql -R /usr/local/mysql5/
	> service mysqld start
```

###### 进程处理
```linux
  ps查看进程		
  >      ps -ef
    或者	   
         ps -aux
  杀死进程,其中-s 9 制定了传递给进程的信号是９，即强制、尽快终止进程
  > kill -s 9  PID
```

###### crontab
1. 安装crontab:		
    ```
      > yum install crontabs
    ```
2. 查看执行历史 		
    ```
      > tail -f /var/log/cron
    ```
3. 启动服务    　		
    ```
      > /sbin/service crond start
    ```
4. 关闭服务				
    ```
      > /sbin/service crond stop
    ```
5. 重启服务				
    ```
      > /sbin/service crond restart
    ```
6. 重新载入配置			
    ```
      > /sbin/service crond reload
    ```
7. 查看服务运行状态
    ```
      > /sbin/service crond status
    ```
8. 设置服务自动启动,在/etc/rc.d/rc.local这个脚本末尾加上 	
    ```
      > /sbin/service crond start
      或者：
      > chkconfig –level 35 crond on
    ```
9. 新增任务计划可用两种方法：
    -  在命令行输入: crontab -e  然后添加相应的任务，wq存盘退出
    - 直接编辑/etc/crontab 文件，即vi  /etc/crontab，添加相应的任务。
10. 查看已存在任务
     ```
       > crontab -l
       # 列出用户jp的所有调度任务
       > crontab -l -u jp
     ```
11. 删除任务调度工作,删除所有任务调度工作

     ```   
      > crontab -r
     ```
12. crontab命令选项: cron服务提供crontab命令来设定cron服务的
     ```
       -u		用户
       -l		列出任务计划,
       -r		删除任务,
       -e		编辑某个用户的任务
     ```
13. cron文件语法

      | 含义 | 分   |   小时  |  日  |  月    |   星期  |    命令|
      | --------   | :----: | -----:   | :----: | :----: | :----: | :----: |
      | 取值范围:  |  0-59  |  0-23 |  1-31  | 1-12   |  0-6，0 7 都是周日 |   command   |

     几个特殊符号的含义:  

    |  符号  |  "*"   |   "/"  |  "-"  |  "," |
    | --------  | :----: | -----:   | :----: | :----: |
    |  含义 | 取值范围内的所有数字   |   "每"  |  从某个数字到某个数字  |  分开几个离散的数字   |

###### chkconfig
- 常用： `chkconfig 服务名 on` 		,把服务设为开机启动

###### centos7中systemctl 命令
systemctl 是管制服务的主要工具， 它整合了chkconfig 与 service功能于一体  
注：**代表某个服务的名字，如http的服务名为httpd**
1. 查询服务是否开机启动		
    ```linux
      > systemctl is-enabled servicename.service
    ```
2. 开机运行服务
    ```linux		
      > systemctl enable *.service
    ```
3. 取消开机运行
    ```linux
      > systemctl disable *.service
    ```		
4. 启动服务
    ```linux
      > systemctl start *.service
    ```				
5. 停止服务
    ```linux		
      > systemctl stop *.service 			
    ```			
6. 重启服务
    ```linux			
      > systemctl restart *.service
    ```				
7. 重新加载服务配置文件
    ```linux
      > systemctl reload *.service
    ```			
8. 查询服务运行状态
    ```linux
      > systemctl status *.service
    ```		
9. 显示启动失败的服务
    ```linux
      > systemctl --failed
    ```					
eg:
1. 启动服务（等同于service httpd start）
    ```linux
      > systemctl start httpd.service
    ```
2. 停止服务（等同于service httpd stop）
    ```linux
      > systemctl stop httpd.service
    ```
3. 重启服务（等同于service httpd restart）
    ```linux
      > systemctl restart httpd.service
    ```
4. 查看服务是否运行（等同于service httpd status）
      ```linux
      > systemctl status httpd.service
      ```
5. 开机自启动服务（等同于chkconfig httpd on）
      ```linux
      > systemctl enable httpd.service
      ```
6. 查看服务是否开机启动 （等同于chkconfig --list）
      ```linux
      > systemctl is-enabled httpd.service
      ```

### 用户和群组
1. 创建一个新用户组
    ```linux
      > groupadd group_name
    ```
2. 删除一个用户组
    ```linux
      > groupdel group_name
    ```
3. 重命名一个用户组
    ```linux
      > groupmod -n new_group_name old_group_name
    ```
4. 创建一个属于 "admin" 用户组的用户
    ```linux
      > useradd -c "Name Surname " -g admin -d /home/user1 -s /bin/bash user1	5. 创建一个新用户
      > useradd user1
    ```
5. 删除一个用户 ( '-r' 排除主目录)
    ```linux
      > userdel -r user1
    ```
6. 修改用户属性
    ```linux
      > usermod -c "User FTP" -g system -d /ftp/user1 -s /bin/nologin user1
    ```
7. 修改口令
    ```linux
      > passwd
    ```
8. 修改一个用户的口令 (只允许root执行)
    ```linux
      > passwd user1
    ```
9. 设置用户口令的失效期限
    ```linux
      > chage -E 2005-12-31 user1
    ```
10. 检查 '/etc/passwd' 的文件格式和语法修正以及存在的用户
    ```linux
      > pwck
    ```
11. 检查 '/etc/passwd' 的文件格式和语法修正以及存在的群组
    ```linux
      > grpck
    ```
12. 登陆进一个新的群组以改变新创建文件的预设群组
    ```linux
      > newgrp group_name
    ```

### Linux系统目录结构

​	**注意：**每个目录下都有 **.** 和 **..** 这两个隐藏目录，**.** 代表当前目录，**..** 代表上一级目录

##### 倒置树型结构:
    |  目录  |  内容   |
    | --------  | :---- |
    |  /  | 通常称为根分区。所有的文件和目录皆由此开始。只有root用户对此目录拥有写权限  |
    |  /etc  | 配置文件  包含所有应用程序的配置文件，也包含启动、关闭某个特定程序的脚本，例如/etc/passwd，/etc/init.d/network等  |
    |  /boot  |  存放Linux系统启动时需要加载的文件。 (一般在另外一个磁盘分区里面保存) Kernel、grub等文件都存放在此 |
    |  /home  |  普通用户所有数据存放在这个目录下 |
    |  /var  |  是一个可增长的目录，包含很经常变的文件。例如，/var/log（系统日志）、/var/lib （包文件） |
    |  /root  | 管理员所有数据。  root用户的家目录  |
    |  /tmp  | 临时文件存储位置  |
    |  /usr  | usr表示的是unix software source  |
    |  /bin  | 命令  此目录包含二进制可执行文件  |
    |  /sbin  | 系统命令 ，此目录中的命令主要供系统管理员使用，以进行系统维护。例如，iptables、reboot、fdisk等  |
    |  /mnt  | 挂载目录  挂载点，系统管理员可用于临时挂载文件系统  |
    |  /dev  | 包含设备文件。在Linux中，一切都被看做文件。终端设备、USB、磁盘等等都被看做文件，如/dev/sda  |





















---
