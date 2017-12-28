## Bootstrap

### 标签：

1. **标题**		 
`   <h1> 到 <h6>或给任何标签添加h1到h6的class`

2. **副标题**

   标题便签内给副标题加small标签或者添加small的class

3. **突出显示：**

   添加lead的class

4. **标记:**

   mark标签,被标记的文本底色变淡黄色

5. **删除的文本**

   del标签

6. **无用的文本**

   s标签

7. **插入的文本**

   ins标签

8. **下划线文本**   

   u标签

9. **着重强调文本**   

   strong标签

10. **斜体文本**   	

    em标签

11. **文字对齐**

     设置class属性,text-left左对齐;text-center居中对齐;text-right右对齐;text-nowrap无样式

12. **改变大小写**   

     设置class属性,text-lowercase文本小写,text-uppercase文本大写,text-capitalize首字母大写

13. **缩略语**   	

     abbr标签，标签内是显示的文本,设置title当鼠标悬停时显示title文本,添加initialism的class,字体会变小一些

14. **地址**

    address	    		

15. **引用的文本**

    blockquote标签

16. **无样式列表**

    给ul添加list-unstyled的class

17. **内联列表**

    给ul添加list-inline的class

18. **带有描述的短语列表**

    `<dl><dt>...</dt><dd>...</dd></dl>`

19. **水平排列的描述**   

    给dl加dl-horizontal的class

20. **自动截断**     

    text-overflow属性

21. **显示代码**

    code标签

22. **用户输入**

    kbd标签

23. **代码块**

    pre标签,添加class pre-scrollable设置宽度350px

24. **变量**

    var标签

25. **程序输出**    	

    samp标签

26. **原样显示html代码到页面需要进行转义**

    ```html
    把<换成 &lt;  >换成&gt;  即可

    eg：
      	<code>&lt;i class="glyphicon glyphicon-star"&gt;&lt;/i&gt;</code>
    ```

---

### 表格

###### 为table标签添加class属性table赋予基本的样式

1. **条纹状表格**			 

   ​	给tbody标签添加class属性table-striped

   2. **带边框**	 		

    ​ 给tabled标签添加class属性table-bordered

    3. **鼠标悬停样式**   	 

    ​给tabled标签添加class属性table-hover

    4. **紧缩表格**			

    ​给tabled标签添加class属性table-condensed

    5. **行或者单元格颜色**

    ​ tr或者td添加如下class属性：active,success成功或积极的动作,warning警告，info普通的提示信息,danger危险

    6. **隐藏**			

    ​ 给标签添加class属性sr-only

    7. **响应式表格**	 

    ​给table父元素添加class属性table-responsive 创建响应式表格

   ```html
   <div class="table-responsive">
   	<table class="table">
         ......
       </table>
   </div>
   ```


---

### 按钮

1. 作用标签：		a链接,input提交,button标签

2. 方法：                    添加class属性btn

3. 预定义样式:(都是添加class属性)

   |  样式  |   class属性   |
   | :--: | :---------: |
   |  默认  | btn-default |
   |  关键  | btn-primary |
   |  成功  | btn-success |
   |  信息  |  btn-info   |
   |  警告  | btn-warning |
   |  危险  | btn-danger  |
   |  链接  |  btn-link   |

   ​

4. 尺寸

   | 尺寸   | class属性   |
   | ---- | --------- |
   | 最大号  | btn-lg    |
   | 中等   | (默认不加为中等) |
   | 小号   | btn-sm    |
   | 超小号  | btn-xs    |

   ​			

5. 块级按钮

   给按钮加class属性btn-block可以将按钮拉伸至父元素100%的宽度,而且变为块级元素

6. 激活状态

   给按钮加class属性active

7. 禁用状态

   给按钮加class属性disabled

---

### 辅助类

1.  情景文本颜色

   |  样式  |   class属性    |
   | :--: | :----------: |
   | 柔和灰  |  text-muted  |
   | 主要蓝  | text-primary |
   | 成功绿  | text-success |
   | 信息蓝  |  text-info   |
   | 警告黄  | text-warning |
   | 危险红  | text-danger  |

2. 情景背景色

   |  样式  |  classs属性  |
   | :--: | :--------: |
   | 主要蓝  | bg-primary |
   | 成功绿  | bg-success |
   | 信息蓝  |  bg-info   |
   | 警告黄  | bg-warning |
   | 危险红  | bg-danger  |

3. 三角符号

   ```html
   <span class="caret"></span>
   ```

4. 快速浮动

   ###### 注：这个浮动就是 float，只不过使用了!important 加强了优先级。

   ```html
   <div class="pull-left">左边</div>
   <div class="pull-right">右边</div>

   ```

