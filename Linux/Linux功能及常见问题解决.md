## 常见问题

### 乱码解决

1. 安装乱码解决工具iconv

   1. 首先确定有没有安装这个ICONV包

      ```
      > rpm -qf `which iconv`
      ```

   2. 如果没有安装,用下面命令安装

      ```
      > rpm -ihv /mnt/Packages/glibc-common-2.17-105.el7.x86_64.rpm
      ```

2. 通过iconv命令转码

   1. 输入/输出格式规范

      ```
      -f     --from-code=名称		原始文本编码
      -o     --output=FILE		  输出文件
      -l	   --list				  列出所有已知的字符集
      ```

      **注意：** GB2312编码适用于汉字处理

   2. 例子：

      ```
      > iconv -f gb2312 test.txt -o new.txt
      ```

---

### 恢复Linux下误删除的文件

- xt4文件系统上      		http://sourceforge.net/  	**extundelete**
- windows恢复误删除的文件：  final data v2.0 汉化版  和  easyrecovery

1. 安装tree命令

   ```linux
     > rpm -ivh tree-1.5.3-2.el6.x86_64.rpm
     # 安装完成之后即可 使用  tree 目录   以树形查看目录结构
   ```

2. 文件被删除之后要做的首先是卸载要恢复文件的分区
    ```linux
      umount /sdb1
    ```
3. 把下载好的extundelete上传到linux中，然后解压并安装extundelete

   ```linux
     > tar jxf extundelete-0.2.4.tar.bz2
     #进入解压好的目录执行
     > ./configure
     #如果报错   configure:error:Can't find ext2fs library  则执行如下命令
     > rpm -ivh /media/RHEL_6.5\ x86_64\ Disc\ 1/Packages/e2fsprogs-devel-1.41.12-18.el6.x86_64.rpm
     #然后重新执行编译安装
     > ./configure
     > make && make install
   ```

4. 开始恢复

   可以通过一下几种方法进行恢复

   - 通过inode节点恢复
   - 通过文件名恢复
   - 恢复某个目录,如目录a下的所有文件
   - 恢复所有的文件

   1. 创建一个目录用于存放恢复的数据和目录

      ```
          > mkdir /test
          > cd /test
      ```

   2. 首先查看一下删除文件的节点号

      ```
          extundelete /dev/sdc1 --inode 2
      ```

   3. 几种方法恢复

      1. 通过inode节点恢复

         ```
             # 12  要恢复文件的inode节点     /dev/sdb1    分区盘
             extundelete --restore-inode 12 /dev/sdb1
         ```

      2. 通过文件名恢复

         ```
             # passwd   文件名    /dev/sdb1    分区盘
             extundelete --restore-file passwd /dev/sdb1
         ```

      3. 恢复某个目录，如目录a下的所有文件

         ```
             # a   目录名    /dev/sdb1    分区盘
             extundelete --restore-directory a /dev/sdb1
         ```

      4. 恢复所有的文件

         ```
             # --restore-all 	/dev/sdb1    分区盘
             extundelete --restore-all  /dev/sdb1
         ```

---

### 恢复root密码
##### centos7版本：
1. 关闭selinux,然后重启,按↑↓键，选择第一项，按e进入编辑
2. 在当前页面找到ro这一项并进行修改,改为**rw  init=/sysroot/bin/sh**
3. 改完之后，按下Ctrl+X进入紧急模式
4. 在紧急模式下进入根目录,进行修改密码,执行一下命令,输入两次密码即可
	   ```
  	   > chroot /sysroot
  	   > passwd
	   ```
     如果之前系统启用了selinux,必须执行一下命令，否则系统无法正常启动程序
	   ```linux
	     > touch /.autorelabel
	   ```
5. 重启系统，先退出当前根，执行命令
	   ```linux
  	   > exit
  	   > /bin/sh shutdown –r now
	   ```

##### centos7之前版本：
1. 重启,按↑↓键，选择第一项，按e进入编辑

2. 输入空格 1，进入单用户模式

3.  回车 -》b

4. 然后修改密码

   ```
      > passwd
   ```

---

### 自制回收站
```linux
    myrm(){ D=/tmp/$(date +%Y%m%d%H%M%S); mkdir -p $D; mv "$@" $D && echo "moved to $D ok"; }
```
