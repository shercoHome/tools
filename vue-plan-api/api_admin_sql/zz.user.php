<?php
require 'allowOrigin.php';

$json_result=array("code"=>"-2","msg"=>"null","data"=>array());

$aff='';
$userID='';
$token='';
$childID='';
$webID='';
$shareCode='';
$username='';
$password='';
$newpassword='';
$registerQQ='';
$registerWechat='';
$registerPhone='';
$registerEmail='';
$fromLink='';
$formKey='';
$formValue='';

if (is_array($_GET)&&count($_GET)>0) {
    $file_path=dirname(__FILE__).'/class.websetting.php';
    try {
        if (file_exists($file_path)) {
            $getid='1';
            if (isset($_GET["userID"])) {
                if (strlen($_GET["userID"])>0) {
                    $getid=$_GET['userID'];
                }
            }
            require_once $file_path;
            $DBwebsetting=new websetting();
            $webInfo=array('userID'=>$getid);
            $arLink=$DBwebsetting->show($webInfo);
            echo $arLink[0]['siteLink'];   
        } else {
        }
    } catch (Exception $e) {
    }
}
if (is_array($_POST)&&count($_POST)>0) {
    if (isset($_POST["aff"])) {
        if (strlen($_POST["aff"])>0) {
            $aff=$_POST["aff"];
        }
    }
    if (isset($_POST["uid"])) {
        if (strlen($_POST["uid"])>0) {
            $userID=$_POST["uid"];
        }
    }
    if (isset($_POST["childID"])) {
        if (strlen($_POST["childID"])>0) {
            $childID=$_POST["childID"];
        }
    }
    if (isset($_POST["token"])) {
        if (strlen($_POST["token"])>0) {
            $token=$_POST["token"];
        }
    }
    if (isset($_POST["webID"])) {
        if (strlen($_POST["webID"])>0) {
            $webID=$_POST["webID"];
        }
    }
    if (isset($_POST["shareCode"])) {
        if (strlen($_POST["shareCode"])>0) {
            $shareCode=$_POST["shareCode"];
        }
    }
    if (isset($_POST["username"])) {
        if (strlen($_POST["username"])>0) {
            $username=$_POST["username"];
        }
    }
    if (isset($_POST["password"])) {
        if (strlen($_POST["password"])>0) {
            $password=$_POST["password"];
        }
    }
    if (isset($_POST["newpassword"])) {
        if (strlen($_POST["newpassword"])>0) {
            $newpassword=$_POST["newpassword"];
        }
    }
    if (isset($_POST["registerQQ"])) {
        if (strlen($_POST["registerQQ"])>0) {
            $registerQQ=$_POST["registerQQ"];
        }
    }
    if (isset($_POST["registerWechat"])) {
        if (strlen($_POST["registerWechat"])>0) {
            $registerWechat=$_POST["registerWechat"];
        }
    }
    if (isset($_POST["registerPhone"])) {
        if (strlen($_POST["registerPhone"])>0) {
            $registerPhone=$_POST["registerPhone"];
        }
    }
    if (isset($_POST["registerEmail"])) {
        if (strlen($_POST["registerEmail"])>0) {
            $registerEmail=$_POST["registerEmail"];
        }
    }
    if (isset($_POST["fromLink"])) {
        if (strlen($_POST["fromLink"])>0) {
            $fromLink=$_POST["fromLink"];
        }
    }
    if (isset($_POST["formKey"])) {
        if (strlen($_POST["formKey"])>0) {
            $formKey=$_POST["formKey"];
        }
    }
    if (isset($_POST["formValue"])) {
        if (strlen($_POST["formValue"])>0) {
            $formValue=$_POST["formValue"];
        }
    }
    ob_clean();
    if (isset($_POST["type"])) {
        if (strlen($_POST["type"])>0) {
            switch ($_POST["type"]) {

                case 'changePassword':
                echo json_encode(changePassword($userID, $token, $password, $newpassword));
                break;
                
                case 'readLetter':
                echo json_encode(readLetter($userID, $token,$childID));
                break;
                case 'getLetter':
                echo json_encode(getLetter($userID, $token));
                break;
                case 'updateUser':
                    echo json_encode(updateUser($userID, $token, $formKey, $formValue));
                    break;
                case 'getAPI':
                    echo json_encode(getApi($aff));
                    break;
                    break;
                case 'webSet':
                    echo json_encode(getWebSet($aff));
                    break;
                case "init":
                    echo json_encode(webInt($aff, $userID, $token, $shareCode));
                    break;
                case 'check':
                    echo json_encode(checkUser($username));
                    break;
                case 'regist':
                    echo json_encode(userRegister($username, $password, $aff, $fromLink, $registerQQ, $registerWechat, $registerPhone, $registerEmail));
                    break;
                case 'login':
                    echo json_encode(userLogin($username, $password, $aff, $fromLink));
                    break;
                case 'reLogin':
                    echo json_encode(reLogin($userID, $token));
                    break;
                case 'share':
                    echo json_encode(addShare($shareCode));
                    break;
                default:
            }
        }
    }
}
//getWebSet('cdadmin.beer668.cn');
//reLogin('5', "4cf9503c19bf5151613c35721a0a0040", "3");
//echo json_encode(addShare('4cf9503c19bf5151613c35721a0a0040'));
//echo json_encode(webInt('cdadmin.beer668.cn','5',"3c7f7a6145cb9a6726dd2922c9010c16",''));
//echo json_encode(checkUser('cdadmin'));
//echo json_encode(userRegister('zhangsan2', 'whatfuckhaha','cdadmin.beer668.cn','baidu.com'));
//echo json_encode(userLogin('zhangsan', 'whatfuck', 'cdadmin.beer668.cn','baidu.com'));

