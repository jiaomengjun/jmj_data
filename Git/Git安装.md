### 安装（Windows）

##### 下载地址：

- https://git-for-windows.github.io/
- https://github.com/waylau/git-for-win

**第一步：下载并进行安装即可**

**第二步：打开git-bash，输入命令进行身份验证**
  ```
    > git config --global user.name "zhaoduo666"
    > git config --global user.email "6519@163.com"
  ```
---

### 安装（Linux）

- ​可以试着输入`git`，看看系统有没有安装Git

**方法一：编译安装**

1. 首先先更新系统

   ```
    > yum update
   ```

2. 安装依赖的包

   ```
     > yum install curl-devel expat-devel gettext-devel openssl-devel zlib-devel gcc perl-ExtUtils-MakeMaker
   ```

3. 下载源码并解压缩

   ```
     > wget https://github.com/git/git/archive/v2.3.0.tar.gz
     > tar -zxvf v2.3.0.tar.gz
     > cd git-2.3.0
   ```

4. 编译安装

   ```
     > make configure
     > ./configure --prefix=/usr
     > make all doc info
     > sudo make install install-doc install-html install-info
   ```

5. 设置环境变量使git命令全局可用

   ```
     # 在主目录的.bash_profile或者/etc/profile文件加入设置环境变量
     > export PATH=/usr/libexec/git-core:$PATH		# /usr/为git的安装目录

     # 然后重启登录或者source一下该文件使其生效。
   ```

方法二：直接yum安装**
- 执行以下命令
  ```
    > yum install git
  ```
---

### 安装（Ubuntu）
##### 命令行直接输入 `git` 看系统是否已经安装
1. 如果安装了则会给你一些git的提示信息。如果没安装则会提示你安装，附带安装命令
    ```
      > sudo apt install git
    ```
2. 执行以上命令 输入 `Y` 等待安装完成即可
3. 使用命令进行git的设置
    ```
      >  git config --global user.name "*****"
      >  git config --global user.email "*********@163.com"
    ```


---

### Mac（Mac上最好的GIT免费GUI工具是[SourceTree](http://www.sourcetreeapp.com/)）



### 卸载（Linux）

- 执行以下命令即可
  ```
    > yum -y remove git
  ```
