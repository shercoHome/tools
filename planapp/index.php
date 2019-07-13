<?php

//http://duke.com/tools/planapp/index.php?id=1


// 根据 网址id 跳转到 指定 链接

$getid='1';

if (is_array($_GET)&&count($_GET)>0) {
    if (isset($_GET["id"])) {
        if (strlen($_GET["id"])>0) {
            $getid=$_GET['id'];
        }
    }
}

$result=file_get_contents('http://154.92.177.252/sqlapi/zz.user.php?userID='.$getid);
     
header("Location: http://".$result);