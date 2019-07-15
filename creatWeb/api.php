<?php
date_default_timezone_set("Asia/Chongqing");
//echo '<!DOCTYPE HTML><html lang="zh-CN"><head><meta charset="utf-8">';
define("DIR", dirname(__FILE__));




$mk_dir=DIR."/list";
if (!file_exists($mk_dir)) {
    mkdir($mk_dir);
}
$path=$mk_dir."/".$_POST['key'].".txt";


if (is_array($_POST)&&count($_POST)>0) {
    if (isset($_POST["type"])) {
        if (strlen($_POST["type"])>0) {
            $json_result=array("code"=>"0","msg"=>"type null","data"=>array());


            switch ($_POST["type"]) {
                case "set":
                    $content=$_POST['content'];
                    $bulletinSize = file_put_contents($path, $_POST['content']);
                    if ($bulletinSize) {
                        $json_result= array("code"=>"1","msg"=>"保存".$_POST['key']."成功","data"=>array("size"=>$bulletinSize,"path"=>$path,"content"=>$content));
                    } else {
                        $json_result= array("code"=>"0","msg"=>"保存".$_POST['key']."失败","data"=>$bulletinSize);
                    }
                    break;
                default:
                    $content_=  file_get_contents($path);
                    $json_result= array("code"=>"1","msg"=>"获取".$_POST['key']."成功","data"=>$content_);
                    break;

            }
        }
    }
}


echo json_encode($json_result);