5. 块级居中

   ###### 注：就是 margin:x auto；并且设置了 display:block;

   ```html
   <div class="center-block">居中</div>
   ```

6. 清理浮动

   ###### 注：这个 div 可以放在需要清理浮动区块的前面即可。

   ```html
    <div class="clearfix"></div>
   ```

7. 显示和隐藏  

   ```html
   <div class="show">show</div>
   <div class="hidden">hidden</div>
   ```

8. 关闭按钮

   ```html
   <button type="button" class="close">×</button>
   ```

---

### 栅格系统

###### 移动端的项目有一份非常重要的 meta，用于设置屏幕和设备等宽以及是否运行用户缩放，及缩放比例（分别代表：屏幕宽度和设备一致、初始缩放比例、最大缩放比例和禁止用户缩放）

```html
<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1, user-scalable=no">
```

1. 创建一个响应式行

   ```html
   //container 是一个容器，占满一行，但是有左右边距
   <div class="container">
     //row代表一行   一行被分为十二列
     <div class="row">
     	...
     </div>
   </div>
   ```

   或者

   ```html
   //同样是容器占满一行，但是没有左右间距
   <div class="container-fluid">
     //row代表一行   一行被分为十二列
     <div class="row">
     	...
     </div>
   </div>
   ```

   eg:

   1. 创建最多 12 列的响应式行

   ```html

   <div class="container">
       <div class="row">
           <div class="col-md-1 a">1</div>
           <div class="col-md-1 a">2</div>
           <div class="col-md-1 a">3</div>
           <div class="col-md-1 a">4</div>
           <div class="col-md-1 a">5</div>
           <div class="col-md-1 a">6</div>
           <div class="col-md-1 a">7</div>
           <div class="col-md-1 a">8</div>
           <div class="col-md-1 a">9</div>
           <div class="col-md-1 a">10</div>
           <div class="col-md-1 a">11</div>
           <div class="col-md-1 a">12</div>
       </div>
   </div>
   ```

   2. 总列数都是 12，被分的每列再分配多列

   ```html
   <div class="container">
       <div class="row">
           <div class="col-md-4 a">1-4</div>
           <div class="col-md-4 a">5-8</div>
           <div class="col-md-4 a">9-12</div>
       </div>
       <div class="row">
           <div class="col-md-8 a">1-8</div>
           <div class="col-md-4 a">9-12</div>
       </div>
   </div>
   ```

   ​

2. 栅格参数表

   ###### 栅格系统最外层区分了四种宽度的浏览器：超小屏(<768px)、小屏(>=768px)、中屏(>=992px)和大屏(>=1200px)。内层.container 容器的自适应宽度为：自动、750px、970px 和 1170px。自动的意思为如果你是手机屏幕，则全面独占一行显示

   |                | 超小屏幕(手机  <768px) |       小屏幕(平板  >=768px)       | 中等屏幕(桌面显示器  >=992px) | 大屏幕(大桌面显示器  >=1200px) |
   | :------------: | :--------------: | :--------------------------: | :------------------: | :-------------------: |
   |     栅格系统行为     |      总是水平排列      | 后三种都是开始堆叠在一起，当大于这个阀值时将变成水平排列 |                      |                       |
   | .container最大宽度 |     None(自动)     |            750px             |        970px         |        1170px         |
   |      类前缀       |     .col-xs-     |           .col-sm-           |       .col-md-       |       .col-lg-        |
   |   列(column)数   |        12        |             全部一样             |         全部一样         |         全部一样          |
   |  最大(column)列宽  |        自动        |            -62px             |        -81px         |         -97px         |
   |   槽(gutter)宽   | 30px(每列左右都是15px) |             全部一样             |         全部一样         |         全部一样          |
   |      可嵌套       |        是         |             全部一样             |         全部一样         |         全部一样          |
   |  偏移(offsets)   |        是         |             全部一样             |         全部一样         |         全部一样          |
   |      列排序       |        是         |             全部一样             |         全部一样         |         全部一样          |

   eg: 四种屏幕分类全部激活

   ```html
   <div class="container">
       <div class="row">
           <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 a">4</div>
           <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 a">4</div>
           <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 a">4</div>
           <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 a">4</div>
           <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 a">4</div>
           <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 a">4</div>
           <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 a">4</div>
           <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 a">4</div>
           <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 a">4</div>
           <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 a">4</div>
           <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 a">4</div>
           <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 a">4</div>
       </div>
   </div>
   ```

---

### 列偏移

