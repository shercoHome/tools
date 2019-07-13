<?php
date_default_timezone_set("Asia/Chongqing");
// id	唯一标识	0				自增，唯一
// userID	账号标识	0				来自user表
// webSetting_siteLink	可否修改本站的链接	0	0	0	1	
// webSetting_siteConfig	可否修改本站的基本设置	0	0	1	1	
// webSetting_publicAuthorization	可否开关自己网站的授权	0	0	0	1	
// webSetting_shareRequiredIP	可否修改自己分享IP数要求	0	0	0	1	
// webSetting_shareRequiredUser	可否修改自己注册数要求	0	0	0	1	
// webSetting_shareLimiteTime	可否修改自己分享授权持续的时间	0	0	0	1	
// webSetting_apiSelect	可否修改默认显示的彩种	0	0	0	1	
// webSetting_defaultPlanID	可否修改自己默认显示的计划	0	0	0	1	
// webSetting_historyLimit	可否修改显示近N期的胜率	0	0	0	1	
// webSetting_leaderboardLimit	可否修改排行榜，显示n条	0	0	0	1	
// webSetting_historyPlanShowLimit	可否修改自己展示多少计划历史结果	0	0	0	1	
// webSetting_needAuthorize	可否修改自己需要授权的条件（彩种|胜率n-m期）	0	0	0	1	
// webSetting_stringUserTitle	可否修改自己的网站的用户头衔	0	0	0	1	
// webSetting_registerQQ	可否开关自己网站要注册要求QQ	1	1	1	1	
// webSetting_registerWechat	可否开关自己网站要注册要求微信	1	1	1	1	
// webSetting_registerPhone	可否开关自己网站要注册要求手机	1	1	1	1	
// webSetting_registerEmail	可否开关自己网站要注册要求邮箱	1	1	1	1	
// webSetting_loginKeep	可否修改本站登录的有效期	0	0	0	1	
// webSetting_csQQ	可否修改本站客服QQ	0	2	2	1	
// webSetting_csQQGroup	可否修改本站客服QQ群	0	2	2	1	
// webSetting_csWechat	可否修改本站客服微信	0	2	2	1	
// webSetting_csEmail	可否修改本站客服邮箱	0	2	2	1	
// webSetting_ezunLink	可否提交ezun官网注册链接	0	0	0	1	
// webSetting_autoEzunLink	可否自动通过提交ezun官网注册链接	0	0	0	1	
// webSetting_hk49plan1	可否修改六合彩计划	0	0	0	1	
// webSetting_hk49plan2	可否修改六合彩计划	0	0	0	1	
// webSetting_hk49plan3	可否修改六合彩计划	0	0	0	1	
// webSetting_hk49plan4	可否修改六合彩计划	0	0	0	1	
// webSetting_hk49plan5	可否修改六合彩计划	0	0	0	1	
// webSetting_hk49PlanPoet	可否修改打油诗	0	0	0	1	
// webSetting_hk49PlanPicture	可否上传六合彩图片	0	0	0	1	
// webSetting_outLinkName	可否修改外链名称（聊天室）	0	0	0	1	
// webSetting_bulletinShow	可否开关首页公告弹窗	0	0	0	1	
// webSetting_baiduStatistics	可否修改百度统计的代码	0	0	0	1	
// webSetting_updateUserPsw	可否修改_会员可否修改自己的密码	1	1	1	1	
// webSetting_submitUpdateUserLevel	可否修改_会员可否提交次级代理申请	1	1	1	1	
// webSetting_updateUserQQ	可否修改_会员可否修改自己的QQ	1	1	1	1	
// webSetting_updateUserWechat	可否修改_会员可否修改自己的邮箱	1	1	1	1	
// webSetting_updateUserPhone	可否修改_会员可否修改自己的微信	1	1	1	1	
// webSetting_updateUserEmail	可否修改_会员可否修改自己的手机	1	1	1	1	
// webSetting_mark1	可否修改备注1	0	0	0	1	
// webSetting_mark2	可否修改备注2	0	0	0	1	
// webSetting_mark3	可否修改备注3	0	0	0	1	
// webSetting_mark4	可否修改备注4	0	0	0	1	
// webSetting_mark5	可否修改备注5	0	0	0	1	
// user_userName	修改下级账号userName	0	0	0	1	
// user_userPsw	可否修改下级会员密码	0	0	0	1	
// user_userQQ	可否修改会员资料中的联系方式qq	0	0	0	1	
// user_userWechat	可否修改会员资料中的联系方式wechat	0	0	0	1	
// user_userPhone	可否修改会员资料中的联系方式phone	0	0	0	1	
// user_userEmail	可否修改会员资料中的联系方式email	0	0	0	1	
// user_verifyQQ	可否手动验证会员的联系方式qq	0	0	0	1	
// user_verifyWechat	可否手动验证会员的联系方式邮箱	0	0	0	1	
// user_verifyPhone	可否手动验证会员的联系方式微信	0	0	0	1	
// user_verifyEmail	可否手动验证会员的联系方式手机	0	0	0	1	
// create_user_3	可否新增会员（归到直接下级）	0	0	0	1	
// create_user_2	可否会员晋升代理（归到直接下级）	0	0	0	1	
// create_user_1	可否代理晋升总代（归到直接下级）	0	0	0	1	
// user_authorizationStatus	可否修改会员授权状态	0	2	2	1	写入、修改授权表
// show_all_user	可否逐级查询代理	0	0	1	1	
// user_agentStatus	可否修改下级代理密码	0	0	0	1	
// user_agentAdmin	可否修改会员的归属管理	0	0	0	1	
// user_agentTop	可否修改会员的归属总代	0	0	0	1	
// user_agentDirect	可否修改会员的归属代理	0	0	0	1	
// user_userActive	可否禁用下级会员	0	1	1	1	
// user_userTitle	可否修改会员头衔	0	2	2	1	
// mark1	备注1	0	0	0	1	
// mark2	备注2	0	0	0	1	
// mark3	备注3	0	0	0	1	
// mark4	备注4	0	0	0	1	
// mark5	备注5	0	0	0	1					
class adminLimit
{
    private $id;
    private $userID;
    private $webSetting_siteLink;
    private $webSetting_siteConfig;
    private $webSetting_publicAuthorization;
    private $webSetting_shareRequiredIP;
    private $webSetting_shareRequiredUser;
    private $webSetting_shareLimiteTime;
    private $webSetting_apiSelect;
    private $webSetting_defaultPlanID;
    private $webSetting_historyLimit;
    private $webSetting_leaderboardLimit;
    private $webSetting_historyPlanShowLimit;
    private $webSetting_needAuthorize;
    private $webSetting_stringUserTitle;
    private $webSetting_registerQQ;
    private $webSetting_registerWechat;
    private $webSetting_registerPhone;
    private $webSetting_registerEmail;
    private $webSetting_loginKeep;
    private $webSetting_csQQ;
    private $webSetting_csQQGroup;
    private $webSetting_csWechat;
    private $webSetting_csEmail;
    private $webSetting_ezunLink;
    private $webSetting_autoEzunLink;
    private $webSetting_hk49plan1;
    private $webSetting_hk49plan2;
    private $webSetting_hk49plan3;
    private $webSetting_hk49plan4;
    private $webSetting_hk49plan5;
    private $webSetting_hk49PlanPoet;
    private $webSetting_hk49PlanPicture;
    private $webSetting_outLinkName;
    private $webSetting_bulletinShow;
    private $webSetting_baiduStatistics;
    private $webSetting_updateUserPsw;
    private $webSetting_submitUpdateUserLevel;
    private $webSetting_updateUserQQ;
    private $webSetting_updateUserWechat;
    private $webSetting_updateUserPhone;
    private $webSetting_updateUserEmail;
    private $webSetting_mark1;
    private $webSetting_mark2;
    private $webSetting_mark3;
    private $webSetting_mark4;
    private $webSetting_mark5;
    private $user_userName;
    private $user_userPsw;
    private $user_userQQ;
    private $user_userWechat;
    private $user_userPhone;
    private $user_userEmail;
    private $user_verifyQQ;
    private $user_verifyWechat;
    private $user_verifyPhone;
    private $user_verifyEmail;
    private $create_user_3;
    private $create_user_2;
    private $create_user_1;
    private $user_authorizationStatus;
    private $show_all_user;
    private $user_agentStatus;
    private $user_agentAdmin;
    private $user_agentTop;
    private $user_agentDirect;
    private $user_userActive;
    private $user_userTitle;
    private $mark1;
    private $mark2;
    private $mark3;
    private $mark4;
    private $mark5;
    /////////////////////
    private $servername;
    private $username;
    private $password;
    private $dbname;

