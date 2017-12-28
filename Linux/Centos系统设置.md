### **关闭selinux**

1. 查看selinux状态

   ```
   > getenforce
   ```

2. 修改配置文件

   ```
   > vim /etc/selinux/config

   # 修改
   SELINUX=disabled
   SELINUXTYPE=targeted
   ```


3. 重启生效

   ```
   reboot
   ```


----------

### **安装gcc及g++**
```
> yum -y install make gcc-c++
```

----------


### **给普通用户设置sudo权限**

1. 切换到root用户执行 `visudo` 命令来编辑修改/etc/sudoers配置文件
2. 在 `/etc/sudoers`  找到 `root  ALL=(ALL)    ALL` 这一行
  3. 在 `root  ALL=(ALL)    ALL`  这行下面添加 `用户名ALL=(ALL)     ALL`
3. 保存退出即可


----------


### **配置yum源**
http://blog.csdn.net/qq_28975017/article/details/77174670

### **设置启动界面**
```
rm -f /etc/systemd/system/default.target
```
####设置命令行级别方法:
```
ln -sf /lib/systemd/system/runlevel3.target /etc/systemd/system/default.target
或
ln -sf /lib/systemd/system/multi-user.target /etc/systemd/system/default.target
或
systemctl set-default multi-user.target
```
####改回窗口级别方法:
```
ln -sf /lib/systemd/system/runlevel5.target /etc/systemd/system/default.target
或
ln -sf /lib/systemd/system/graphical.target /etc/systemd/system/default.target
或
systemctl set-default graphical.target
```

---

### **关闭firewall,启动iptables**

1. 关闭firewall

   ```
   > systemctl stop firewalld.service 			#停止firewall
   > systemctl disable firewalld.service 		#禁止firewall开机启动
   ```

2. 安装iptables

   ```
   > yum -y install iptables-services
   ```

3. 设为开机启动

   ```
   > systemctl enable iptables
   ```

4. 启动服务

   ```
   > systemctl start iptables
   ```

5. 这样就可以设置防火墙了

   配置文件地址：/etc/sysconfig/iptables


----------


### **网络管理工具   适合最小化安装的系统,可不装**
```
> yum -y install net-tools
```


----------


### **一个语法分析器生成器，可不装**
```
> yum -y install bison
```


----------


### **一个比make更高级的编译配置工具，可yum安装也可下载编译安装**
```
> yum -y install cmake
```


----------


### **网络相关配置**

**NAT模式配置静态IP:**

1. 在VMware里，依次点击”编辑“ - ”虚拟网络编辑器“，选择的是NAT模式

2. 为了能够使用静态IP，不要勾选”使用本地DHCP服务将IP分配给虚拟机“这个选项

3. 配置子网ip，子网IP与宿主机的ip一定不能处在同一地址范围里，否则就算虚拟机能上网，网络既慢，还不稳定

4. 在这个界面接着点"NAT设置"，查看虚拟机的网关，这个网关在第三步要用

5. 配置文件：/etc/sysconfig/network-scripts/ifcfg-   开头的

6. 主要参数：根据实际情况修改

   ```
   TYPE=Ethernet
   BOOTPROTO="static" 		#dhcp改为static 	
   ONBOOT="yes" 			#开机启用本配置
   IPADDR=192.168.7.106 	#配置静态ip，在第三步已经设置ip处于192.168.10.xxx这个范围，只要不和网关相同均可
   GATEWAY=192.168.7.1 	
   NETMASK=255.255.255.0 	#子网掩码
   DNS1=114.114.114.113 	#DNS 配置
   DNS2=223.6.6.6			#dns服器2
   ```

7. 重启下网络服务,查看配置是否成功

   ```
   > service network restart	# 重启服务
   > ifconfig					# 查看网络信息

   centos7以上使用 systemctl restart network 重启网络服务,使用 ip addr 查看网络信息
   ```

**桥接模式配置静态IP**

1. 网络选择桥接模式

2. 配置文件：/etc/sysconfig/network-scripts/ifcfg-   开头的

3. 修改配置文件

   ```
   TYPE=Ethernet
   BOOTPROTO="static" 		#dhcp改为static 	
   ONBOOT="yes" 			#开机启用本配置
   IPADDR=192.168.1.111 	#配置静态ip，与主机在一个IP段范围，只要不和网关相同均可
   GATEWAY=192.168.1.1 	#默认网关	与主机在一样
   NETMASK=255.255.255.0 	#子网掩码
   DNS1=114.114.114.114 	#DNS 配置
   DNS2=223.6.6.6			#dns服器2
   ```

4. 重启下网络服务,查看配置是否成功

   ```
   > service network restart	# 重启服务
   > ifconfig					# 查看网络信息

   centos7以上使用 systemctl restart network 重启网络服务,使用 ip addr 查看网络信息
   ```


----------

### **sshd服务**

- **介绍**

  - SSH协议：安全外壳协议。为Secure Shell的缩写。SSH 为建立在应用层和传输层基础上的安全协议。

