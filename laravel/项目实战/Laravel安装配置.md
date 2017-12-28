### 全局安装

1. 使用composer安装laravel

   ```
   > composer global require "laravel/installer=~1.1"
   ```

2. 会在本地目录生成一个 ~/.composer/vendor/bin 这样的目录，目录不定可进行查找。laravel命令就是放在了这个目录里面，为了方便我们使用laravel命令，所以我们需要将他放到系统的$PATH里面，windows里面把这个路径配置到环境变量里面

   ```
   > export PATH=$PATH:/root/.composer/vendor/bin/			# /root/.composer/vendor/bin/ 为laravel所在的目录
   ```

3. 可以直接使用以下命令创建项目,会在当前目录下创建项目

   ```
   > laravel new blog		# blog 为项目的根目录名
   > laravel new MyProject --5.2    #指定版本号安装
   > composer create-project laravel/laravel MyProject "5.1.*"       #指定更早版本进行安装
   ```
   ​

### 注意：

1. 在创建项目时php要开启proc open相关函数

   开启方法：php.ini中找到disable_functions,删除所有跟proc open相关的函数

2. 需要的php扩展`OpenSSL `和`mcrypt`

3. 项目安装成功之后要对项目目录下的`storage`和`vendor`开放权限
