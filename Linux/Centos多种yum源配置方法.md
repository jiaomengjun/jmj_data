### **注意：三种方法执行前都应执行一下操作**
#### 一、安装Centos后默认的yum源如下
```
[root@kangvcar ~]# ll /etc/yum.repos.d/
total 32
-rw-r--r--. 1 root root 1664 Dec  9  2015 CentOS-Base.repo
-rw-r--r--. 1 root root 1309 Dec  9  2015 CentOS-CR.repo
-rw-r--r--. 1 root root  649 Dec  9  2015 CentOS-Debuginfo.repo
-rw-r--r--. 1 root root  290 Dec  9  2015 CentOS-fasttrack.repo
-rw-r--r--. 1 root root  630 Dec  9  2015 CentOS-Media.repo
-rw-r--r--. 1 root root 1331 Dec  9  2015 CentOS-Sources.repo
-rw-r--r--. 1 root root 1952 Dec  9  2015 CentOS-Vault.repo
```
### 二、把默认或原yum源备份或直接删除(可选)
```
[root@kangvcar ~]# mkdir /opt/centos-yum.bak
[root@kangvcar ~]# mv /etc/yum.repos.d/* /opt/centos-yum.bak/
```


----------


# 本地yum源配置

### 第一步：在虚拟机上挂载CentOS镜像文件
```
[root@kangvcar ~]# mount -t iso9660 /dev/sr0 /opt/centos
mount: /dev/sr0 is write-protected, mounting read-only
```
### 第二步：编写repo文件并指向镜像的挂载目录
```
[root@kangvcar ~]# vi /etc/yum.repos.d/local.repo  
[local]
name=local
baseurl=file:///opt/centos
enabled=1
gpgcheck=0
```
###第三步：运行yum makecache生成缓存
```
	yum clean all
```
**运行yum makecache生成缓存**
```
	yum makecache
```
**更新系统**
```
	yum -y update
```


----------


# Centos下替换yum源为阿里云源
#### 阿里云官方教程：http://mirrors.aliyun.com/help/centos
#### 阿里云Linux安装镜像源地址：http://mirrors.aliyun.com/

### 第一步：下载CentOS-Base.repo 到/etc/yum.repos.d/
#### **CentOS 5**
```
	wget -O /etc/yum.repos.d/CentOS-Base.repo http://mirrors.aliyun.com/repo/Centos-5.repo
```
#### **CentOS 6**
```
	wget -O /etc/yum.repos.d/CentOS-Base.repo http://mirrors.aliyun.com/repo/Centos-6.repo
```
#### **CentOS 7**
```
	wget -O /etc/yum.repos.d/CentOS-Base.repo http://mirrors.aliyun.com/repo/Centos-7.repo
```
### 第二步：运行yum makecache生成缓存
```
	yum clean all
```
**运行yum makecache生成缓存**
```
	yum makecache
```
**更新系统**
```
	yum -y update
```


----------


# Centos下替换yum源为国内源163
#### 163官方教程：http://mirrors.163.com/.help/centos.html

### 第一步：下载163 yum源repo文件
#### **CentOS 5**
```
	wget -O /etc/yum.repos.d/CentOS5-Base-163.repo http://mirrors.163.com/.help/CentOS5-Base-163.repo
```
#### **CentOS 6**
```
	wget -O /etc/yum.repos.d/CentOS6-Base-163.repo http://mirrors.163.com/.help/CentOS6-Base-163.repo
```
#### **CentOS 7**
```
	wget -O /etc/yum.repos.d/CentOS7-Base-163.repo http://mirrors.163.com/.help/CentOS7-Base-163.repo
```
###第二步：运行yum makecache生成缓存
```
	yum clean all
```
**运行yum makecache生成缓存**
```
	yum makecache
```
**更新系统**
```
	yum -y update
```


----------


# 修改yum源的优先级

**ps:当既有本地yum源又有163源的时候，我们在装软件包的时候当然希望先用本地的yum源去安装，本地找不到可用的包时再使用163源去安装软件,这里就涉及到了优先级的问题，yum提供的插件yum-plugin-priorities.noarch可以解决这个问题**

### 第一：查看系统是否安装了优先级的插件
```
	[root@kangvcar ~]# rpm -qa | grep yum-plugin-
	yum-plugin-fastestmirror-1.1.31-34.el7.noarch        
	//这里看到没有安装yum-plugin-priorities.noarch这个插件
	[root@kangvcar ~]# yum search yum-plugin-priorities        
	//用search查看是否有此插件可用
	Loaded plugins: fastestmirror
	Loading mirror speeds from cached hostfile
	* base: mirrors.aliyun.com
	* extras: mirrors.aliyun.com
	* updates: mirrors.aliyun.com
	====================================================== N/S matched: yum-plugin-priorities =======================================================
	yum-plugin-priorities.noarch : plugin to give priorities to packages from different repos
```

### 第二：安装yum-plugin-priorities.noarch插件
```
	[root@kangvcar ~]# yum -y install yum-plugin-priorities.noarch
```
### 第三：查看插件是否启用
```
	[root@kangvcar ~]# cat /etc/yum/pluginconf.d/priorities.conf
	[main]
	enabled = 1
	//1为启用；0为禁用
```
### 第四：修改本地yum源优先使用
```
	[root@kangvcar ~]# ll /etc/yum.repos.d/
	total 8
	-rw-r--r--. 1 root root 2573 May 15  2015 CentOS-Base.repo
	-rw-r--r--. 1 root root   67 Jun 20 06:04 local.repo
	//有两个repo文件
	[root@kangvcar ~]# vi /etc/yum.repos.d/local.repo
	[local]
	name=local
	baseurl=file:///opt/centos
	enabled=1
	gpgcheck=0
	priority=1
	//在原基础上加入priority=1 ；数字越小优先级越高
	//可以继续修改其他源的priority值，经测试仅配置本地源的优先级为priority=1就会优先使用本地源了
```

### 第五：测试

#### **配置优先级前：(使用阿里云yum源)**
```
	[root@kangvcar ~]# yum -y install vim
	Dependencies Resolved
	=================================================================================================================================================
	Package                            Arch                         Version                                     Repository                     Size
	=================================================================================================================================================
	Installing:
	vim-enhanced                       x86_64                       2:7.4.160-1.el7_3.1                         updates                       1.0 M
	Updating for dependencies:
	vim-common                         x86_64                       2:7.4.160-1.el7_3.1                         updates                       5.9 M
	······
	······
	······
```

#### **配置优先级后：(使用本地yum源)**
```
	[root@kangvcar ~]# yum -y install vim
	Dependencies Resolved
	=================================================================================================================================================
	Package                                     Arch                        Version                                Repository                  Size
	=================================================================================================================================================
	Installing:
	vim-enhanced                                x86_64                      2:7.4.160-1.el7                        local                      1.0 M
	Installing for dependencies:
	gpm-libs                                    x86_64                      1.20.7-5.el7                           local                       32 k
	perl                                        x86_64                      4:5.16.3-286.el7                       local                      8.0 M
	perl-Carp                                   noarch                      1.26-244.el7                           local                       19 k
	perl-Encode                                 x86_64                      2.51-7.el7                             local                      1.5 M
	perl-Exporter                               noarch                      5.68-3.el7                             local                       28 k
	perl-File-Path                              noarch                      2.09-2.el7                             local                       26 k
	perl-File-Temp                              noarch                      0.23.01-3.el7                          local                       56 k
	······
	······
	······
```
