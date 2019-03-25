<?php
require '../sqlAPI/allowOrigin.php';



// $myfile = fopen('http://localhost/tools/txtapi/ffssc/txt-plan/20190316/1.txt', "r") or die("Unable to open file!");
// $content_=  fgets($myfile);
// fclose($myfile);
// $plan_arr=json_decode($content_);

// var_dump($plan_arr);
// exit();


$api="pk10";//哪个文件夹  彩种
$plan_ways=0;   //玩法 
$plan_positon=0;   //  冠 亚 和...
$plan_numbers=0;   //几码
$q=1;  //几期计划
$id=-1;//  计划代码
$t=0;  //测试……
$userID="0";
$userAuthorize="0"; //用户当前的授权状态，0表示未授权,1表示可以查看此计划
$token="0";//当前token

$check="0";// 获取全局授权检测状态  不开启0	开启1
//$whitePlanId="0";//白名单，当前（授权或免费）+在不改变plan id的情况下，可以持续查看
$defaultPlanId_index="0";//默认的一个计划可以直接查看计划，无需授权
$history_limit="50";//统计几期胜率
$needAuthorize_array=array("0","0");//胜率排行第0-0名需要授权

if (is_array($_GET)&&count($_GET)>0) {
    if (isset($_GET["id"])) {
        if (strlen($_GET["id"])>0) {
            $id=$_GET["id"];
        }
    }
    if (isset($_GET["y"])) {
        if (strlen($_GET["y"])>0) {
            $plan_ways=$_GET["y"];
        }
    }
    if (isset($_GET["p"])) {
        if (strlen($_GET["p"])>0) {
            $plan_positon=$_GET["p"];
        }
    }
    if (isset($_GET["n"])) {
        if (strlen($_GET["n"])>0) {
            $plan_numbers=$_GET["n"];
        }
    }
    if (isset($_GET["h"])) {
        if (strlen($_GET["h"])>0) {
            $history_limit=$_GET["h"];
        }
    }
    if (isset($_GET["a"])) {
        if (strlen($_GET["a"])>0) {
            $api=$_GET["a"];
        }
    }
    if (isset($_GET["q"])) {
        if (strlen($_GET["q"])>0) {
            $q=$_GET["q"];
        }
    }

    if (isset($_GET["uid"])) {
        if (strlen($_GET["uid"])>0) {
            $userID=$_GET["uid"];
        }
    }
    if (isset($_GET["tk"])) {
        if (strlen($_GET["tk"])>20) {
            $token=$_GET["tk"];

            //  启动 Session
session_start();
$_SESSION["token"] = $token;
    
        require_once '../sqlAPI/class.common.php';
            $__common=new commonFun();
            $__temp =$__common->decrypt($token);
         
            $__tempAr=explode("|",$__temp);
            $token_userID=$__tempAr[1];//用户id
            $token_webID=$__tempAr[2];//网站id
            $token_loginKeep=$__tempAr[3];//登录有效时长  分钟
            $authorizationStatus=$__tempAr[4];//用户授权状态

            // 在此读取网站配置表，以当前访问的网站为准
            require_once '../sqlAPI/class.websetting.php';
            $DBset=new websetting();
            $json_set=$DBset->show(array('id'=>$token_webID))[0];//读取配置表中

            $check=$json_set['publicAuthorization'];// 获取全局授权检测状态  不开启0	开启1
            $defaultPlanId_index=$json_set['defaultPlanID'];//默认的一个计划可以直接查看计划，无需要授权
            $history_limit=$json_set['historyLimit'];//统计几期胜率
            $needAuthorizeStr=$json_set['needAuthorize'];//默认的一个计划可以直接查看计划，无需要授权
            //解析  all|1-3||js|1-3  这样的字符串
            $needAuthorizeLotterysArr=explode('||',$needAuthorizeStr);
            $needAuthorizeLotterysArrlength=count($needAuthorizeLotterysArr);
            $temp="0-0";
            for($x=0;$x<$needAuthorizeLotterysArrlength;$x++) {
                $needAuthorize_One=explode('|',$needAuthorizeLotterysArr[$x]);
                if($needAuthorize_One[0]=="all"){
                    $temp=$needAuthorize_One[1];
                }
                if($needAuthorize_One[0]==$api){
                    $temp=$needAuthorize_One[1];
                }
            }
            $tempArr=explode('-',$temp);
            if(count($tempArr)<2){
                $tempArr[1]=$tempArr[0];
            }
            $needAuthorize_array=$tempArr;
            if (isset($_GET["w"])) {
                if (strlen($_GET["w"])>0) {
                        $whitePlanId=$_GET["w"];//返回（随机当前最佳计划）到这里并视为可直接查看
                }
            }

          //  if ($id==$defaultPlanID) {//默认计划，无须授权，可直接查看
           //     $userAuthorize="1";
         //   }else{
                if($check=="1"){// 开启了检测，所以要再检测登录用户的授权
                    if($token_userID!="0"){
                        require_once '../sqlAPI/class.logLogin.php';
                        $logLogin=new logLogin();
                        $isLogin=$logLogin->checkToken($userID, $token);
                        if ($isLogin===true) {
                            // 登录id为  $token_userID
                            // require_once '../sqlAPI/class.user.php';
                            // $DBuser=new user();
                            // $userInfoAr=$DBuser->show(array("id"=>$token_userID));
                            // $userInfoJson=$userInfoAr[0];
                            // $authorizationStatus=$userInfoJson['authorizationStatus'];
                            if($authorizationStatus=="1"||$authorizationStatus=="3") //0,2   1,3
                            {
                                $userAuthorize="1";
                            }
                        }else{
                            //登录token无效
                            //未登录状态
                        }
                    }else{
                         //未登录状态的token
                    }
                }else{
                    //没有开启检测，所有人都可以查看
                    $userAuthorize="1";
                }
          //  }
        }
    }

    if (isset($_GET["t"])) {
        if (strlen($_GET["t"])>0) {
            $t=$_GET["t"];
        }
    }


    $mk_day=date("Ymd");


    ////开奖时间，13:09~~ 次日 04：04
    if($api=="lucky-air-ship"){
        $nowtime=date("Y-m-d H:i:s");
        $firstTime=date("Y-m-d")." 04:09:00";
        if(strtotime($nowtime)<strtotime($firstTime)){
            $mk_day=date("Ymd", strtotime("-1 day"));
        }
    }
        ////开奖时间，09:00~~ 次日 00：00
        if($api=="pc28"){
            $nowtime=date("Y-m-d H:i:s");
            $firstTime=date("Y-m-d")." 00:05:00";
            if(strtotime($nowtime)<strtotime($firstTime)){
                $mk_day=date("Ymd", strtotime("-1 day"));
            }
        }


    $dir=$api."/txt-kj/".$mk_day;
    if (is_dir($dir)) {
        require_once 'WinRate.php';
        $info=array(
            "api"=>$api, //文件夹名称 pk10    k10-js   pk10-js-xy"
            "plan_ways"=>$plan_ways, //冠 亚
            "plan_positon"=>$plan_positon, //冠 亚
            "plan_numbers"=>$plan_numbers,  //四码
            "latest_limit"=>$history_limit,  //统计最近n期的胜率
            "n_qi_plan"=>$q, //n期计划
            "plan_id"=>$id, //计划代号 0-9999
            "authorizeMark"=>$userAuthorize, // 0 表示未经授权
            "defaultPlanId_index"=>$defaultPlanId_index,
            "needAuthorize_array"=>$needAuthorize_array
        );
        $WinRate=new WinRate($info);

        //var_dump($WinRate);
        if ($id==-1) {
            echo json_encode($WinRate->getAllRate());
        } else {
           // echo json_encode($WinRate->getOneRate());
            echo json_encode($WinRate->getAllRate($id));
        }
     
    } else {
        echo 'Unable to open dir!';
    }
} else {
    echo '{err:"No parameters"}';
}
