<?php
$api="https://www.ezun85.com/WebApi/";//正式
//$api="http://test.ezun8.org:8080/WebApi/";//测试
//$api="http://localhost:11816/WebApi/";//本地

$sss="&sss=alipay3947891273419023749823519023";//密钥啊


date_default_timezone_set("Asia/Chongqing");
if (!isset($_POST["test"])) {
    error_reporting(E_ALL ^ E_NOTICE);
    error_reporting(E_ALL ^ E_WARNING);
}else{
    if($_POST["test"]!="dddkkk"){
        error_reporting(E_ALL ^ E_NOTICE);
        error_reporting(E_ALL ^ E_WARNING);
    }else{
        //只有在传入test:dddkkk 时，才会显示 错误信息，用于测试
    }
}
if (is_array($_POST)&&count($_POST)>0) {
    if (isset($_POST["type"])) {
        if (strlen($_POST["type"])>0) {
            if (isset($_POST["name"])) {
                if (strlen($_POST["name"])>0) {
                    if (isset($_POST["data"])) {
                        if (strlen($_POST["data"])>0) {

                            //转为一个get请求
                            $url=$api.$_POST["name"].".aspx?".$_POST["data"].$sss;
                            $type=$_POST["type"];

                            if ($type=="getCard"||$type=="submit") {
                                get($url, $type);
                            } else {
                                fn_add_log("log_".$type, $_POST["data"], $result);
                            }
                        }
                    }
                }
            }
        }
    }
}


function get($link, $type)
{
 
        $result=file_get_contents($link);
        echo $result;


        $error = error_get_last();  
        if($error['message']!='hi') {  
           //处理错误    
           $result = $error['message'];  
        }  

    fn_add_log("log_".$type, $_POST["data"], $result);
}


function fn_add_log($mk_dir, $data, $r)
{
    $mk_day=date("Ymd");
    if (!file_exists($mk_dir)) {
        mkdir($mk_dir);
    }
    $path=$mk_dir.'/'.$mk_day.'.txt';

    $str=date("Y-m-d H:i:s")."|".$data."|".$r."\r\n";

    if (!file_exists($path)) {
        file_put_contents($path, $str);
    } else {
        file_put_contents($path, $str, FILE_APPEND);
    }
}
