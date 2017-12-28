## 使用PHP操作Memcached
### 1.创建一个Memcached对象
```php
	$m = new Memcached();
```
### 2.传入服务器
```php
	//一台服务器
		$m->addServer('127.0.0.1','11211');
	//多台服务器
		$servers = array(
    		array('127.0.0.1','11211'),
    		array('127.0.0.2','11211')
    		);
		$m->addServers($servers);
	//查看一下运行状态
		print_r($m->getStats());
	//获取memcached版本
	    $m->getVersion();
```
##### 执行结果得到以下结果:
```
Array ( [127.0.0.1:11211] => Array ( [pid] => 1164 [uptime] => 80 [threads] => 4 [time] => 1491374933 [pointer_size] => 64 [rusage_user_seconds] => 0 [rusage_user_microseconds] => 0 [rusage_system_seconds] => 0 [rusage_system_microseconds] => 9556 [curr_items] => 0 [total_items] => 0 [limit_maxbytes] => 67108864 [curr_connections] => 10 [total_connections] => 32 [connection_structures] => 11 [bytes] => 0 [cmd_get] => 0 [cmd_set] => 0 [get_hits] => 0 [get_misses] => 0 [evictions] => 0 [bytes_read] => 302 [bytes_written] => 21588 [version] => 1.4.15 ) )
```
###### 注意：因为传入的第二台服务器是不存在的，所以无法获取到正确的信息。也可以使用getVersion()来直接获取memcached的版本信息。
### 3.add()方法和get()方法
```php
	/*
	 * add()
	 * key代表加入缓存的key值
	 * value代表加入缓存的value值
	 * 600代表这条缓存的生效时间为600秒，0代表永久生效
	 */

	$m->add('key','value',600);

	/*
	 * get()
	 * 通过key值来获取缓存
	 */

 	echo "缓存key值：".$m->get('key);
```


如果我在第一个add()方法下面再添加一个：
```php
$m->add('key','value1',600);
```
其实这样是不会覆盖掉前面的值得，如果想要覆盖的话可以使用replace()方法
### 4.replace()方法
```php
	$m->add('key','value',600);

	$m->replace('key','value11',600);
```
##### 这样当我们再次get(‘key’)的时候就会获取到value11了。
### 5.set()方法
##### set()方法其实就集成了add方法和replace方法，如果set的key值是不存在的，它就相当于add方法，如果set的key值已经存在了，它就相当于replace方法，所以一般的时候set方法才是最常用的方法。
```php
	$m->set('key','value',600);
```
### 6.delete()方法,删除缓存
```php
	/*
	 * delete()
	 * 传入一条缓存的key
	 */
	$m->delete('key');
```
##### 假如我上面添加的缓存失效时间还没有到，执行delete方法后，我们依然无法获取到这条缓存了。
### 7.flush()方法
##### **直接清除掉所有的缓存！（慎用！！！）**
### 8.increment()方法,加法操作
```php
	//设置一条key值为num，value为5，永久生效的缓存,只需要第一次时候设置缓存即可,之后每次访问缓存值都会递增
	$m->set('num',5,0);
	//没刷新一次页面key值为num的缓存value加5
	$m->increment('num',5);
	//输出这条缓存
	echo $m->get('num');
```
### 9.decrement()方法
##### **和increment()方法相似，只是变成了减法，具体使用方法和increment()方法一样。**


### 10.setMulti()方法,更加优雅的使用Memcached方法
##### 如果一直按照前面的方法进行set缓存的话，一条一条存入是很慢的，所以Memcached为我们提供给了setMulti()方法，使用方法如下：
```php
	//首先定义要存入缓存的数组
	$data = array(
		'key1'=>'value1',
		'key2'=>'value2'
	);
	/*
	 * setMulti()
	 * 第一个参数代表传入的数组，第二个参数代表生效时间，0代表永久
	 */
	$m->setMulti($data,0);
```
### 11.getMulti()方法
##### 同样获取缓存也可以一次获取多条缓存，使用方法如下：
```php
	//定义获取缓存的key值得数组
	$get = array('key1','key2');
	/*
	 * getMulti()
	 * 传入需要获取缓存的key值
	 */
	$result = $m->getMulti($get);
	var_dump($result);
```
### 12.deleteMulti()方法
##### 和getMulti()方法类似，不过是删除缓存，使用方法如下：
```php
	$delete = array('key1','key2');
	$m->deleteMulti($delete);
	//这时key值为key1和key2的缓存就被删除掉了。
```

### 13.getResultCode()方法
##### 当正确执行时会返回0
```php
	//执行完一个操作之后可以使用这个方法来查看执行的情况,刚才执行了deleteMulti()方法，这时候可以使用getResultCode()方法来查看操作是否成功
	echo $m->getResultCode();
```
### 14.getResultMessage()方法
##### 和getResultCode()方法的区别是，getResultCode()是返回状态码，getResultMessage()方法是返回具体信息。使用方法如下：
```php
	//上面执行deleteMulti()方法
	$m->getResultMessage();
	//这回是返回一个SUCCESS的信息，告诉我们操作成功了，具体的返回信息参考上面的更多状态码链接！
```
