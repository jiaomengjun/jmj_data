# Macbook Pro配置PHP开发环境
## Apache配置
##### MacOS 中自带Apache，只需启动服务就好以下是操作Apache常用的几个命令：
```
  // 启动Apache服务
		sudo apachectl start
	// 重新启动Apache服务
		sudo apachectl restart
	// 关闭Apache服务
		sudo apachectl stop
	// 查看Apache的版本
		httpd －v
```
###### 注意：   
1. 在浏览器中输入localhost。出现It works字样，说明Apache就搞定了
2. Apache的网站服务器根目录在/Library/WebServer/Documents路径下

## PHP配置
##### Mac OS自带PHP，只需在Apache的配置文件中添加Apache对PHP的支持，如下：
1. 编辑http.conf配置文件，命令如下：
    ```
      sudo vim /etc/apache2/httpd.conf
    ```
2. 去掉以下部分的注释：
    ```
      LoadModule php5_module libexec/apache2/libphp5.so
    ```
3. 重启Apache服务；
4. 简单的测试一下
```     <?	php phpinfo(); ?>   ```

## MySQL配置
1. 先在官网下载想要的版本的压缩文件
2. 找到下载的 MySQL tar.gz 文件位置，进入终端, 解压 tar.gz 文件:
3. 解压完成后得到 mysql-5.6.24-osx10.9-x86_64 目录
4. 移动解压目录到 MySQL/usr/local/mysql下, /usr/local，路径不存在时, 先 sudo mkdir /usr/local 创建。
    ```
      cd /Users/<YourName>/Downloads
      tar zxvf mysql-5.6.24-osx10.9-x86_64.tar.gz
    ```
5. 移动解压后的二进制包到安装目录
    ```
      sudo mv mysql-5.6.24-osx10.9-x86_64 /usr/local/mysql
    ```
6. 更改 mysql 安装目录所属用户与用户组
    ```
      cd /usr/local
      sudo chown -R root:wheel mysql
    ```
7. 执行 scripts 目录下的mysql_install_db 脚本完成默认的初始化(创建默认配置文件、授权表等)
    ```
      cd /usr/local/mysql
      sudo scripts/mysql_install_db --user=mysql
    ```

    注意: MySQL 5.7.6 以上版本取消了 scripts 目录,如果是5.7以上的上步不操作, 初始化命令改成了
        `sudo /usr/local/mysql/bin/mysqld --initialize --user=mysql`
##### 基本命令：
    启动：			   sudo /usr/local/mysql/support-files/mysql.server start
    重启：		     sudo /usr/local/mysql/support-files/mysql.server stop
    停止：		     sudo /usr/local/mysql/support-files/mysql.server stop
    检查 MySQL 运行状态：	sudo /usr/local/mysql/support-files/mysql.server status

###### 可以简化一下：在~/.bash_aliases中添加这样的命令：
```
  alias mysqlstart='sudo /usr/local/mysql/support-files/mysql.server start'
  alias mysqlstop='sudo /usr/local/mysql/support-files/mysql.server stop'
```
注意：如果没有.bash_aliases文件，创建一个，在.bash_profile文件的最后加上这样的代码：
```
  if [ -f ~/.bash_aliases ]; then
    . ~/.bash_aliases
  fi
```

##### 创建能在终端中直接使用的MySQL快捷命令`sudo vim /etc/bashrc`  
在bashrc中添加创建别名的命令：
```
  alias mysql '/usr/local/mysql/bin/mysql'
  alias mysqladmin '/usr/local/mysql/bin/mysqladmin'
```
##### 通过自带的 MySQL Client 连接数据库
```
  mysql -u root -p
```


##### 彻底删除MySQL
```
  sudo rm -rf /usr/local/mysql  
  sudo rm -rf /usr/local/mysql*  
  sudo rm -rf /Library/StartupItems/MySQLCOM  
  sudo rm -rf /Library/PreferencePanes/My*  
  sudo nano /etc/hostconfig     
      复制前面部分回车，然后删掉这一行:
      MYSQLCOM=-YES-，
      control+O回车保存，control+X退出编辑界面
  sudo rm -rf ~/Library/PreferencePanes/My*  
  sudo rm -rf /Library/Receipts/mysql*  
  sudo rm -rf /Library/Receipts/MySQL*  
  sudo rm -rf /var/db/receipts/com.mysql.*
```

##### MySQL5.7以上重置默认密码：
1. 关闭mysql服务
2. 执行命令
    ```
      /usr/local/mysql/bin/mysqld_safe --skip-grant-tables &
    ```
3. 新建终端窗口，输入mysql进入数据库
4. 执行     `FLUSH PRIVILEGES;`
5. 执行     `SET PASSWORD FOR 'root'@'localhost' = PASSWORD('你的新密码');`
6. 如果第五步命令不行，尝试命令：
    ```
      ALTER USER 'root'@'localhost' IDENTIFIED BY 'MyNewPass';
    ```
7. 停止mysql server，再启动mysql server
8. 如果第六步中停止mysql server出现问题，就直接查看mysql process id, 再把进程杀掉，命令如下：
    ```
      sudo cat /usr/local/mysql/data/*.pid
      比如输出id是1234
      sudo kill 1234
    ```
