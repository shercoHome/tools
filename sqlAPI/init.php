<?php
require_once("sql.php");

// 创建连接
$conn = new mysqli($servername, $username, $password);
//new mysqli("localhost", "username", "password", "", port)//其他端口（默认为3306）
// 检测连接
if ($conn->connect_error) {
    die("connect_error: " . $conn->connect_error);
}
// 创建数据库
$sql = "CREATE DATABASE $dbname";
if ($conn->query($sql) === true) {
    echo "Database created";
} else {
    echo "Error creating database: " . $conn->error;
}
echo "<hr><br>";
$conn->close();

createUserTable($servername, $username, $password, $dbname);echo "<br>";
createWebSettingTable($servername, $username, $password, $dbname);echo "<br>";
createAdminLimitTable($servername, $username, $password, $dbname);echo "<br>";
createAuthorizationStatusTable($servername, $username, $password, $dbname);echo "<br>";
createApiTable($servername, $username, $password, $dbname);echo "<br>";
createShareIPTable($servername, $username, $password, $dbname);echo "<br>";
createShareRegisterTable($servername, $username, $password, $dbname);echo "<br>";
createLogLoginTable($servername, $username, $password, $dbname);echo "<br>";
createLogSubmitTable($servername, $username, $password, $dbname);echo "<br>";
                        

//初始化管理员和网站
//创建一个总代账号作为管理员
require_once 'class.user.php';
$user=new user();
$adminInfo=array(
    "userName"=>$admin_user,
    "userPsw"=>$admin_psw,
    "authorizationStatus"=>"3",//特别授权
    "userLevel"=>"1",//总代
    "agentStatus"=>"1"//是代理
);
//获取的管理员id
$adminID=$user->insert($adminInfo);
if($adminID!==false){echo "admin insert successfully<br>";}else{echo "admin insert err<br>";}
//层级关系都指向0（即为管理员）
$adminInfo2=array(
    "id"=>$adminID,
    "agentAdmin"=>'0',
    "agentTop"=>'0',
    "agentDirect"=>'0',
    "creater"=>'0',
    "shareCode"=>$adminID,
);
$re=$user->update($adminInfo2);
if($re===true){echo "admin update successfully<br>";}else{echo "admin update err<br>";}

//为管理员，特别授权
require_once 'class.authorizationWBStatus.php';
$authorizationWBStatus=new authorizationWBStatus();
$re=$authorizationWBStatus->insert(array("userID"=>$adminID,"wbStatus"=>"1","updater"=>$adminID));
if($re===true){echo "admin white Status insert successfully<br>";}else{echo "admin white Status insert err<br>";}

