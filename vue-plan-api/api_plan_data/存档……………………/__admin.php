<?php
$origin = isset($_SERVER['HTTP_ORIGIN'])? $_SERVER['HTTP_ORIGIN'] : '';
$allow_origin = array(
    'http://localhost:8080',
    'http://192.168.0.117:8080',
    'http://192.168.0.117:8081',
    'http://www.beer668.cn',
    'http://www.ezun666.cn'
);
if (in_array($origin, $allow_origin)) {
    header('Access-Control-Allow-Origin:'.$origin);
}

if (is_array($_POST)&&count($_POST)>0) {
    if (isset($_POST["type"])) {
        if (strlen($_POST["type"])>0) {
            require_once 'DB/DBset.php';
            $DBset=new DBset();
            $json_result=array("code"=>"-2","msg"=>"set null","data"=>array());

            switch ($_POST["type"]) {
                case 'admin':
                if ($_POST["value"]=="ashjde3323") {
                    $json_result=array("code"=>"1","msg"=>"admin login success","data"=>array());
                } else {
                    $json_result=array("code"=>"0","msg"=>"admin login false","data"=>array());
                }
                    break;
                case 'show':
                    $json_result=array("code"=>"1","msg"=>"show success","data"=>$DBset->show());
                    break;
                case 'alter':
                    $DBset->alter($_POST["key"], $_POST["value"]);
                    $json_result=array("code"=>"1","msg"=>"alter success","data"=>$DBset->show());
                    break;
                case 'delete':
                    $DBset->delete($_POST["key"], $_POST["value"]);
                    $json_result=array("code"=>"1","msg"=>"delete success","data"=>$DBset->show());
                    break;
                case 'userList':
                    require_once 'DB/DBuser.php';
                    $DBuser=new DBuser();
                    $json_result=array("code"=>"1","msg"=>"get userlist success","data"=>$DBuser->show());
                    break;
                case 'userLog':
                    require_once 'DB/DBlog.php';
                    $DBlog=new DBlog();
                    $json_result=array("code"=>"1","msg"=>"get userlist success","data"=>$DBlog->show($_POST["user"]));
                    break;
                case 'userShare':
                    require_once 'DB/DBshare.php';
                    $DBshare=new DBshare();
                    $json_result=array("code"=>"1","msg"=>"get userlist success","data"=>$DBshare->show($_POST["code"]));
                    break;
                default:
                    $json_result=array("code"=>"1","msg"=>"planId success","data"=>$DBset->show()['planId']);
            }
            echo json_encode($json_result);
        }
    }
}