###### 	给div加col-md-offset-1类属性进行列偏移 中间保持空隙 1代表偏移一列 2代表偏移2列...   注意:相应的每行12列应算上偏移的列数否则会挤下去 md应该与设置的屏幕属性一致

​	eg:

```html
<div class="container">
    <div class="row">
    	<div class="col-md-8 a">8</div>
        <div class="col-md-3 col-md-offset-1 a">3</div>
    </div>
</div>
```

1. **嵌套**

   ###### 每个被分出来的列同样可被等分成12列  也就是嵌套   注意：默认两边会有padding，自己设置padding为0就可以了

   ```html
   <div class="container">
       <div class="row">
           <div class="col-md-9 a" style="padding:0px;">
               <div class="col-md-8 a">1-8</div>
               <div class="col-md-4 a">9-12</div>
           </div>
           <div class="col-md-3 a"> 11-12</div>
       </div>
   </div>
   ```

   ​

2. **交换位置**

   ###### 可以把两个列交换位置   col-md-push-3   代表向右移动三列    col-md-pull-9  代表向左移动九列    注意:md与设置屏幕的属性一致

   ```html
   <div class="container">
       <div class="row">
           <div class="col-md-9 col-md-push-3 a">9</div>
           <div class="col-md-3 col-md-pull-9 a">3</div>
       </div>
   </div>
   ```

---

### 响应式工具

​

|               | 超小屏幕(手机  <768px) | 小屏幕(平板  >=768px) | 中等屏幕(桌面显示器  >=992px) | 大屏幕(大桌面显示器  >=1200px) |
| ------------- | ---------------- | ---------------- | -------------------- | --------------------- |
| .visible-xs-* | 可见               | 隐藏               | 隐藏                   | 隐藏                    |
| .visible-sm-* | 隐藏               | 可见               | 隐藏                   | 隐藏                    |
| .visible-md-* | 隐藏               | 隐藏               | 可见                   | 隐藏                    |
| .visible-lg-* | 隐藏               | 隐藏               | 隐藏                   | 可见                    |
| .hidden-xs    | 隐藏               | 可见               | 可见                   | 可见                    |
| .hidden-sm    | 可见               | 隐藏               | 可见                   | 可见                    |
| .hidden-md    | 可见               | 可见               | 隐藏                   | 可见                    |
| .hidden-lg    | 可见               | 可见               | 可见                   | 隐藏                    |

1. 超小屏幕激活显示

   ```html
   <div class="visible-xs-block a">Bootstrap</div>
   ```

2. 超小屏幕激活隐藏

   ```html
   <div class="hidden-xs a">Bootstrap</div>
   ```

3. 对于显示的内容，有三种变体，分别为：block、inline-block、inline。

---

### 小图标组件

1. 可以使用<i>或<span>标签来配合使用

   ```html
   <i class="glyphicon glyphicon-star"></i>
   <span class="glyphicon glyphicon-star"></span>
   ```

2. 也可以结合按钮

   ```html
   <button class="btn btn-default btn-lg">
   	<span class="glyphicon glyphicon-star"></span>
   </button>
   ```

---

### 下拉菜单组件

###### 就是点击一个元素或按钮，触发隐藏的列表显示出来

1. 基本格式

   ```html
   <div class="dropdown">
       <button class="btn btn-default" data-toggle="dropdown">下拉菜单
       	<span class="caret"></span>
       </button>
       <ul class="dropdown-menu">
           <li><a href="#">首页</a></li>
           <li><a href="#">资讯</a></li>
           <li><a href="#">产品</a></li>
           <li><a href="#">关于</a></li>
       </ul>
   </div>
   ```

   **注意：**

   ###### 	按钮和菜单需要包裹在.dropdown 的容器里，作为被点击的元素需要设置data-toggle="dropdown"才能有效。菜单部分，设置 class="dropdown-menu"才能自动隐藏并添加固定样式。设置 class="caret"表示箭头，可上可下。

2. 设置向上触发

   ```html
   <div class="dropup">
   ```

3. 菜单项居右对齐，默认值是dropdown-menu-left

   ```html
   <ul class="dropdown-menu dropdown-menu-right">
   ```

4. 设置菜单的标题，不要加超链接

   ```html
   <li class="dropdown-header">网站导航</li>
   ```

5. 设置菜单的分割线

   ```html
   <li class="divider"></li>
   ```

6. 设置菜单的禁用项

   ```html
   <li class="disabled"><a href="#">产品</a></li>
   ```

7. 让菜单默认显示

   ```html
   <div class="dropdown open">
   ```

---

### 按钮组组件

###### 	按钮组就是多个按钮集成在一个容器里形成独有的效果。