    private $common;

    public function __construct()
    {
        require 'sql.php';
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;

        require_once 'class.common.php';
        $this->common=new commonFun();
        
        $this->id='0';//唯一标识
        $this->userID='0';//账号标识
        $this->webSetting_siteLink='0';//可否修改本站的链接
        $this->webSetting_siteConfig='0';//可否修改本站的基本设置
        $this->webSetting_publicAuthorization='0';//可否开关自己网站的授权
        $this->webSetting_shareRequiredIP='0';//可否修改自己分享IP数要求
        $this->webSetting_shareRequiredUser='0';//可否修改自己注册数要求
        $this->webSetting_shareLimiteTime='0';//可否修改自己注册数要求
        $this->webSetting_apiSelect='0';//可否修改默认显示的彩种
        $this->webSetting_defaultPlanID='0';//可否修改自己默认显示的计划
        $this->webSetting_historyLimit='0';//可否修改显示近N期的胜率
        $this->webSetting_leaderboardLimit='0';//可否修改排行榜，显示n条
        $this->webSetting_historyPlanShowLimit='0';//可否修改自己展示多少计划历史结果
        $this->webSetting_needAuthorize='0';//可否修改自己需要授权的条件（彩种|胜率n-m期）
        $this->webSetting_stringUserTitle='0';//可否修改自己的网站的用户头衔
        $this->webSetting_registerQQ='1';//可否开关自己网站要注册要求QQ
        $this->webSetting_registerWechat='1';//可否开关自己网站要注册要求微信
        $this->webSetting_registerPhone='1';//可否开关自己网站要注册要求手机
        $this->webSetting_registerEmail='1';//可否开关自己网站要注册要求邮箱
        $this->webSetting_loginKeep='0';//可否修改本站登录的有效期
        $this->webSetting_csQQ='0';//可否修改本站客服QQ
        $this->webSetting_csQQGroup='0';//可否修改本站客服QQ群
        $this->webSetting_csWechat='0';//可否修改本站客服微信
        $this->webSetting_csEmail='0';//可否修改本站客服邮箱
        $this->webSetting_ezunLink='0';//可否提交ezun官网注册链接
        $this->webSetting_autoEzunLink='0';//可否自动通过提交ezun官网注册链接
        $this->webSetting_hk49plan1='0';//可否修改六合彩计划
        $this->webSetting_hk49plan2='0';//可否修改六合彩计划
        $this->webSetting_hk49plan3='0';//可否修改六合彩计划
        $this->webSetting_hk49plan4='0';//可否修改六合彩计划
        $this->webSetting_hk49plan5='0';//可否修改六合彩计划
        $this->webSetting_hk49PlanPoet='0';//可否修改打油诗
        $this->webSetting_hk49PlanPicture='0';//可否上传六合彩图片
        $this->webSetting_outLinkName='0';//可否修改外链名称（聊天室）
        $this->webSetting_bulletinShow='0';//可否开关首页公告弹窗
        $this->webSetting_baiduStatistics='0';//可否修改百度统计的代码
        $this->webSetting_updateUserPsw='1';//可否修改_会员可否修改自己的密码
        $this->webSetting_submitUpdateUserLevel='1';//可否修改_会员可否提交次级代理申请
        $this->webSetting_updateUserQQ='1';//可否修改_会员可否修改自己的QQ
        $this->webSetting_updateUserWechat='1';//可否修改_会员可否修改自己的邮箱
        $this->webSetting_updateUserPhone='1';//可否修改_会员可否修改自己的微信
        $this->webSetting_updateUserEmail='1';//可否修改_会员可否修改自己的手机
        $this->webSetting_mark1='0';//可否修改备注1
        $this->webSetting_mark2='0';//可否修改备注2
        $this->webSetting_mark3='0';//可否修改备注3
        $this->webSetting_mark4='0';//可否修改备注4
        $this->webSetting_mark5='0';//可否修改备注5
        $this->user_userName='0';//修改下级账号userName
        $this->user_userPsw='0';//可否修改下级会员密码
        $this->user_userQQ='0';//可否修改会员资料中的联系方式qq
        $this->user_userWechat='0';//可否修改会员资料中的联系方式wechat
        $this->user_userPhone='0';//可否修改会员资料中的联系方式phone
        $this->user_userEmail='0';//可否修改会员资料中的联系方式email
        $this->user_verifyQQ='0';//可否手动验证会员的联系方式qq
        $this->user_verifyWechat='0';//可否手动验证会员的联系方式邮箱
        $this->user_verifyPhone='0';//可否手动验证会员的联系方式微信
        $this->user_verifyEmail='0';//可否手动验证会员的联系方式手机
        $this->create_user_3='0';//可否新增会员（归到直接下级）
        $this->create_user_2='0';//可否会员晋升代理（归到直接下级）
        $this->create_user_1='0';//可否代理晋升总代（归到直接下级）
        $this->user_authorizationStatus='0';//可否修改会员授权状态
        $this->show_all_user='0';//可否逐级查询代理
        $this->user_agentStatus='0';//可否修改下级代理密码
        $this->user_agentAdmin='0';//可否修改会员的归属管理
        $this->user_agentTop='0';//可否修改会员的归属总代
        $this->user_agentDirect='0';//可否修改会员的归属代理
        $this->user_userActive='0';//可否禁用下级会员
        $this->user_userTitle='0';//可否修改会员头衔
        $this->mark1='0';//备注1
        $this->mark2='0';//备注2
        $this->mark3='0';//备注3
        $this->mark4='0';//备注4
        $this->mark5='0';//备注5
    }
    /**
     * 插入新的用户
     * @param userinfo array('userID'='',a=''...);
     * @return Boolean false  失败，ip已存在
     * @return String  错误信息  失败
     * @return Boolean true    成功
     */
    public function insert($userinfo)
    {
        foreach ($userinfo as $key => $value) {
            $userinfo[$key] = trim($value); //去掉用户内容后面的空格.
        }
        if(array_key_exists('userID', $userinfo)) {$this->userID=$userinfo ['userID'];}
        if(array_key_exists('webSetting_siteLink', $userinfo)) {$this->webSetting_siteLink=$userinfo ['webSetting_siteLink'];}
        if(array_key_exists('webSetting_siteConfig', $userinfo)) {$this->webSetting_siteConfig=$userinfo ['webSetting_siteConfig'];}
        if(array_key_exists('webSetting_publicAuthorization', $userinfo)) {$this->webSetting_publicAuthorization=$userinfo ['webSetting_publicAuthorization'];}
        if(array_key_exists('webSetting_shareRequiredIP', $userinfo)) {$this->webSetting_shareRequiredIP=$userinfo ['webSetting_shareRequiredIP'];}
        if(array_key_exists('webSetting_shareRequiredUser', $userinfo)) {$this->webSetting_shareRequiredUser=$userinfo ['webSetting_shareRequiredUser'];}
        if(array_key_exists('webSetting_shareLimiteTime', $userinfo)) {$this->webSetting_shareLimiteTime=$userinfo ['webSetting_shareLimiteTime'];}
        if(array_key_exists('webSetting_apiSelect', $userinfo)) {$this->webSetting_apiSelect=$userinfo ['webSetting_apiSelect'];}
        if(array_key_exists('webSetting_defaultPlanID', $userinfo)) {$this->webSetting_defaultPlanID=$userinfo ['webSetting_defaultPlanID'];}
        if(array_key_exists('webSetting_historyLimit', $userinfo)) {$this->webSetting_historyLimit=$userinfo ['webSetting_historyLimit'];}
        if(array_key_exists('webSetting_leaderboardLimit', $userinfo)) {$this->webSetting_leaderboardLimit=$userinfo ['webSetting_leaderboardLimit'];}
        if(array_key_exists('webSetting_historyPlanShowLimit', $userinfo)) {$this->webSetting_historyPlanShowLimit=$userinfo ['webSetting_historyPlanShowLimit'];}
        if(array_key_exists('webSetting_needAuthorize', $userinfo)) {$this->webSetting_needAuthorize=$userinfo ['webSetting_needAuthorize'];}
        if(array_key_exists('webSetting_stringUserTitle', $userinfo)) {$this->webSetting_stringUserTitle=$userinfo ['webSetting_stringUserTitle'];}
        if(array_key_exists('webSetting_registerQQ', $userinfo)) {$this->webSetting_registerQQ=$userinfo ['webSetting_registerQQ'];}
        if(array_key_exists('webSetting_registerWechat', $userinfo)) {$this->webSetting_registerWechat=$userinfo ['webSetting_registerWechat'];}
        if(array_key_exists('webSetting_registerPhone', $userinfo)) {$this->webSetting_registerPhone=$userinfo ['webSetting_registerPhone'];}
        if(array_key_exists('webSetting_registerEmail', $userinfo)) {$this->webSetting_registerEmail=$userinfo ['webSetting_registerEmail'];}
        if(array_key_exists('webSetting_loginKeep', $userinfo)) {$this->webSetting_loginKeep=$userinfo ['webSetting_loginKeep'];}
        if(array_key_exists('webSetting_csQQ', $userinfo)) {$this->webSetting_csQQ=$userinfo ['webSetting_csQQ'];}
        if(array_key_exists('webSetting_csQQGroup', $userinfo)) {$this->webSetting_csQQGroup=$userinfo ['webSetting_csQQGroup'];}
        if(array_key_exists('webSetting_csWechat', $userinfo)) {$this->webSetting_csWechat=$userinfo ['webSetting_csWechat'];}
        if(array_key_exists('webSetting_csEmail', $userinfo)) {$this->webSetting_csEmail=$userinfo ['webSetting_csEmail'];}
        if(array_key_exists('webSetting_ezunLink', $userinfo)) {$this->webSetting_ezunLink=$userinfo ['webSetting_ezunLink'];}
        if(array_key_exists('webSetting_autoEzunLink', $userinfo)) {$this->webSetting_autoEzunLink=$userinfo ['webSetting_autoEzunLink'];}
        if(array_key_exists('webSetting_hk49plan1', $userinfo)) {$this->webSetting_hk49plan1=$userinfo ['webSetting_hk49plan1'];}
        if(array_key_exists('webSetting_hk49plan2', $userinfo)) {$this->webSetting_hk49plan2=$userinfo ['webSetting_hk49plan2'];}
        if(array_key_exists('webSetting_hk49plan3', $userinfo)) {$this->webSetting_hk49plan3=$userinfo ['webSetting_hk49plan3'];}
        if(array_key_exists('webSetting_hk49plan4', $userinfo)) {$this->webSetting_hk49plan4=$userinfo ['webSetting_hk49plan4'];}
        if(array_key_exists('webSetting_hk49plan5', $userinfo)) {$this->webSetting_hk49plan5=$userinfo ['webSetting_hk49plan5'];}
        if(array_key_exists('webSetting_hk49PlanPoet', $userinfo)) {$this->webSetting_hk49PlanPoet=$userinfo ['webSetting_hk49PlanPoet'];}
        if(array_key_exists('webSetting_hk49PlanPicture', $userinfo)) {$this->webSetting_hk49PlanPicture=$userinfo ['webSetting_hk49PlanPicture'];}
        if(array_key_exists('webSetting_outLinkName', $userinfo)) {$this->webSetting_outLinkName=$userinfo ['webSetting_outLinkName'];}
        if(array_key_exists('webSetting_bulletinShow', $userinfo)) {$this->webSetting_bulletinShow=$userinfo ['webSetting_bulletinShow'];}
        if(array_key_exists('webSetting_baiduStatistics', $userinfo)) {$this->webSetting_baiduStatistics=$userinfo ['webSetting_baiduStatistics'];}
        if(array_key_exists('webSetting_updateUserPsw', $userinfo)) {$this->webSetting_updateUserPsw=$userinfo ['webSetting_updateUserPsw'];}
        if(array_key_exists('webSetting_submitUpdateUserLevel', $userinfo)) {$this->webSetting_submitUpdateUserLevel=$userinfo ['webSetting_submitUpdateUserLevel'];}
        if(array_key_exists('webSetting_updateUserQQ', $userinfo)) {$this->webSetting_updateUserQQ=$userinfo ['webSetting_updateUserQQ'];}
        if(array_key_exists('webSetting_updateUserWechat', $userinfo)) {$this->webSetting_updateUserWechat=$userinfo ['webSetting_updateUserWechat'];}
        if(array_key_exists('webSetting_updateUserPhone', $userinfo)) {$this->webSetting_updateUserPhone=$userinfo ['webSetting_updateUserPhone'];}
        if(array_key_exists('webSetting_updateUserEmail', $userinfo)) {$this->webSetting_updateUserEmail=$userinfo ['webSetting_updateUserEmail'];}
        if(array_key_exists('webSetting_mark1', $userinfo)) {$this->webSetting_mark1=$userinfo ['webSetting_mark1'];}
        if(array_key_exists('webSetting_mark2', $userinfo)) {$this->webSetting_mark2=$userinfo ['webSetting_mark2'];}
        if(array_key_exists('webSetting_mark3', $userinfo)) {$this->webSetting_mark3=$userinfo ['webSetting_mark3'];}
        if(array_key_exists('webSetting_mark4', $userinfo)) {$this->webSetting_mark4=$userinfo ['webSetting_mark4'];}
        if(array_key_exists('webSetting_mark5', $userinfo)) {$this->webSetting_mark5=$userinfo ['webSetting_mark5'];}
        if(array_key_exists('user_userName', $userinfo)) {$this->user_userName=$userinfo ['user_userName'];}
        if(array_key_exists('user_userPsw', $userinfo)) {$this->user_userPsw=$userinfo ['user_userPsw'];}
        if(array_key_exists('user_userQQ', $userinfo)) {$this->user_userQQ=$userinfo ['user_userQQ'];}
        if(array_key_exists('user_userWechat', $userinfo)) {$this->user_userWechat=$userinfo ['user_userWechat'];}
        if(array_key_exists('user_userPhone', $userinfo)) {$this->user_userPhone=$userinfo ['user_userPhone'];}
        if(array_key_exists('user_userEmail', $userinfo)) {$this->user_userEmail=$userinfo ['user_userEmail'];}
        if(array_key_exists('user_verifyQQ', $userinfo)) {$this->user_verifyQQ=$userinfo ['user_verifyQQ'];}
        if(array_key_exists('user_verifyWechat', $userinfo)) {$this->user_verifyWechat=$userinfo ['user_verifyWechat'];}
        if(array_key_exists('user_verifyPhone', $userinfo)) {$this->user_verifyPhone=$userinfo ['user_verifyPhone'];}
        if(array_key_exists('user_verifyEmail', $userinfo)) {$this->user_verifyEmail=$userinfo ['user_verifyEmail'];}
        if(array_key_exists('create_user_3', $userinfo)) {$this->create_user_3=$userinfo ['create_user_3'];}
        if(array_key_exists('create_user_2', $userinfo)) {$this->create_user_2=$userinfo ['create_user_2'];}
        if(array_key_exists('create_user_1', $userinfo)) {$this->create_user_1=$userinfo ['create_user_1'];}
        if(array_key_exists('user_authorizationStatus', $userinfo)) {$this->user_authorizationStatus=$userinfo ['user_authorizationStatus'];}
        if(array_key_exists('show_all_user', $userinfo)) {$this->show_all_user=$userinfo ['show_all_user'];}
        if(array_key_exists('user_agentStatus', $userinfo)) {$this->user_agentStatus=$userinfo ['user_agentStatus'];}
        if(array_key_exists('user_agentAdmin', $userinfo)) {$this->user_agentAdmin=$userinfo ['user_agentAdmin'];}
        if(array_key_exists('user_agentTop', $userinfo)) {$this->user_agentTop=$userinfo ['user_agentTop'];}
        if(array_key_exists('user_agentDirect', $userinfo)) {$this->user_agentDirect=$userinfo ['user_agentDirect'];}
        if(array_key_exists('user_userActive', $userinfo)) {$this->user_userActive=$userinfo ['user_userActive'];}
        if(array_key_exists('user_userTitle', $userinfo)) {$this->user_userTitle=$userinfo ['user_userTitle'];}
        if(array_key_exists('mark1', $userinfo)) {$this->mark1=$userinfo ['mark1'];}
        if(array_key_exists('mark2', $userinfo)) {$this->mark2=$userinfo ['mark2'];}
        if(array_key_exists('mark3', $userinfo)) {$this->mark3=$userinfo ['mark3'];}
        if(array_key_exists('mark4', $userinfo)) {$this->mark4=$userinfo ['mark4'];}
        if(array_key_exists('mark5', $userinfo)) {$this->mark5=$userinfo ['mark5'];}
        $flag=false;
        // 创建连接
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // 检测连接
        if ($conn->connect_error) {
            die("connect_error: " . $conn->connect_error);
            return $flag;
        }
     
        $sql = "INSERT INTO adminLimit (userID,webSetting_siteLink,webSetting_siteConfig,webSetting_publicAuthorization,webSetting_shareRequiredIP,webSetting_shareRequiredUser,webSetting_shareLimiteTime,webSetting_apiSelect,webSetting_defaultPlanID,webSetting_historyLimit,webSetting_leaderboardLimit,webSetting_historyPlanShowLimit,webSetting_needAuthorize,webSetting_stringUserTitle,webSetting_registerQQ,webSetting_registerWechat,webSetting_registerPhone,webSetting_registerEmail,webSetting_loginKeep,webSetting_csQQ,webSetting_csQQGroup,webSetting_csWechat,webSetting_csEmail,webSetting_ezunLink,webSetting_autoEzunLink,webSetting_hk49plan1,webSetting_hk49plan2,webSetting_hk49plan3,webSetting_hk49plan4,webSetting_hk49plan5,webSetting_hk49PlanPoet,webSetting_hk49PlanPicture,webSetting_outLinkName,webSetting_bulletinShow,webSetting_baiduStatistics,webSetting_updateUserPsw,webSetting_submitUpdateUserLevel,webSetting_updateUserQQ,webSetting_updateUserWechat,webSetting_updateUserPhone,webSetting_updateUserEmail,webSetting_mark1,webSetting_mark2,webSetting_mark3,webSetting_mark4,webSetting_mark5,user_userName,user_userPsw,user_userQQ,user_userWechat,user_userPhone,user_userEmail,user_verifyQQ,user_verifyWechat,user_verifyPhone,user_verifyEmail,create_user_3,create_user_2,create_user_1,user_authorizationStatus,show_all_user,user_agentStatus,user_agentAdmin,user_agentTop,user_agentDirect,user_userActive,user_userTitle,mark1,mark2,mark3,mark4,mark5)
            VALUES ('$this->userID', '$this->webSetting_siteLink', '$this->webSetting_siteConfig', '$this->webSetting_publicAuthorization', '$this->webSetting_shareRequiredIP', '$this->webSetting_shareRequiredUser','$this->webSetting_shareLimiteTime', '$this->webSetting_apiSelect', '$this->webSetting_defaultPlanID', '$this->webSetting_historyLimit', '$this->webSetting_leaderboardLimit', '$this->webSetting_historyPlanShowLimit', '$this->webSetting_needAuthorize', '$this->webSetting_stringUserTitle', '$this->webSetting_registerQQ', '$this->webSetting_registerWechat', '$this->webSetting_registerPhone', '$this->webSetting_registerEmail', '$this->webSetting_loginKeep', '$this->webSetting_csQQ', '$this->webSetting_csQQGroup', '$this->webSetting_csWechat', '$this->webSetting_csEmail', '$this->webSetting_ezunLink', '$this->webSetting_autoEzunLink', '$this->webSetting_hk49plan1', '$this->webSetting_hk49plan2', '$this->webSetting_hk49plan3', '$this->webSetting_hk49plan4', '$this->webSetting_hk49plan5', '$this->webSetting_hk49PlanPoet', '$this->webSetting_hk49PlanPicture', '$this->webSetting_outLinkName', '$this->webSetting_bulletinShow', '$this->webSetting_baiduStatistics','$this->webSetting_updateUserPsw','$this->webSetting_submitUpdateUserLevel','$this->webSetting_updateUserQQ','$this->webSetting_updateUserWechat','$this->webSetting_updateUserPhone','$this->webSetting_updateUserEmail', '$this->webSetting_mark1', '$this->webSetting_mark2', '$this->webSetting_mark3', '$this->webSetting_mark4', '$this->webSetting_mark5', '$this->user_userName', '$this->user_userPsw', '$this->user_userQQ', '$this->user_userWechat', '$this->user_userPhone', '$this->user_userEmail', '$this->user_verifyQQ', '$this->user_verifyWechat', '$this->user_verifyPhone', '$this->user_verifyEmail', '$this->create_user_3', '$this->create_user_2', '$this->create_user_1', '$this->user_authorizationStatus', '$this->show_all_user', '$this->user_agentStatus', '$this->user_agentAdmin', '$this->user_agentTop', '$this->user_agentDirect', '$this->user_userActive', '$this->user_userTitle', '$this->mark1', '$this->mark2', '$this->mark3', '$this->mark4', '$this->mark5')";
     
        $result = mysqli_query($conn, $sql);
        if ($result=== true) {
            $this->id=mysqli_insert_id($conn);
            // $this->createShareCode();
            // $this->update("shareCode", $this->shareCode);
            // if ($this->creater==='userID') {
            //     $this->creater=$this->id;
            //     $this->update("creater", $this->creater);
            // }
            $flag=true;
        } else {
            die("INSERT_Error: " . $sql . "<br>" . $conn->error);
            return $flag;
        }
            
        $conn->close();
            
        return $flag;
    }
 