- **作用**

  - sshd服务使用SSH协议可以用来进行远程控制， 或在计算机之间传送文件
  - 相比较之前用telnet方式来传输文件要安全很多，因为telnet使用明文传输，是加密传输

- **安装**

  1. **需要安装OpenSSH四个安装包**

     1. openssh-5.3p1-114.el6_7.x86_64：

        包含OpenSSH服务器及客户端需要的核心文件

     2. openssh-clients-5.3p1-114.el6_7.x86_64：

        OpenSSH客户端软件包

     3. openssh-server-5.3p1-114.el6_7.x86_64：

        OpenSSH服务器软件包

     4. openssh-askpass-5.3p1-114.el6_7.x86_64：

        支持对话框窗口的显示，是一个基于X 系统的密码

  2. **安装方法有两种：**

     1. **配置yum源,执行**

        ```
        > yum install openssh openssh-clients openssh-server openssh-askpass
        ```

        **前提：系统配置好yum源，（本地源or网络源） 推荐用yum来安装**

     2. **本地直接安装rpm包文件：**

        ```
        > rpm –ivh /media/cdrom/Packages/openssh*.rpm
        ```

        **可能需要解决依赖关系**

  3. **确认软件包是否已经安装**:

     ```
     > rpm -qa | grep openssh
     ```

  4. **OpenSSH配置文件**

     /etc/ssh/ssh_config和/etc/sshd_config

     ssh_config为客户端配置文件

     sshd_config为服务器端配置文件

     ```
     1. Port 22		设置sshd监听端口号
           # SSH预设使用22端口,也可以使用多个port,即重复使用 port 这个设定项目！
           # 例如想要开放sshd端口为22和222，则多加一行内容为： Port 222 即可,然后重新启动sshd
           # 建议大家修改 port number 为其它端口。防止别人暴力破解。

     2. Protocol 2		选择的 SSH 协议版本，可以是 1 也可以是 2

     3. HostKey /etc/ssh/ssh_host_key		设置包含计算机私人密匙的文件

     4. SyslogFacility AUTHPRIV 		
     	当有人使用 SSH 登入系统的时候，SSH 会记录信息，这个信息要记录的类型为AUTHPRIV。

     5. sshd服务日志存放在： /var/log/secure
     #######################安全调优重点###############################
     6. LoginGraceTime 2m
     	# 当使用者连上 SSH server 之后，会出现输入密码的画面，在该画面中，
     	# 在多久时间内没有成功连上 SSH server 就强迫断线！若无单位则默认时间为秒！
     	# 可以根据实际情况来修改实际

     7. PermitRootLogin yes
     	# 是否允许 root 登入！预设是允许的，但是建议设定成 no ！真实的生产环境服务器，是不允许root账号登陆的！！！

     8. PasswordAuthentication yes
     	# 密码验证当然是需要的！所以这里写 yes，也可以设置为no
     	# 在真实的生产服务器上，根据不同安全级别要求，有的是设置不需要密码登陆的，通过认证的秘钥来登陆

     9. PermitEmptyPasswords no
     	# 若上面那一项如果设定为 yes 的话，这一项就最好设定为 no ，
     	# 这个项目在是否允许以空的密码登入！当然不许！

     10. PrintMotd yes
     	# 登入后是否显示出一些信息呢？例如上次登入的时间、地点等等，预设是 yes
     	# 亦即是打印出 /etc/motd这个文档的内容
     	例：给sshd服务添加一些警告信息
     		> cat /etc/motd
     		> echo 'Warning ! From now on, all of your operation has been 4record!'> /etc/motd

     11. PrintLastLog yes 	显示上次登入的信息！预设也是 yes

     12. UseDNS yes		
     	#一般来说，为了要判断客户端来源是正常合法的，因此会使用 DNS 去反查客户端的主机名
     	# 不过如果是在内网互连，这项目设定为 no 会让联机速度比较快
     ```

  5. **服务启动关闭脚本**

     ```
     > service sshd restart/stop/start/status
     或
     > /etc/init.d/sshd restart/stop/start/status
     ```

  6. **使用ssh远程链接主机**

     ```
     方法1：
     	ssh  [远程主机用户名] @[远程服务器主机名或IP地址]
     	eg:
     		> ssh zhaoduo@192.168.0.64
     		使用root登陆主机可直接
     		> ssh 192.168.0.64
     方法二、
     	ssh -l [远程主机用户名] [远程服务器主机名或IP 地址]
     	eg:
     		ssh -l zhaoduo 192.168.0.64
     ```

     **扩展：**

            	1. 第一次登录服务器时系统没有保存远程主机的信息，为了确认该主机身份会提示用户是否继续连接，输入yes后登录，这时系统会将远程服务器信息写入用户主目录下的$HOME/.ssh/known_hosts文件中，下次再进行登录时因为保存有该主机信息就不会再提示了
          	2. RSA算法基于一个十分简单的数论事实：将两个大素数相乘十分容易，但是想要对其乘积进行因式分解却极其困难，因此可以将乘积公开作为加密密钥
