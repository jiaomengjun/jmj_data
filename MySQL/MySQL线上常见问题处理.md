#### MySQL锁表导致的网站故障处理
接到报警发现服务器内存占用过高，httpd进程太多。
1. 查看数据库：`SHOW processlist;`, 状态全部为 `Waiting for table metadata lock`

2.查看未提交事务
```
  select trx_state, trx_started, trx_mysql_thread_id, trx_query from information_schema.innodb_trx;
```
- trx_state: 事务状态，一般为RUNNING
- trx_started: 事务执行的起始时间，若时间较长，则要分析该事务是否合理
- trx_mysql_thread_id: MySQL的线程ID，用于kill
- trx_query: 事务中的sql

 查看时间，如果是长时间持续未提交完成的事务，在事务没有完成之前，表上的锁不会释放

3.解决
1. 杀死掉该事务  `kill trx_mysql_thread_id`
```
  KILL 822614518;
```
2. 调整锁超时阈值。lock_wait_timeout 表示获取metadata lock的超时（单位为秒），允许的值范围为1到31536000（1年）。 默认值为31536000，调整为30分钟
```
  set session lock_wait_timeout = 1800;
  set global lock_wait_timeout = 1800;
```
3. 重启数据库也可以解决



#### gruop by报错
错误信息：this is incompatible with sql_mode=only_full_group_by  
解决方案:
  1. 在配置文件my.cnf中关闭sql_mode=ONLY_FULL_GROUP_BY
msqyl的默认配置是
```
  sql_mode=ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION。
```
  2. 可以把ONLY_FULL_GROUP_BY去掉，如果你确信其他选项不会造成影响的话也可以去掉所有选项设置成sql_mode=
