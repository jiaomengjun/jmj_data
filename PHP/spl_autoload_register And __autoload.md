## ___autoload() 自动加载类文件
### 注意：
1. 如果类存在继承关系（例如：ClassB extends ClassA），并且ClassA不在ClassB所在目录,利用__autoload魔术函数实例化ClassB的时候就会受到一个致命错误：
	```
		Fatal error: Class ‘Classd’ not found in ……ClassB.php on line
	```
###### 解决方法：
1. 把所有存在extends关系的类放在同一个文件目录下，或者在实例化一个继承类的时候在文件中手工包含被继承的类；
2. 另外一个需要注意的是，类名和类的文件名必须一致，才能更方便的使用魔术函数__autoload；
3.  在CLI模式下运行PHP脚本的话这个方法无效；
4. 如果你的类名称和用户的输入有关——或者依赖于用户的输入，一定要注意检查输入的文件名，例如：.././这样的文件名是非常危险的。



##### spl_autoload_register(‘func_name');
`func_name`  欲注册的自动装载函数。如果没有提供任何参数，则自动注册autoload的默认实现函数
###### spl_autoload()
1. 将函数注册到`SPL __autoload`函数栈中。如果该栈中的函数尚未激活，则激活它们
2. 如果在你的程序中已经实现了`__autoload`函数，它必须显式注册到`__autoload`栈中。因为`spl_autoload_register()``函数会将`Zend Engine`中的`__autoload`函数取代为`spl_autoload()`或`spl_autoload_call()`
3. 当PHP找不到类文件会调用这个方法，当注册了自己的函数或方法时，PHP不会调用`__autoload()`函数，而会调用自定义的函数

##### spl_autoload_register比__aotuload的好处：
1. 可以按需多次写spl_autoload_register注册加载函数，加载顺序按谁先注册谁先调用。__aotuload由于是全局函数只能定义一次，不够灵活。
2. 可以被catch到错误，而__aotuload不能。
3. spl_autoload_register注册的加载函数可以按需被spl_autoload_unregister掉
