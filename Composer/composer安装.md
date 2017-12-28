# 说明：

- 本篇文章用到`php` 安装的方法中都可使用 ` -- --install-dir= "bin"` 参数进行指定目录安装
- 安装用到的两个网址`https://getcomposer.org/installer` 和 `http://getcomposer.org/installer`可以根据情况随意切换

# 安装（Windows）

### 方法一：使用安装程序

​	下载并且运行 [Composer-Setup.exe](https://getcomposer.org/Composer-Setup.exe)，它将安装最新版本的 Composer ，并设置好系统的环境变量，因此你可以在任何目录下直接使用 `composer` 命令。

### 方法二：手动安装

1. 在要安装的位置运行安装命令下载 composer.phar 文件：（前提是安装了php并全局可用）
    ```
       > php -r "readfile('https://getcomposer.org/installer');" | php
    ```

   **注意：** 如果收到 readfile 错误提示，请使用 `http` 链接或者在 php.ini 中开启 php_openssl.dll 。

   **或者windows配置好的curl可用,也可以通过以下命令进行下载**
   ```
      > curl -Ss https://getcomposer.org/installer | php
   ```

2. 在 `composer.phar` 同级目录下执行以下命令创建 `composer.bat` ：
   ```
      > echo @php "%~dp0composer.phar" %*>composer.bat
   ```

   **或者直接创建文件`composer.bat`加入以下内容:**
   ```
      > @php "%~dp0composer.phar" %*
   ```

3. 关闭当前的命令行窗口，打开新的命令行窗口进行测试：
   ```
      > composer -V
      Composer version 1.4.1 2017-03-10 09:29:45
   ```

4. 把安装的路径配合到环境变量`path`里面即可实现全局使用




# 安装（linux）

### 方法一：

1. 执行命令下载composer.phar文件
   ```
      > curl -sS https://getcomposer.org/installer | php
      网速较差时访问http网站进行下载
      > curl -sS http://getcomposer.org/installer | php
   ```
   或者使用 `install-dir` 参数 指定路径进行进行安装,上面的命令默认安装到当前目录下
   ```
      > curl -sS https://getcomposer.org/installer | php -- --install-dir= "bin"
   ```
   如果网站还是不行，则直接执行以下命令进行下载后执行第二步

   ```
      > wget https://getcomposer.org/download/1.4.0/composer.phar
   ```

2. 配置全局可使用

   ```
      > mv composer.phar /usr/local/bin/composer
   ```

### 方法二：（前提是安装了php并全局可用）

1. 如果curl命令不可用的话可以使用`php` 进行安装
   ```
       > php -r "readfile('https://getcomposer.org/installer');" | php
       网速较差时访问http网站进行下载
       > php -r "readfile('http://getcomposer.org/installer');" | php
   ```

2. 配置全局可使用
   ```
      > mv composer.phar /usr/local/bin/composer
   ```


# 安装（Mac）

### 方法一：

1. 执行命令下载composer.phar文件

   ```
     > curl -sS https://getcomposer.org/installer | php
     网速较差时访问http网站进行下载
     > curl -sS http://getcomposer.org/installer | php
   ```

   或者使用 `install-dir` 参数 指定路径进行进行安装,上面的命令默认安装到当前目录下

   ```
      > curl -sS https://getcomposer.org/installer | php -- --install-dir= "bin"
   ```

2. 配置全局可使用

   ```
      > mv composer.phar /usr/local/bin/composer
   ```

### 方法二：（前提是安装了php并全局可用）

1. 如果curl命令不可用的话可以使用`php` 进行安装

   ```
       > php -r "readfile('https://getcomposer.org/installer');" | php
       网速较差时访问http网站进行下载
       > php -r "readfile('http://getcomposer.org/installer');" | php
   ```

2. 配置全局可使用
   ```
      > mv composer.phar /usr/local/bin/composer
   ```


# 切换为国内镜像

### 方法一：（全局配置为国内镜像）    ★ **推荐**

**在任何地方执行一下命令即可（前提是composer是全局安装,否则要到composer目录下去执行）**

```
> composer config -g repo.packagist composer https://packagist.phpcomposer.com
```

### 方法二：（只配置当前项目使用国内镜像）

**进入项目的`composer.json`所在的目录，执行以下命令**

```
> composer config repo.packagist composer https://packagist.phpcomposer.com
```

**上述命令将会在当前项目中的 `composer.json` 文件的末尾自动添加镜像的配置信息（你也可以不执行命令而自己手工添加）：**

```json
"repositories": {
    "packagist": {
        "type": "composer",
        "url": "https://packagist.phpcomposer.com"
    }
}
```








# 卸载（windows）

方法一：

1. 如果是全局安装的话先把环境变量里面的配置给删掉

2. 自己创建的composer.phar/composer.bat/composer.json等文件删掉

3. 执行以下命令找到composer的php扩展进行删除即可

   ```
      where composer
   ```

### composer&github实现项目同步

1. github创建一个新项目

2. git clone 项目到本地

3. 进入项目目录，在项目目录执行composer init进行初始化设置,之后会在项目目录出现composer.json文件

4. 执行git更新,把生成的文件同步到github上之后在composer通过github账号登陆就可以搜出来自己的项目了

5. 这时候如果自己的项目发生了更新的话需要去packagist里面执行更新命令里面的项目才会更新

6. 设置主动向packageist里面更新项目
   1. 在github的项目设置里找到Integrations & services选项，在里面进行添加一个Services,可以直接进行搜索packagist
   2. 添加页面输入账号密码,Domain是packagist生成的token，可在packagist的个人信息里面找到API token复制过来即可
   3. 这样就实现了当本地向github上进行更新代码的时候会自动更新到packagist去
