<?php
//require '../sqlAPI/allowOrigin.php';

$fileTempMK="../api_admin_sql/";
require $fileTempMK.'allowOrigin.php';
// php获取目录中的所有文件名
// 1、先打开要操作的目录，并用一个变量指向它
//打开当前目录下的目录pic下的子目录common。


if (is_array($_GET)&&count($_GET)>0) {
    if (isset($_GET["f"])) {
        if (strlen($_GET["f"])>0) {
            $myfile = fopen($_GET["f"], "r") or die("Unable to open file!");
            echo fgets($myfile);


            fclose($myfile);
        }
    }
}
