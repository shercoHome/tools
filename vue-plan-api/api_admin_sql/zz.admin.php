<?php
require 'allowOrigin.php';

$userID='';
$childID='';
$token='';
$form='';
$formKey='';
$formValue='';
$userName="";
$wbStatus="";
$authorizeID="";
$shareCode="";
$userLevel="";
$fromUserID="";
// $page=1;
// $n=10;
if (is_array($_POST)&&count($_POST)>0) {
    if (isset($_POST["page"])) {
        if (strlen($_POST["page"])>0) {
            $page=$_POST["page"];
        }
    }
    if (isset($_POST["n"])) {
        if (strlen($_POST["n"])>0) {
            $n=$_POST["n"];
        }
    }
    if (isset($_POST["sort"])) {
        if (strlen($_POST["sort"])>0) {
            $sort=$_POST["sort"];
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
    if (isset($_POST["fromUserID"])) {
        if (strlen($_POST["fromUserID"])>0) {
            $fromUserID=$_POST["fromUserID"];
        }
    }
    if (isset($_POST["userName"])) {
        if (strlen($_POST["userName"])>0) {
            $userName=$_POST["userName"];
        }
    }
    if (isset($_POST["userLevel"])) {
        if (strlen($_POST["userLevel"])>0) {
            $userLevel=$_POST["userLevel"];
        }
    }
    if (isset($_POST["wbStatus"])) {
        if (strlen($_POST["wbStatus"])>0) {
            $wbStatus=$_POST["wbStatus"];
        }
    }
    if (isset($_POST["authorizeID"])) {
        if (strlen($_POST["authorizeID"])>0) {
            $authorizeID=$_POST["authorizeID"];
        }
    }
    if (isset($_POST["shareCode"])) {
        if (strlen($_POST["shareCode"])>0) {
            $shareCode=$_POST["shareCode"];
        }
    }
    if (isset($_POST["token"])) {
        if (strlen($_POST["token"])>0) {
            $token=$_POST["token"];
        }
    }
    if (isset($_POST["form"])) {
        if (strlen($_POST["form"])>0) {
            $form=$_POST["form"];
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

    if (isset($_POST["type"])) {
        if (strlen($_POST["type"])>0) {
            // require_once 'DB/DBset.php';
            // $DBset=new DBset();
            $json_result=array("code"=>"-2","msg"=>"set null","data"=>array());

            switch ($_POST["type"]) {
                case "getBulletin":
                $path="txt/bulletin.txt";
              //  $myfile = fopen($path, "r") or die("Unable to open file!");
                $content_=  file_get_contents($path);
          
                $json_result= array("code"=>"1","msg"=>"获取公告成功","data"=>$content_);

                break;
                case "setBulletin":
                $mk_dir="txt";
                    if (!file_exists($mk_dir)) {
                        mkdir($mk_dir);
                    }
                    $path=$mk_dir."/bulletin.txt";

                    $bulletinSize = file_put_contents($path, $_POST['bulletin']);
                    if ($bulletinSize) {
                        $json_result= array("code"=>"1","msg"=>"更新公告成功","data"=>$bulletinSize);
                    } else {
                        $json_result= array("code"=>"0","msg"=>"try更新公告失败","data"=>$bulletinSize);
                    }
                    
                break;
                
                case "addLetter":

                $json_result= addLetter($userID, $token, $childID, $formKey, $formValue);
                break;
                case "deleteMyLetters":
                $json_result= deleteMyLetters($userID, $token, $childID);
                break;
                // case "updateMyLetters":
                // $json_result= updateMyLetters($userID, $token, $childID);
                // break;
                case "getMyLetters":
                $json_result= getMyLetters($userID, $token, $formKey, $formValue);
                break;
                case "websiteOverview":
                $json_result= websiteOverview($userID, $token, $childID);
                break;
                case "changeAgent":
                $json_result=changeAgent($userID, $token, $childID, $userName);
                break;

                case "createMyLotteryApi":
                $json_result=createMyLotteryApi($userID, $token, $childID);
                break;
                case "deleteMyLotteryApi":
                $json_result=deleteMyLotteryApi($userID, $token, $childID);
                break;
                case "getMyLotteryApi":
                    $json_result=getMyLotteryApi($userID, $token, $childID);
                    break;
                case "updateLogSubmitList":
                    $json_result=updateLogSubmitList($userID, $token, $childID, $formValue);
                    break;
                case "getLogSubmitList":
                    $json_result=getLogSubmitList($userID, $token);
                    break;
                case "getLimitsByID":
                    $json_result=getLimitsByID($userID, $token, $childID);
                    break;
                case "getAdminLimits":
                    $json_result=getAdminLimits($userID, $token, $userName);
                    break;
                case "createOneUser":
                    $json_result=createOneUser($userID, $token, $userName, $userLevel, $fromUserID);
                    break;
                case "getMyLimit":
                    $json_result=getMyLimit($userID, $token);
                    break;
                case "submitToUpdate":
                    $json_result=submitToUpdate($userID, $token, $childID, $userName, $form, $formKey, $formValue);
                    break;
                case 'toBeAgent':
                    if ($childID=='') {
                        $json_result=submitToUpdate($userID, $token, $userID, $userName, 'user', 'agentStatus', '1');
                    } else {
                        $json_result=submitToUpdate($userID, $token, $childID, $userName, 'user', 'agentStatus', '1');
                    }
                    break;
                case "getUserByName":
                    $json_result=getUserByName($userID, $token, $userName);
                    break;
                case "getMyShareIPList":
                    $json_result=getMyShareIPList($userID, $token, $shareCode);
                    break;
                case "deleteMyAuthorizeList":
                    $json_result=deleteMyAuthorizeList($userID, $token, $authorizeID);
                    break;
                case "updateMyAuthorizeList":
                    $json_result=updateMyAuthorizeList($userID, $token, $authorizeID, $wbStatus);
                    break;
                case "getMyAuthorizeList":
                    $json_result=getMyAuthorizeList($userID, $token, $childID);
                    break;
                case "insertAuthorization":
                    $json_result=insertAuthorization($userID, $token, $userName, $wbStatus);
                    break;
                case "getMySiteSetting":
                    $json_result=getMySiteSetting($userID, $token, $childID);
                    break;
                case 'getMyUsers':
                    $json_result= getMyUsers($userID, $token, $userName);
                    break;
                case 'submitChange':
                    $json_result=submitChange($userID, $token, $childID, $form, $formKey, $formValue);
                    break;
                case 'doChange':
                    $json_result=doChange($userID, $token, $childID, $form, $formKey, $formValue);
                    break;
                case 'show':
                    $json_result=array("code"=>"1","msg"=>"show success","data"=>array());
                    break;
                default:
                    $json_result=array("code"=>"0","msg"=>"type null","data"=>array());
                    break;
            }
            echo json_encode($json_result);
        }
    }
}


if (is_array($_GET)&&count($_GET)>0) {
    if (isset($_GET["t"])) {
        if (strlen($_GET["t"])>0) {
            if ($_GET["t"]=='createCDagent') {
                createCDagent('wangwu', '123qwe', '3', 'wangwu.duke.com', '王老五');
                createCDagent('zhangsan', '123qwe', '3', 'zhangsan.duke.com', '王老五');
                createCDagent('lisi', '123qwe', '3', 'lisi.duke.com', '王老五');
                createCDagent('zhaoliu', '123qwe', '3', 'zhaoliu.duke.com', '王老五');
                $_n = createCDagent('wangwu1', '123qwe', '4', 'wangwu1.duke.com', '王老五');
                $_m = createCDagent('wangwu2', '123qwe', '4', 'wangwu2.duke.com', '王老五');
                createCDagent('wangwu11', '123qwe', $_n, 'wangwu11.duke.com', '王老五');
                createCDagent('wangwu12', '123qwe', $_m, 'wangwu12.duke.com', '王老五');
            };
            if ($_GET["t"]=='getMySiteSetting') {
                $json_result=getMySiteSetting($_GET["id"]);
                echo json_encode($json_result);
            };
            if ($_GET["t"]=='getMyUsers') {
                $json_result=getMyUsers($_GET["id"], 'test', '');
                echo json_encode($json_result);
            };
            if ($_GET["t"]=='isAfromB') {
                require_once 'class.user.php';
                $user=new user();
                $json_result=$user->isAfromB('11', '4');
                echo json_encode($json_result);
            };
        }
    }
}

//代理账号及对应的代理链接是唯一的，其它设置选项在初始化时从直接上级代理获取
function createCDagent($userName, $psw, $creator, $siteLink='', $siteConfig='')
{
    //初始化次代权限，并继承总代对于网站的设置
    require_once 'class.user.php';
    $user=new user();
    if ($user->show(array("userName"=>$userName))!=false) {//用户存在
        echo 'user name ['.$userName.'] already exists';
        return false;
    }
    if ($user->show(array("id"=>$creator))==false) {//判断用户不存在
        echo 'creator ['.$creator.'] is not exists';
        return false;
    }
    $creatorInfo=$user->show(array("id"=>$creator));
    $creatorInfo=$creatorInfo[0];
    $adminID=$creatorInfo['agentAdmin'];
    $zdID=$creatorInfo['agentTop'];

    $cdInfo=array(
    "userName"=>$userName,
    "userPsw"=>$psw,
    "userLevel"=>"2",//次代
    "agentStatus"=>"1"//是代理
    );
    $cdID=$user->insert($cdInfo);
    if ($cdID!==false) {
        echo "cd['.$userName.'] insert successfully<br>";
    } else {
        echo "cd['.$userName.'] insert err<br>";
    }
    $cdInfo2=array(
    "id"=>$cdID,
    "agentAdmin"=>$adminID,
    "agentTop"=>$zdID,
    "agentDirect"=>$creator,
    "creater"=>$creator,
    "shareCode"=>$cdID,
    );
    $re=$user->update($cdInfo2);
    if ($re===true) {
        echo "cd['.$userName.'] update successfully<br>";
    } else {
        echo "cd['.$userName.'] update err<br>";
    }

    require_once 'class.adminLimit.php';
    $adminLimit=new adminLimit();
    $re=$adminLimit->copy('3', $cdID);
    if ($re===true) {
        echo "cd['.$userName.'] LimitInfo insert successfully<br>";
    } else {
        echo "cd['.$userName.'] LimitInfo insert err<br>";
    }

    require_once 'class.webSetting.php';
    $webSetting=new webSetting();
    $re=$webSetting->copy($creator, $cdID);
    if ($re===true) {
        echo "cd['.$userName.'] webSetting copy successfully<br>";
    } else {
        echo "cd['.$userName.'] webSetting copy err<br>";
    }

    $updateWebSeting=array();
    $updateWebSeting['userID']=$cdID;
    if ($siteLink!=='') {
        $updateWebSeting['siteLink']=$siteLink;
    }
    if ($siteConfig!=='') {
        $updateWebSeting['siteConfig']=$siteConfig;
    }
    $re=$webSetting->update($updateWebSeting);
    if ($re===true) {
        echo "cd['.$userName.'] webSetting update successfully<br>";
    } else {
        echo "cd['.$userName.'] webSetting update err<br>";
    }

    return $cdID;
}
function addLetter($userID, $token, $childID, $formKey, $formValue)
{
    require_once 'class.logLogin.php';
    $logLogin=new logLogin();
    $isLogin=$logLogin->checkToken($userID, $token);
    if ($isLogin!==true) {
        return array("code"=>"-9","msg"=>"登录超时<br>deleteMyLetters","data"=>$isLogin);
    }
    require_once 'class.user.php';
    $user=new user();
    $userType=$user->isAdmin(array("id"=>$userID));

    $isAgent=($userType===true||$userType==='1'||$userType==='2');
    $isAdmin=($userType===true);


    if ($isAgent!==true) {
        return array("code"=>"0","msg"=>"非管理员无法发送站内信息<br>addLetter","data"=>$isAgent);
    }

    //会员账号列表，检测是否存在，是否是其线下
    $childNameList=explode(",", $childID);
    if ($childID=="all") {
        $childNameList=$user->showUserListByAgentID(array('agentID'=>$userID));
        $childNameListLength=count($childNameList);
        if ($childNameListLength<=0) {
            return array("code"=>"0","msg"=>"未找到线下会员<br>addLetter","data"=>$childNameList);
        }
        $TEMP_RIGHT_ID=array();
        $TEMP_RIGHT_NAME=array();
        for ($x=0;$x<$childNameListLength;$x++) {
            $childOne = $childNameList[$x];
            array_push($TEMP_RIGHT_ID, $childOne["id"]);
            array_push($TEMP_RIGHT_NAME, $childOne["userName"]);
        }

    } else {
        $childNameListLength=count($childNameList);
        $TEMP_RIGHT_ID=array();
        $TEMP_RIGHT_NAME=array();
        for ($x=0;$x<$childNameListLength;$x++) {
            $childName = $childNameList[$x];
            $childInfos=$user->show(array("userName"=>$childName));
            if ($childNameList!=false) {
                if (count($childInfos)==1) {
                    $__childID__=$childInfos[0]['id'];
                    $isChild=$user->isAfromB($__childID__, $userID);
                    if ($isChild) {
                        array_push($TEMP_RIGHT_ID, $__childID__);
                        array_push($TEMP_RIGHT_NAME, $childName);
                    }
                }
            }
        }
        if (count($TEMP_RIGHT_ID)<=0) {
            return array("code"=>"0","msg"=>"您输入的账号不正确","data"=>$TEMP_RIGHT_ID);
        };
    }



    require_once 'class.letter.php';
    $myLetter=new letter();
    $letterConfig=array();
    $letterConfig['userIDList']=$TEMP_RIGHT_ID;
    $letterConfig['title']=$formKey;
    $letterConfig['content']=$formValue;
    $letterConfig['creater']=$userID;
    $myLetterDelete=$myLetter->insert($letterConfig);
 
    if ($myLetterDelete!=false) {
        return array("code"=>"1","msg"=>"站内信息发送成功","data"=>implode(",", $TEMP_RIGHT_NAME));
    } else {
        return array("code"=>"0","msg"=>"站内信息发送失败","data"=>$myLetterDelete);
    }
}
function deleteMyLetters($userID, $token, $childID)
{
    require_once 'class.logLogin.php';
    $logLogin=new logLogin();
    $isLogin=$logLogin->checkToken($userID, $token);
    if ($isLogin!==true) {
        return array("code"=>"-9","msg"=>"登录超时<br>deleteMyLetters","data"=>$isLogin);
    }
    require_once 'class.user.php';
    $user=new user();
    $userType=$user->isAdmin(array("id"=>$userID));

 
    $isAgent=($userType===true||$userType==='1'||$userType==='2');
    $isAdmin=($userType===true);

    require_once 'class.letter.php';
    $myLetter=new letter();
    //将 消息的ID 赋值给 letterID
    $letterID=$childID;
    $letterLists=$myLetter->show(array("id"=>$letterID));
    if ($letterLists==false) {
        return array("code"=>"0","msg"=>"您要删除的消息不存在<br>deleteMyLetters","data"=>$letterLists);
    }
    //将 消息的所属的会员 赋值给 childID
    $childID=$letterLists[0]['userID'];
    $isChild=$user->isAfromB($childID, $userID);

    if (!$isChild) {
        return array("code"=>"0","msg"=>$childID."->您要删除的消息不存在，owner err","data"=>$childID);
    }

    if ($isAgent!==true && $isSelf!==true) {
        return array("code"=>"0","msg"=>"非管理员或本人无法删除站内信息<br>deleteMyLetters","data"=>$isAgent."+".$isSelf);
    }


    $letterConfig=array();
    $letterConfig['id']=$letterID;
    $letterConfig['isDelete']='1';
    $myLetterDelete=$myLetter->update($letterConfig);

    if ($myLetterDelete!=false) {
        return array("code"=>"1","msg"=>"删除站内信息成功","data"=>$myLetterDelete);
    } else {
        return array("code"=>"0","msg"=>"删除站内信息失败","data"=>$myLetterDelete);
    }
}
function getMyLetters($userID, $token, $formKey, $formValue)
{
    require_once 'class.logLogin.php';
    $logLogin=new logLogin();
    $isLogin=$logLogin->checkToken($userID, $token);
    if ($isLogin!==true) {
        return array("code"=>"-9","msg"=>"登录超时<br>getMyLetters","data"=>$isLogin);
    }

    require_once 'class.user.php';
    $user=new user();

    //////// 检查输入的用户名  开始
    $userName=$formValue;
    $re_userName_is=$user->show(array("userName"=>$userName));
    if ($re_userName_is==false) { //不存在
        return array("code"=>"0","msg"=>"获取失败，账号不存在<br>getMyLetters","data"=>$re_userName_is);
    }
    $childID=$re_userName_is[0]['id'];
    //////// 检查输入的用户名  结束
    $userType=$user->isAdmin(array("id"=>$userID));
    $isSelf=($userID==$childID);
    $isChild=$user->isAfromB($childID, $userID);
    $isAgent=($userType===true||$userType==='1'||$userType==='2');
    $isAdmin=($userType===true);

    if ($formKey=="userName"&&!$isChild) {
        return array("code"=>"0","msg"=>$formValue."不是您的线下会员","data"=>$childID);
    }
    if ($formKey=="agentName" && !$isChild && !$isSelf) {
        return array("code"=>"0","msg"=>$formValue."不是您的线下代理","data"=>$childID);
    }
    if ($isAgent!==true && $isSelf!==true) {
        return array("code"=>"0","msg"=>"非管理员或本人无法操作<br>getMyLetters","data"=>$isAgent."+".$isSelf);
    }

    require_once 'class.letter.php';
    $letter=new letter();

    $letterConfig=array();

    $letterConfig[$formKey]=$userName;
    if ($isAdmin&&$isSelf) {
        $letterConfig=array();
    }


    if (isset($GLOBALS["page"])) {
        $letterConfig["page"]=$GLOBALS['page'];
    }
    if (isset($GLOBALS["n"])) {
        $letterConfig["n"]=$GLOBALS['n'];
    }
    if (isset($GLOBALS["sort"])) {
        $letterConfig["sort"]=$GLOBALS['sort'];
    }


    $letterLists=$letter->show($letterConfig);
    if ($letterLists!==false) {
        return array("code"=>"1","msg"=>"获取站内消息成功","data"=>$letterLists);
    } else {
        return array("code"=>"0","msg"=>"获取站内消息失败","data"=>$letterLists);
    }
}

function deleteMyLotteryApi($userID, $token, $childID)
{
    require_once 'class.logLogin.php';
    $logLogin=new logLogin();
    $isLogin=$logLogin->checkToken($userID, $token);
    if ($isLogin!==true) {
        return array("code"=>"-9","msg"=>"登录超时<br>deleteMyLotteryApi","data"=>$isLogin);
    }
    require_once 'class.user.php';
    $user=new user();
    $userType=$user->isAdmin(array("id"=>$userID));
    $isAdmin=($userType===true);
    if ($isAdmin!==true) {
        return array("code"=>"0","msg"=>"非管理员无法删除计划","data"=>$isAdmin);
    }
    require_once 'class.api.php';
    $DBapi=new api();
    $userInfo=array();
    $userInfo['lotteryID']=$childID;
    $Arr_DBapi=$DBapi->delete($userInfo);

    if ($Arr_DBapi!=false) {
        return array("code"=>"1","msg"=>"删除计划成功","data"=>$Arr_DBapi);
    } else {
        return array("code"=>"0","msg"=>"删除计划失败","data"=>$Arr_DBapi);
    }
}
function createMyLotteryApi($userID, $token, $childID)
{
    require_once 'class.logLogin.php';
    $logLogin=new logLogin();
    $isLogin=$logLogin->checkToken($userID, $token);
    if ($isLogin!==true) {
        return array("code"=>"-9","msg"=>"登录超时<br>createMyLotteryApi","data"=>$isLogin);
    }
    require_once 'class.user.php';
    $user=new user();
    $userType=$user->isAdmin(array("id"=>$userID));
    $isAdmin=($userType===true);
    if ($isAdmin!==true) {
        return array("code"=>"0","msg"=>"非管理员无法创建计划","data"=>$isAdmin);
    }
    require_once 'class.api.php';
    $DBapi=new api();
    $userInfo=array();
    $userInfo['lotteryID']=$childID;
    $Arr_DBapi=$DBapi->insert($userInfo);

    if ($Arr_DBapi!=false) {
        return array("code"=>"1","msg"=>"创建计划成功","data"=>$Arr_DBapi);
    } else {
        return array("code"=>"0","msg"=>"创建计划失败","data"=>$Arr_DBapi);
    }
}
function getMyLotteryApi($userID, $token, $childID)
{
    require_once 'class.logLogin.php';
    $logLogin=new logLogin();
    $isLogin=$logLogin->checkToken($userID, $token);
    if ($isLogin!==true) {
        return array("code"=>"-9","msg"=>"登录超时<br>getMyLotteryApi","data"=>$isLogin);
    }
    require_once 'class.user.php';
    $user=new user();
    $userType=$user->isAdmin(array("id"=>$userID));
    $isAdmin=($userType===true);
    if ($isAdmin!==true) {
        return array("code"=>"0","msg"=>"非管理员无法获取计划","data"=>$isAdmin);
    }
    require_once 'class.api.php';
    $DBapi=new api();
    $userInfo=array();

    if ($childID!="") {
        if (is_numeric($childID)) {
            $userInfo['id']=$childID;
        } else {
            $userInfo['lotteryID']=$childID;
        }
    }

    if (isset($GLOBALS["page"])) {
        $userInfo["page"]=$GLOBALS['page'];
    }
    if (isset($GLOBALS["n"])) {
        $userInfo["n"]=$GLOBALS['n'];
    }

    if (isset($GLOBALS["sort"])) {
        $userInfo["sort"]=$GLOBALS['sort'];
    }


    $Arr_DBapi=$DBapi->show($userInfo);

    if ($Arr_DBapi!=false) {
        return array("code"=>"1","msg"=>"获取计划成功","data"=>$Arr_DBapi);
    } else {
        return array("code"=>"0","msg"=>"获取计划失败","data"=>$Arr_DBapi);
    }
}
function updateLogSubmitList($userID, $token, $childID, $formValue)
{
    require_once 'class.logLogin.php';
    $logLogin=new logLogin();
    $isLogin=$logLogin->checkToken($userID, $token);
    if ($isLogin!==true) {
        return array("code"=>"-9","msg"=>"登录超时<br>LogSubmitList","data"=>$isLogin);
    }
    require_once 'class.user.php';
    $user=new user();
    $userType=$user->isAdmin(array("id"=>$userID));
    $isAdmin=($userType===true);
    if ($isAdmin!==true) {
        return array("code"=>"0","msg"=>"非管理员无法操作<br>updateLogSubmitList","data"=>$isAdmin);
    }

    require_once 'class.logSubmit.php';
    $DBlogSubmit=new logSubmit();
    $Arr_DBlogSubmit=$DBlogSubmit->update($childID, $formValue);

    if ($Arr_DBlogSubmit!=false) {
        return array("code"=>"1","msg"=>"修改成功<br>updateLogSubmitList","data"=>$Arr_DBlogSubmit);
    } else {
        return array("code"=>"0","msg"=>"修改失败<br>updateLogSubmitList","data"=>$Arr_DBlogSubmit);
    }
}
function getLogSubmitList($userID, $token)
{
    require_once 'class.logLogin.php';
    $logLogin=new logLogin();
    $isLogin=$logLogin->checkToken($userID, $token);
    if ($isLogin!==true) {
        return array("code"=>"-9","msg"=>"登录超时<br>getLogSubmitList","data"=>$isLogin);
    }

    require_once 'class.user.php';
    $user=new user();
    $userType=$user->isAdmin(array("id"=>$userID));
    $isAdmin=($userType===true);
    if ($isAdmin!==true) {
        return array("code"=>"0","msg"=>"非管理员无法操作<br>getLogSubmitList","data"=>$isAdmin);
    }

    require_once 'class.logSubmit.php';
    $DBlogSubmit=new logSubmit();
    $Arr_DBlogSubmit=$DBlogSubmit->show();


    if (gettype($Arr_DBlogSubmit)=="array") {
        if (count($Arr_DBlogSubmit)>0) {
            return array("code"=>"1","msg"=>"获取成功<br>getLogSubmitList","data"=>$Arr_DBlogSubmit);
        } else {
            return array("code"=>"1","msg"=>"暂无信息<br>getLogSubmitList","data"=>$Arr_DBlogSubmit);
        }
    } else {
        return array("code"=>"0","msg"=>"获取失败<br>getLogSubmitList","data"=>$Arr_DBlogSubmit);
    }
}
function getLimitsByID($userID, $token, $childID)
{
    require_once 'class.logLogin.php';
    $logLogin=new logLogin();
    $isLogin=$logLogin->checkToken($userID, $token);
    if ($isLogin!==true) {
        return array("code"=>"-9","msg"=>"登录超时<br>getLimitsByID","data"=>$isLogin);
    }

    require_once 'class.user.php';
    $user=new user();
    $userType=$user->isAdmin(array("id"=>$userID));//userLevel   总代1，次代2，会员3
    //////////////
    $isSelf=($userID==$childID);//自己

    $isChild=$user->isAfromB($childID, $userID);//下级

    $isAgent=($userType===true||$userType==='1'||$userType==='2');
    
    /////////////
    $isAdmin=($userType===true);

    if ($isAgent!==true && $isSelf!==true) {
        return array("code"=>"0","msg"=>"非管理员或本人无法操作<br>getAdminLimits","data"=>$isAgent."+".$isSelf);
    }

    require_once 'class.adminLimit.php';
    $DBadminLimit=new adminLimit();
    
    $userInfo=array();
    if ($childID!=='') {
        $userInfo['userID']=$childID;
    }
   

    $Arr_limit=$DBadminLimit->show($userInfo);

    if ($Arr_limit!=false) {
        return array("code"=>"1","msg"=>"获取成功<br>getAdminLimits","data"=>$Arr_limit);
    } else {
        return array("code"=>"0","msg"=>"获取失败<br>getAdminLimits","data"=>$Arr_limit);
    }
}
function getAdminLimits($userID, $token, $userName)
{
    require_once 'class.logLogin.php';
    $logLogin=new logLogin();
    $isLogin=$logLogin->checkToken($userID, $token);
    if ($isLogin!==true) {
        return array("code"=>"-9","msg"=>"登录超时<br>getAdminLimits","data"=>$isLogin);
    }

    require_once 'class.user.php';
    $user=new user();
    $userType=$user->isAdmin(array("id"=>$userID));
    $isAdmin=($userType===true);
    if ($isAdmin!==true) {
        return array("code"=>"0","msg"=>"非管理员无法操作<br>getAdminLimits","data"=>$isAdmin);
    }

    require_once 'class.adminLimit.php';
    $DBadminLimit=new adminLimit();
    
    $userInfo=array();
    if ($userName!="") {
        if (is_numeric($userName)) {
            $userInfo['userID']=$userName;
        } else {
            $userInfo['userName']=$userName;
        }
    }
    $Arr_limit=$DBadminLimit->show($userInfo);

    if ($Arr_limit!=false) {
        return array("code"=>"1","msg"=>"获取成功<br>getAdminLimits","data"=>$Arr_limit);
    } else {
        return array("code"=>"0","msg"=>"获取失败<br>getAdminLimits","data"=>$Arr_limit);
    }
}

    /**
     * 更改会员的代理归属
     * 将会员 从一个代理线下转移到另一个代理线下
     *
     * @param userID 操作人，检测其登录状态和操作权限（总代或管理员）
     * @param token  用于检测登录状态
     * @param childID 被转者，应该是userID的线下的一名会员
     * @param userName 接收者，应该是一个代理
     *
     * @return Boolean false 失败
     */
function changeAgent($userID, $token, $childID, $userName)
{
    $actorUserName=$childID;
    $acceptAgentName=$userName;


    require_once 'class.logLogin.php';
    $logLogin=new logLogin();
    $isLogin=$logLogin->checkToken($userID, $token);
    if ($isLogin!==true) {
        return array("code"=>"-9","msg"=>"登录超时<br>changeAgent","data"=>$isLogin);
    }

    require_once 'class.user.php';
    $user=new user();
    //////// 检查输入的 userID  开始
    $re_myName=$user->show(array("id"=>$userID));
    if ($re_myName==false) { //不存在
        return array("code"=>"0","msg"=>"内部错误，请重新登录","data"=>$re_actorre_myNameUserName);
    } else {
        $myInfo=$re_myName[0];
   
        if ($myInfo['userLevel'] !=='1') {
            return array("code"=>"0","msg"=>"非站长无权操作","data"=>$myInfo['userLevel']);
        }
    }
    //////// 检查输入的 userID  结束


    //////// 检查输入的 childID  开始
    $re_actorUserName=$user->show(array("userName"=>$actorUserName));
    if ($re_actorUserName==false) { //不存在
        return array("code"=>"0","msg"=>"想要转移的账号不存在","data"=>$re_actorUserName);
    } else {
        $actorUserID=$re_actorUserName[0]['id'];
        if ($re_actorUserName[0]['userLevel']!=='3') {
            return array("code"=>"0","msg"=>"只能转移角色为 会员 的账号","data"=>$re_actorUserName);
        }
    }
    //////// 检查输入的 childID  结束

    $isChild=$user->isAfromB($actorUserID, $userID);
    if (!$isChild) {
        return array("code"=>"0","msg"=>$childID."不是您的线下会员","data"=>$isChild);
    }

    //////// 检查输入的 userName  开始
    $re_acceptAgentName=$user->show(array("userName"=>$acceptAgentName));
    if ($re_acceptAgentName==false) { //不存在
        return array("code"=>"0","msg"=>"接收的代理账号不存在","data"=>$re_acceptAgentName);
    } else {
        $acceptAgentInfo=$re_acceptAgentName[0];
        if ($acceptAgentInfo['agentStatus']!=='1') {
            return array("code"=>"0","msg"=>"接收的账号角色必须是 代理","data"=>$re_acceptAgentName);
        }
    }
    //////// 检查输入的 userName  结束

    $doInfo=array(
        "id"=>$actorUserID,
        "agentAdmin"=> $acceptAgentInfo['agentAdmin'],
        "agentTop"=> $acceptAgentInfo['agentTop'],
        "agentDirect"=> $acceptAgentInfo['id']
    );

    $re_update=$user->update($doInfo);

    if ($re_update!==true) {
        return array("code"=>"0","msg"=>"转移失败，请联系站长","data"=>$re_update);
    } else {
        return array("code"=>"1","msg"=>"转移成功","data"=>$re_update);
    }
}
    /**
     * 生成一位会员
     * 将会员 晋升为 代理
     * 将会员 晋升为 总代
     * 将代理 晋升为 总代
     *
     * @param userID 操作人，检测其登录状态和操作权限
     * @param token  用于检测登录状态
     * @param userName 想要生成的会员名称（或要晋升的会员名称）
     * @param userLevel 生成/晋升为哪一层会员  1 总代  2 代理  3会员
     * @param fromUserID 此操作是来自某人的申请，会员将归来他的线下
     * @return Boolean false 失败
     */
function createOneUser($userID, $token, $userName, $userLevel, $fromUserID='')
{
    require_once 'class.logLogin.php';
    $logLogin=new logLogin();
    $isLogin=$logLogin->checkToken($userID, $token);
    if ($isLogin!==true) {
        return array("code"=>"-9","msg"=>"登录超时<br>createOneUser","data"=>$isLogin);
    }

    require_once 'class.user.php';
    $user=new user();

    //////// 检查输入的用户名  开始
    $re_list=$user->show(array("userName"=>$userName));
    if ($re_list==false) { //不存在
        $actorNameLevel='0';
    } else {
        $actorNameLevel=$re_list[0]['userLevel'];
    }
    //////// 检查输入的用户名  结束

    require_once 'class.adminLimit.php';
    $DBadminLimit=new adminLimit();
    $userInfo=array("userID"=>$userID);
    $Arr_limit=$DBadminLimit->show($userInfo);
    $json_limit= $Arr_limit[0];
    $canCreateUser1=($json_limit['create_user_1']==='1');
    $canCreateUser2=($json_limit['create_user_2']==='1');
    $canCreateUser3=($json_limit['create_user_3']==='1');

    //获取[申请人]的信息，以便 复制 其代理从属
    if ($fromUserID==='') {
        $creatorID=$userID;
    } else {
        if (is_numeric($fromUserID)) {
            $creatorID=$fromUserID;
        } else {
            $fromUserID_ar=$user->show(array("userName"=>$fromUserID));
            if ($fromUserID_ar==false) { //不存在
                return array("code"=>"0","msg"=>"想要归属的账号不存在","data"=>$fromUserID_ar);
            } else {
                $creatorID=$fromUserID_ar[0]['id'];
            }
        }
    }
    $creatorInfo=$user->show(array("id"=>$creatorID));
    $creatorInfo=$creatorInfo[0];
    $creatorAgentAdmin=$creatorInfo['agentAdmin']==="0"?$creatorID:$creatorInfo['agentAdmin'];
    $creatorAgentTop=$creatorInfo['agentTop']==="0"?$creatorID:$creatorInfo['agentTop'];

    //1、会员不存在
    if ($actorNameLevel==="0") {
        if ($userLevel==="3") {
            if (!$canCreateUser3) {
                return array("code"=>"0","msg"=>"您暂时不能创建会员","data"=>array());
            }
            //在此创建一位普通会员

            if (!isMatch($userName)) {
                return array("code"=>"-1","msg"=>"账号为6-15位英文字母、数字或下划线","data"=>array());
            }

            $__Info=array(
                "userName"=>$userName,
                "agentAdmin"=>$creatorAgentAdmin,
                "agentTop"=>$creatorAgentTop,
                "agentDirect"=>$creatorID,
                "creater"=>$creatorID,
                "fromLink"=>'直接创建'
                );
            $__ID=$user->insert($__Info);
            if ($__ID===false) {
                return array("code"=>"0","msg"=>"创建会员失败","data"=>$__ID);
            }
            $__updateShareCode=$user->update(array("shareCode"=>$__ID));
            if ($__updateShareCode!==true) {
                return array("code"=>"1","msg"=>"创建会员成功(初始密码：123456)，但是更新分享码失败","data"=>$__updateShareCode);
            } else {
                return array("code"=>"1","msg"=>"创建会员成功(初始密码：123456)","data"=>$__ID);
            }
        } else {
            return array("code"=>"0","msg"=>"账号不存在，无法操作<br>createOneUser [0-1/2]","data"=>array());
        }
    }
    $childID=$re_list[0]['id'];
    $isSelf=($userID==$childID);
    $userType=$user->isAdmin(array("id"=>$userID));
    $isChild=$user->isAfromB($childID, $userID);
    $isDirectChild=($re_list[0]['agentDirect']===$userID);
    $isAgent=($userType===true||$userType==='1'||$userType==='2');
    $isAdmin=($userType===true);
    $canShowAll=($json_limit['show_all_user']==='1');//开启循环查询
    ////////// 检查权限 开始
    $cando=true;
    $mark='cando=';
    if (!$isAdmin) {//不是管理员
        $mark.=" 不是管理员,";
        if ($isChild) {
            if ($isDirectChild) {
                $cando=true;
            } else {
                $mark.=" 不是您的直接下线,";
                if ($canShowAll) {
                    $cando=true;
                } else {
                    $cando=false;
                    $mark.=" 未开启深度查询,";
                }
            }
        } elseif ($isSelf) {
            $cando=true;
        } else {
            $cando=false;
            $mark.=" no 不是您的下线,";
        }
    } else {
        $cando=true;
    }
    if ($cando===false) {
        return array("code"=>"-2","msg"=>"操作失败<br>createOneUser [1/2-] false:账号正确 and ".$mark,"data"=>array());
    }

    //2、总代
    if ($actorNameLevel==="1") {
        return array("code"=>"0","msg"=>"已经是总代了<br>createOneUser [1-]","data"=>array());
    }
    //3、代理
    if ($actorNameLevel==="2") {
        if ($userLevel==="1") {
            if (!$canCreateUser1) {
                return array("code"=>"0","msg"=>"操作失败，无权晋升<br>createOneUser [2-1]","data"=>array());
            }
            //在此将代理 晋升为 总代
            $__Info=array(
                "id"=>$childID,
                "userLevel"=>$userLevel,
                "agentTop"=>$childID,
                "agentDirect"=>$creatorAgentAdmin
                );
            $__updateInfo=$user->update($__Info);
            if ($__updateInfo!==true) {
                return array("code"=>"0","msg"=>"操作失败，晋升出错<br>createOneUser [2-1]","data"=>$__updateInfo);
            }

            $__changeAgentTop=$user->changeAgentTop($childID);
            if ($__changeAgentTop!==true) {
                return array("code"=>"0","msg"=>"晋升成功，但下级更正总代失败<br>createOneUser [2-1]","data"=>$__updateInfo);
            }
    

            $__copyAdminLimit=$DBadminLimit->copy('2', $childID);
            if ($__copyAdminLimit!==true) {
                return array("code"=>"1","msg"=>"晋升成功，但权限升级失败<br>createOneUser [2-1]","data"=>$__copyAdminLimit);
            }

            return array("code"=>"1","msg"=>"晋升成功<br>createOneUser [2-1] success:all","data"=>array());
        } else {
            return array("code"=>"0","msg"=>"操作失败，已经是代理了<br>createOneUser [2-2/3]","data"=>array());
        }
    }
    //3、普通会员
    if ($actorNameLevel==="3") {
        if ($userLevel==="1") {//不能 将会员 直接 晋升为 总代
            return array("code"=>"0","msg"=>"无法将会员直接晋升为总代<br>createOneUser [3-1]","data"=>array());
        } elseif ($userLevel==="2") {
            if (!$canCreateUser2) {
                return array("code"=>"0","msg"=>"无权晋升代理<br>createOneUser [3-2]","data"=>array());
            }
            //在此将会员 晋升为 代理
            
            $__Info=array(
                "id"=>$childID,
                "userLevel"=>$userLevel,
                "agentStatus"=>"1"
                );
            $__updateInfo=$user->update($__Info);
            if ($__updateInfo!==true) {
                return array("code"=>"0","msg"=>"晋升代理失败<br>createOneUser [3-2]","data"=>$__updateInfo);
            }
            

            $__copyAdminLimit=$DBadminLimit->copy('3', $childID);
            if ($__copyAdminLimit!==true) {
                return array("code"=>"1","msg"=>"晋升代理成功，但权限升级失败<br>createOneUser [3-2]","data"=>$__copyAdminLimit);
            }
            
            require_once 'class.webSetting.php';
            $webSetting=new webSetting();
            $__copyWebSetting=$webSetting->copy($creatorID, $childID);
            if ($__copyWebSetting!==true) {
                return array("code"=>"1","msg"=>"晋升代理成功，但生成代理网站失败<br>createOneUser [3-2]","data"=>array("__copyWebSetting"=>$__copyWebSetting,"creatorID"=>$creatorID,"childID"=>$childID));
            }

            return array("code"=>"1","msg"=>"晋升代理成功！<br>createOneUser [3-2] success:all","data"=>array("__copyWebSetting"=>$__copyWebSetting,"creatorID"=>$creatorID,"childID"=>$childID));
        } else {
            return array("code"=>"0","msg"=>"账号已存在<br>createOneUser [3-3]","data"=>array());
        }
    }
};

function getMyLimit($userID, $token)
{
    require_once 'class.logLogin.php';
    $logLogin=new logLogin();
    $isLogin=$logLogin->checkToken($userID, $token);
    if ($isLogin!==true) {
        return array("code"=>"-9","msg"=>"登录超时<br>getMyLimit","data"=>$isLogin);
    }

    $userInfo=array("userID"=>$userID);

    require_once 'class.adminLimit.php';
    $DBadminLimit=new adminLimit();
    $Arr_limit=$DBadminLimit->show($userInfo);
    if (count($Arr_limit)>0) {
        $json_limit= $Arr_limit[0];

        return array("code"=>"1","msg"=>"获取成功<br>getMyLimit","data"=>$json_limit);
    } else {
        return array("code"=>"0","msg"=>"获取失败<br>getMyLimit Arr_limit count: false","data"=>$Arr_limit);
    }
}
                                         //'user', 'agentStatus', '1'
function submitToUpdate($creater, $token, $actor, $actorName, $form, $formKey, $formValue)
{
    $userID=$creater;
    $childID=$actor;

    require_once 'class.logLogin.php';
    $logLogin=new logLogin();
    require_once 'class.user.php';
    $user=new user();
    require_once 'class.adminLimit.php';
    $DBadminLimit=new adminLimit();
    $userType=$user->isAdmin(array("id"=>$userID));
    $isLogin=$logLogin->checkToken($userID, $token);
    //////// 检查输入的用户名  开始
    if ($childID==='') {
        $re_list=$user->show(array("userName"=>$actorName));
        if ($re_list==false) {
            return array("code"=>"0","msg"=>"提交失败，账号不存在<br>submitToUpdate: actorName is not exist","data"=>$re_list);
        }
        $childID=$re_list[0]['id'];
    } else {
        $re_list=$user->show(array("id"=>$childID));
        if ($re_list==false) {
            return array("code"=>"0","msg"=>"提交失败，账号编码错误<br>submitToUpdate: actor is not exist","data"=>$re_list);
        }
    }
    //re_list 是 child / actor 的会员信息
    $child_is_agent=($re_list[0]['agentStatus']==="1");
    //代理想申请成为次级代理
    if ($child_is_agent && $form=="user" && $formKey=="agentStatus" && $formValue == "1") {
        return array("code"=>"0","msg"=>"提交失败，已经是代理了<br>submitToUpdate: actor is an agent","data"=>$re_list);
    }
    //////// 检查输入的用户名  结束
    $isSelf=($userID==$childID);
    $isChild=$user->isAfromB($childID, $userID);
    $isDirectChild=($re_list[0]['agentDirect']===$userID);
    $isAgent=($userType===true||$userType==='1'||$userType==='2');
    $isAdmin=($userType===true);

    $userInfo=array("userID"=>$userID);
    $Arr_limit=$DBadminLimit->show($userInfo);
    $json_limit= $Arr_limit[0];

    $canShowAll=($json_limit['show_all_user']==='1');//开启循环查询

    //会员想申请成为次级代理
    if ($re_list[0]['userLevel']==="3"&& $form=="user" && $formKey=="agentStatus" && $formValue == "1") {
        require_once 'class.common.php';
        $__common=new commonFun();
        $__temp =$__common->decrypt($token);
        $__tempAr=explode("|", $__temp);
        $webID=$__tempAr[2];//登录的网站id

        require_once 'class.websetting.php';
        $DBwebsetting=new websetting();
        $webSetting__=$DBwebsetting->show(array('id'=>$webID));
        if ($webSetting__[0]['submitUpdateUserLevel']!=='1') {
            return array("code"=>"0","msg"=>"提交失败，暂无权限<br>submitToUpdate: webSetting_submitUpdateUserLevel limit->","data"=>$webSetting__[0]['submitUpdateUserLevel']);
        }
    }
    ////////// 检查权限 开始
    $cando=true;
    $mark='cando=';
    if ($isLogin===true) {
        if (!$isAdmin) {//不是管理员
            $mark.=" 不是管理员,";
            if ($isChild) {
                if ($isDirectChild) {
                    $cando=true;
                } else {
                    $mark.=" 不是您的直接下线,";
                    if ($canShowAll) {
                        $cando=true;
                    } else {
                        $cando=false;
                        $mark.=" 未开启深度查询,";
                    }
                }
            } elseif ($isSelf) {
                $cando=true;
            } else {
                $cando=false;
                $mark.=" 不是您的下线,";
            }
        } else {
            $cando=true;
        }
    } else {
        $cando=false;
        return array("code"=>"-9","msg"=>"登录超时<br>submitToUpdate","data"=>$isLogin);
    }
    if ($cando===false) {
        return array("code"=>"-2","msg"=>"提交失败<br>submitToUpdate false:".$mark,"data"=>array());
    }


    require_once 'class.logSubmit.php';
    $DBlogSubmit=new logSubmit();
    $re_logSubmit=$DBlogSubmit->insert($userID, $childID, $form, $formKey, $formValue);
    
    if ($re_logSubmit!==false) {
        $json_result=array("code"=>"1","msg"=>"提交成功","data"=>$re_logSubmit);
    
        //想申请成功次级代理，则将会员信息中，代理状态修改为 待审核
        if ($form=="user" && $formKey=="agentStatus" && $formValue == "1") {
            require_once 'class.user.php';
            $DBuser=new user();
            $userInfo=$DBuser->update(array("id"=>$childID,"agentStatus"=>'2'));
        }
    } else {
        $json_result=array("code"=>"0","msg"=>"提交出错<br>submitToUpdate err","data"=>$re_logSubmit);
    }
    return $json_result;
}
function getUserByName($userID, $token, $userName)
{
    require_once 'class.logLogin.php';
    $logLogin=new logLogin();
    require_once 'class.user.php';
    $user=new user();
    require_once 'class.adminLimit.php';
    $DBadminLimit=new adminLimit();

    $userType=$user->isAdmin(array("id"=>$userID));

    $isLogin=$logLogin->checkToken($userID, $token);

    //////// 检查输入的用户名  开始
    $re_list=$user->show(array("userName"=>$userName));
    if ($re_list==false) {
        return array("code"=>"0","msg"=>"账号不存在<br>getUserByName: userName is not exist","data"=>$re_list);
    }
    //////// 检查输入的用户名  结束

    $childID=$re_list[0]['id'];

    $isSelf=($userID==$childID);
    $isChild=$user->isAfromB($childID, $userID);
    $isDirectChild=($re_list[0]['agentDirect']===$userID);
    $isAgent=($userType===true||$userType==='1'||$userType==='2');
    $isAdmin=($userType===true);

    $userInfo=array("userID"=>$userID);
    $Arr_limit=$DBadminLimit->show($userInfo);
    $json_limit= $Arr_limit[0];

    $canShowAll=($json_limit['show_all_user']==='1');//开启循环查询
    ////////// 检查权限 开始
    $cando=true;
    $mark='cando=';
    if ($isLogin===true) {
        if (!$isAdmin) {//不是管理员
            $mark.=" 不是管理员,";
            if ($isChild) {
                if ($isDirectChild) {
                    $cando=true;
                } else {
                    $mark.=" 不是直接下线,";
                    if ($canShowAll) {
                        $cando=true;
                    } else {
                        $cando=false;
                        $mark.=" 未开启深度查询,";
                    }
                }
            } elseif ($isSelf) {
                $cando=true;
            } else {
                $cando=false;
                $mark.=" 不是下线,";
            }
        } else {
            $cando=true;
        }
    } else {
        $cando=false;
        return array("code"=>"-9","msg"=>"登录超时<br>getUserByName token false","data"=>$isLogin);
    }
    if ($cando===false) {
        return array("code"=>"-2","msg"=>"获取出错<br>getUserByName false:".$mark,"data"=>array());
    }
    ////////// 检查权限 结束
    $userList=$re_list;
    ///////过滤过滤过滤过滤过滤过滤过滤过滤过滤过滤过滤
    $re_userList=array();
    $re_limit=array();

    $userListOne = $userList[0];

    $re_userListOne=array();
    foreach ($userListOne as $key=>$value) {
        $adminLimitKey="user_". $key;

        //默认过滤
        if ($key=='userPsw') {
            $value="***";
        }

        $filterKey = array("id", "userName", "registerTime", "registerIP", "shareCode", "authorizationStatus", "agentStatus", "agentName", "userLevel", "userActive", "userTitle", "fromLink");
        if (in_array($key, $filterKey)) {
            $re_userListOne[$key]=$value;
        }
        
        //权限过滤
        if (array_key_exists($adminLimitKey, $json_limit)) {
            if ($json_limit[$adminLimitKey]!=0) {
                $re_userListOne[$key]=$value;

                $filterKey__2 = array("authorizationStatus", "agentStatus", "userLevel");
                if (!in_array($key, $filterKey__2)) {
                    $re_limit[$key]=$json_limit[$adminLimitKey];
                }
            }
        } else {
            //echo "键不存在！";
        }
    }
    $re_userListOne['nextCount']=-1;
    if ($userListOne['agentStatus']=='2') {
        $re_userListOne['nextCount']=-2;
    }
    //会员是代理
    if ($userListOne['agentStatus']=='1') {
        //此会员（下一级代理）的下级会员情况
        $re_userList_2=$user->showUserListByAgentID(array('agentID'=>$userListOne['id']));
        $re_userList_2_length=$re_userList_2?count($re_userList_2):0;

        $re_userListOne['nextCount']=$re_userList_2_length;
        $re_userListOne['nextCanShow']=$json_limit['show_all_user'];
    }
    array_push($re_userList, $re_userListOne);

    $json_result=array("code"=>"1","msg"=>"获取成功<br>getUserByName success","data"=>array('userList'=>$re_userList,'userLimit'=>$re_limit));

    return $json_result;
}
function getMyShareIPList($userID, $token, $shareCode)
{
    // if($userID!=='1'){
    //     return array("code"=>"0","msg"=>"非管理员无法操作<br>getMyShareIPList","data"=>$isLogin);
    // }

    require_once 'class.logLogin.php';
    $logLogin=new logLogin();
    $isLogin=$logLogin->checkToken($userID, $token);
    if ($isLogin!==true) {
        return array("code"=>"-9","msg"=>"登录超时<br>getMyShareIPList","data"=>$isLogin);
    }

    require_once 'class.shareIP.php';
    $shareIP=new shareIP();
    $re_list=$shareIP->show($shareCode);
  
    if ($re_list!==false) {
        return array("code"=>"1","msg"=>"获取成功<br>getMyShareIPList","data"=>$re_list);
    } else {
        return array("code"=>"0","msg"=>"获取失败<br>getMyShareIPList","data"=>$re_list);
    }
}
function deleteMyAuthorizeList($userID, $token, $authorizeID)
{
    if ($userID!=='1') {
        return array("code"=>"0","msg"=>"非管理员无法操作<br>deleteMyAuthorizeList","data"=>$isLogin);
    }

    require_once 'class.logLogin.php';
    $logLogin=new logLogin();
    $isLogin=$logLogin->checkToken($userID, $token);
    if ($isLogin!==true) {
        return array("code"=>"-9","msg"=>"登录超时<br>deleteMyAuthorizeList","data"=>$isLogin);
    }

    $info=array(
        "id"=>$authorizeID
        );

    require_once 'class.authorizationWBStatus.php';
    $authorizationWBStatus=new authorizationWBStatus();
    $re_insert=$authorizationWBStatus->delete($info);

    if ($re_insert) {
        return array("code"=>"1","msg"=>"删除成功<br>deleteMyAuthorizeList","data"=>$re_insert);
    } else {
        return array("code"=>"0","msg"=>"删除失败<br>deleteMyAuthorizeList","data"=>$re_insert);
    }
}
function updateMyAuthorizeList($userID, $token, $authorizeID, $wbStatus)
{
    if ($userID!=='1') {
        return array("code"=>"0","msg"=>"非管理员无法操作<br>updateMyAuthorizeList","data"=>$isLogin);
    }

    require_once 'class.logLogin.php';
    $logLogin=new logLogin();
    $isLogin=$logLogin->checkToken($userID, $token);
    if ($isLogin!==true) {
        return array("code"=>"-9","msg"=>"登录超时<br>updateMyAuthorizeList","data"=>$isLogin);
    }

    $info=array(
        "id"=>$authorizeID,
        "wbStatus"=>$wbStatus,
        "updater"=>$userID
        );

    require_once 'class.authorizationWBStatus.php';
    $authorizationWBStatus=new authorizationWBStatus();
    $re_insert=$authorizationWBStatus->update($info);

    if ($re_insert) {
        return array("code"=>"1","msg"=>"修改成功<br>updateMyAuthorizeList","data"=>$re_insert);
    } else {
        return array("code"=>"0","msg"=>"修改失败<br>updateMyAuthorizeList","data"=>$re_insert);
    }
}

function getMyAuthorizeList($userID, $token, $childID="")
{
    if ($childID==="") {
        $childID=$userID;
    }

    require_once 'class.logLogin.php';
    $logLogin=new logLogin();
    $isLogin=$logLogin->checkToken($userID, $token);
    if ($isLogin!==true) {
        return array("code"=>"-9","msg"=>"登录超时<br>getMyAuthorizeList","data"=>$isLogin);
    }


    require_once 'class.user.php';
    $re_user=new user();
    //////////////
    if (!is_numeric($childID)) {
        $num_childID=$re_user->show(array("userName"=>$childID));
        if ($num_childID==false) { //不存在
            return array("code"=>"0","msg"=>"查找的账号不存在","data"=>$num_childID);
        } else {
            $childID=$num_childID[0]['id'];
        }
    }
    $userType=$re_user->isAdmin(array("id"=>$userID));//userLevel   总代1，次代2，会员3
    $isSelf=($userID==$childID);//自己
    $isChild=$re_user->isAfromB($childID, $userID);//下级
    $isAgent=($userType===true||$userType==='1'||$userType==='2');
    $isAdmin=($userType===true);
    if ($isAgent!==true) {
        return array("code"=>"0","msg"=>"非管理员无法操作<br>getMyAuthorizeList","data"=>$isAgent);
    }
    if ($isSelf!==true && $isChild!==true) {
        return array("code"=>"0","msg"=>"非线下或本人无法操作<br>getMyAuthorizeList","data"=>$isChild);
    }
    /////////////


    $my_list=$re_user->show(array("id"=>$childID))[0];

    $info=array("agentDirect"=>$childID);
    $__info=array("agentDirect"=>$childID,"authorizationStatus"=>'1');

    if ($my_list['agentAdmin']==0) {
        $info=array("agentAdmin"=>$childID);
        $__info=array("agentAdmin"=>$childID,"authorizationStatus"=>'1');
    }
    if ($my_list['agentTop']==$childID) {
        $info=array("agentTop"=>$childID);
        $__info=array("agentTop"=>$childID,"authorizationStatus"=>'1');
    }
    if ($my_list["userLevel"]=="3") {
        $info=array("userID"=>$childID);
        $__info=array("id"=>$childID,"authorizationStatus"=>'1');
    }


  

    if (isset($GLOBALS["page"])) {
        $info["page"]=$GLOBALS['page'];
        $__info["page"]=$GLOBALS['page'];
    }
    if (isset($GLOBALS["n"])) {
        $info["n"]=$GLOBALS['n'];
        $__info["n"]=$GLOBALS['n'];
    }

    if (isset($GLOBALS["sort"])) {
        $info["sort"]=$GLOBALS['sort'];
        $__info["sort"]=$GLOBALS['sort'];
    }

    require_once 'class.authorizationWBStatus.php';
    $authorizationWBStatus=new authorizationWBStatus();
    $re_insert=$authorizationWBStatus->show($info);//特别授权表中的数据

  
    if ($re_insert!==false) {
        $___my_list=$re_user->show($__info);//分享授权来的


        
        $___my_list_result=array();
        
        $___my_list_count=count($___my_list);
        for ($x=0;$x<$___my_list_count;$x++) {
            $___my_list_One = $___my_list[$x];

            $___my_list_temp=array();
            $___my_list_temp['id']=$___my_list_One['shareCode'];
            $___my_list_temp['userID']=$___my_list_One['id'];
            $___my_list_temp['userName']=$___my_list_One['userName'];
            $___my_list_temp['wbStatus']='3';
            $___my_list_temp['loginTime']=$___my_list_One['loginTime'];
            $___my_list_temp['updateIP']=$___my_list_One['registerIP'];
            $___my_list_temp['updateTime']=$___my_list_One['authorizationTime'];
            $___my_list_temp['updater']=$___my_list_One['id'];
            $___my_list_temp['mark1']=$___my_list_One['mark1'];
            $___my_list_temp['mark2']=$___my_list_One['mark2'];
            $___my_list_temp['mark3']=$___my_list_One['mark3'];
            $___my_list_temp['mark4']=$___my_list_One['mark4'];
            $___my_list_temp['mark5']=$___my_list_One['mark5'];
          

            array_push($___my_list_result, $___my_list_temp);
        }

        $re_insert=array_merge($___my_list_result, $re_insert);


        if (isset($GLOBALS["sort"])) {
            $sort=$GLOBALS['sort'];
            if ($sort=="1") {
                array_multisort(array_column($re_insert, 'loginTime'), SORT_DESC, $re_insert);
            }
            if ($sort=="2") {
                array_multisort(array_column($re_insert, 'loginTime'), SORT_ASC, $re_insert);
            }
            if ($sort=="3") {
                array_multisort(array_column($re_insert, 'userID'), SORT_DESC, SORT_NUMERIC, $re_insert);
            }
            if ($sort=="4") {
                array_multisort(array_column($re_insert, 'userID'), SORT_ASC, SORT_NUMERIC, $re_insert);
            }
            if ($sort=="5") {
                array_multisort(array_column($re_insert, 'updateTime'), SORT_DESC, $re_insert);
            }
            if ($sort=="6") {
                array_multisort(array_column($re_insert, 'updateTime'), SORT_ASC, $re_insert);
            }
        }




        return array("code"=>"1","msg"=>"获取成功<br>getMyAuthorizeList","data"=>$re_insert);
    } else {
        return array("code"=>"0","msg"=>"获取失败<br>getMyAuthorizeList","data"=>$re_insert);
    }
}
function insertAuthorization($userID, $token, $userName, $wbStatus)
{
    require_once 'class.logLogin.php';
    $logLogin=new logLogin();
    require_once 'class.user.php';
    $user=new user();
    require_once 'class.adminLimit.php';
    $DBadminLimit=new adminLimit();

    $userType=$user->isAdmin(array("id"=>$userID));

    $isLogin=$logLogin->checkToken($userID, $token);

    //////// 检查输入的用户名  开始
    if (!is_numeric($userName)) {
        $re_list=$user->show(array("userName"=>$userName));
        if ($re_list==false) {
            return array("code"=>"0","msg"=>"账号不存在<br>insertAuthorization: userName is not exist","data"=>$re_list);
        } else {
            $childID=$re_list[0]['id'];
        }
    } else {
        $re_list=$user->show(array("id"=>$userName));
        $childID=$userName;
    }
    //////// 检查输入的用户名  结束

    $isSelf=($userID==$childID);
    $isChild=$user->isAfromB($childID, $userID);
    $isDirectChild=($re_list[0]['agentDirect']===$userID);
    $isAgent=($userType===true||$userType==='1'||$userType==='2');
    $isAdmin=($userType===true);

    $userInfo=array("userID"=>$userID);
    $Arr_limit=$DBadminLimit->show($userInfo);
    $json_limit= $Arr_limit[0];

    $canShowAll=($json_limit['show_all_user']==='1');//开启循环查询
    ////////// 检查权限 开始
    $cando=true;
    $mark='cando=';
    if ($isLogin===true) {
        if (!$isAdmin) {//不是管理员
            $mark.=" 不是管理员,";
            if ($isChild) {
                if ($isDirectChild) {
                    $cando=true;
                } else {
                    $mark.=" 不是直接下线,";
                    if ($canShowAll) {
                        $cando=true;
                    } else {
                        $cando=false;
                        $mark.=" 未开启深度查询,";
                    }
                }
            } elseif ($isSelf) {
                $cando=true;
            } else {
                $cando=false;
                $mark.=" 不是下线,";
            }
        } else {
            $cando=true;
        }
    } else {
        $cando=false;
        return array("code"=>"-9","msg"=>"登录超时<br>insertAuthorization token false","data"=>$isLogin);
    }
    if ($cando===false) {
        return array("code"=>"-2","msg"=>"操作出错<br>insertAuthorization false:".$mark,"data"=>array());
    }
    ////////////////////////////////////////////
    
    $info=array(
        "userID"=>$childID,
        "wbStatus"=>$wbStatus,
        "updater"=>$userID
        );

    require_once 'class.authorizationWBStatus.php';
    $authorizationWBStatus=new authorizationWBStatus();
    $re_insert=$authorizationWBStatus->insert($info);

    if ($re_insert) {
        return array("code"=>"1","msg"=>"添加成功<br>insertAuthorization","data"=>$re_insert);
    } else {
        return array("code"=>"0","msg"=>"添加失败<br>insertAuthorization","data"=>$re_insert);
    }
}
function loopChange($id, $formKey, $formValue)
{
    require_once 'class.user.php';
    $user=new user();
    $userList=$user->showAgentListByAgentID($id);


    if ($userList==false) {
        return;
    }
    $userListlength=count($userList);
    for ($x=0;$x<$userListlength;$x++) {
        $userListOne = $userList[$x];
        $userListOneID=$userListOne['id'];


      

        //查询权限
        require_once 'class.adminLimit.php';
        $DBadminLimit=new adminLimit();
        $userInfo=array("userID"=>$userListOneID);
        $Arr_limit=$DBadminLimit->show($userInfo);
        $json_limit= $Arr_limit[0];
        //无修改权限
        if ($json_limit['webSetting_'.$formKey]==='0') {
            require_once 'class.websetting.php';
            $DBwebsetting=new websetting();
   
            $re_update=$DBwebsetting->update(array("userID"=>$userListOneID,$formKey=>$formValue));
            loopChange($userListOneID, $formKey, $formValue);
        }
    }
}
// ----------------------代理A 发展了 代理B ，B 发展了代理C
// 1、代理账号及对应的代理链接是唯一的，其它设置选项在初始化时从直接上级代理获取
// 2、当代理试图修改某一设置时，需要先查询权限表是否处于可更改状态
// 3、当代理A修改了某一项设置，并且他的直接代理下线B无权限修改此设置时，代理B及其所有下线（递归）的设置会随之改变
function doChange($userID, $token, $childID, $form, $formKey, $formValue)
{
    require_once 'class.logLogin.php';
    $logLogin=new logLogin();
    require_once 'class.user.php';
    $user=new user();
    $userType=$user->isAdmin(array("id"=>$userID));

    $isLogin=$logLogin->checkToken($userID, $token);
    $isSelf=($userID==$childID);
    $isChild=$user->isAfromB($childID, $userID);
    $isAgent=($userType===true||$userType==='1'||$userType==='2');
    $isAdmin=($userType===true);

    if ($isLogin!==true) {
        return array("code"=>"-9","msg"=>"登录超时<br>submitChangee","data"=>$isLogin);
    }

    if ($isAdmin===true) {
        if ($form==='user') {
            if ($formKey=='userName') {
                $showUserList=$user->show(array("userName"=>$formValue));
                if ($showUserList!=false) {//判断用户是否存在
                    return array("code"=>"0","msg"=>"修改失败,账号已存在<br>admin doChange user","data"=>$formValue);
                }
            }

            $re_update=$user->update(array("id"=>$childID,$formKey=>$formValue));
            if ($re_update) {
                return array("code"=>"1","msg"=>"修改成功<br>admin doChange user","data"=>$re_update);
            } else {
                return array("code"=>"0","msg"=>"修改失败<br>admin doChange user","data"=>$re_update);
            }
        }
        if ($form==='webSetting') {
            require_once 'class.websetting.php';
            $DBwebsetting=new websetting();
            $re_update=$DBwebsetting->update(array("userID"=>$childID,$formKey=>$formValue));//代理ID

            loopChange($childID, $formKey, $formValue);

            if ($re_update) {
                return array("code"=>"1","msg"=>"修改成功<br>admin doChange webSetting","data"=>$re_update);
            } else {
                return array("code"=>"0","msg"=>"修改失败<br>admin doChange webSetting","data"=>$re_update);
            }
        }
        if ($form==='adminLimit') {
            require_once 'class.adminLimit.php';
            $DBadminLimit=new adminLimit();
            $re_update=$DBadminLimit->update(array("userID"=>$childID,$formKey=>$formValue));//代理ID

            // loopChange($childID,$formKey,$formValue);

            if ($re_update) {
                return array("code"=>"1","msg"=>"修改成功<br>admin doChange adminLimit","data"=>$re_update);
            } else {
                return array("code"=>"0","msg"=>"修改失败<br>admin doChange adminLimit","data"=>$re_update);
            }
        }
        if ($form==='api') {
            require_once 'class.api.php';
            $DBapi=new api();
            $re_update=$DBapi->update(array("id"=>$childID,$formKey=>$formValue));

            // loopChange($childID,$formKey,$formValue);

            if ($re_update) {
                return array("code"=>"1","msg"=>"修改成功<br>admin doChange api","data"=>$re_update);
            } else {
                return array("code"=>"0","msg"=>"修改失败<br>admin doChange api","data"=>$re_update);
            }
        }
    } elseif ($userType==='1'||$userType==='2') {
        if ($form==='user' || $form==='webSetting') {
            //查询有没有修改权限
            require_once 'class.adminLimit.php';
            $DBadminLimit=new adminLimit();
            $userInfo=array("userID"=>$userID);
            $Arr_limit=$DBadminLimit->show($userInfo);
            $json_limit= $Arr_limit[0];
            //无修改权限
            if ($json_limit[$form.'_'.$formKey]!=='1') {
                return array("code"=>"0","msg"=>"修改失败<br>agent doChange ".$form.": limit","data"=>$json_limit['webSetting_'.$formKey]);
            }

            if ($form==='webSetting') {
                require_once 'class.websetting.php';
                $DBwebsetting=new websetting();
                $re_update=$DBwebsetting->update(array("userID"=>$childID,$formKey=>$formValue));
                loopChange($childID, $formKey, $formValue);
            } else {
                if ($formKey=='userName') {
                    $showUserList=$user->show(array("userName"=>$formValue));
                    if ($showUserList!=false) {//判断用户是否存在
                        return array("code"=>"0","msg"=>"修改失败,账号已存在<br>admin doChange user","data"=>$formValue);
                    }
                }
                
                $re_update=$user->update(array("id"=>$childID,$formKey=>$formValue));
            }
           
            if ($re_update) {
                return array("code"=>"1","msg"=>"修改成功<br>agent doChange ".$form.": update success","data"=>$re_update);
            } else {
                return array("code"=>"0","msg"=>"修改失败<br>agent doChange ".$form." ","data"=>$re_update);
            }
        } elseif ($form==='adminLimit') {



            //查询有没有修改权限
            require_once 'class.adminLimit.php';
            $DBadminLimit=new adminLimit();
            $userInfo=array("userID"=>$userID);
            $Arr_limit=$DBadminLimit->show($userInfo);
            $json_limit= $Arr_limit[0];
            //无修改权限
            if ($json_limit[$formKey]!=='1') {
                return array("code"=>"0","msg"=>"修改失败<br>agent doChange ".$form.": limit","data"=>$json_limit[$formKey]);
            }

            $re_update=$DBadminLimit->update(array("userID"=>$childID,$formKey=>$formValue));

            if ($re_update) {
                return array("code"=>"1","msg"=>"修改成功<br>agent doChange adminLimit","data"=>$re_update);
            } else {
                return array("code"=>"0","msg"=>"修改失败<br>agent doChange adminLimit","data"=>$re_update);
            }
        } else {
            return array("code"=>"0","msg"=>"修改失败<br>agent doChange __".$form." ","data"=>$form);
        }
    }
    return $json_result;
}


function submitChange($userID, $token, $childID, $form, $formKey, $formValue)
{
    require_once 'class.logLogin.php';
    $logLogin=new logLogin();
    require_once 'class.user.php';
    $user=new user();
    $userType=$user->isAdmin(array("id"=>$userID));

    $isLogin=$logLogin->checkToken($userID, $token);
    $isSelf=($userID==$childID);
    $isChild=$user->isAfromB($childID, $userID);
    $isAgent=($userType===true||$userType==='1'||$userType==='2');
    $isAdmin=($userType===true);

    if ($isLogin!==true) {
        return array("code"=>"-9","msg"=>"登录超时<br>submitChange","data"=>$isLogin);
    }

    //自己提交修改自己的信息
    if ($isSelf===true) {
        //不是来自后台
        if ($form!=="webSetting") {
            return array("code"=>"0","msg"=>"提交失败<br>submitChange: form is not  websetting ","data"=>$isAgent);
        }
        //不是代理
        if ($isAgent!==true) {
            return array("code"=>"0","msg"=>"提交失败，不是网站代理<br>submitChange:  not Agent, can not websetting","data"=>$isAgent);
        }
        //查询有没有提交权限
        require_once 'class.adminLimit.php';
        $DBadminLimit=new adminLimit();
        $userInfo=array("userID"=>$userID);
        $Arr_limit=$DBadminLimit->show($userInfo);
        $json_limit= $Arr_limit[0];
        //无提交权限
        if ($json_limit['webSetting_'.$formKey]!=='2') {
            return array("code"=>"0","msg"=>"提交失败，无权限<br>submitChange:  limit, can not websetting","data"=>$json_limit['webSetting_'.$formKey]);
        }
        //执行提交操作
        require_once 'class.logSubmit.php';
        $DBlogSubmit=new logSubmit();
        $re_submit=$DBlogSubmit->insert($userID, $childID, $form, $formKey, $formValue);
        //提交失败
        if ($re_submit!==true) {
            return array("code"=>"-1","msg"=>"提交出错<br>submitChange: insert false","data"=>$re_submit);
        }
        $json_result=array("code"=>"1","msg"=>"提交成功<br>submitChange","data"=>$re_submit);

    //修改线下的信息
    } else {
        //不是你的线下
        if ($isChild!==true) {
            return array("code"=>"0","msg"=>"提交失败，不是您的下线<br>submitChange: It is not your childAgent","data"=>array());
        }
        //不是来自后台
        if ($form!=="user") {
            return array("code"=>"0","msg"=>"提交失败<br>submitChange: form is not  user ","data"=>$isAgent);
        }
        //不是代理
        if ($isAgent!==true) {
            return array("code"=>"0","msg"=>"提交失败，不是网站代理<br>submitChange:  not Agent, can not user","data"=>$isAgent);
        }
        //查询有没有提交权限
        require_once 'class.adminLimit.php';
        $DBadminLimit=new adminLimit();
        $userInfo=array("userID"=>$userID);
        $Arr_limit=$DBadminLimit->show($userInfo);
        $json_limit= $Arr_limit[0];
        //无提交权限
        if ($json_limit['user_'.$formKey]!=='2') {
            return array("code"=>"0","msg"=>"提交失败，权限不足<br>submitChange: limit, can not user","data"=>$json_limit['webSetting_'.$formKey]);
        }
        //执行提交操作
        require_once 'class.logSubmit.php';
        $DBlogSubmit=new logSubmit();
        $re_submit=$DBlogSubmit->insert($userID, $childID, $form, $formKey, $formValue);
        //提交失败
        if ($re_submit!==true) {
            return array("code"=>"-1","msg"=>"提交出错<br>submitChange: insert false","data"=>$re_submit);
        }
        $json_result=array("code"=>"1","msg"=>"提交成功<br>submitChange","data"=>$re_submit);
    }
    return $json_result;
}
function getMyUsers($userID, $token, $userName)//childID
{
    require_once 'class.logLogin.php';
    $logLogin=new logLogin();
    $isLogin=$logLogin->checkToken($userID, $token);
    if ($isLogin!==true) {
        return array("code"=>"-9","msg"=>"登录超时<br>getMyUsers","data"=>$isLogin);
    }

    require_once 'class.user.php';
    $user=new user();

    //////// 检查输入的用户名  开始
    $re_userName_is=$user->show(array("userName"=>$userName));
    if ($re_userName_is==false) { //不存在
        return array("code"=>"0","msg"=>"获取失败，代理账号不存在<br>getMyUsers","data"=>$re_userName_is);
    }
    $childID=$re_userName_is[0]['id'];
    //////// 检查输入的用户名  结束


    require_once 'class.adminLimit.php';
    $DBadminLimit=new adminLimit();
    $userType=$user->isAdmin(array("id"=>$userID));
    $isSelf=($userID==$childID);
    $isChild=$user->isAfromB($childID, $userID);
    $isAgent=($userType===true||$userType==='1'||$userType==='2');
    $isAdmin=($userType===true);

    $userInfo=array("userID"=>$userID);
    $Arr_limit=$DBadminLimit->show($userInfo);
    $json_limit= $Arr_limit[0];

    $canShowAll=($json_limit['show_all_user']==='1');//开启循环查询

    if ($isSelf===true ||  $isChild) {
        if ($isChild && !$canShowAll) {
            return array("code"=>"-2","msg"=>"未开启深度查询","data"=>array());
        }

     
        if ($isAgent===true) {//true 1 2 3 false


            if (isset($GLOBALS["page"])) {
                $userListInfo["page"]=$GLOBALS['page'];
            }
            if (isset($GLOBALS["n"])) {
                $userListInfo["n"]=$GLOBALS['n'];
            }
            if (isset($GLOBALS["sort"])) {
                $userListInfo["sort"]=$GLOBALS['sort'];
            }

            if ($isAdmin===true &&  $isSelf===true) {
                $userList=$user->show($userListInfo);
            } else {
                $userListInfo["agentID"]=$childID;
                $userList=$user->showUserListByAgentID($userListInfo);
            }
            if ($userList==false) {
                return array("code"=>"1","msg"=>"暂时没有信息<br>userList empty","data"=>array('userList'=>array(),'userLimit'=>array()));
            }
            /////////////////////////////
            $userListlength=count($userList);

            $re_userList=array();
            $re_limit=array();
            for ($x=0;$x<$userListlength;$x++) {
                $userListOne = $userList[$x];

                $re_userListOne=array();
                foreach ($userListOne as $key=>$value) {
                    $adminLimitKey="user_". $key;
                        

                    //默认过滤
                    if ($key=='userPsw') {
                        $value="***";
                    }

                    $filterKey = array("id", "userName", "registerTime", "registerIP", "shareCode", "authorizationStatus", "agentStatus", "userLevel", "userActive", "userTitle", "fromLink","loginTime","agentName");
                    if (in_array($key, $filterKey)) {
                        $re_userListOne[$key]=$value;
                    }
                        
                    //权限过滤
                    if (array_key_exists($adminLimitKey, $json_limit)) {
                        if ($json_limit[$adminLimitKey]!=0) {
                            $re_userListOne[$key]=$value;

                            $filterKey__2 = array("authorizationStatus", "agentStatus", "userLevel");
                            if (!in_array($key, $filterKey__2)) {
                                $re_limit[$key]=$json_limit[$adminLimitKey];
                            }
                        }
                    } else {
                        //echo "键不存在！";
                    }
                }
                $re_userListOne['nextCount']=-1;
                if ($userListOne['agentStatus']=='2') {
                    $re_userListOne['nextCount']=-2;
                }

                require_once 'class.shareIP.php';
                $shareIP=new shareIP();
                $re_shareIP_list=$shareIP->show($re_userListOne['shareCode']);
                $re_shareIP_list_length=$re_shareIP_list?count($re_shareIP_list):0;
                $re_userListOne['shareIPCount']=$re_shareIP_list_length;

                //会员是代理
                if ($userListOne['agentStatus']=='1') {
                    //此会员（下一级代理）的下级会员情况
                    $re_userList_2=$user->showUserListByAgentID(array('agentID'=>$userListOne['id']));
                    $re_userList_2_length=$re_userList_2?count($re_userList_2):0;

                    $re_userListOne['nextCount']=$re_userList_2_length;
                    $re_userListOne['nextCanShow']=$json_limit['show_all_user'];
                }
                array_push($re_userList, $re_userListOne);
            }
            $json_result=array("code"=>"1","msg"=>"获取成功<br>userList success","data"=>array('userList'=>$re_userList,'userLimit'=>$re_limit));
        //////////////////////////////////
        } else {
            $json_result=array("code"=>"-1","msg"=>"获取失败，不是网站代理<br>is not agent","data"=>$re);
        }
    } else {
        $json_result=array("code"=>"-2","msg"=>"获取失败，不是您的下线代理<br>It is not your childAgent","data"=>array());
    }
    return $json_result;
}

function getMySiteSetting($userID, $token, $childID)
{
    require_once 'class.logLogin.php';
    $logLogin=new logLogin();
    require_once 'class.user.php';
    $user=new user();
    require_once 'class.adminLimit.php';
    $DBadminLimit=new adminLimit();
    require_once 'class.websetting.php';
    $DBwebsetting=new websetting();

    $isLogin=$logLogin->checkToken($userID, $token);
    if ($isLogin!==true) {
        return array("code"=>"-9","msg"=>"登录超时<br>getMySiteSetting","data"=>$isLogin);
    }
    $userType=$user->isAdmin(array("id"=>$userID));
    $isSelf=($userID==$childID);
  
    $isAdmin=($userType===true);

    if ($isSelf!==true &&  $isAdmin!==true) {
        return array("code"=>"-2","msg"=>"权限不足<br>getMySiteSetting","data"=>array());
    }

    $webInfo=array();
    if ($childID!="") {
        if (strpos($childID, ".")!==false) {
            $webInfo["siteLink"]=$childID;
        } elseif (is_numeric($childID)) {
            $webInfo["userID"]=$childID;
        } else {
            $webInfo["userName"]=$childID;
        }
    }

    if (isset($GLOBALS["page"])) {
        $webInfo["page"]=$GLOBALS['page'];
    }
    if (isset($GLOBALS["n"])) {
        $webInfo["n"]=$GLOBALS['n'];
    }

    if (isset($GLOBALS["sort"])) {
        $webInfo["sort"]=$GLOBALS['sort'];
    }

    if (count($webInfo)==0 && $isSelf) {
        return array("code"=>"-2","msg"=>"未查询到信息<br>getMySiteSetting：isSelf err enter =".$childID,"data"=>array());
    }
    $json_set=$DBwebsetting->show($webInfo);

    if ($json_set===array()) {
        return array(
            "code"=>"2",
            "msg"=>"没有了<br>getMySiteSetting",
            "data"=>array(
                'set'=>array($json_set),
                'limit'=>$json_set
            )
        );
    }



    $userInfo=array("userID"=>$userID);
    $Arr_limit=$DBadminLimit->show($userInfo);
    $json_limit= $Arr_limit[0];

    $re_webArr=array();
    $re_limit=array();
    $myWebsCount=count($json_set);
    for ($x=0;$x<$myWebsCount;$x++) {
        $myWebJson=$json_set[$x];

        $re_webArrOne=array();
        foreach ($myWebJson as $key=>$value) {
            $adminLimitKey="webSetting_". $key;


            //默认过滤
            // if ($key=='userPsw') {
            //     $value="***";
            // }

            //默认显示的信息
            $filterKey = array("id","userID","userName","userLevel","siteLink","siteConfig","agentName");
            if (in_array($key, $filterKey)) {
                $re_webArrOne[$key]=$value;
            }
            //此站长可修改的信息
            if ($key=="userLevel"||$key=="agentName") {
                continue;
            }
            if ($key!=="id"&&$key!=="userID"&&$key!=="userName"&&$json_limit[$adminLimitKey]!=0) {
                $re_webArrOne[$key]=$value;
                $re_limit[$key]=$json_limit[$adminLimitKey];
            }
        }
        array_push($re_webArr, $re_webArrOne);
    }
  
    $re_arr=array('set'=>$re_webArr,'limit'=>$re_limit);
    //   echo '<hr>';


    if ($json_set!==false) {
        $json_result=array("code"=>"1","msg"=>"获取成功<br>getMySiteSetting","data"=>$re_arr);
    } else {
        $json_result=array("code"=>"0","msg"=>"获取出错<br>getMySiteSetting","data"=>$json_set);
    }
    return $json_result;
}

function websiteOverview($userID, $token, $childID)
{
    require_once 'class.logLogin.php';
    $logLogin=new logLogin();
    require_once 'class.user.php';
    $user=new user();

    $isLogin=$logLogin->checkToken($userID, $token);
    if ($isLogin!==true) {
        return array("code"=>"-9","msg"=>"登录超时<br>websiteOverview","data"=>$isLogin);
    }
    $userType=$user->isAdmin(array("id"=>$userID));
    $isSelf=($userID==$childID);
  
    $isAdmin=($userType===true);

    if ($isSelf!==true &&  $isAdmin!==true) {
        return array("code"=>"-2","msg"=>"权限不足<br>websiteOverview","data"=>array());
    }

    $agentInfo=array();
    if ($childID!="") {
        if (is_numeric($childID)) {
            $agentInfo["agentID"]=$childID;
        } else {
            $agentInfo["agentName"]=$childID;
        }
    }

    if ($isAdmin === true) {
        $agentInfo["isAdmin"]="1";
    }

    if (count($agentInfo)==0 && $isSelf) {
        return array("code"=>"-2","msg"=>"未查询到信息<br>websiteOverview err enter =".$childID,"data"=>array());
    }
    $re_arr=$user->websiteOverview($agentInfo);


    if ($re_arr!==false) {
        $json_result=array("code"=>"1","msg"=>"获取会员概况成功","data"=>$re_arr[0]);
    } else {
        $json_result=array("code"=>"0","msg"=>"获取出错<br>websiteOverview","data"=>$re_arr);
    }
    return $json_result;
}


function isMatch($str)
{
    if (preg_match('/^[a-zA-Z0-9_]{6,15}$/', $str)) {
        return true;
    } else {
        return false;
    }
}
