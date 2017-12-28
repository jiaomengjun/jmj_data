# Redis 安装

## Window 下安装

- **下载地址：**[https://github.com/MSOpenTech/redis/releases](https://github.com/MSOpenTech/redis/releases)。

1. Redis 支持 32 位和 64 位。这个需要根据你系统平台的实际情况选择，这里我们下载 **Redis-x64-xxx.zip**压缩包到 C 盘，解压后，将文件夹重新命名为 **redis**。

2. 打开一个 **cmd** 窗口  使用cd命令切换目录到 **C:\redis**  运行 **redis-server.exe redis.windows.conf** 。

   ```
   redis-server.exe redis.windows.conf
   ```

3. redis作为windows服务启动方式

   ```
   redis-server --service-install redis.windows.conf
   ```

4. dos命令

   ```
   启动服务：redis-server --service-start

   停止服务：redis-server --service-stop
   ```

5. 如果想方便的话，可以把 redis 的路径加到系统的环境变量里，这样就省得再输路径了，后面的那个 redis.windows.conf 可以省略，如果省略，会启用默认的。

6. 这时候另启一个cmd窗口，原来的不要关闭，不然就无法访问服务端了。

7. 切换到redis目录下运行 **redis-cli.exe -h 127.0.0.1 -p 6379** 。

   ```
   redis-cli.exe -h 127.0.0.1 -p 6379
   ```

   1. 设置键值对 **set myKey abc**

      ```
      > set myKey abc
      ```

   2. 取出键值对 **get myKey**

      ```
      > get myKey
      ```

------

## Linux 下安装

- **下载地址：**[http://redis.io/download](http://redis.io/download)，下载最新文档版本。

1. 本教程使用的最新文档版本为 2.8.17，下载并安装：

   ```
   > wget wget http://download.redis.io/releases/redis-3.2.8.tar.gz
   > tar xzf redis-3.2.8.tar.gz
   > cd redis-3.2.8
   > make && make install
   ```


2. make完后 redis-3.2.8目录下会出现编译后的redis服务程序redis-server,还有用于测试的客户端程序redis-cli,两个程序位于安装目录 src 目录下：

3. 启动、关闭redis服务

   ```
   > cd src
   > ./redis-server		#启动
   > ./redis-cli -p 6379 shutdown		#关闭
   ```

4. **注意**

   ###### 这种方式启动redis 使用的是默认配置。也可以通过启动参数告诉redis使用指定配置文件使用下面命令启动

   ```
   > cd src
   > ./redis-server redis.conf     redis.conf是一个默认的配置文件。我们可以根据需要使用自己的配置文件。
   ```

5. 启动redis服务进程后,就可以使用测试客户端程序redis-cli和redis服务交互。比如：

   ```
   > cd src
   > ./redis-cli
   redis> set foo bar
   OK
   redis> get foo
   "bar"
   ```

##### redis作为系统服务并开机启动

1.   将redis服务作为守护进程来运行，修改配置文件

     ```
     > vi redis.conf

       - daemonize	表示是否作为守护进程运行,默认为false,改为true
       - pidfile   	当服务已手机进程方式运行时,redis默认会把pid写入这个路径文件中，服务运行中该文件会存在,服务一旦停止该文件就自动删除,可以根据这个文件来判断redis是否正在运行,可不修改,默认即可,

       修改成功之后保存退出
     ```

2. 在 /etc/目录下创建 redis目录,把配置文件复制到该目录下

     ```
     > cd /etc
     > mkdir redis
     > cp /usr/local/src/redis2.8.17/redis.conf /etc/redis/6379.conf
     ```

3. 管理启动、关闭、重启、查看状态的脚本

 ###### redis源码里其实已经提供了一个初始化脚本,在安装目录下的utils里面有个**redis_init_script**即是。

4. 对该脚本进行修改

5. 添加一句    # chkconfig: 2345 90 10
6. 分别修改EXEC(redis-server的路径)、CLIEXEC(redis-cli的路径)、CLIEXEC(守护进行方式的pid所在文件路径,要和配置文件中的pidfile一致)、CONF(刚才复制的配置文件路径)的值

   ```
   #!/bin/sh#
   # chkconfig: 2345 90 10

   REDISPORT=6379
   EXEC=/usr/local/src/redis-3.2.8/src/redis-server
   CLIEXEC=/usr/local/src/redis-3.2.8/src/redis-cli

   CLIEXEC=/var/run/redis_${REDISPORT}.pid
   CONF="/etc/redis/${REDISPORT}.conf"

   case "$1" in
       start)
           if [ -f $PIDFILE ]
           then
                   echo "$PIDFILE exists, process is already running or crashed"
           else
                   echo "Starting Redis server..."
                   $EXEC $CONF
           fi
           ;;
       stop)
           if [ ! -f $PIDFILE ]
           then
                   echo "$PIDFILE does not exist, process is not running"
           else
                   PID=$(cat $PIDFILE)
                   echo "Stopping ..."
                   $CLIEXEC -p $REDISPORT shutdown
                   while [ -x /proc/${PID} ]
                   do
                       echo "Waiting for Redis to shutdown ..."
                       sleep 1
                   done
                   echo "Redis stopped"
           fi
           ;;
       *)
           echo "Please use start or stop as first argument"
           ;;
   esac
   ```

5. 复制redis_init_script脚本到/etc/init.d/redisd

   ```
   cp /usr/local/src/redis-3.2.8/utils/redis_init_script /etc/init.d/redisd
   ```

6. 在/etc/init.d下的脚本都是可以在系统启动是自动启动的服务,配置redis随系统启动

   ```
   chkconfig redisd on
   ```

7. 操作命令

   ```
   > service redisd start
   > service redisd stop
   > service redisd status
   > service redisd restart

   centos7以上
   > systemctl start redisd
   > systemctl stop redisd
   > systemctl status redisd
   > systemctl restart redisd
   ```

------

## Ubuntu 下安装

1. 在 Ubuntu 系统安装 Redi 可以使用以下命令:

   ```
   $sudo apt-get update
   $sudo apt-get install redis-server
   ```

2. 启动 Redis

   ```
   redis-server
   ```


3. 查看 redis 是否启动？

   ```
   redis-cli
   ```


4. 以上命令将打开以下终端：

   ```
   redis 127.0.0.1:6379>
   ```


5. 127.0.0.1 是本机 IP ，6379 是 redis 服务端口。现在我们输入 PING 命令。

   ```
   redis 127.0.0.1:6379> ping
   PONG
   ```