1. 基本格式

   ```html
   <div class="btn-group">
       <button type="button" class="btn btn-default">左</button>
       <button type="button" class="btn btn-default">中</button>
       <button type="button" class="btn btn-default">右</button>
   </div>
   ```

2. 将多个按钮组整合起来便于管理

   ```html
   <div class="btn-toolbar">
       <div class="btn-group">
       	<button type="button" class="btn btn-default">左</button>
       	<button type="button" class="btn btn-default">中</button>
       	<button type="button" class="btn btn-default">右</button>
       </div>
       <div class="btn-group">
       	<button type="button" class="btn btn-default">1</button>
       	<button type="button" class="btn btn-default">2</button>
       	<button type="button" class="btn btn-default">3</button>
       </div>
   </div>
   ```

3. 设置按钮组大小

   ```html
   <div class="btn-group btn-group-lg">
   <div class="btn-group>
   <div class="btn-group btn-group-sm">
   <div class="btn-group btn-group-xs">
   ```

4. 设置按钮组垂直排列

   ```html
   <div class="btn-group-vertical">
   ```

5. 设置两端对齐按钮组，使用<a>标签

   ```html
   <div class="btn-group-justified">
       <a type="button" class="btn btn-default">左</a>
       <a type="button" class="btn btn-default">中</a>
       <a type="button" class="btn btn-default">右</a>
   </div>
   ```

6. 如果需要使用`<button>`标签，则需要对每个按钮进行群组

   ```html
   <div class="btn-group-justified">
       <div class="btn-group">
       	<button type="button" class="btn btn-default">左</button>
       </div>
       <div class="btn-group">
       	<button type="button" class="btn btn-default">左</button>
       </div>
       <div class="btn-group">
       	<button type="button" class="btn btn-default">左</button>
       </div>
    </div>
   ```

7. 嵌套一个分组，比如下拉菜单

   ```html
   <div class="btn-group">
   	<button type="button" class="btn btn-default">左</button>
   	<button type="button" class="btn btn-default">中</button>
   	<button type="button" class="btn btn-default">右</button>
   	<div class="btn-group">
   		<button class="btn btn-default dropdown-toggle" data-toggle="dropdown">下拉菜单<span class="caret"></span>
   		</button>
   		<ul class="dropdown-menu">
   			<li><a href="#">首页</a></li>
   			<li><a href="#">资讯</a></li>
   			<li><a href="#">产品</a></li>
   			<li><a href="#">关于</a></li>
   		</ul>
   	</div>
    </div>
   ```

   **注意：**

   ###### 	这里<div>中并没有实现 class="dropdown"，通过源码分析知道嵌套本身已经有定位就不需要再设置。而右边的圆角只要多加一个 class="dropdown-toggle"即可。

---

### 按钮式下拉菜单

###### 	其实和下拉菜单一样，只不过，这个是在群组里，不需要<div>声明class="dropdown"。

1. 群组按钮下拉菜单

   ```html
   <div class="btn-group">
   	<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">下拉菜单<span class="caret"></span></button>
   	<ul class="dropdown-menu">
   		<li><a href="#">首页</a></li>
   		<li><a href="#">资讯</a></li>
   		<li><a href="#">产品</a></li>
   		<li><a href="#">关于</a></li>
   	</ul>
    </div>
   ```

2. 分裂式按钮下拉菜单

   ```html
   <div class="btn-group">
   	<button type="button" class="btn btn-default">下拉菜单</button>
   	<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span> </button>
   	<ul class="dropdown-menu">
   		<li><a href="#">首页</a></li>
   		<li><a href="#">资讯</a></li>
   		<li><a href="#">产品</a></li>
   		<li><a href="#">关于</a></li>
   	</ul>
    </div>
   ```

3. 向上弹出式

   ```html
   <div class="btn-group dropup">
   ```

---

### 输入框组件

###### 	文本输入框就是可以在`<input>`元素前后加上文字或按钮,实现表单控件的扩展

1. 在左侧添加文字

   ```html
   <div class="input-group">
       <span class="input-group-addon">@</span>
       <input type="text" class="form-control">
   </div>
   ```

2. 在右侧添加文字

   ```html
   <div class="input-group">
       <input type="text" class="form-control">
       <span class="input-group-addon">@163.com</span>
   </div>
   ```

3. 在两侧添加文字

   ```html
   <div class="input-group">
       <span class="input-group-addon">$</span>
       <input type="text" class="form-control">
       <span class="input-group-addon">.00</span>
   </div>
   ```

4. 设置尺寸，另外三种分别是默认、xs、sm

   ```html
   <div class="input-group input-group-lg">
   ```

