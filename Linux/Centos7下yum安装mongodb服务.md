# Centos7下yum安装mongodb服务

- yum源请看:		[https://repo.mongodb.org/yum/redhat/](https://repo.mongodb.org/yum/redhat/)

1. 检查系统是多少位主机，以便于添加对应的yum源

   ```
   > uname -a
   ```

2. 禁止 selinux

   ```
   > cat /etc/selinux/config |grep -v '#' |grep -i selinux

   显示如下正确
   SELINUX=disabled	    SELINUXTYPE=targeted

   如果没有则需要修改配置，并且重启
   > sed -i '/SELINUX/s/enforcing/disabled/' /etc/selinux/config
   ```

3. 添加Yum源

   ```
   > vim /etc/yum.repos.d/mongodb-3.2.repos
   ```

   添加如下内容：

    ```
    [mongodb-org-3.2]

    name=MongoDB Repository

    baseurl=https://repo.mongodb.org/yum/redhat/7/mongodb-org/3.2/x86_64/

    gpgcheck=0

    enabled=1

    ```

**注意：**
链接可到[https://repo.mongodb.org/yum/redhat/](https://repo.mongodb.org/yum/redhat/)  获取

4. 可先执行一下yum update命令

   执行以下命令进行安装

   ```
   > yum -y install mongodb-org
   ```

5. 安装完成之后找到配置文件进行设置

   ```
   配置文件在：/etc/mongod.conf
   数据文件在：/var/lib/mongo
   日志文件在：/var/log/mongodb
   ```
