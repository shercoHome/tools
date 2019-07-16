<?php
//require '../sqlAPI/allowOrigin.php';

$fileTempMK="../api_admin_sql/";
require $fileTempMK.'allowOrigin.php';

$api="pk10";//哪个文件夹
$plan_positon=0;
$plan_numbers=0;
$latest_limit=10;
$q=1;
$id=-1;
$t=0;
$check="0";
$userAuthorize="0"; //默认不开启授权检测

// 在此读取配置表，对比授权要求，并更正授权状态
require_once 'DB/DBset.php';
$DBset=new DBset();
$json_set=$DBset->show();//读取配置表中
$check=$json_set['authorize'];// 获取全局授权检测状态
$whitePlanId=$json_set['planId'];// 获取全局授权检测状态

if (is_array($_GET)&&count($_GET)>0) {
    if (isset($_GET["w"])) {
        if (strlen($_GET["w"])>0) {
            $whitePlanId=$_GET["w"];
        }
    }
    if (isset($_GET["p"])) {
        if (strlen($_GET["p"])>0) {
            $plan_positon=$_GET["p"];
        }
    }
    if (isset($_GET["m"])) {
        if (strlen($_GET["m"])>0) {
            $plan_numbers=$_GET["m"];
        }
    }
    if (isset($_GET["n"])) {
        if (strlen($_GET["n"])>0) {
            $latest_limit=$_GET["n"];
        }
    }
    if (isset($_GET["a"])) {
        if (strlen($_GET["a"])>0) {
            $api=$_GET["a"];
        }
    }
    if (isset($_GET["plan"])) {
        if (strlen($_GET["plan"])>0) {
            $q=$_GET["plan"];
        }
    }
    if (isset($_GET["id"])) {
        if (strlen($_GET["id"])>0) {
            $id=$_GET["id"];
        }
    }
    if (isset($_GET["t"])) {
        if (strlen($_GET["t"])>0) {
            $t=$_GET["t"];
        }
    }
    if ($check=="1") {
        if (isset($_GET["name"])) {
            if (strlen($_GET["name"])>0) {
                $name=$_GET["name"];
    
                if ($id==$whitePlanId) {//默认计划，无须授权，可直接查看
                    $userAuthorize="1";
                }else{
                    if (in_array($name, $json_set['authorizeWhite'])) {//白名单检测
                        $userAuthorize="1";
                    } elseif (in_array($name, $json_set['authorizeBlack'])) { //黑名单检测
                        $userAuthorize="0";
                    } else {
                        require_once 'DB/DBuser.php';
                        $DBuser=new DBuser();
                        $isExist=$DBuser->select($name);
                        if ($isExist) {
                            $userAuthorize=$isExist[6];// 获取用户授权状态
        
                            //$userinfo=array("userid"=>$isExist[0],"username"=>$isExist[1],"usercreatetime"=>$isExist[2]);
                            //$r=$TxtDB->alter($userinfo);
                            // if ($t) {
                            //     var_dump($r);
                            // }
                        }
                    }
                }
            }
        }
    } else {
        
        //未开启全局授权检测，则所有user都默认已授权
        $userAuthorize="1";
    }

    $dir=$api."/txt-kj/".date("Ymd");
    if (is_dir($dir)) {
        require_once 'WinRate.php';
        $WinRate=new WinRate($api, $plan_positon, $plan_numbers, $latest_limit, $q, $id, $userAuthorize);
        if ($id==-1) {
            echo json_encode($WinRate->getAllRate());
        } else {
            echo json_encode($WinRate->getOneRate());
        }
    } else {
        echo 'Unable to open dir!';
    }
} else {
    echo '{err:"No parameters"}';
}