function webInt($aff, $userID, $token, $shareCode)
{
    $re_err=array("code"=>"0","msg"=>"result err","data"=>array());
    $re_arr=array();
    $re_arr['webSet']=getWebSet($aff);
    $webID=($re_arr['webSet']['code']==="1")?$re_arr['webSet']['data']['id']:"";
    $re_arr['api']=getApi();
    $re_arr['token']=($token!=='')?reLogin($userID, $token):$re_err;
    $re_arr['shareCode']=($shareCode!=="")?addShare($shareCode):$re_err;
    return $re_arr;
}
function readLetter($userID, $token,$childID){
    require_once 'class.logLogin.php';
    $logLogin=new logLogin();
    $isLogin=$logLogin->checkToken($userID, $token);
    if ($isLogin!==true) {
        return array("code"=>"-9","msg"=>"登录超时<br>updateUser","data"=>$isLogin);
    }
    require_once 'class.letter.php';
    $DBletter=new letter();
    $letterInfos=$DBletter->update(array("id"=>$childID,"isRead"=>"1"));
    if ($letterInfos===true) {
        return array("code"=>"1","msg"=>"获取站内信(".$childID.")isRead","data"=>$letterInfos);
    } else {
        return array("code"=>"0","msg"=>"获取站内信失败","data"=>$letterInfos);
    }

}
function getLetter($userID, $token){
    require_once 'class.logLogin.php';
    $logLogin=new logLogin();
    $isLogin=$logLogin->checkToken($userID, $token);
    if ($isLogin!==true) {
        return array("code"=>"-9","msg"=>"登录超时<br>updateUser","data"=>$isLogin);
    }

    require_once 'class.letter.php';
    $DBletter=new letter();
    $letterInfos=$DBletter->show(array("userID"=>$userID));
    if ($letterInfos!==false) {
        return array("code"=>"1","msg"=>"获取站内信成功","data"=>$letterInfos);
    } else {
        return array("code"=>"0","msg"=>"获取站内信失败","data"=>$letterInfos);
    }
}
function changePassword($userID, $token, $password, $newpassword)
{
    require_once 'class.logLogin.php';
    $logLogin=new logLogin();
    $isLogin=$logLogin->checkToken($userID, $token);
    if ($isLogin!==true) {
        return array("code"=>"-9","msg"=>"登录超时<br>updateUser","data"=>$isLogin);
    }

    require_once 'class.user.php';
    $DBuser=new user();
    $userInfos=$DBuser->show(array("id"=>$userID));
    $userInfo=$userInfos[0];
    $oldpassword=$userInfo['userPsw'];
    $oldpassword_temp=$DBuser->createPassWord($password);
    if ($oldpassword!==$oldpassword_temp) {
        return array("code"=>"0","msg"=>"旧密码错误","data"=>$oldpassword_temp);
    }

    $updateInfo=array("id"=>$userID,"userPsw"=>$newpassword);
    
    $re_update=$DBuser->update($updateInfo);
    if ($re_update===true) {
        return array("code"=>"1","msg"=>"修改成功<br>changePassword: successfully","data"=>$re_update);
    } else {
        return array("code"=>"0","msg"=>"修改出错<br>changePassword: false","data"=>$re_update);
    }


}

