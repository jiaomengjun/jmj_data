##### 创建控制器
```
php artisan make:controller Photo/PhotoController
```  
## Photo/PhotoController为多级目录的方式创建


##### 数据库迁移相关
###### 使用Artisan命令make:migration来创建一个新的迁移
```
php artisan make:migration create_pay_order_log_table --create=pay_order_log
```
新的迁移位于database/migrations目录下，每个迁移文件名都包含时间戳从而允许Laravel判断其顺序


###### --table和--create选项可以用于指定表名以及该迁移是否要创建一个新的数据表。这些选项只需要简单放在上述迁移命令后面并指定表名
```
    php artisan make:migration add_votes_to_users_table --table=users
    php artisan make:migration create_users_table --create=users
```
    如果你想要指定生成迁移的自定义输出路径，在执行make:migration命令时可以使用--path选项，提供的路径应该是相对于应用根目录的

###### 修改表结构新增字段需新建一个迁移文件,注意命名要规范
    1.生成迁移文件
        php artisan make:migration add_votes_to_users_table --table=users
    2.然后在生成的迁移文件的up函数里面写入要添加的字段 ->after 代表在某个字段后添加,不加则在最后
        $table->string('seruname','100')->after('money')-> nullable()->comment('给用户发的账号名');
    注意: 如果在执行迁移时发生「class not found」错误，试着先执行 composer dump-autoload 命令后再进行一次。

###### 执行迁移
    php artisan migrate
