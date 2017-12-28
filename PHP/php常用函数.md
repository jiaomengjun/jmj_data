#### 发送请求
```php
function http($url, $params, $method = 'GET', $header = array(), $multi = false){
        $opts = array(
                CURLOPT_TIMEOUT        => 30,
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_HTTPHEADER     => $header
        );
        /* 根据请求类型设置特定参数 */
        switch(strtoupper($method)){
            case 'GET':
                $opts[CURLOPT_URL] = $url . '?' . http_build_query($params);
                break;
            case 'POST':
                //判断是否传输文件
                $params = $multi ? $params : http_build_query($params);
                $opts[CURLOPT_URL] = $url;
                $opts[CURLOPT_POST] = 1;
                $opts[CURLOPT_POSTFIELDS] = $params;
                break;
            default:
                throw new Exception('不支持的请求方式！');
        }
        /* 初始化并执行curl请求 */
        $ch = curl_init();
        curl_setopt_array($ch, $opts);
        $data  = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if($error) throw new Exception('请求发生错误：' . $error);
        return  $data;
    }
```


----------


#### 下载文件
```
function downloadFile( $fullPath ){
        // Must be fresh start

        if( headers_sent() ) //check if any header has been sent
            die('Headers Sent'); //Equivalent to exit()

        // Required for some browsers
        if(ini_get('zlib.output_compression')) //Gets the value of a configuration option
            ini_set('zlib.output_compression', 'Off'); //该模块允许PHP透明的读取和写入gzip(.gz)压缩文件
        // File Exists?
        if( file_exists($fullPath) ){
            // Parse Info / Get Extension
            $fsize = filesize($fullPath);
            $path_parts = pathinfo($fullPath);//返回文件路径的信息 /
            /*
             $path_parts = pathinfo("/www/htdocs/index.html");
             echo $path_parts["dirname"] . "n";
             echo $path_parts["basename"] . "n";
             echo $path_parts["extension"] . "n";//后缀名
             返回的信息分别为：
            /www/htdocs
             index.html
             html
             */
            $ext = strtolower($path_parts["extension"]); //将字符串转化为小写

            // Determine Content Type
            switch ($ext) {
                case "pdf": $ctype="application/pdf"; break;
                case "exe": $ctype="application/octet-stream"; break;
                case "zip": $ctype="application/zip"; break;
                case "doc": $ctype="application/msword"; break;
                case "xls": $ctype="application/vnd.ms-excel"; break;
                case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
                case "gif": $ctype="image/gif"; break;
                case "png": $ctype="image/png"; break;
                case "jpeg":
                case "jpg": $ctype="image/jpg"; break;
                default: $ctype="application/force-download";
            }
            header("Pragma: public"); // required 指明响应可被任何缓存保存
            header("Expires: 0");
            /*
             Expires实体头域（entity-header）给出了在何时之后响应即被视为陈旧的。一个陈旧的缓存项
             不能被缓存（一个代理缓存或一个用户代理的缓存）返回给客户端，除非此缓存项被源服务器
             （或者被一个拥有实体的保鲜副本的中间缓存）验证。
            0表示立即过期，就是不缓存的意思。
            */
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private",false); // required for certain browsers
            //header("Content-Type: $ctype");
            header("Content-Disposition: attachment; filename=".basename($fullPath).";");
            header("Content-Transfer-Encoding: binary");
            header("Content-Length: ".$fsize);
            header("Content-type: $ctype; charset=gb2312");
            ob_clean(); //Clean (erase) the output buffer
            flush(); //刷新PHP程序的缓冲，而不论PHP执行在何种情况下（CGI ，web服务器等等）。该函数将当前为止程序的所有输出发送到用户的浏览器。
            readfile( $fullPath ); //读入一个文件并写入到输出缓冲。
        } else
            die('File Not Found');
    }


    用法：
      $fullPath=$_GET['path'];
      if(!is_null($fullPath))
        downloadFile($fullPath);
```

----------

#### 时间比较函数，返回两个日期相差几秒、几分钟、几小时或几天
```
function DateDiff ( $date1 , $date2 , $unit = "" ) {
	switch ( $unit ) {
		case 's' :
			$dividend = 1 ;
			break;
		case 'i' :
			$dividend = 60 ;
			break;
		case 'h' :
			$dividend = 3600 ;
			break;
		case 'd' :
			$dividend = 86400 ;
			break;
		default:
			$dividend = 86400 ;
	}
	$time1 = strtotime ( $date1 );
	$time2 = strtotime ( $date2 );
	if ( $time1 && $time2 )
		return (float)( $time1 - $time2 ) / $dividend ;
	return false ;
}
```

----------

#### 检查日期是否合法日期
```
function check_date ( $date ) {
	$dateArr = explode ( "-" , $date );
	if ( is_numeric ( $dateArr [ 0 ]) && is_numeric ( $dateArr [ 1 ]) && is_numeric ( $dateArr [ 2 ])) {
		return checkdate ( $dateArr [ 1 ], $dateArr [ 2 ], $dateArr [ 0 ]);
	}
	return false ;
}
```

----------

#### 检查时间是否合法时间
```
function check_time ( $time ) {
	$timeArr = explode ( ":" , $time );
	if ( is_numeric ( $timeArr [ 0 ]) && is_numeric ( $timeArr [ 1 ]) && is_numeric ( $timeArr [ 2 ])) {
		if (( $timeArr [ 0 ] >= 0 && $timeArr [ 0 ] <= 23 ) && ( $timeArr [ 1 ] >= 0 && $timeArr [ 1 ] <= 59 ) && ( $timeArr [ 2 ] >= 0 && $timeArr [ 2 ] <= 59 ))
			return true ;
		else
			return false ;
	}
	return false ;
}
```

----------

#### 计算出给出的日期是星期几
```
function GetWeekDay ( $date ) {
	$dateArr = explode ( "-" , $date );
	return date ( "w" , mktime ( 0 , 0 , 0 , $dateArr [ 1 ], $dateArr [ 2 ], $dateArr [ 0 ]));
}
```

----------

#### 写入csv文件
```
# $row数据源/$tabke_title表头/$file_name文件名(全路径)

function write_csv($row,$table_title,$file_name){
        //打开文件句柄
        $fp = fopen($file_name, 'w');
        //写入表头
        fputcsv($fp,$table_title);
        //循环写入内容     fputcsv可以用数组循环的方式进行实现
        foreach($row as $key => $value)
        {
            $data = array();
            array_push($data,$value['username']);
            array_push($data,$value['subject']);
            array_push($data,$value['money']);
            array_push($data,$value['interface']);
            array_push($data,$value['status']);
            array_push($data,$value['deliver']);

            fputcsv($fp,$data);
        }

        fclose($fp);
    }
```