function updateUser($userID, $token, $formKey, $formValue)
{
    require_once 'class.logLogin.php';
    $logLogin=new logLogin();
    $isLogin=$logLogin->checkToken($userID, $token);
    if ($isLogin!==true) {
        return array("code"=>"-9","msg"=>"登录超时<br>updateUser","data"=>$isLogin);
    }
    $updateInfo=array("id"=>$userID);

    if ($formKey=="") {
    }

    $updateInfo[$formKey]=$formValue;

    require_once 'class.common.php';
    $__common=new commonFun();
    $__temp =$__common->decrypt($token);
    $__tempAr=explode("|", $__temp);
    $webID=$__tempAr[2];//登录的网站id

    require_once 'class.websetting.php';
    $DBwebsetting=new websetting();
    $DBwebsettingList=$DBwebsetting->show(array("id"=>$webID));
    $DBwebsettingOne=$DBwebsettingList[0];

    switch ($formKey) {
        case "userPsw":
            if ($DBwebsettingOne['updateUserPsw']=="0") {
                return array("code"=>"0","msg"=>"暂时无法修改<br>updateUser: webset->updateUserPsw false","data"=>$DBwebsettingOne['updateUserPsw']);
            }
            break;
        case "userQQ":
            if ($DBwebsettingOne['updateUserQQ']=="0") {
                return array("code"=>"0","msg"=>"暂时无法修改<br>: webset->updateUserQQ false","data"=>$DBwebsettingOne['updateUserQQ']);
            }
            break;
        case "userWechat":
            if ($DBwebsettingOne['updateUserWechat']=="0") {
                return array("code"=>"0","msg"=>"暂时无法修改<br>: webset->updateUserWechat false","data"=>$DBwebsettingOne['updateUserWechat']);
            }
            break;
        case "userPhone":
            if ($DBwebsettingOne['updateUserPhone']=="0") {
                return array("code"=>"0","msg"=>"暂时无法修改<br>: webset->updateUserPhone false","data"=>$DBwebsettingOne['updateUserPhone']);
            }
            break;
        case "userEmail":
            if ($DBwebsettingOne['updateUserEmail']=="0") {
                return array("code"=>"0","msg"=>"暂时无法修改<br>: webset->updateUserEmail false","data"=>$DBwebsettingOne['updateUserEmail']);
            }
            break;
        default:
            return array("code"=>"0","msg"=>"修改失败，参数出错<br>:formKey false","data"=>$formKey);
    }
    require_once 'class.user.php';
    $user=new user();
    $re_update=$user->update($updateInfo);
    if ($re_update===true) {
        return array("code"=>"1","msg"=>"修改成功<br>updateUser: successfully","data"=>$re_update);
    } else {
        return array("code"=>"0","msg"=>"修改出错<br>updateUser: false","data"=>$re_update);
    }
}
function getApi($aff)
{


    
    $array_plansForThisSite=array();
    if ($aff!="admin") {
        // $info['switch']='1';

        require_once 'class.websetting.php';
        $DBwebsetting=new websetting();
        $webInfo=array("siteLink"=>$aff);
        $json_set=$DBwebsetting->show($webInfo);
        if ($json_set!==false) {
            $json_set=$json_set[0];
            $str_plansForThisSite=$json_set["mark4"];//此站点开放的计划
            // 

           // $str_plansForThisSite="pk10-js||pk10-js-xy||lucky-air-ship||ffssc||pc28||pk10-bj||vr-sxffc||cqssc||ffssclt";
            //转为数组
            $array_plansForThisSite=explode("||", $str_plansForThisSite);
        }
    } else {
        $array_plansForThisSite='allForAdmin';
    }
    require_once 'class.api.php';
    $DBapi=new api();
    $re_api=$DBapi->show();


    $re_api_temp=array();
    if ($array_plansForThisSite!=='allForAdmin') {
      
        foreach ($re_api as $apiJson) {
            $lotteryID = $apiJson['lotteryID'];
            if (in_array($lotteryID, $array_plansForThisSite)) {
                array_push($re_api_temp, $apiJson);
               
            }
        
        }
     
    }
    $re_api=$re_api_temp;
       

    if ($re_api!==false) {
        $json_result=array("code"=>"1","msg"=>"getApi success","data"=>$re_api);
    } else {
        $json_result=array("code"=>"0","msg"=>"getApi err","data"=>$re_api);
    }
    return $json_result;
}
/**
 * 获取网站配置
 * @param   aff xxx.domain.cn;
 * @return json_encode
 */