    /**
     * 查询并显示内容
     * @param userinfo array('id'='',userID=''，n='');
     * @return Boolean false 失败
     * @return Array  信息   成功
     */
    public function show($userinfo=array())
    {
        foreach ($userinfo as $key => $value) {
            $userinfo[$key] = trim($value); //去掉用户内容后面的空格.
        }
        $flag=false;
        // 创建连接
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // 检测连接
        if ($conn->connect_error) {
            die("connect_error: " . $conn->connect_error);
            return $flag;
        }

        $sql="SELECT  u.userName,a.* FROM adminlimit a,user u WHERE a.userID=u.id ";

        if (array_key_exists("userID", $userinfo)) { //用户id
            $this->userID=$userinfo ["userID"]; 
            $sql="SELECT  a.*,u.userName FROM adminlimit a,user u WHERE a.userID=u.id AND a.userID='$this->userID' ";  
        }
        if (array_key_exists("id", $userinfo)) { //权限表id
            $this->id=$userinfo ["id"]; 
            $sql="SELECT a.*,u.userName FROM adminlimit a,user u WHERE a.userID=u.id AND a.id='$this->id' ";
        }
        if (array_key_exists("userName", $userinfo)) { //用户账号
            $userName=$userinfo ["userName"]; 
            $sql="SELECT a.*,u.userName FROM adminlimit a,user u WHERE a.userID=u.id AND u.userName='$userName' ";
        }

        if (array_key_exists("n", $userinfo)) { 
            $page=1;
            if (array_key_exists("page", $userinfo)) { 
                $page = $userinfo ["page"]; 
            }
            $n=$userinfo ["n"]; 
            $m = ($page - 1) * $n;
            $sql .= " limit $m, $n";

        }

        $result = mysqli_query($conn, $sql);

        if ($result===false) {
            return $flag;
        }
        if ($result->num_rows > 0) {
            // 输出数据
            $arr=array();
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($arr, $row);
            }
            $flag= $arr;
        } else {
            $flag=false;
        }

