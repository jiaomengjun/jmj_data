<?php
    $upload=new FileUpload('pic');//pic 上传的文件名
    $tmp=$upload->tmpFileName;
    if(empty($tmp)){
        //没有文件上传执行的代码

    }else{
        $name = $_FILES['pic']['name'];
        $upload->path="./upload/push_image/$today/";//设置文件上传路径
        $upload->newFileName=$picnum.$houzhui;//文件上传保存的名称
        $up1=$upload->upload();//执行上传
        if(!$up1){
            //$upload->getError()  //获取上传失败的原因
            //上传失败执行的操作
        }else{
            //上传成功执行的代码
        }
    }