function getWebSet($aff)
{
    require_once 'class.websetting.php';
    $DBwebsetting=new websetting();
    $webInfo=array("siteLink"=>$aff);
    $json_set=$DBwebsetting->show($webInfo);
    if ($json_set!==false) {
        $json_set=$json_set[0];


        require_once 'class.logLogin.php';
        $DBlog=new logLogin();
        $nologinToken=$DBlog->createToken('0', $json_set["id"], $json_set["loginKeep"], "0");
        $json_set['token']=$nologinToken;

        $json_result=array("code"=>"1","msg"=>"getWebSet success","data"=>$json_set);
    } else {
        $json_result=array("code"=>"0","msg"=>"getWebSet err","data"=>$json_set);
    }
    return $json_result;
}
/**
 * 检查token时效
 * @param   $userID="5";$token="4cf9503c19bf5151613c35721a0a0040";$web-ID="3";
 * @return json_encode
 */
function reLogin($userID, $token)
{
    require_once 'class.logLogin.php';
    $logLogin=new logLogin();
    $toCheckLogin=$logLogin->checkToken($userID, $token);
    if ($toCheckLogin===true) {
        require_once 'class.user.php';
        $DBuser=new user();
        $userInfo=$DBuser->show(array("id"=>$userID));
        $userInfo=$userInfo[0];
        $userInfo['loginToken']=$token;
        //刷新授权
        require_once 'class.shareIP.php';
        $DBshare=new shareIP();
        $shareCode=$userInfo['shareCode'];

        if ($DBshare->checkCode($shareCode)) {
            $shareArray=$DBshare->show();
  
            if ($shareArray===false) {
                $shareCount=0;
            } else {
                $shareCount=count($shareArray);
            }

            //////////////////////////////////
            $hisAgentID=$userInfo['agentDirect'];
            if ($userInfo['agentStatus']==1) {
                $hisAgentID=$userInfo['id'];
            }
            // 在此读取配置表，对比授权要求，并更正授权状态
            require_once 'class.websetting.php';
            $DBwebsetting=new websetting();
            $webInfo=array("userID"=>$hisAgentID);
            $json_set=$DBwebsetting->show($webInfo)[0];
            $hisShareRequiredIP=$json_set['shareRequiredIP'];
            $hisLimite=$json_set['shareLimiteTime'];//授权持续的时间 分享授权|荣誉授权  0永久，n 天
            $hisLimite_array=explode("|",$hisLimite);
            $hisLimite_share=array_key_exists(0,$hisLimite_array)?$hisLimite_array[0]:"10";//分享授权持续时间
            $hisLimite_white=array_key_exists(1,$hisLimite_array)?$hisLimite_array[1]:"30";//荣誉授权持续时间
            $hisStatus=$userInfo['authorizationStatus'];
            $hisTime=$userInfo['authorizationTime'];

            //hisStatus	授权状态（0未 1已 2待 3特别   //未授权0	已授权1	黑名单2	特别授权3 2019年6月15日 15:33:13 修改状态2 为黑名单
            //hisTime 开始授权的时间，变更授权状态时修改


            $new_hisStatus=$hisStatus;

            if ($hisStatus =="0") {//未授权处理
                if ($shareCount>=$hisShareRequiredIP) {//对比授权要求
                    //授权有变，更正授权状态
                    $userInfo['authorizationStatus']="1";
                    $__update=$DBuser->update(array("id"=>$userInfo['id'],'authorizationStatus'=>'1'));
                    if($__update){
                        $new_hisStatus="1";
                    }
                }
            } elseif ($hisStatus=="1") {  //已授权1  
                $t1= strtotime($hisTime);
                $t2=strtotime("-".$hisLimite_share." days");
                if ($t1<$t2 && $hisLimite_share!="0") {//到期
                    $userInfo['authorizationStatus']="0";
                    $__update=$DBuser->update(array("id"=>$userInfo['id'],'authorizationStatus'=>'0'));
                    if($__update){
                        $new_hisStatus="0";
                    }

                    $expired=$DBshare->expired($shareCode);
                }
                if ($shareCount<$hisShareRequiredIP) {//对比授权要求
                    //授权有变，更正授权状态
                    $userInfo['authorizationStatus']="0";
                    $__update=$DBuser->update(array("id"=>$userInfo['id'],'authorizationStatus'=>'0'));
                    if($__update){
                        $new_hisStatus="0";
                    }
                }
            } elseif ($hisStatus=="3" ) {  //  特别授权3 
                $t1= strtotime($hisTime);
                $t2=strtotime("-".$hisLimite_white." days");
            
                if ($t1<$t2 && $hisLimite_white!="0") {//到期
                    $userInfo['authorizationStatus']="0";
                    $__update=$DBuser->update(array("id"=>$userInfo['id'],'authorizationStatus'=>'0'));
                    if($__update){
                        $new_hisStatus="0";
                    }
                    $expired=$DBshare->expired($shareCode);

                    $info=array(
                        "userID"=>$userInfo['id'],
                        "wbStatus"=>'0',
                        "updater"=>$userInfo['id']
                        );

                        require_once 'class.authorizationWBStatus.php';
                        $authorizationWBStatus=new authorizationWBStatus();
                    //  $re_authorizationWBStatus=$authorizationWBStatus->show(array("id"=>$userID));//特别授权表中的数据
                    //  $hisWBStatue=$re_authorizationWBStatus[0]['wbStatus']; //白名单1	黑名单2 不在名单0
                    $re_insert=$authorizationWBStatus->insert($info);
                }
            } else {//黑名单
                $new_hisStatus="2";
            }
            // if ($hisStatus =="0" || $hisStatus=="2") {//待授权未处理，先覆盖
            //     if ($shareCount>=$hisShareRequiredIP) {//对比授权要求
            //         //授权有变，更正授权状态
            //         $userInfo['authorizationStatus']="1";
            //         $DBuser->update(array("id"=>$userInfo['id'],'authorizationStatus'=>'1'));
            //     }
            // } elseif ($hisStatus=="1") {
            //     $t1= strtotime($hisTime);
            //     $t2=strtotime("-".$hisLimite." days");
            //     if ($t1<$t2 && $hisLimite!="0") {//到期
            //         $userInfo['authorizationStatus']="0";
            //         $DBuser->update(array("id"=>$userInfo['id'],'authorizationStatus'=>'0'));
            //         $expired=$DBshare->expired($shareCode);
            //     }
            //     if ($shareCount<$hisShareRequiredIP) {//对比授权要求
            //         //授权有变，更正授权状态
            //         $userInfo['authorizationStatus']="0";
            //         $DBuser->update(array("id"=>$userInfo['id'],'authorizationStatus'=>'0'));
            //     }
            // } else {
            //     $t1= strtotime($hisTime);
            //     $t2=strtotime("-".$hisLimite." days");
            //     if ($t1<$t2 && $hisLimite!="0") {//到期
            //         $userInfo['authorizationStatus']="0";
            //         $DBuser->update(array("id"=>$userInfo['id'],'authorizationStatus'=>'0'));
            //         $expired=$DBshare->expired($shareCode);

            //         $info=array(
            //             "userID"=>$userInfo['id'],
            //             "wbStatus"=>'0',
            //             "updater"=>$userInfo['id']
            //             );
            //         require_once 'class.authorizationWBStatus.php';
            //         $authorizationWBStatus=new authorizationWBStatus();
            //         $re_insert=$authorizationWBStatus->insert($info);
            //     }
            // }
            //////////////////////////////////


            $userInfo['authorizationStatus']=$new_hisStatus;



            if($hisStatus!==$new_hisStatus){
                //加入登录日志
                require_once 'class.logLogin.php';
                $DBlog=new logLogin();
                $loginToken=$DBlog->createToken($userID, $loginWeb_ID, $loginkeep, $new_hisStatus);
            // $DBlogInsert=$DBlog->insert($userInfo['id'], $aff, $fromLink);
            // if ($DBlogInsert===true) {
                    //
            // };
                $userInfo['loginToken']=$loginToken;
            }


            



            $userInfo['aff']= "http://".$json_set['siteLink'];
            $userInfo['shareCount']=$shareCount;
            $userInfo['shareRequiredIP']=$json_set['shareRequiredIP'];
        } else {
            // echo shareCode 不正确？ 程序出错了
        }

                        //获取站内信
                        require_once 'class.letter.php';
                        $DBletter=new letter();
                        $letterInfos=$DBletter->show(array("userID"=>$userID));
                        $userInfo['letter']=$letterInfos;
                        
        $json_result=array("code"=>"1","msg"=>"toCheckLogin success","data"=> $userInfo);
    } else {
        $json_result=array("code"=>"2","msg"=>"登录超时<br>toCheckLogin","data"=>$toCheckLogin);
    }
    return $json_result;
}
/**
 * 登录
 * @param   $name 账号   $psw  密码
 * @return json_encode
 */
