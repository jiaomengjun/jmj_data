###  和导出excel/csv的方式或者语言没有太大关系
- Excel显示数字时，如果数字大于12位就会自动转化为科学计数法
- 如果数字大于15位，它不仅用于科学技术费表示，还会只保留高15位，其他位都变0。
### 解决这个问题简单粗暴
####只要把数字字段后面加上显示上看不见的字符即可,如空格、制表符等
 - php 程序可以用"\t"，注意不是'\t'
 - 网页直接导出可以加`&nbsp;`