//初始化管理员权限
require_once 'class.adminLimit.php';
$adminLimit=new adminLimit();
$adminLimitInfo=array(
    'userID'=>$adminID,
    'webSetting_siteLink'=>'1',
    'webSetting_siteName'=>'1',
    'webSetting_publicAuthorization'=>'1',
    'webSetting_shareRequiredIP'=>'1',
    'webSetting_shareRequiredUser'=>'1',
    'webSetting_shareLimiteTime'=>'1',
    'webSetting_apiSelect'=>'1',
    'webSetting_defaultPlanID'=>'1',
    'webSetting_historyLimit'=>'1',
    'webSetting_leaderboardLimit'=>'1',
    'webSetting_historyPlanShowLimit'=>'1',
    'webSetting_showWinQis'=>'1',
    'webSetting_stringUserTitle'=>'1',
    'webSetting_registerQQ'=>'1',
    'webSetting_registerWechat'=>'1',
    'webSetting_registerPhone'=>'1',
    'webSetting_registerEmail'=>'1',
    'webSetting_loginKeep'=>'1',
    'webSetting_csQQ'=>'1',
    'webSetting_csQQGroup'=>'1',
    'webSetting_csWechat'=>'1',
    'webSetting_csEmail'=>'1',
    'webSetting_ezunLink'=>'1',
    'webSetting_autoEzunLink'=>'1',
    'webSetting_hk49plan1'=>'1',
    'webSetting_hk49plan2'=>'1',
    'webSetting_hk49plan3'=>'1',
    'webSetting_hk49plan4'=>'1',
    'webSetting_hk49plan5'=>'1',
    'webSetting_hk49PlanPoet'=>'1',
    'webSetting_hk49PlanPicture'=>'1',
    'webSetting_outLinkName'=>'1',
    'webSetting_outLinkUrl'=>'1',
    'webSetting_baiduStatistics'=>'1',
    'webSetting_updateUserPsw'=>'1',
    'webSetting_submitUpdateUserLevel'=>'1',
    'webSetting_updateUserQQ'=>'1',
    'webSetting_updateUserWechat'=>'1',
    'webSetting_updateUserPhone'=>'1',
    'webSetting_updateUserEmail'=>'1',
    'webSetting_mark1'=>'1',
    'webSetting_mark2'=>'1',
    'webSetting_mark3'=>'1',
    'webSetting_mark4'=>'1',
    'webSetting_mark5'=>'1',
    'user_userName'=>'1',
    'user_userPsw'=>'1',
    'user_userQQ'=>'1',
    'user_userWechat'=>'1',
    'user_userPhone'=>'1',
    'user_userEmail'=>'1',
    'user_verifyQQ'=>'1',
    'user_verifyWechat'=>'1',
    'user_verifyPhone'=>'1',
    'user_verifyEmail'=>'1',
    'create_user_3'=>'1',
    'create_user_2'=>'1',
    'create_user_1'=>'1',
    'user_authorizationStatus'=>'1',
    'show_all_user'=>'1',
    'user_agentStatus'=>'1',
    'user_agentAdmin'=>'1',
    'user_agentTop'=>'1',
    'user_agentDirect'=>'1',
    'user_userActive'=>'1',
    'user_userTitle'=>'1',
    'mark1'=>'1',
    'mark2'=>'1',
    'mark3'=>'1',
    'mark4'=>'1',
    'mark5'=>'1'
);
$re=$adminLimit->insert($adminLimitInfo);
if($re===true){echo "adminLimitInfo insert successfully<br>";}else{echo "adminLimitInfo insert err<br>";}
//初始化管理员网站配置
require_once 'class.webSetting.php';
$webSetting=new webSetting();
$webInfo=array(
    'userID'=>$adminID,
    'siteLink'=>$admin_site_link,
    'siteName'=>$admin_site_name,
    'csQQ'=>$admin_site_csQQ,
    'csQQGroup'=>$admin_site_csQQGroup,
    'csWechat'=>$admin_site_csWechat,
    'csEmail'=>$admin_site_csEmail,
    'ezunLink'=>$admin_site_ezunLink,
    'hk49plan1'=>'isNull',
    'hk49plan2'=>'isNull',
    'hk49plan3'=>'isNull',
    'hk49plan4'=>'isNull',
    'hk49plan5'=>'isNull',
    'hk49PlanPoet'=>'isNull',
    'hk49PlanPicture'=>'isNull',
    'outLinkUrl'=>$admin_site_outLinkUrl,
    'baiduStatistics'=>$admin_site_baiduStatistics,
    'hk49plan1'=>$admin_site_hk49plan1,
    'hk49plan2'=>$admin_site_hk49plan2,
    'hk49plan3'=>$admin_site_hk49plan3,
    'hk49plan4'=>$admin_site_hk49plan4,
    'hk49plan5'=>$admin_site_hk49plan5,
    'hk49PlanPoet'=>$admin_site_hk49PlanPoet,
    'hk49PlanPicture'=>$admin_site_hk49PlanPicture

);
$re=$webSetting->insert($webInfo);
if($re===true){echo "webSetting insert successfully<br>";}else{echo "webSetting insert err<br>";}


//生成一位总代并初始化总代权限，并继承管理员对于网站的设置
require_once 'class.user.php';
$user=new user();
$zdInfo=array(
    "userName"=>$zd_user,
    "userPsw"=>$zd_psw,
    "userLevel"=>"1",//总代
    "agentStatus"=>"1"//是代理
);
$zdID=$user->insert($zdInfo);
if($zdID!==false){echo "zd insert successfully<br>";}else{echo "zd insert err<br>";}
$zdInfo2=array(
    "id"=>$zdID,
    "agentAdmin"=>$adminID,
    "agentTop"=>$zdID,
    "agentDirect"=>$adminID,
    "creater"=>$adminID,
    "shareCode"=>$zdID,
);
$re=$user->update($zdInfo2);
if($re===true){echo "zd update successfully<br>";}else{echo "zd update err<br>";}