function userLogin($name, $psw, $aff, $fromLink)
{
    if (!isMatchLoginName($name) && $name!=='admin') {
        $json_result=array("code"=>"-1","msg"=>"账号错误","data"=>array());
    } elseif (!isMatchPSw($psw)) {
        $json_result=array("code"=>"-1","msg"=>"密码错误","data"=>array());
    } else {
        require_once 'class.user.php';
        $DBuser=new user();
        $isExist=$DBuser->show(array("userName"=>$name));
        if ($isExist!=false) {//判断,用户存在
            $userInfo=$isExist[0];

            if ($userInfo['userActive']!="1") {
                return  array("code"=>"-1","msg"=>"账号异常请联系客服","data"=>array());
            }
            
           
            $DBpsw=$userInfo['userPsw'];
            $userID=$userInfo['id'];
            $authorizationStatus=$userInfo['authorizationStatus'];


            $inputPassWord=$DBuser->createPassWord($psw);
            if ($DBpsw==$inputPassWord) {


                // 在此读取配置表，查看对应网站的id和token的keepTime
                require_once 'class.websetting.php';
                $DBwebsetting=new websetting();
                $webInfo=array("siteLink"=>$aff);
                $json_set=$DBwebsetting->show($webInfo)[0];
                $loginWeb_ID=$json_set['id'];
                $loginWebMasterID=$json_set['userID'];
                $loginkeep=$json_set['loginKeep'];
                //$loginOutTime=date('Y-m-d H:i:s', strtotime("+".$loginkeep." minutes"));//过期时间


                
                //刷新授权
                require_once 'class.shareIP.php';
                $DBshare=new shareIP();
                $shareCode=$userInfo['shareCode'];

                $checkShareCode=$DBshare->checkCode($shareCode);
                if ($checkShareCode) {
                    $shareArray=$DBshare->show();
                    if ($shareArray===false) {
                        $shareCount=0;
                    } else {
                        $shareCount=count($shareArray);
                    }
                    
                    // 根据配置表，对比授权要求，并更正授权状态

                    //////////////////////////////////
                    $hisAgentID=$userInfo['agentDirect'];
                    if ($userInfo['agentStatus']==1) {
                        $hisAgentID=$userInfo['id'];
                    }
                    // 在此读取配置表，对比授权要求，并更正授权状态
                    require_once 'class.websetting.php';
                    $DBwebsetting=new websetting();
                    $webInfo=array("userID"=>$hisAgentID);
                    $json_set=$DBwebsetting->show($webInfo)[0];
                    $hisShareRequiredIP=$json_set['shareRequiredIP'];
                    $hisLimite=$json_set['shareLimiteTime'];//授权持续的时间 分享授权|荣誉授权  0永久，n 天
                    $hisLimite_array=explode("|",$hisLimite);
                    $hisLimite_share=array_key_exists(0,$hisLimite_array)?$hisLimite_array[0]:"10";//分享授权持续时间
                    $hisLimite_white=array_key_exists(1,$hisLimite_array)?$hisLimite_array[1]:"30";//荣誉授权持续时间
                    $hisStatus=$userInfo['authorizationStatus'];
                    $hisTime=$userInfo['authorizationTime'];
        
                    //hisStatus	授权状态（0未 1已 2待 3特别   //未授权0	已授权1	黑名单2	特别授权3 2019年6月15日 15:33:13 修改状态2 为黑名单
                    //hisTime 开始授权的时间，变更授权状态时修改
                    

                    $new_hisStatus=$hisStatus;

                    if ($hisStatus =="0") {//未授权处理
                        if ($shareCount>=$hisShareRequiredIP) {//对比授权要求
                            //授权有变，更正授权状态
                            $userInfo['authorizationStatus']="1";
                            $__update=$DBuser->update(array("id"=>$userInfo['id'],'authorizationStatus'=>'1'));
                            if($__update){
                                $new_hisStatus="1";
                            }
                        }
                    } elseif ($hisStatus=="1") {  //已分享授权1  
                        $t1= strtotime($hisTime);
                        $t2=strtotime("-".$hisLimite_share." days");
                        if ($t1<$t2 && $hisLimite_share!="0") {//到期
                            $userInfo['authorizationStatus']="0";
                            $__update=$DBuser->update(array("id"=>$userInfo['id'],'authorizationStatus'=>'0'));
                            if($__update){
                                $new_hisStatus="0";
                            }

                            $expired=$DBshare->expired($shareCode);
                        }
                        if ($shareCount<$hisShareRequiredIP) {//对比授权要求
                            //授权有变，更正授权状态
                            $userInfo['authorizationStatus']="0";
                            $__update=$DBuser->update(array("id"=>$userInfo['id'],'authorizationStatus'=>'0'));
                            if($__update){
                                $new_hisStatus="0";
                            }
                        }
                    } elseif ($hisStatus=="3" ) {  //  特别授权3 
                        $t1= strtotime($hisTime);
                        $t2=strtotime("-".$hisLimite_white." days");
                     
                        if ($t1<$t2 && $hisLimite_white!="0") {//到期
                            $userInfo['authorizationStatus']="0";
                            $__update=$DBuser->update(array("id"=>$userInfo['id'],'authorizationStatus'=>'0'));
                            if($__update){
                                $new_hisStatus="0";
                            }
                            $expired=$DBshare->expired($shareCode);

                            $info=array(
                                "userID"=>$userInfo['id'],
                                "wbStatus"=>'0',
                                "updater"=>$userInfo['id']
                                );

                                require_once 'class.authorizationWBStatus.php';
                                $authorizationWBStatus=new authorizationWBStatus();
                              //  $re_authorizationWBStatus=$authorizationWBStatus->show(array("id"=>$userID));//特别授权表中的数据
                              //  $hisWBStatue=$re_authorizationWBStatus[0]['wbStatus']; //白名单1	黑名单2 不在名单0
                            $re_insert=$authorizationWBStatus->insert($info);
                        }
                    } else {//黑名单
                        $new_hisStatus="2";
                    }
                    
///////////////////////////////
                    // if ($hisStatus =="0" || $hisStatus=="2") {//待授权未处理，先覆盖
                    //     if ($shareCount>=$hisShareRequiredIP) {//对比授权要求
                    //         //授权有变，更正授权状态
                    //         $userInfo['authorizationStatus']="1";
                    //         $DBuser->update(array("id"=>$userInfo['id'],'authorizationStatus'=>'1'));
                    //     }
                    // } elseif ($hisStatus=="1") {
                    //     $t1= strtotime($hisTime);
                    //     $t2=strtotime("-".$hisLimite." days");
                    //     if ($t1<$t2 && $hisLimite!="0") {//到期
                    //         $userInfo['authorizationStatus']="0";
                    //         $DBuser->update(array("id"=>$userInfo['id'],'authorizationStatus'=>'0'));
                    //         $expired=$DBshare->expired($shareCode);
                    //     }
                    //     if ($shareCount<$hisShareRequiredIP) {//对比授权要求
                    //         //授权有变，更正授权状态
                    //         $userInfo['authorizationStatus']="0";
                    //         $DBuser->update(array("id"=>$userInfo['id'],'authorizationStatus'=>'0'));
                    //     }
                    // } else {
                    //     $t1= strtotime($hisTime);
                    //     $t2=strtotime("-".$hisLimite." days");
                    //     if ($t1<$t2 && $hisLimite!="0") {//到期
                    //         $userInfo['authorizationStatus']="0";
                    //         $DBuser->update(array("id"=>$userInfo['id'],'authorizationStatus'=>'0'));
                    //         $expired=$DBshare->expired($shareCode);
        
                    //         $info=array(
                    //             "userID"=>$userInfo['id'],
                    //             "wbStatus"=>'0',
                    //             "updater"=>$userInfo['id']
                    //             );
                    //         require_once 'class.authorizationWBStatus.php';
                    //         $authorizationWBStatus=new authorizationWBStatus();
                    //         $re_insert=$authorizationWBStatus->insert($info);
                    //     }
                    // }
                    //////////////////////////////////

                    $userInfo['aff']= "http://".$json_set['siteLink'];
                    $userInfo['shareCount']=$shareCount;
                    $userInfo['shareRequiredIP']=$json_set['shareRequiredIP'];
                } else {
                    // echo shareCode 不正确？ 程序出错了

                    $userInfo['checkShareCode']=$checkShareCode;
                }

                $userInfo['authorizationStatus']=$new_hisStatus;

                //加入登录日志
                require_once 'class.logLogin.php';
                $DBlog=new logLogin();
                $loginToken=$DBlog->createToken($userID, $loginWeb_ID, $loginkeep, $new_hisStatus);
                $DBlogInsert=$DBlog->insert($userInfo['id'], $aff, $fromLink);
                if ($DBlogInsert===true) {
                    //
                };
                $userInfo['loginToken']=$loginToken;

                //获取站内信
                require_once 'class.letter.php';
                $DBletter=new letter();
                $letterInfos=$DBletter->show(array("userID"=>$userID));
                $userInfo['letter']=$letterInfos;

                //0-id 1-user 2-psw 3-time 4-ip 5-code 6-userAuthorize
                $json_result=array("code"=>"1","msg"=>"登录成功","data"=>$userInfo);
            } else {
                $json_result=array("code"=>"0","msg"=>"密码错误","data"=>array());
            }
        } else {
            $json_result=array("code"=>"-1","msg"=>"账号不存在","data"=>array());
        }
    }
    return $json_result;
}

