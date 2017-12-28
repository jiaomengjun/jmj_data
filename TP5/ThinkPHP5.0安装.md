# [thinkphp5.0安装](http://www.cnblogs.com/chinalorin/p/5828392.html)

### ThinkPHP5的环境要求如下：

- PHP >= 5.4.0
- PDO PHP Extension
- MBstring PHP Extension
- CURL PHP Extension

### 一、下载ThinkPHP安装

- 官方网站（[http://thinkphp.cn](http://thinkphp.cn/)）是最好的下载和文档获取来源。
- 官网稳定版本的下载：[http://thinkphp.cn/down/framework.html](http://thinkphp.cn/down/framework.html)

### 二、使用Composer安装

###### 	ThinkPHP支持Composer安装，如果还没有安装 Composer，你可以按 [Composer安装](http://www.kancloud.cn/thinkphp/composer/35669) 中的方法安装,(也可查看之前的composer安装笔记)

1. 在 Linux 和 Mac OS X 中可以运行如下命令安装composer：

   ```
   curl -sS https://getcomposer.org/installer | php
   mv composer.phar /usr/local/bin/composer
   ```

2. 然后在命令行下面，切换到你的web根目录下面并执行下面的命令：

   ```
   composer create-project topthink/think tp5 dev-master --prefer-dist
   ```

   附：如果国内访问composer的速度比较慢，参考说明==>[使用国内镜像](http://pkg.phpcomposer.com/)

### 三、Git安装

- 应用项目：https://github.com/top-think/think


- 核心框架：https://github.com/top-think/framework

1. 首先克隆下载应用项目仓库

   ```
   git clone https://github.com/top-think/think tp5
   ```

2. 然后切换到tp5目录下面，再克隆核心框架仓库：

   ```
   git clone https://github.com/top-think/framework thinkphp
   ```

3. 两个仓库克隆完成后，就完成了ThinkPHP5.0的Git方式下载，如果需要更新核心框架的时候，只需要切换到thinkphp核心目录下面，然后执行：

   ```
   git pull https://github.com/top-think/framework
   ```

 