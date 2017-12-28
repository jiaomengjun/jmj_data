# **Mac配置PHP开发环境**
## **Apache配置**
##### **MacOS 中自带Apache，只需启动服务就好以下是操作Apache常用的几个命令：**
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
###### **注意：**   
    1.在浏览器中输入localhost。出现It works字样，说明Apache就搞定了
 	2.Apache的网站服务器根目录在/Library/WebServer/Documents路径下

## **PHP配置**
##### **Mac OS自带PHP，只需在Apache的配置文件中添加Apache对PHP的支持，如下：**
```
	1.编辑http.conf配置文件，命令如下：
        sudo vim /etc/apache2/httpd.conf
    2.去掉以下部分的注释：
        LoadModule php5_module libexec/apache2/libphp5.so
    3.重启Apache服务；
    4.简单的测试一下
        <?	php phpinfo(); ?>
```
## **MySQL配置**
**1、先在官网下载想要的版本的压缩文件**
**2、找到下载的 MySQL tar.gz 文件位置，进入终端, 解压 tar.gz 文件:**
**3、解压完成后得到 mysql-5.6.24-osx10.9-x86_64 目录**
**4、移动解压目录到 MySQL/usr/local/mysql下, /usr/local，路径不存在时, 先 sudo mkdir /usr/local 创建**。
```
	cd /Users/<YourName>/Downloads
	tar zxvf mysql-5.6.24-osx10.9-x86_64.tar.gz
```
**5、移动解压后的二进制包到安装目录**
```
 sudo mv mysql-5.6.24-osx10.9-x86_64 /usr/local/mysql
```
**6、更改 mysql 安装目录所属用户与用户组**
```
  cd /usr/local
  sudo chown -R root:wheel mysql
```
**7、执行 scripts 目录下的mysql_install_db 脚本完成默认的初始化(创建默认配置文件、授权表等)**
```
  cd /usr/local/mysql
  sudo scripts/mysql_install_db --user=mysql
```        
**注意: MySQL 5.7.6 以上版本取消了 scripts 目录,如果是5.7以上的上步不操作, 初始化命令改成了**
```
sudo /usr/local/mysql/bin/mysqld --initialize --user=mysql
```
#### **基本命令：**
    启动			       sudo /usr/local/mysql/support-files/mysql.server start
    重启		           sudo /usr/local/mysql/support-files/mysql.server stop
    停止		           sudo /usr/local/mysql/support-files/mysql.server stop
    检查 MySQL 运行状态   sudo /usr/local/mysql/support-files/mysql.server status
##### **可以简化一下：在~/.bash_aliases中添加这样的命令：**
```
	alias mysqlstart='sudo /usr/local/mysql/support-files/mysql.server start'
	alias mysqlstop='sudo /usr/local/mysql/support-files/mysql.server stop'
```
**注意：如果没有.bash_aliases文件，创建一个，在.bash_profile文件的最后加上这样的代码：**
```
    if [ -f ~/.bash_aliases ]; then
	    . ~/.bash_aliases
    fi
```
#### **创建能在终端中直接使用的MySQL快捷命令**
```
	sudo vim /etc/bashrc
在bashrc中添加创建别名的命令：
	alias mysql '/usr/local/mysql/bin/mysql'
	alias mysqladmin '/usr/local/mysql/bin/mysqladmin'
```
####**通过自带的 MySQL Client 连接数据库**
    mysql -u root -p


#### **彻底删除MySQL**
```
    sudo rm -rf /usr/local/mysql  
    sudo rm -rf /usr/local/mysql*  
    sudo rm -rf /Library/StartupItems/MySQLCOM  
    sudo rm -rf /Library/PreferencePanes/My*  
    sudo nano /etc/hostconfig
```     
**复制前面部分回车，然后删掉这一行: **
```
	MYSQLCOM=-YES-，
```
**control+O回车保存，control+X退出编辑界面**
```
    sudo rm -rf ~/Library/PreferencePanes/My*  
    sudo rm -rf /Library/Receipts/mysql*  
    sudo rm -rf /Library/Receipts/MySQL*  
    sudo rm -rf /var/db/receipts/com.mysql.*
```

#### **MySQL5.7以上重置默认密码：**
1. 关闭mysql服务
2. 执行命令
```
	/usr/local/mysql/bin/mysqld_safe --skip-grant-tables &
```
	3. 新建终端窗口，输入mysql进入数据库
	4. 执行     FLUSH PRIVILEGES;
	5. 执行     SET PASSWORD FOR 'root'@'localhost' = PASSWORD('你的新密码');
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


# **ZIP包在Win7X64配置Apache+Mysql+PHP环境**