$zdLimitInfo=array(
    'userID'=>$zdID,
    'webSetting_siteLink'=>'0',
    'webSetting_siteName'=>'1',
    'webSetting_publicAuthorization'=>'0',
    'webSetting_shareRequiredIP'=>'1',
    'webSetting_shareRequiredUser'=>'0',
    'webSetting_shareLimiteTime'=>'1',
    'webSetting_apiSelect'=>'1',
    'webSetting_defaultPlanID'=>'1',
    'webSetting_historyLimit'=>'0',
    'webSetting_leaderboardLimit'=>'0',
    'webSetting_historyPlanShowLimit'=>'0',
    'webSetting_showWinQis'=>'0',
    'webSetting_stringUserTitle'=>'1',
    'webSetting_registerQQ'=>'1',
    'webSetting_registerWechat'=>'1',
    'webSetting_registerPhone'=>'1',
    'webSetting_registerEmail'=>'1',
    'webSetting_loginKeep'=>'0',
    'webSetting_csQQ'=>'1',
    'webSetting_csQQGroup'=>'1',
    'webSetting_csWechat'=>'1',
    'webSetting_csEmail'=>'1',
    'webSetting_ezunLink'=>'1',
    'webSetting_autoEzunLink'=>'0',
    'webSetting_hk49plan1'=>'1',
    'webSetting_hk49plan2'=>'1',
    'webSetting_hk49plan3'=>'1',
    'webSetting_hk49plan4'=>'1',
    'webSetting_hk49plan5'=>'1',
    'webSetting_hk49PlanPoet'=>'1',
    'webSetting_hk49PlanPicture'=>'1',
    'webSetting_outLinkName'=>'0',
    'webSetting_outLinkUrl'=>'0',
    'webSetting_baiduStatistics'=>'0',
    'webSetting_updateUserPsw'=>'1',
    'webSetting_submitUpdateUserLevel'=>'1',
    'webSetting_updateUserQQ'=>'1',
    'webSetting_updateUserWechat'=>'1',
    'webSetting_updateUserPhone'=>'1',
    'webSetting_updateUserEmail'=>'1',
    'webSetting_mark1'=>'0',
    'webSetting_mark2'=>'0',
    'webSetting_mark3'=>'0',
    'webSetting_mark4'=>'0',
    'webSetting_mark5'=>'0',
    'user_userName'=>'1',
    'user_userPsw'=>'1',
    'user_userQQ'=>'1',
    'user_userWechat'=>'1',
    'user_userPhone'=>'1',
    'user_userEmail'=>'1',
    'user_verifyQQ'=>'0',
    'user_verifyWechat'=>'0',
    'user_verifyPhone'=>'0',
    'user_verifyEmail'=>'0',
    'create_user_3'=>'1',
    'create_user_2'=>'1',
    'create_user_1'=>'0',
    'user_authorizationStatus'=>'1',
    'show_all_user'=>'1',
    'user_agentStatus'=>'1',
    'user_agentAdmin'=>'0',
    'user_agentTop'=>'0',
    'user_agentDirect'=>'0',
    'user_userActive'=>'1',
    'user_userTitle'=>'1',
    'mark1'=>'0',
    'mark2'=>'0',
    'mark3'=>'0',
    'mark4'=>'0',
    'mark5'=>'0'
);
$re=$adminLimit->insert($zdLimitInfo);
if($re===true){echo "zdLimitInfo insert successfully<br>";}else{echo "zdLimitInfo insert err<br>";}

$re=$webSetting->copy($adminID,$zdID);
if($re===true){echo "zd webSetting copy successfully<br>";}else{echo "zd webSetting copy err<br>";}

//初始化次代权限，并继承总代对于网站的设置
require_once 'class.user.php';
$user=new user();
$cdInfo=array(
    "userName"=>$cd_user,
    "userPsw"=>$cd_psw,
    "userLevel"=>"2",//次代
    "agentStatus"=>"1"//是代理
);
$cdID=$user->insert($cdInfo);
if($cdID!==false){echo "cd insert successfully<br>";}else{echo "cd insert err<br>";}
$cdInfo2=array(
    "id"=>$cdID,
    "agentAdmin"=>$adminID,
    "agentTop"=>$zdID,
    "agentDirect"=>$zdID,
    "creater"=>$adminID,
    "shareCode"=>$cdID,
);
$re=$user->update($cdInfo2);
if($re===true){echo "cd update successfully<br>";}else{echo "cd update err<br>";}

$cdLimitInfo=array(
    'userID'=>$cdID,
    'webSetting_siteLink'=>'0',
    'webSetting_siteName'=>'0',
    'webSetting_publicAuthorization'=>'0',
    'webSetting_shareRequiredIP'=>'0',
    'webSetting_shareRequiredUser'=>'0',
    'webSetting_shareLimiteTime'=>'0',
    'webSetting_apiSelect'=>'0',
    'webSetting_defaultPlanID'=>'0',
    'webSetting_historyLimit'=>'0',
    'webSetting_leaderboardLimit'=>'0',
    'webSetting_historyPlanShowLimit'=>'0',
    'webSetting_showWinQis'=>'0',
    'webSetting_stringUserTitle'=>'0',
    'webSetting_registerQQ'=>'0',
    'webSetting_registerWechat'=>'0',
    'webSetting_registerPhone'=>'0',
    'webSetting_registerEmail'=>'0',
    'webSetting_loginKeep'=>'0',
    'webSetting_csQQ'=>'0',
    'webSetting_csQQGroup'=>'0',
    'webSetting_csWechat'=>'0',
    'webSetting_csEmail'=>'0',
    'webSetting_ezunLink'=>'0',
    'webSetting_autoEzunLink'=>'0',
    'webSetting_hk49plan1'=>'0',
    'webSetting_hk49plan2'=>'0',
    'webSetting_hk49plan3'=>'0',
    'webSetting_hk49plan4'=>'0',
    'webSetting_hk49plan5'=>'0',
    'webSetting_hk49PlanPoet'=>'0',
    'webSetting_hk49PlanPicture'=>'0',
    'webSetting_outLinkName'=>'0',
    'webSetting_outLinkUrl'=>'0',
    'webSetting_baiduStatistics'=>'0',
    'webSetting_updateUserPsw'=>'1',
    'webSetting_submitUpdateUserLevel'=>'1',
    'webSetting_updateUserQQ'=>'1',
    'webSetting_updateUserWechat'=>'1',
    'webSetting_updateUserPhone'=>'1',
    'webSetting_updateUserEmail'=>'1',
    'webSetting_mark1'=>'0',
    'webSetting_mark2'=>'0',
    'webSetting_mark3'=>'0',
    'webSetting_mark4'=>'0',
    'webSetting_mark5'=>'0',
    'user_userName'=>'0',
    'user_userPsw'=>'0',
    'user_userQQ'=>'0',
    'user_userWechat'=>'0',
    'user_userPhone'=>'0',
    'user_userEmail'=>'0',
    'user_verifyQQ'=>'0',
    'user_verifyWechat'=>'0',
    'user_verifyPhone'=>'0',
    'user_verifyEmail'=>'0',
    'create_user_3'=>'1',
    'create_user_2'=>'0',
    'create_user_1'=>'0',
    'user_authorizationStatus'=>'0',
    'show_all_user'=>'1',
    'user_agentStatus'=>'0',
    'user_agentAdmin'=>'0',
    'user_agentTop'=>'0',
    'user_agentDirect'=>'0',
    'user_userActive'=>'0',
    'user_userTitle'=>'0',
    'mark1'=>'0',
    'mark2'=>'0',
    'mark3'=>'0',
    'mark4'=>'0',
    'mark5'=>'0',
);
$re=$adminLimit->insert($cdLimitInfo);
if($re===true){echo "cdLimitInfo insert successfully<br>";}else{echo "cdLimitInfo insert err<br>";}

