##1.1 Cmake编译安装时
###1.1.1
####错误信息
```
170818 01:53:26 mysqld_safe Starting mysqld daemon with databases from /data/3306/data
170818 01:53:26 mysqld_safe mysqld from pid file /data/3306/mysqld.pid ended
```
####解决办法:
	删除data目录下已经存在的文件（必须在此目录为空时初始化数据库才可以），然后初始化数据库

###1.1.2
####错误信息
```
/usr/local/mysql/bin/mysqld: File ‘./mysql-bin.index' not found (Errcode: 13)
```
####解决办法:
	errcode13，一般就是权限问题，mysql用户是否对数据库目录内的所有文件具有写的权限，查看一下权限，修改MySQL目录的用户和用户组权限
```
 > chown -R mysql:mysql   /usr/local/mysql
```


----------


##1.2多实例(mysqld_multi方式)
###1.2.1
####错误信息
	Mysql5.5 启动 报unknown option '--skip-locking'
####解决方法:
	1.MySQL 5.5.已经移除了--skip-locking
	2.修改my.ini中将skip-locking替换为skip-external-locking
###1.2.2
####错误信息
```
Unknown/unsupported storage engine: InnoDB
```
####解决方法:
	1.检查一下配置文件中关于innodb的参数，如果有skip-innodb注释掉
	2.如果重新设置了innodb_log_file_size之类的，需要删除几个ib_logfile，然后重启数据库

###1.2.3
####错误信息
	mysqld_multi停止不掉MySQL
####解决办法：
	修改mysqld_multi的如下行 （MySQL5.5之后好像不支持-s  或报错）
```
	my $com= join ' ', 'my_print_defaults', @defaults_options, $group;
	修改为
	my $com= join ' ', 'my_print_defaults -s', @defaults_options, $group;
```


###1.2.4
####错误信息
	实战中我用尽了洪荒之力还是不行，最后发现是因为my.cnf的账号填的不对
####解决办法：
```
	[mysqld_multi]
	mysqld = /usr/local/mysql/bin/mysqld_safe
	mysqladmin = /usr/local/mysql/bin/mysqladmin
	user=root   # 注意:这里指的是mysql账号  我填成了系统账号.....
	password=password
```