5. 左侧使用复选框和单选框

   ```html
   <div class="input-group">
       <span class="input-group-addon">
       	<input type="checkbox">
       </span>
     	<input type="text" class="form-control">
   </div>
   <div class="input-group">
       <span class="input-group-addon">
       	<input type="radio">
       </span>
       <input type="text" class="form-control">
   </div>
   ```

6. 左侧使用按钮

   ```html
   <div class="input-group">
       <span class="input-group-btn">
       	<button type="button" class="btn btn-default">按钮</button>
       </span>
       <input type="text" class="form-control">
   </div>
   ```

7. 左侧使用下拉菜单或分列式

   ```html
   <div class="input-group">
       <span class="input-group-btn">
           <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
           下拉菜单
           	<span class="caret"></span>
           </button>
           <ul class="dropdown-menu">
               <li class="dropdown-header">网站导航</li>
               <li><a href="#">首页</a></li>
               <li><a href="#">资讯</a></li>
               <li class="divider"><a href="#">产品</a></li>
               <li class="disabled"><a href="#">关于</a></li>
           </ul>
       </span>
       <input type="text" class="form-control">
   </div>
   ```

---

### 导航组件

###### 	导航组件，用于实现 Web 页面的栏目操作。

1. 基本导航标签页

   ```html
   <ul class="nav nav-tabs">
       <li class="active"><a href="#">首页</a></li>
       <li><a href="#">资讯</a></li>
       <li><a href="#">产品</a></a></li>
       <li><a href="#">关于</a></li>
   </ul>
   ```

2. 胶囊式导航

   ```html
   <ul class="nav nav-pills">
   ```

3. 垂直胶囊式导航

   ```html
   <ul class="nav nav-pills nav-stacked">
   ```

4. 导航两端对齐

   ```html
   <ul class="nav nav-tabs nav-justified">
   ```

5. 禁用导航中的项目

   ```html
   <li class="disabled"><a href="#">关于</a></li>
   ```

6. 带下拉菜单的导航

   ```html
   <ul class="nav nav-tabs">
       <li class="active"><a href="#">首页</a></li>
       <li><a href="#">资讯</a></li>
       <li class="dropdown">
           <a href="#" class="dropdown-toggle" data-toggle="dropdown">
           下拉菜单
               <span class="caret"></span>
           </a>
           <ul class="dropdown-menu">
             	<li><a href="#">菜单一</a></li>
             	<li><a href="#">菜单二</a></li>
           </ul>
       </li>
   </ul>
   ```

   ​

---

### 导航条组件

###### 	导航条是网站中作为导航页头的响应式基础组件

1. 基本格式

   ```html
   <nav class="navbar navbar-default">
   	...
   </nav>
   ```

2. 反色调导航

   ```html
   <nav class="navbar navbar-inverse">
   	...
   </nav>
   ```

3. 基本导航条，包含标题和列表

   ```html
   <nav class="navbar navbar-default">
       <div class="container">
           <div class="navbar-header">
           	<a href="#" class="navbar-brand">标题</a>
           </div>
           <ul class="nav navbar-nav">
               <li class="active"><a href="#">首页</a></li>
               <li><a href="#">资讯</a></li>
               <li class="disabled"><a href="#">产品</a></li>
               <li><a href="#">关于</a></li>
           </ul>
       </div>
   </nav>
   ```

4. 导航条中使用表单

   ```html
   <form action="" class="navbar-form navbar-left">
       <div class="input-group">
           <input type="text" class="form-control">
           <span class="input-group-btn">
           	<button type="submit" class="btn btn-default">提交</button>
           </span>
       </div>
   </form>
   ```

5. 导航中使用按钮

   ```html
   <button class="btn btn-default navbar-btn">按钮</button>
   ```

6. 导航中使用对齐方式，left 和 right

   ```html
   <button class="btn btn-default navbar-btn navbar-right">按钮</button>
   ```

7. 导航中使用一段文本

   ```html
   <p class="navbar-text">我是一段文本</p>
   ```

8. 非导航链接，一般需要置入文本区域内

   ```html
   <a href="#" class="navbar-link">非导航链接</a>
   ```

9. 将导航固定在顶部，下面的内容会自动上移

   ```html
   <nav class="navbar navbar-default navbar-fixed-top">
   ```

10. 将导航补丁在底部\

    ```html
    <nav class="navbar navbar-default navbar-fixed-bottom">
    ```

11. 静态导航，和页面等宽的导航条，去掉了圆角

    ```html
    <nav class="navbar navbar-default navbar-static-top">
    ```