$re=$webSetting->copy($zdID,$cdID);
if($re===true){echo "cd webSetting copy successfully<br>";}else{echo "cd webSetting copy err<br>";}


//初始化网站api
require_once 'class.api.php';
$api=new api();
////  1 LT极速PK10
$apiInfo=array(
    'lotteryID'=>'pk10-js',
    'lotteryname'=>'LT极速PK10',
    'dir'=>'pk10-js'
);
$re=$api->insert($apiInfo);
if($re===true){echo "api js insert successfully<br>";}else{echo "api js insert err<br>";}
////  2 幸运极速PK10
$apiInfo=array(
    'lotteryID'=>'pk10-js-xy',
    'lotteryname'=>'幸运极速PK10',
    'dir'=>'pk10-js-xy'
);
$re=$api->insert($apiInfo);
if($re===true){echo "api xyjs insert successfully<br>";}else{echo "api xyjs insert err<br>";}
////  3 幸运飞艇
$apiInfo=array(
    'lotteryID'=>'lucky-air-ship',
    'lotteryname'=>'幸运飞艇',
    'dir'=>'lucky-air-ship',
    'maxPeriod'=>'180',
    'intervalPeriod'=>'300',
    'delayPeriod'=>'60'
);
$re=$api->insert($apiInfo);
if($re===true){echo "api xyft insert successfully<br>";}else{echo "api xyft insert err<br>";}
////  4 分分时时彩
$apiInfo=array(
    'lotteryID'=>'ffssc',
    'lotteryname'=>'分分时时彩',
    'dir'=>'ffssc',
    'strPosition'=>'[{"name":"定位胆","item":[{"name":"万","item":[{"name":"四码","item":4},{"name":"五码","item":5},{"name":"六码","item":6},{"name":"七码","item":7}]},{"name":"千","item":[{"name":"四码","item":4},{"name":"五码","item":5},{"name":"六码","item":6},{"name":"七码","item":7}]},{"name":"百","item":[{"name":"四码","item":4},{"name":"五码","item":5},{"name":"六码","item":6},{"name":"七码","item":7}]},{"name":"十","item":[{"name":"四码","item":4},{"name":"五码","item":5},{"name":"六码","item":6},{"name":"七码","item":7}]},{"name":"个","item":[{"name":"四码","item":4},{"name":"五码","item":5},{"name":"六码","item":6},{"name":"七码","item":7}]}]},{"name":"大小定位","item":[{"name":"万","item":[{"name":"一码","item":1}]},{"name":"千","item":[{"name":"一码","item":1}]},{"name":"百","item":[{"name":"一码","item":1}]},{"name":"十","item":[{"name":"一码","item":1}]},{"name":"个","item":[{"name":"一码","item":1}]}]},{"name":"单双定位","item":[{"name":"万","item":[{"name":"一码","item":1}]},{"name":"千","item":[{"name":"一码","item":1}]},{"name":"百","item":[{"name":"一码","item":1}]},{"name":"十","item":[{"name":"一码","item":1}]},{"name":"个","item":[{"name":"一码","item":1}]}]},{"name":"和值","item":[{"name":"大小","item":[{"name":"四码","item":4}]},{"name":"单双","item":[{"name":"一码","item":1}]},{"name":"大小单双","item":[{"name":"一码","item":1}]}]},{"name":"五星","item":[{"name":"定胆","item":[{"name":"一码","item":1}]}]},{"name":"组三","item":[{"name":"前三","item":[{"name":"七码","item":7},{"name":"八码","item":8},{"name":"九码","item":9}]},{"name":"中三","item":[{"name":"七码","item":7},{"name":"八码","item":8},{"name":"九码","item":9}]},{"name":"后三","item":[{"name":"七码","item":7},{"name":"八码","item":8},{"name":"九码","item":9}]}]},{"name":"组六","item":[{"name":"前三","item":[{"name":"六码","item":6},{"name":"七码","item":7},{"name":"八码","item":8},{"name":"九码","item":9}]},{"name":"中三","item":[{"name":"六码","item":6},{"name":"七码","item":7},{"name":"八码","item":8},{"name":"九码","item":9}]},{"name":"后三","item":[{"name":"六码","item":6},{"name":"七码","item":7},{"name":"八码","item":8},{"name":"九码","item":9}]}]}]',
);
$re=$api->insert($apiInfo);
if($re===true){echo "api ffssc insert successfully<br>";}else{echo "api ffssc insert err<br>";}
////  5 幸运28(PC蛋蛋)
$apiInfo=array(
    'lotteryID'=>'pc28',
    'lotteryname'=>'幸运28-PC蛋蛋',
    'dir'=>'pc28',
    'strPosition'=>'[{"name":"定位胆","item":[{"name":"百","item":[{"name":"四码","item":4},{"name":"五码","item":5},{"name":"六码","item":6},{"name":"七码","item":7}]},{"name":"十","item":[{"name":"四码","item":4},{"name":"五码","item":5},{"name":"六码","item":6},{"name":"七码","item":7}]},{"name":"个","item":[{"name":"四码","item":4},{"name":"五码","item":5},{"name":"六码","item":6},{"name":"七码","item":7}]}]},{"name":"和值","item":[{"name":"特码","item":[{"name":"14码","item":14}]},{"name":"大小","item":[{"name":"四码","item":4}]},{"name":"单双","item":[{"name":"一码","item":1}]},{"name":"大小单双","item":[{"name":"一码","item":1}]},{"name":"色波","item":[{"name":"一码","item":1}]}]}]',
    'maxPeriod'=>'179',
    'intervalPeriod'=>'300',
    'delayPeriod'=>'120'
);
$re=$api->insert($apiInfo);
if($re===true){echo "api xy28 insert successfully<br>";}else{echo "api xy28 insert err<br>";}
////  6 北京PK10
$apiInfo=array(
    'lotteryID'=>'pk10-bj',
    'lotteryname'=>'北京PK10',
    'dir'=>'pk10-bj',
    'maxPeriod'=>'44',
    'intervalPeriod'=>'1200',
    'delayPeriod'=>'120'
);
$re=$api->insert($apiInfo);
if($re===true){echo "api pk10-bj insert successfully<br>";}else{echo "api pk10-bj insert err<br>";}
////  7 重庆时时彩
$apiInfo=array(
    'lotteryID'=>'cqssc',
    'lotteryname'=>'重庆时时彩',
    'dir'=>'cqssc',
    'strPosition'=>'[{"name":"定位胆","item":[{"name":"万","item":[{"name":"四码","item":4},{"name":"五码","item":5},{"name":"六码","item":6},{"name":"七码","item":7}]},{"name":"千","item":[{"name":"四码","item":4},{"name":"五码","item":5},{"name":"六码","item":6},{"name":"七码","item":7}]},{"name":"百","item":[{"name":"四码","item":4},{"name":"五码","item":5},{"name":"六码","item":6},{"name":"七码","item":7}]},{"name":"十","item":[{"name":"四码","item":4},{"name":"五码","item":5},{"name":"六码","item":6},{"name":"七码","item":7}]},{"name":"个","item":[{"name":"四码","item":4},{"name":"五码","item":5},{"name":"六码","item":6},{"name":"七码","item":7}]}]},{"name":"大小定位","item":[{"name":"万","item":[{"name":"一码","item":1}]},{"name":"千","item":[{"name":"一码","item":1}]},{"name":"百","item":[{"name":"一码","item":1}]},{"name":"十","item":[{"name":"一码","item":1}]},{"name":"个","item":[{"name":"一码","item":1}]}]},{"name":"单双定位","item":[{"name":"万","item":[{"name":"一码","item":1}]},{"name":"千","item":[{"name":"一码","item":1}]},{"name":"百","item":[{"name":"一码","item":1}]},{"name":"十","item":[{"name":"一码","item":1}]},{"name":"个","item":[{"name":"一码","item":1}]}]},{"name":"和值","item":[{"name":"大小","item":[{"name":"四码","item":4}]},{"name":"单双","item":[{"name":"一码","item":1}]},{"name":"大小单双","item":[{"name":"一码","item":1}]}]},{"name":"五星","item":[{"name":"定胆","item":[{"name":"一码","item":1}]}]},{"name":"组三","item":[{"name":"前三","item":[{"name":"七码","item":7},{"name":"八码","item":8},{"name":"九码","item":9}]},{"name":"中三","item":[{"name":"七码","item":7},{"name":"八码","item":8},{"name":"九码","item":9}]},{"name":"后三","item":[{"name":"七码","item":7},{"name":"八码","item":8},{"name":"九码","item":9}]}]},{"name":"组六","item":[{"name":"前三","item":[{"name":"六码","item":6},{"name":"七码","item":7},{"name":"八码","item":8},{"name":"九码","item":9}]},{"name":"中三","item":[{"name":"六码","item":6},{"name":"七码","item":7},{"name":"八码","item":8},{"name":"九码","item":9}]},{"name":"后三","item":[{"name":"六码","item":6},{"name":"七码","item":7},{"name":"八码","item":8},{"name":"九码","item":9}]}]}]',
    'maxPeriod'=>'59',
    'intervalPeriod'=>'1200',
    'delayPeriod'=>'120'
);
$re=$api->insert($apiInfo);
if($re===true){echo "api ffssc insert successfully<br>";}else{echo "api ffssc insert err<br>";}
///////////////////////////////////////////////////////
/////////////////////////////////////////////////////

