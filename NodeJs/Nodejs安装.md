## Ubuntu安装NodeJs
所有历史版本：
- http://nodejs.org/dist/
- https://nodejs.org/download/release/

### 方法1：
（推荐使用：直接安装在系统环境/usr/bin目录下，之后使用npm -g安装其他插件也会安装到/usr/lib/node_modules’(需要使用sudo权限)）
```
  > url -sL https://deb.nodesource.com/setup_9.x | sudo -E bash -
  > sudo apt-get install -y nodejs
```

### 方法2：压缩包方式
每次npm -g安装插件都会安装在nodejs原路径下的node_modules
##### 1. 首先下载压缩包
`wget https://nodejs.org/dist/v9.2.0/node-v9.2.0-linux-x64.tar.gz`
##### 2. 解压
` tar -xvf node-v9.2.0-linux-x64.tar.gz `
##### 3. 进入node命令，测试是否可用
```
  > cd node-v9.2.0-linux-x64/bin
  > ./node -v   #显示版本号则说明可用
```
##### 4. 将node设置为全局
```
  > sudo ln /var/local/node-v9.2.0-linux-x64/bin/node /usr/local/bin/node
```
##### 5. 将npm设置全局

 1. 首先查看当前目录的npm是否是一个软连接,执行`> ll`

 2. 如果是一个软连接的话测试执行`> sudo ln /var/local/node-v9.2.0-linux-x64/bin/npm /usr/local/bin/npm`创建出来的不能用，应该到 `/usr/local/bin` 目录下重新创建一个软连接到目标文件就可以用了
 ```
  > sudo ln -s  /var/local/node-v9.2.0-linux-x64/lib/node_modules/npm/bin/npm-cli.js npm
 ```


### 方法3：
也可以使用ubuntu自带apt-get安装,安装后使用node -v查看版本
```
  > sudo apt-get install nodejs-legacy nodejs #会安装nodejs和npm
```

###卸载npm和nodejs

#### 1. 方法1和3安装的卸载
```
  > sudo npm uninstall npm -g   #卸载npm
  > sudo apt-get remove nodejs    #卸载node
```

#### 2. 压缩包方式安装的卸载
- 删除安装目录
```
  > sudo rm -rf /var/local/node-v9.2.0-linux-x64
```
- 删除配置的全局命令
```
  > sudo rm -f /usr/local/bin/node
  > sudo rm -f /usr/local/bin/npm
```

















```
