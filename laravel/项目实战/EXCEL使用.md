## EXCEL使用
### 安装
##### 1). 使用 Composer 安装该扩展包：
    composer require maatwebsite/excel
##### 2). 安装完成后，修改 config/app.php 在 providers 数组内追加如下内容
    'providers' => [
        ...
        Maatwebsite\Excel\ExcelServiceProvider::class,
    ],
##### 3). 同时在 aliases 数组内追加如下内容:
    'aliases' => [
        ...
        'Excel' => Maatwebsite\Excel\Facades\Excel::class,
     ]
##### 4). 接下来运行以下命令生成此扩展包的配置文件 config/excel.php：
    php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider"
###### 默认配置基本能通用大部分的项目开发需求, 因此本文不对此配置文件做过多叙述, 想深入研究的童鞋可以阅读官方文档.
##### 到此, 此拓展包即安装成功
### 基础用法
##### 解析 Excel 文件
    // $excel_file_path = 你的 Excel 文件存放地址
    $excel_data = Excel::load($excel_file_path, function($reader) {
        $excel_data = Excel::load($excel_file_path)->get()->toArray();
        // 直接打印内容即可看到效果
        echo 'job.xlsx 表格内容为:';
        dd($excel_data);
    });
##### 将数据导成 Excel 文件
###### 导出 Excel 并能直接在浏览器下载
    $export_file_name = 要生成的文件名
    Excel::create($export_file_name, function ($excel) {
        $excel->sheet('Sheetname', function ($sheet) {
            $sheet->appendRow(['data 1', 'data 2']);
            $sheet->appendRow(['data 3', 'data 4']);
            $sheet->appendRow(['data 5', 'data 6']);
        });
    })->download('xls');

###### 导出 Excel 并存储到指定目录
    Excel::create($export_file_name, function ($excel) {
        $excel->sheet('Sheetname', function ($sheet) {
            $sheet->appendRow(['data 1', 'data 2']);
            $sheet->appendRow(['data 3', 'data 4']);
            $sheet->appendRow(['data 5', 'data 6']);
        });
    })->store('xls', $object_path);
导出的 Excel 内容见下图:

36d628e26b59530839f3e1c4230c918f.png

##### 更多功能
###### 除了上述的解析/导出功能外, 此扩展包还支持:
    解析指定表格里的指定列;
    格式化日期;
    添加计算公式;
    缓存表格;
    批量解析指定目录里的所有 Excel 文件;
    可以做格式转换, 如将 csv 转换成 xls, 反之亦可;
    可以将 Excel 结合 blade 模板引擎进行渲染.