function createUserTable($servername, $username, $password, $dbname)
{
    // 创建连接
    $conn = new mysqli($servername, $username, $password, $dbname);
    // 检测连接
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    }
 
    // 使用 sql 创建数据表
    $sql = "CREATE TABLE user (
id INT AUTO_INCREMENT PRIMARY KEY, 
userName VARCHAR(32) NOT NULL,
userPsw VARCHAR(32) NOT NULL,
userQQ VARCHAR(32) NOT NULL,
userWechat VARCHAR(32) NOT NULL,
userPhone VARCHAR(32) NOT NULL,
userEmail text NOT NULL,
verifyQQ VARCHAR(32) NOT NULL,
verifyWechat VARCHAR(32) NOT NULL,
verifyPhone VARCHAR(32) NOT NULL,
verifyEmail VARCHAR(32) NOT NULL,
registerTime TIMESTAMP NOT NULL default CURRENT_TIMESTAMP,
registerIP VARCHAR(20) NOT NULL,
shareCode VARCHAR(32) NOT NULL,
authorizationStatus VARCHAR(32) NOT NULL,
authorizationTime TIMESTAMP Null,
userLevel VARCHAR(32) NOT NULL,
agentStatus VARCHAR(32) NOT NULL,
agentAdmin VARCHAR(32) NOT NULL,
agentTop VARCHAR(32) NOT NULL,
agentDirect VARCHAR(32) NOT NULL,
userActive VARCHAR(32) NOT NULL,
creater VARCHAR(32) NOT NULL,
userTitle VARCHAR(32) NOT NULL,
fromLink text NOT NULL,
mark1 text,
mark2 text,
mark3 text,
mark4 text,
mark5 text
)";
 
    if ($conn->query($sql) === true) {
        echo "Table user created successfully";
    } else {
        echo "Table user created wrong: " . $conn->error;
    }
 
    $conn->close();
}


