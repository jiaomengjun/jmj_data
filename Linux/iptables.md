1. **iptables文件位置**

   ```
   /etc/sysconfig/iptables
   ```

2. **指令**

   ###### 如果你想配置属于自己的防火墙,那就清除现在filter的所有规则

   ```
   > iptables -F        清除预设表filter中的所有规则链的规则
   > iptables -X        清除预设表filter中使用者自定链中的规则
   > iptables -L -n
   > service iptables start restart stop status
   ```

3. **列出INPUT 链所有的规则**

   ```
   > iptables -L INPUT --line-numbers
   ```

4. **屏蔽单个IP的命令是**   

   ```
   > iptables -I INPUT -s 123.45.6.7 -j DROP
   ```

5. **封整个段即从123.0.0.1到123.255.255.254的命令**   

   ```
   > iptables -I INPUT -s 123.0.0.0/8 -j DROP  
   ```

6. **封IP段即从123.45.0.1到123.45.255.254的命令**   

   ```   
   > iptables -I INPUT -s 124.45.0.0/16 -j DROP
   ```

7. **封IP段即从123.45.6.1到123.45.6.254的命令是**

   ```   
   > iptables -I INPUT -s 123.45.6.0/24 -j DROP
   ```

8. **指令I是insert指令 但是该指令会insert在正确位置并不像A指令看你自己的排序位置，因此用屏蔽。因为必须在一开始就要加载屏蔽IP，所以必须使用I命令加载，然后注意执行/etc/rc.d/init.d/iptables 	save进行保存后重启服务即可**

9. **删除指定行规则**

    1. 直接解除指定ip的黑名单

       ```
       > iptables -D INPUT -s 121.40.167.3 -j DROP
       ```

    2. 利用行号删除

       ```
       列出所有规则（行号）
       > iptables -nL --line-number
       进行删除（删除多个ip，行号用空格隔开）
       > iptables -D INPUT 4  167
       ```

10. **如果想针对某IP进行单独开放端口可以如下配置**

    ###### 如果我需要对内网某机器单独开放mysql端口，应该如下配置：  

    在tcp协议中，禁止所有的ip访问本机的1521端口。

    ```
    > iptables -I INPUT -p tcp --dport 1521 -j DROP

    --dport为目标端口，当数据从外部进入服务器为目标端口
    --sport为数据源端口，数据从服务器出去则为数据源端口
     -s是指定源地址，-d是指定目标地址。

    > iptables -A INPUT -s 192.168.2.6 -p tcp -m tcp --dport 3306 -j ACCEPT  
    > iptables -A OUTPUT -s 192.168.2.6 -p tcp -m tcp --sport 3306 -j ACCEPT  
    ```

11. **将内容保存到 /etc/sysconfig/iptables**

    ```
    > service iptables save
    ```

12. **重启iptables**

    ```
    > service iptables restart

    centos 7:
    > systemctl restart iptables.service
    ```

14. **查看iptables状态**

    ```
    > systemctl status iptables.service
    ```
