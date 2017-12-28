### 索引，记得创建索引，真的很重要。

##### 举例:做模拟器游戏中心项目,从360游戏合作平台初始化获取数据插入到自己的数据库,因为是需要判断数据库里是否已经存在，存在的话更新，不存在的话插入，所以需要每次都对数据库进行查询，总共二十多万数据，执行脚本的时候MySQL    CUP占用基本都在95%以上，而且执行速度超慢，执行了好几天，第二次进行同样操作的时候，从网上看改配置文件可以提高插入速度，但是都是关于Innodb类型的表，我的表是Myisam的，配置文件就没改，但是脚本执行中查看了执行的SQL语句，一般都是select语句太慢，于是直接给查询的字段加了索引，速度马上提上去了，占用内存也降到几乎忽略不计了

#### 查看索引

```MySQL
		show index from tablename;

 	或	show keys from tablename;
```

#### 添加索引：

```MySQL
		ALTER TABLE tablename ADD INDEX ( fieldname );

	或	create index index_name on tables_name(fieldname);
```

#### 删除索引

```MySQL
		 DROP INDEX index_name ON talbe_name

	或	ALTER TABLE table_name DROP INDEX index_name

	只在删除PRIMARY KEY索引时使用：

		ALTER TABLE table_name DROP PRIMARY KEY
```

#### 显示正在运行的线程		

```MySQL
	show processlist; 
```

#### 导入导出txt文件

```MySQL
如果路径一个\不行用两个\   如果txt格式的出问题  用csv的

	//导出

		select * into outfile 'c:\data.txt' from tablename; 

	//导入

		load data local infile 'c:\data.txt' into table tablename;
```

##### 注意：

​	1. csv注意文件类型要选gb2312，不管导入导出时都是，会有汉字乱码的问题
​	2. 日期格式导入时注意选择分隔符   要和文件中日期的分隔符一致