function createWebSettingTable($servername, $username, $password, $dbname)
{
    // 创建连接
    $conn = new mysqli($servername, $username, $password, $dbname);
    // 检测连接
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    }
 
    // 使用 sql 创建数据表
    $sql = "CREATE TABLE webSetting (
id INT AUTO_INCREMENT PRIMARY KEY,
userID INT NOT NULL,
siteLink text NOT NULL,
siteName VARCHAR(32) NOT NULL,
publicAuthorization VARCHAR(32) NOT NULL,
shareRequiredIP VARCHAR(32) NOT NULL,
shareRequiredUser VARCHAR(32) NOT NULL,
shareLimiteTime VARCHAR(32) NOT NULL,
apiSelect VARCHAR(32) NOT NULL,
defaultPlanID VARCHAR(32) NOT NULL,
historyLimit VARCHAR(32) NOT NULL,
leaderboardLimit VARCHAR(32) NOT NULL,
historyPlanShowLimit VARCHAR(32) NOT NULL,
needAuthorize VARCHAR(32) NOT NULL,
stringUserTitle text NOT NULL,
registerQQ VARCHAR(32) NOT NULL,
registerWechat VARCHAR(32) NOT NULL,
registerPhone VARCHAR(32) NOT NULL,
registerEmail VARCHAR(32) NOT NULL,
loginKeep VARCHAR(32) NOT NULL,
csQQ text NOT NULL,
csQQGroup text NOT NULL,
csWechat text NOT NULL,
csEmail text NOT NULL,
ezunLink text NOT NULL,
autoEzunLink text NOT NULL,
hk49plan1 text NOT NULL,
hk49plan2 text NOT NULL,
hk49plan3 text NOT NULL,
hk49plan4 text NOT NULL,
hk49plan5 text NOT NULL,
hk49PlanPoet text NOT NULL,
hk49PlanPicture text NOT NULL,
outLinkName VARCHAR(8) NOT NULL,
outLinkUrl text NOT NULL,
baiduStatistics text NOT NULL,
updateUserPsw VARCHAR(32) NOT NULL,
submitUpdateUserLevel VARCHAR(32) NOT NULL,
updateUserQQ VARCHAR(32) NOT NULL,
updateUserWechat VARCHAR(32) NOT NULL,
updateUserPhone VARCHAR(32) NOT NULL,
updateUserEmail VARCHAR(32) NOT NULL,
mark1 text,
mark2 text,
mark3 text,
mark4 text,
mark5 text
)";
 
    if ($conn->query($sql) === true) {
        echo "Table webSetting created successfully";
    } else {
        echo "Table webSetting created wrong: " . $conn->error;
    }
 
    $conn->close();
}