        $conn->close();
        return $flag;
    }

    /**
     * update
     * @param  id	唯一标识	0	自增，唯一	其它表中的userID
     * @param  key	修改哪个字段
     * @param  value	修改成什么
     * @return Boolean false  失败，
     * @return Boolean true   成功，
     */
    public function update($userinfo=array())
    {
        $updateSqlArr=array();
        foreach ($userinfo as $key => $value) {
            $userinfo[$key] = trim($value); //去掉用户内容后面的空格.
            if($key!=="id" && $key!=="userID" && $key!=="userName")array_push($updateSqlArr," a.".$key."='".$value."' ");
        }
        $updateSqlStr=implode(",", $updateSqlArr);

        if(array_key_exists('id', $userinfo)) {
            $this->id=$userinfo ['id'];
            $updateSqlStr.="WHERE a.id='".$this->id."'";
        }
        if(array_key_exists('userID', $userinfo)) {
            $this->userID=$userinfo ['userID'];
            if($this->userID=='1'){
                $updateSqlStr.="WHERE a.userID=u.id AND u.agentAdmin='0'";
            }elseif($this->userID=='2'){
                $updateSqlStr.="WHERE a.userID=u.id AND u.userLevel='1' AND u.agentAdmin<>'0'";
            }elseif($this->userID=='3'){
                $updateSqlStr.="WHERE a.userID=u.id AND u.userLevel='2' ";
            }else{
                $updateSqlStr.="WHERE a.userID='".$this->userID."'";
            }
        }
        $sql="UPDATE adminlimit a, user u SET ".$updateSqlStr;

        $flag=false;
        // 创建连接
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // 检测连接
        if ($conn->connect_error) {
            die("connect_error: " . $conn->connect_error);
            return $flag;
        }
        $flag = mysqli_query($conn, $sql);

        $conn->close();
        return $flag;
    }
    /**
     * 复制设置
     * @param  from 从谁复制 userID
     * @param  to	        userID
     * @return Boolean false  失败，
     * @return Boolean true   成功，
     */
    function copy($from,$to){
        $info=$this->show(array("userID"=>$from));
        $infoOne=$info[0];
        array_shift($infoOne);
        $infoOne["userID"]=$to;
        if($this->show(array("userID"=>$to))===false){
            return $this->insert($infoOne);
        }else{
            return $this->update($infoOne);
        }
    }
    /**
     * delete
     * @param  id
     * @return Boolean false  失败，
     * @return Boolean true   成功，
     */
    public function delete($id)
    {
        $flag=false;

        $this->id=$id;
        // 创建连接
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // 检测连接
        if ($conn->connect_error) {
            die("connect_error: " . $conn->connect_error);
            return $flag;
        }
        $retval=mysqli_query($conn, "DELETE FROM adminLimit WHERE id='$this->id'");
        if (! $retval) {
            die('DELETE_ERR: ' . mysqli_error($conn));
            $flag=false;
        } else {
            $flag=true;
        }
        $conn->close();
        return $flag;
    }
    public function __destruct()
    {
    }
}
