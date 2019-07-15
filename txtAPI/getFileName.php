<?php
//require '../sqlAPI/allowOrigin.php';

$fileTempMK="../api_admin_sql/";
require $fileTempMK.'allowOrigin.php';
// php获取目录中的所有文件名
// 1、先打开要操作的目录，并用一个变量指向它
//打开当前目录下的目录pic下的子目录common。


if (is_array($_GET)&&count($_GET)>0) {
    if (isset($_GET["dir"])) {
        if (strlen($_GET["dir"])>0) {

            $__dir__=$_GET["dir"];

            if (!file_exists($__dir__)) {
                //vr-3fc/txt-kj/20190715
               $dirArr =  explode("/",$__dir__);
               $dirArr[2]= $dirArr[2]-1;
               $__dir__=implode("/", $dirArr);
            }

            if (!file_exists( $__dir__)) {
                echo "0";
            } else {
                $handler = opendir( $__dir__);
                // 2、循环的读取目录下的所有文件
                /*其中$filename = readdir($handler)是每次循环的时候将读取的文件名赋值给$filename，为了不陷于死循环，所以还要让$filename !== false。一定要用!==，因为如果某个文件名如果叫’0′，或者某些被系统认为是代表false，用!=就会停止循环*/
                while (($filename = readdir($handler)) !== false) {
                    //   3、目录下都会有两个文件，名字为’.'和‘..’，不要对他们进行操作
                    if ($filename !="." && $filename !="..") {
                        //   4、进行处理
                        //这里简单的用echo来输出文件名
                        echo $filename;
                        echo "|";
                    }
                }
                // 5、关闭目录
                closedir($handler);
            }
        }
    }
}