function createAdminLimitTable($servername, $username, $password, $dbname)
{
    // 创建连接
    $conn = new mysqli($servername, $username, $password, $dbname);
    // 检测连接
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    }
 
    // 使用 sql 创建数据表
    $sql = "CREATE TABLE adminLimit (
        id INT AUTO_INCREMENT PRIMARY KEY,
        userID INT NOT NULL,
        webSetting_siteLink INT NOT NULL,
        webSetting_siteName INT NOT NULL,
        webSetting_publicAuthorization INT NOT NULL,
        webSetting_shareRequiredIP INT NOT NULL,
        webSetting_shareRequiredUser INT NOT NULL,
        webSetting_shareLimiteTime INT NOT NULL,
        webSetting_apiSelect INT NOT NULL,
        webSetting_defaultPlanID INT NOT NULL,
        webSetting_historyLimit INT NOT NULL,
        webSetting_leaderboardLimit INT NOT NULL,
        webSetting_historyPlanShowLimit INT NOT NULL,
        webSetting_needAuthorize INT NOT NULL,
        webSetting_stringUserTitle INT NOT NULL,
        webSetting_registerQQ INT NOT NULL,
        webSetting_registerWechat INT NOT NULL,
        webSetting_registerPhone INT NOT NULL,
        webSetting_registerEmail INT NOT NULL,
        webSetting_loginKeep INT NOT NULL,
        webSetting_csQQ INT NOT NULL,
        webSetting_csQQGroup INT NOT NULL,
        webSetting_csWechat INT NOT NULL,
        webSetting_csEmail INT NOT NULL,
        webSetting_ezunLink INT NOT NULL,
        webSetting_autoEzunLink INT NOT NULL,
        webSetting_hk49plan1 INT NOT NULL,
        webSetting_hk49plan2 INT NOT NULL,
        webSetting_hk49plan3 INT NOT NULL,
        webSetting_hk49plan4 INT NOT NULL,
        webSetting_hk49plan5 INT NOT NULL,
        webSetting_hk49PlanPoet INT NOT NULL,
        webSetting_hk49PlanPicture INT NOT NULL,
        webSetting_outLinkName INT NOT NULL,
        webSetting_outLinkUrl INT NOT NULL,
        webSetting_baiduStatistics INT NOT NULL,
        webSetting_updateUserPsw INT NOT NULL,
        webSetting_submitUpdateUserLevel INT NOT NULL,
        webSetting_updateUserQQ INT NOT NULL,
        webSetting_updateUserWechat INT NOT NULL,
        webSetting_updateUserPhone INT NOT NULL,
        webSetting_updateUserEmail INT NOT NULL,
        webSetting_mark1 INT NOT NULL,
        webSetting_mark2 INT NOT NULL,
        webSetting_mark3 INT NOT NULL,
        webSetting_mark4 INT NOT NULL,
        webSetting_mark5 INT NOT NULL,
        user_userName INT NOT NULL,
        user_userPsw INT NOT NULL,
        user_userQQ INT NOT NULL,
        user_userWechat INT NOT NULL,
        user_userPhone INT NOT NULL,
        user_userEmail INT NOT NULL,
        user_verifyQQ INT NOT NULL,
        user_verifyWechat INT NOT NULL,
        user_verifyPhone INT NOT NULL,
        user_verifyEmail INT NOT NULL,
        create_user_3 INT NOT NULL,
        create_user_2 INT NOT NULL,
        create_user_1 INT NOT NULL,
        user_authorizationStatus INT NOT NULL,
        show_all_user INT NOT NULL,
        user_agentStatus INT NOT NULL,
        user_agentAdmin INT NOT NULL,
        user_agentTop INT NOT NULL,
        user_agentDirect INT NOT NULL,
        user_userActive INT NOT NULL,
        user_userTitle INT NOT NULL,
        mark1 INT NOT NULL,
        mark2 INT NOT NULL,
        mark3 INT NOT NULL,
        mark4 INT NOT NULL,
        mark5 INT NOT NULL
    )";
        
    if ($conn->query($sql) === true) {
        echo "Table adminLimit created successfully";
    } else {
        echo "Table adminLimit created wrong: " . $conn->error;
    }
 
    $conn->close();
}



function createAuthorizationStatusTable($servername, $username, $password, $dbname)
{
    // 创建连接
    $conn = new mysqli($servername, $username, $password, $dbname);
    // 检测连接
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    }
 
    // 使用 sql 创建数据表
    $sql = "CREATE TABLE authorizationWBStatus (
                id INT AUTO_INCREMENT PRIMARY KEY, 
                userID INT NOT NULL,
                wbStatus VARCHAR(32) NOT NULL,
                updateTime TIMESTAMP,
                updateIP VARCHAR(32) NOT NULL,
                updater VARCHAR(32) NOT NULL,
                mark1 text,
                mark2 text,
                mark3 text,
                mark4 text,
                mark5 text
            )";
 
    if ($conn->query($sql) === true) {
        echo "Table authorizationWBStatus created successfully";
    } else {
        echo "Table authorizationWBStatus created wrong: " . $conn->error;
    }
 
    $conn->close();
}