###**工具：**

- Apache 2.4.23 X64位

  1. 下载地址:官网 [http://httpd.apache.org/](http://httpd.apache.org/)  

  2. 找到要下载版本

     Download—>[Files for Microsoft Windows](#down)--> [ApacheHaus](http://www.apachehaus.com/cgi-bin/download.plx)—>找到对应版本点击下载  

- PHP 5.7.38 X64位
  1. 下载地址: [http://windows.php.net/qa/](http://windows.php.net/qa/)  注意下载Thread Safe版   并要与电脑版 本一样  	x86 x64
- Mysql 5.7.14 X64
  1. 下载地址: [http://dev.mysql.com/downloads/mysql/](http://dev.mysql.com/downloads/mysql/) downloadsàcommunityàMySQL Community 						 	Server，进入之后选择Microsoft Windows之后找到要下载的版本，点击后 面download 之后找到No Thinks,just start my download就可以了

### **Apache的安装**

#### **一、 安装：**

1. **首先在要安装的盘下新建文件夹，这里比如我要建在F:wamp/文件夹里。，比如apache装在F:/wamp/Apache文件夹里，把下载好的httpd-2.4.23-x64-vc14.zip解压到F:/wamp/Apache文件夹里**。

2. **然后以管理员身份运行命令行窗口，具体方法：开始菜单(所有程序(附件(右键命令提示符(以管理员身份运行）**

3. **在命令行进入Apache的bin目录下 F:\wamp \Apache\bin。步骤为：输入 f: 回车，再输入 cd F:\wamp \Apache\bin 回车**。

4.  **修改配置文件，对httpd.conf进行编辑**

   1. 先找到ServerRoot 把值改为F:/wamp/Apache，注意 / ,

   2. 然后搜索到#LoadModule xml2enc_module modules/mod_xml2enc.so 在这一行下面添加:

      ```
      LoadModule php5module "F:/wamp/PHP/php5apache24.dll"

      PHPiniDir "F:/wamp/PHP"

      AddType application/x-httpd-php .html .htm .php
      ```

   3. **注意**

      看下载php文件夹里面是否有php5apache2_4.dll，没有则说明下载错了

   4. 找到DocumentRoot 这个是设置网页文件存放的根目录，可以随意设置,比如我在wamp下新建www目录，就可以 把值改为F:/wamp/www,下面的一行目录也应改成同样的

   5. 找到 ServerName localhost:80 把前面的注释去掉

#### **二、 常见问题及解决办法**

1. **80端口被其他服务占用**

   解决办法:

   1. 命令提示符中输入netstat -ano 即可看到所有连接的PID，之后在任务管理器中找到这个PID所 						对应的程序，如果任务管理器中没有PID这一项，可以在任务管理器中选"查看"-"选择列"

   2. 也可以在windows命令行窗口下执行：

      ```
      查看所有的端口占用情况：C:>netstat –ano
      查看指定端口的占用情况：C:>netstat -aon|findstr "80" //80为端口号
      查看PID对应的进程：C:>tasklist|findstr "2016" //2016为PID
      结束该进程：C:>taskkill /f /t /im tor.exe //tor.exe为具体进程
      ```

   3. 修改端口: 在Apache配置文件中查找到“Listen 80”，将80改为其他数字作为端口号，再	将“ServerName www.example.com:80”中的80改为相同的数字

   4. 最后再执行httpd -k start。

2. **启动失败**

   错误代码:

   ```
   AH00433
   AH00436:执行httpd -k install  进行实验；有可能出现httpd.conf错误
   ```



### **PHP的安装配置**

#### **一、 安装：**

1. 在F:/wamp文件夹下新建PHP文件夹，把下载好的php-5.6.25RC1-Win32-VC11-x64.zip解压到F:/wamp/PHP文件夹里（这个目录不是随便建的，要与Apache的安装步骤四的B中的目录对应）
2. 对php.ini文件进行配置，如果不存在php.ini，就把php.ini-production复制一份重命名位php.ini并进行编辑，
   1. 查找到extension_dir，修改extension_dir = "F:\wamp\PHP\ext",注意前面的“;”
   2. 找到扩展列表，;extension=php_gd2.dll、;extension=php_mysql.dll、;extension=php_mysqli.dll，将其前面的“;”去掉即为开启该扩展，你也可根据功能需求不同					开启相应扩展，方法同此。
3. PHP配置完毕。

### **Mysql的安装配置**

#### **一、 安装：**

1.  **在F:/wamp下新建Mysql文件夹，并把下载的mysql-5.7.14-winx64.zip文件解压到Mysql文件夹**。

2. **Mysql文件夹下新建个my.ini，复制下面的代码保存就ok了**

   ###### 注意：把里面D:\mysql\mysql-5.6.17-winx64改成你自己的软件路径

   ```
   [mysql]
   # 设置mysql客户端默认字符集
   default-character-set=utf8

   [mysqld]
   #设置3306端口
   port = 3306
   # 设置mysql的安装目录
   basedir=D:\mysql\mysql-5.6.17-winx64
   # 设置mysql数据库的数据的存放目录
   datadir=D:\mysql\mysql-5.6.17-winx64\data
   # 允许最大连接数
   max_connections=200
   # 服务端使用的字符集默认为8比特编码的latin1字符集
   character-set-server=utf8
   # 创建新表时将使用的默认存储引擎
   default-storage-engine=INNODB
   ```

3. **以管理员身份运行cmd,将目录切换到Mysql所在的bin目录，再输入mysqld install回车运行就行了，若是my.ini写错的话，错误码是1067**

4. **接着就是在输入 net start mysql 启动服务**

#### **二、 常见问题及解决办法**

1. **数据库密码忘记**

   解决办法:

   1. 首先，同时按下win7旗舰版电脑键盘上的win+R快捷键打开电脑的运行窗口，之后，运行窗口中输入services.msc并单击回车

   2. 在进入到win7旗舰版电脑的服务窗口之后，咱们找到右侧窗口中的“MySQL56”，选定，将其“停止”即可，这样，MySQL Server服务就停止了

   3. 接下来，咱们需要找到MySQL在win7旗舰版电脑中的安装位置，找到之后，咱们会看到其文件夹中有一个ini格式的文件，该文件便是用来记录MySQL的配置信息的文件

   4. 咱们直接打开win7旗舰版电脑中的命令提示符窗口，接着，打开命令行窗口，输入如下的命令：

      ```
      C:\Users\wang>mysqld --defaults-file="D:\Program Files\MySQL\MySQL Server 5.6\my-default.ini" --console --skip-grant-tables
      ```

      ###### 注意：请根据你安装mysql配置的文件位置进行相应变化

   5. 另外打开一个命令行窗口，输入命令：mysql -u root -p，回车即可进入mysql命令行界面。

   6. 最后一步，修改win7旗舰版系统的数据库，将密码进行更新即可

      ```
      show databases;
      use mysql;
      update user set password=PASSWORD('12345') where USER='root';
      ```

      **注意：**

      ###### 	最后一条命令，高版本的password字段为authentication_string

2. **第一次登陆或者有时解决完第一个问题也会需要再次设置 密码，如果直接执行mysql语句会出现报错信息为1820**

   解决办法:

   1. 第一次登陆mysql不需要密码

   2. 登录mysql之后，设置root密码

      ```
      set password for root@localhost = password('YourPassword');
      ```

      或者使用mysqlamdin修改root密码

      ```
      mysqladmin -u root -p password NewPassword
      ```

3. **同一机器上安装多个mysql**

   解决办法:

   1. 按照正常方法进行解压安装，将mysql程序直接解压到某个目录,(假设目录为d:\mysql_1)

      注意：如果你的数据库表单包含innodb类型的表可能不能访问

   2. 修改mysql的配置文件my.ini

      1. 将port=3306的选项修改成其他端口(如果和本机上的其他mysql端口重复)

      2. 修改以下参数

         ```
         basedir=d:/mysql_1/
         datadir=d:/mysql_1/data/
         ```

      3. 将my.ini拷贝至d:\mysql_1目录下(其他目录均可，只是在设置服务时defaults-file参数需对应)

      4. 将mysql设置成服务,在dos界面进入mysql安装下bin目录，执行一下代码

         ```
         mysqld-nt --install mysql_cy --defaults-file=d:\mysql_1\my.ini
         ```

         注意：其中mysql_cy是mysql的服务名，d:\mysql_1\my.ini为安装的my.ini的路径，有的mysql的bin目录下没有mysqld-nt.exe，有可能是mysqld.exe

      5. myql服务的移除

         进入mysql的bin目录后，执行：

         ```
         mysqld-nt --remove mysql_cy
         ```

4. **同一机器上安装多个mysql怎么启用服务和进入数据库**

   解决办法:

   1. 启用mysql服务: 使用安装时设置的不同服务名来启动服务

      ```
      net start mysql		net start mysql02
      ```

   2. 进入mysql:

      ```
      mysql -u -p -P3307			3307为端口
      ```

5. **初始化为用户设置密码**

   解决办法:

   ```
   update user set authentication_string=password('123qwe') where user='root' and Host = 'localhost';
   ```

   注意:修改完毕要重启数据库
