### PHP使用Redis

#### 连接到 redis 服务

```php
<?php
    //连接本地的 Redis 服务
   $redis = new Redis();
   $redis->connect('127.0.0.1', 6379);
   echo "Connection to server sucessfully";
         //查看服务是否运行
   echo "Server is running: " . $redis->ping();
?>
```

执行脚本输出结果为：

```
Connection to server sucessfully
Server is running: PONG
```

------

#### Redis PHP String(字符串) 实例

```php
<?php
   //连接本地的 Redis 服务
   $redis = new Redis();
   $redis->connect('127.0.0.1', 6379);
   echo "Connection to server sucessfully";
   //设置 redis 字符串数据
   $redis->set("tutorial-name", "Redis tutorial");
   // 获取存储的数据并输出
   echo "Stored string in redis:: " . $redis->get("tutorial-name");
?>
```

执行脚本，输出结果为：

```
Connection to server sucessfully
Stored string in redis:: Redis tutorial
```

------

#### Redis PHP List(列表) 实例

```php
<?php
   //连接本地的 Redis 服务
   $redis = new Redis();
   $redis->connect('127.0.0.1', 6379);
   echo "Connection to server sucessfully";
   //存储数据到列表中
   $redis->lpush("tutorial-list", "Redis");
   $redis->lpush("tutorial-list", "Mongodb");
   $redis->lpush("tutorial-list", "Mysql");
   // 获取存储的数据并输出
   $arList = $redis->lrange("tutorial-list", 0 ,5);
   echo "Stored string in redis";
   print_r($arList);
?>
```

执行脚本，输出结果为：

```
Connection to server sucessfully
Stored string in redis
Redis
Mongodb
Mysql
```

------

#### Redis PHP Keys 实例

```php
<?php
   //连接本地的 Redis 服务
   $redis = new Redis();
   $redis->connect('127.0.0.1', 6379);
   echo "Connection to server sucessfully";
   // 获取数据并输出
   $arList = $redis->keys("*");
   echo "Stored keys in redis:: ";
   print_r($arList);
?>
```

执行脚本，输出结果为：

```
Connection to server sucessfully
Stored string in redis::
tutorial-name
tutorial-list
```
