# Mac

### 对目录操作报错：Operation not permitted

​	Apple 在 OS X 10.11 以后的版本中默认启动了一项系统保护程序，叫做 System Integrity Protection，也被唤作 rootless（寓意让 root 弱一点），该程序意在保护电脑不被恶意程序攻击

**SIP 会锁定几个系统文件目录**：

```
/System
/sbin
/usr （/usr/local 除外）
```

**在 SIP 的保护下，部分软件、功能、脚本都会失效，我们可以通过如下步骤关闭 SIP**：

1. 重启电脑，按下 `Command + R` 直到听到开机声音，此时电脑会进入恢复模式（Recovery Mode）
2. 当 OSX 工具出现在屏幕中时，下拉工具（Utilities）菜单，选择终端（Terminal）
3. 键入 `csrutil disable` ，回车
4. 电脑重启后，SIP 就关闭了

**恢复 SIP 的方式同上，只不过终端中键入 csrutil enable 。通过 csrutil status 可以检测系统当前 SIP 的启动状态：**
```
> csrutil status
System Integrity Protection status: enabled.
```



# 虚拟机

### 进入Mac恢复模式

1. **首先重启虚拟机内的osx系统，重启的时候虚拟机会出现一个带有vmware logo的灰白色界面**

2. **当出现第一步的界面时，按住键盘的`commad`键（windows对应的`Ctrl`）,系统会跳出一个蓝色的界面**

3. **然后在蓝色界面中按照以下路径，一路回车**

   ```
   Enter setup ——> Boot from a file ——> Recovery HD[PciRoot(0x0)/…] ——>  ——> boot.efi
   ```

4. **系统会再次重启就进入RecoveryHD模式啦~**