/**
 * 检查用户名是否存在
 * @param   $name 账号
 * @return json_encode
 */
function checkUser($name)
{
    $userInfo=array("userName"=>$name);
    if (isMatchName($name)) {
        require_once 'class.user.php';
        $DBuser=new user();
        
        $json_result=array("code"=>"0","msg"=>"账号可用","data"=>array());

        if ($DBuser->show($userInfo)!=false) {//判断,用户存在
            $json_result=array("code"=>"-1","msg"=>"账号已存在","data"=>array());
        }
    } else {
        $json_result=array("code"=>"-1","msg"=>"账号为6-15位英文字母、数字或下划线","data"=>array());
    }
    return $json_result;
}

/**
 * 注册
 * @param    $name 账号   $psw  密码
 * @return json_encode
 */
function userRegister($name, $psw, $aff, $fromLink, $registerQQ, $registerWechat, $registerPhone, $registerEmail)
{

    //维护中，无法注册，便于搬家
   // return array("code"=>"0","msg"=>"注册失败，系统维护中，请22:00后再试","data"=>array());

    if (!isMatchName($name)) {
        $json_result=array("code"=>"-1","msg"=>"账号为6-15位英文字母、数字或下划线（字母开头）","data"=>array());
    } elseif (!isMatchPSw($psw)) {
        $json_result=array("code"=>"-1","msg"=>"密码为6-15位英文字母、数字或下划线","data"=>array());
    } else {
        require_once 'class.user.php';
        $DBuser=new user();
        $showUserList=$DBuser->show(array("userName"=>$name));
        if ($showUserList!=false) {//判断用户是否存在
            $json_result=array("code"=>"-1","msg"=>"账号已存在","data"=>array());
        } else {
            require_once 'class.websetting.php';
            $DBwebsetting=new websetting();
            $webInfo=array("siteLink"=>$aff);
            $webOwner=$DBwebsetting->show($webInfo)[0]['userID'];

            $webOwnerInfo=$DBuser->show(array("id"=>$webOwner));

            $userInfo=array(
                "userName"=>$name,
                "userPsw"=>$psw,
                "agentAdmin"=>$webOwnerInfo[0]["agentAdmin"],
                "agentTop"=>$webOwnerInfo[0]["agentTop"],
                "agentDirect"=>$webOwner,
                "fromLink"=>$fromLink
            );
            if ($registerQQ!=='') {
                $userInfo["userQQ"] = $registerQQ;
            }
            if ($registerWechat!=='') {
                $userInfo["userWechat"] = $registerWechat;
            }
            if ($registerPhone!=='') {
                $userInfo["userPhone"] = $registerPhone;
            }
            if ($registerEmail!=='') {
                $userInfo["userEmail"] = $registerEmail;
            }

            $userID=$DBuser->insert($userInfo);
            if ($userID!==false) {
                $DBuser->update(array(
                    "id"=>$userID,
                    "shareCode"=>$userID
                ));
                

                $json_result=array("code"=>"1","msg"=>"注册成功","data"=>$userID);
            } else {
                $json_result=array("code"=>"0","msg"=>"注册失败","data"=>array());
            }
        }
    }
    return $json_result;
}
/**
 * 增加分享、访问次数
 * @param   $shareCode 分享码
 * @return json_encode
 */
function addShare($shareCode)
{
    require_once 'class.shareIP.php';
    $DBshare=new shareIP();
    if ($DBshare->checkCode($shareCode)) {
        if ($DBshare->insert()) {
            $json_result=array("code"=>"1","msg"=>"Share +1","data"=>array());
        } else {
            $json_result=array("code"=>"-1","msg"=>"Visits +1","data"=>array());
        }
    } else {
        $json_result=array("code"=>"-1","msg"=>"shareCode err","data"=>array());
    }
    return $json_result;
}
function isMatchLoginName($str)
{
    if (preg_match('/^[a-zA-Z]([a-zA-Z0-9_]{4,14})+$/', $str)) {
        return true;
    } else {
        return false;
    }
}
function isMatchName($str)
{
    if (preg_match('/^[a-zA-Z]([a-zA-Z0-9_]{5,14})+$/', $str)) {
        return true;
    } else {
        return false;
    }
}
function isMatchPSw($str)
{
    if (preg_match('/^[a-zA-Z0-9_]{6,15}+$/', $str)) {
        return true;
    } else {
        return false;
    }
}