function createApiTable($servername, $username, $password, $dbname)
{    // 创建连接
    $conn = new mysqli($servername, $username, $password, $dbname);
    // 检测连接
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    }
     
    // 使用 sql 创建数据表
    $sql = "CREATE TABLE api (
    id INT AUTO_INCREMENT PRIMARY KEY, 
    switch VARCHAR(32) NOT NULL,
    lotteryID VARCHAR(32) NOT NULL,
    lotteryname VARCHAR(32) NOT NULL,
    link text NOT NULL,
    dir text NOT NULL,
    code text NOT NULL,
    strPlanName text NOT NULL,
    strPosition text NOT NULL,
    strQis text NOT NULL,
    strNumbers text NOT NULL,
    str_numbers_show text NOT NULL,
    maxPeriod text NOT NULL,
    intervalPeriod text NOT NULL,
    delayPeriod text NOT NULL,
    defaultPlanQi text NOT NULL,
    defaultPlanPosition text NOT NULL,
    defaultNumbers text NOT NULL,
    mark1 text,
    mark2 text,
    mark3 text,
    mark4 text,
    mark5 text
    )";
     
    if ($conn->query($sql) === true) {
        echo "Table api created successfully";
    } else {
        echo "Table api created wrong: " . $conn->error;
    }
     
    $conn->close();
};
function createShareIPTable($servername, $username, $password, $dbname)
{
    // 创建连接
    $conn = new mysqli($servername, $username, $password, $dbname);
    // 检测连接
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    }
 
    // 使用 sql 创建数据表
    $sql = "CREATE TABLE shareIP (
                id INT AUTO_INCREMENT PRIMARY KEY, 
                shareCode VARCHAR(32) NOT NULL,
                createIP VARCHAR(32) NOT NULL,
                createTime TIMESTAMP NOT NULL default CURRENT_TIMESTAMP,
                shareCount INT NOT NULL,
                shareExpired INT NOT NULL,
                mark1 text,
                mark2 text,
                mark3 text,
                mark4 text,
                mark5 text
            )";
 
    if ($conn->query($sql) === true) {
        echo "Table shareIP created successfully";
    } else {
        echo "Table shareIP created wrong: " . $conn->error;
    }
 
    $conn->close();
}
function createShareRegisterTable($servername, $username, $password, $dbname){
    // 创建连接
    $conn = new mysqli($servername, $username, $password, $dbname);
    // 检测连接
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    }
 
    // 使用 sql 创建数据表
    $sql = "CREATE TABLE shareRegister (
                id INT AUTO_INCREMENT PRIMARY KEY, 
                shareCode VARCHAR(32) NOT NULL,
                createIP VARCHAR(32) NOT NULL,
                createTime TIMESTAMP NOT NULL default CURRENT_TIMESTAMP,
                userID INT NOT NULL,
                mark1 text,
                mark2 text,
                mark3 text,
                mark4 text,
                mark5 text
            )";
 
    if ($conn->query($sql) === true) {
        echo "Table shareRegister created successfully";
    } else {
        echo "Table shareRegister created wrong: " . $conn->error;
    }
 
    $conn->close();
};
function createLogLoginTable($servername, $username, $password, $dbname){
    // 创建连接
    $conn = new mysqli($servername, $username, $password, $dbname);
    // 检测连接
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    }
 
    // 使用 sql 创建数据表
    $sql = "CREATE TABLE logLogin (
                id INT AUTO_INCREMENT PRIMARY KEY, 
                userID INT NOT NULL,
                loginTime TIMESTAMP NOT NULL default CURRENT_TIMESTAMP,
                loginIP VARCHAR(32) NOT NULL,
                loginLink text,
                fromLink text,
                loginToken text,
                loginTokenTime TIMESTAMP,
                mark1 text,
                mark2 text,
                mark3 text,
                mark4 text,
                mark5 text
            )";
 
    if ($conn->query($sql) === true) {
        echo "Table logLogin created successfully";
    } else {
        echo "Table logLogin created wrong: " . $conn->error;
    }
 
    $conn->close();
};
function createLogSubmitTable($servername, $username, $password, $dbname){
    // 创建连接
    $conn = new mysqli($servername, $username, $password, $dbname);
    // 检测连接
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    }
 
    // 使用 sql 创建数据表
    $sql = "CREATE TABLE logSubmit (
                id INT AUTO_INCREMENT PRIMARY KEY,
                creater INT NOT NULL,
                actor INT NOT NULL,
                form VARCHAR(32) NOT NULL,
                formKey VARCHAR(32) NOT NULL,
                formValue text,
                submitTime TIMESTAMP NOT NULL default CURRENT_TIMESTAMP,
                doneTime TIMESTAMP Null,
                result VARCHAR(32) NOT NULL,
                mark1 text,
                mark2 text,
                mark3 text,
                mark4 text,
                mark5 text
            )";
 
    if ($conn->query($sql) === true) {
        echo "Table logSubmit created successfully";
    } else {
        echo "Table logSubmit created wrong: " . $conn->error;
    }
 
    $conn->close();
};


