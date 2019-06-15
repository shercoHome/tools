<?php
date_default_timezone_set("Asia/Chongqing");
// id	唯一标识	0	自增，唯一			
// userID	代理账号	isNull	来自user表，即会员账号			必填
// siteLink	计划官网链接	isNull	一个链接对应到一个代理账号			必填
// siteName	计划官网名称	isNull				
// publicAuthorization	全局授权	0	不开启0	开启1		优先从上级获取
// shareRequiredIP	分享IP数要求	0	无要求0	其它数为具体要求，达到可开启授权		优先从上级获取
// shareRequiredUser	分享注册数要求	0	无要求0	其它数为具体要求，达到可开启授权		优先从上级获取
// shareLimiteTime	分享授权持续的时间	0	0永久，n 天	
// apiSelect	默认显示的彩种	0				
// defaultPlanID	默认显示的计划代码	0	按当前胜率第几名		优先从上级获取
// historyLimit	显示近N期的胜率	100  	n中几		
// leaderboardLimit	排行榜，显示n条	30	胜率最高的n条			
// historyPlanShowLimit	展示多少计划历史结果	10		 展示多少条历史数据			
// needAuthorize	需要授权的条件（彩种|胜率n-m期）	all|1-3	  所有彩种，当前胜率第1-3名的计划需要授权		
// stringUserTitle	设置用户头衔	普通|中级|高级|超级	以|分割			
// registerQQ	注册的QQ	0	隐藏不用填写0	选填1	必填2	优先从上级获取
// registerWechat	注册的微信	0	隐藏不用填写0	选填1	必填2	优先从上级获取
// registerPhone	注册的手机	0	隐藏不用填写0	选填1	必填2	优先从上级获取
// registerEmail	注册的邮箱	0	隐藏不用填写0	选填1	必填2	优先从上级获取
// loginKeep	用户登录的有效期	5	数值，单位分钟			优先从上级获取
// csQQ	客服的联系方式	isNull	1157733159|wx_1157733159.jpg|weixin://  多组以||分割			优先从上级获取
// csQQGroup	客服的联系方式	isNull	账号|图片路径|打开地址			优先从上级获取
// csWechat	客服的联系方式	isNull	账号|图片路径|打开地址			优先从上级获取
// csEmail	客服的联系方式	isNull	账号|图片路径|打开地址			优先从上级获取
// ezunLink	ezun官网注册链接	isNull	输入完整域名前缀，多个域名以|分割			优先从上级获取
// autoEzunLink	开启自动修改注册链接	0	不开启0，开启1			优先从上级获取
// hk49plan1	六合彩计划	isNull				优先从上级获取
// hk49plan2	六合彩计划	isNull				优先从上级获取
// hk49plan3	六合彩计划	isNull				优先从上级获取
// hk49plan4	六合彩计划	isNull				优先从上级获取
// hk49plan5	六合彩计划	isNull				优先从上级获取
// hk49PlanPoet	六合打油诗	isNull				优先从上级获取
// hk49PlanPicture	六合图	isNull				优先从上级获取
// outLinkName	一个外链名称	聊天室				优先从上级获取
// outLinkUrl	一个外链地址	isNull	有填写时，会启用，如http://ezun.yabomg.com			优先从上级获取
// baiduStatistics	百度统计的代码	isNull	5aae175363290255b62c0f8e066ef1cb			
// updateUserPsw	会员可否修改自己的密码	1				
// submitUpdateUserLevel	会员可否提交次级代理申请	1				
// updateUserQQ	会员可否修改自己的QQ	1				
// updateUserWechat	会员可否修改自己的邮箱	1				
// updateUserPhone	会员可否修改自己的微信	1				
// updateUserEmail	会员可否修改自己的手机	1				
// mark1	备注1	isNull				
// mark2	备注2	isNull				
// mark3	备注3	isNull				
// mark4	备注4	isNull				
// mark5	备注5	isNull				
// "----------------------代理A 发展了 代理B ，B 发展了代理C
// 1、代理账号及对应的代理链接是唯一的，其它设置选项在初始化时从直接上级代理获取
// 2、当代理试图修改某一设置时，需要先查询权限表是否处于可更改状态
// 3、当代理A修改了某一项设置，并且他的直接代理下线B无权限修改此设置时，代理B及其所有下线（递归）的设置会随之改变"															
class webSetting
{
    private $id;
    private $userID;
    private $siteLink;
    private $siteName;
    private $publicAuthorization;
    private $shareRequiredIP;
    private $shareRequiredUser;
    private $shareLimiteTime;
    private $apiSelect;
    private $defaultPlanID;
    private $historyLimit;
    private $leaderboardLimit;
    private $historyPlanShowLimit;
    private $needAuthorize;
    private $stringUserTitle;
    private $registerQQ;
    private $registerWechat;
    private $registerPhone;
    private $registerEmail;
    private $loginKeep;
    private $csQQ;
    private $csQQGroup;
    private $csWechat;
    private $csEmail;
    private $ezunLink;
    private $autoEzunLink;
    private $hk49plan1;
    private $hk49plan2;
    private $hk49plan3;
    private $hk49plan4;
    private $hk49plan5;
    private $hk49PlanPoet;
    private $hk49PlanPicture;
    private $outLinkName;
    private $outLinkUrl;
    private $baiduStatistics;
    private $updateUserPsw;
    private $submitUpdateUserLevel;
    private $updateUserQQ;
    private $updateUserWechat;
    private $updateUserPhone;
    private $updateUserEmail;
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
        $this->userID='isNull';//代理账号
        $this->siteLink='isNull';//计划官网链接
        $this->siteName='isNull';//计划官网名称
        $this->publicAuthorization='0';//全局授权
        $this->shareRequiredIP='0';//分享IP数要求
        $this->shareRequiredUser='0';//分享授权持续的时间 0永久，n 天
        $this->shareLimiteTime='0';//分享注册数要求
        $this->apiSelect='1';//默认显示的彩种
        $this->defaultPlanID='3';//默认显示的计划代码 按当前胜率第几名
        $this->historyLimit='100';//显示近N期的胜率
        $this->leaderboardLimit='30';//排行榜，显示n条
        $this->historyPlanShowLimit='10';//展示多少计划历史结果
        $this->needAuthorize='all|1-3';//需要授权的条件（彩种|胜率n-m期）	all|1-3	  所有彩种，当前胜率第1-3名的计划需要授权		
        $this->stringUserTitle='普通|中级|高级|超级';//设置用户头衔
        $this->registerQQ='0';//注册的QQ
        $this->registerWechat='0';//注册的微信
        $this->registerPhone='0';//注册的手机
        $this->registerEmail='0';//注册的邮箱
        $this->loginKeep='5';//用户登录的有效期 分钟
        $this->csQQ='isNull';//客服的联系方式
        $this->csQQGroup='isNull';//客服的联系方式
        $this->csWechat='isNull';//客服的联系方式
        $this->csEmail='isNull';//客服的联系方式
        $this->ezunLink='isNull';//ezun官网注册链接
        $this->autoEzunLink='0';//开启自动修改注册链接
        $this->hk49plan1='isNull';//六合彩计划
        $this->hk49plan2='isNull';//六合彩计划
        $this->hk49plan3='isNull';//六合彩计划
        $this->hk49plan4='isNull';//六合彩计划
        $this->hk49plan5='isNull';//六合彩计划
        $this->hk49PlanPoet='isNull';//六合打油诗
        $this->hk49PlanPicture='isNull';//六合图
        $this->outLinkName='聊天室';//一个外链名称
        $this->outLinkUrl='isNull';//一个外链地址
        $this->baiduStatistics='isNull';//百度统计的代码
        $this->updateUserPsw='1';//会员可否修改自己的密码
        $this->submitUpdateUserLevel='1';//会员可否提交次级代理申请
        $this->updateUserQQ='1';//会员可否修改自己的QQ
        $this->updateUserWechat='1';//会员可否修改自己的邮箱
        $this->updateUserPhone='1';//会员可否修改自己的微信
        $this->updateUserEmail='1';//会员可否修改自己的手机
        $this->mark1='isNull';//备注1
        $this->mark2='isNull';//备注2
        $this->mark3='isNull';//备注1
        $this->mark4='isNull';//备注1
        $this->mark5='isNull';//备注1
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
        if(array_key_exists('siteLink', $userinfo)) {$this->siteLink=$userinfo ['siteLink'];}
        if(array_key_exists('siteName', $userinfo)) {$this->siteName=$userinfo ['siteName'];}
        if(array_key_exists('publicAuthorization', $userinfo)) {$this->publicAuthorization=$userinfo ['publicAuthorization'];}
        if(array_key_exists('shareRequiredIP', $userinfo)) {$this->shareRequiredIP=$userinfo ['shareRequiredIP'];}
        if(array_key_exists('shareRequiredUser', $userinfo)) {$this->shareRequiredUser=$userinfo ['shareRequiredUser'];}
        if(array_key_exists('shareLimiteTime', $userinfo)) {$this->shareLimiteTime=$userinfo ['shareLimiteTime'];}
        if(array_key_exists('apiSelect', $userinfo)) {$this->apiSelect=$userinfo ['apiSelect'];}
        if(array_key_exists('defaultPlanID', $userinfo)) {$this->defaultPlanID=$userinfo ['defaultPlanID'];}
        if(array_key_exists('historyLimit', $userinfo)) {$this->historyLimit=$userinfo ['historyLimit'];}
        if(array_key_exists('leaderboardLimit', $userinfo)) {$this->leaderboardLimit=$userinfo ['leaderboardLimit'];}
        if(array_key_exists('historyPlanShowLimit', $userinfo)) {$this->historyPlanShowLimit=$userinfo ['historyPlanShowLimit'];}
        if(array_key_exists('needAuthorize', $userinfo)) {$this->needAuthorize=$userinfo ['needAuthorize'];}
        if(array_key_exists('stringUserTitle', $userinfo)) {$this->stringUserTitle=$userinfo ['stringUserTitle'];}
        if(array_key_exists('registerQQ', $userinfo)) {$this->registerQQ=$userinfo ['registerQQ'];}
        if(array_key_exists('registerWechat', $userinfo)) {$this->registerWechat=$userinfo ['registerWechat'];}
        if(array_key_exists('registerPhone', $userinfo)) {$this->registerPhone=$userinfo ['registerPhone'];}
        if(array_key_exists('registerEmail', $userinfo)) {$this->registerEmail=$userinfo ['registerEmail'];}
        if(array_key_exists('loginKeep', $userinfo)) {$this->loginKeep=$userinfo ['loginKeep'];}
        if(array_key_exists('csQQ', $userinfo)) {$this->csQQ=$userinfo ['csQQ'];}
        if(array_key_exists('csQQGroup', $userinfo)) {$this->csQQGroup=$userinfo ['csQQGroup'];}
        if(array_key_exists('csWechat', $userinfo)) {$this->csWechat=$userinfo ['csWechat'];}
        if(array_key_exists('csEmail', $userinfo)) {$this->csEmail=$userinfo ['csEmail'];}
        if(array_key_exists('ezunLink', $userinfo)) {$this->ezunLink=$userinfo ['ezunLink'];}
        if(array_key_exists('autoEzunLink', $userinfo)) {$this->autoEzunLink=$userinfo ['autoEzunLink'];}
        if(array_key_exists('hk49plan1', $userinfo)) {$this->hk49plan1=$userinfo ['hk49plan1'];}
        if(array_key_exists('hk49plan2', $userinfo)) {$this->hk49plan2=$userinfo ['hk49plan2'];}
        if(array_key_exists('hk49plan3', $userinfo)) {$this->hk49plan3=$userinfo ['hk49plan3'];}
        if(array_key_exists('hk49plan4', $userinfo)) {$this->hk49plan4=$userinfo ['hk49plan4'];}
        if(array_key_exists('hk49plan5', $userinfo)) {$this->hk49plan5=$userinfo ['hk49plan5'];}
        if(array_key_exists('hk49PlanPoet', $userinfo)) {$this->hk49PlanPoet=$userinfo ['hk49PlanPoet'];}
        if(array_key_exists('hk49PlanPicture', $userinfo)) {$this->hk49PlanPicture=$userinfo ['hk49PlanPicture'];}
        if(array_key_exists('outLinkName', $userinfo)) {$this->outLinkName=$userinfo ['outLinkName'];}
        if(array_key_exists('outLinkUrl', $userinfo)) {$this->outLinkUrl=$userinfo ['outLinkUrl'];}
        if(array_key_exists('baiduStatistics', $userinfo)) {$this->baiduStatistics=$userinfo ['baiduStatistics'];}
        if(array_key_exists('updateUserPsw', $userinfo)) {$this->updateUserPsw=$userinfo ['updateUserPsw'];}
        if(array_key_exists('submitUpdateUserLevel', $userinfo)) {$this->submitUpdateUserLevel=$userinfo ['submitUpdateUserLevel'];}
        if(array_key_exists('updateUserQQ', $userinfo)) {$this->updateUserQQ=$userinfo ['updateUserQQ'];}
        if(array_key_exists('updateUserWechat', $userinfo)) {$this->updateUserWechat=$userinfo ['updateUserWechat'];}
        if(array_key_exists('updateUserPhone', $userinfo)) {$this->updateUserPhone=$userinfo ['updateUserPhone'];}
        if(array_key_exists('updateUserEmail', $userinfo)) {$this->updateUserEmail=$userinfo ['updateUserEmail'];}
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
     
        $sql = "INSERT INTO webSetting (userID,siteLink,siteName,publicAuthorization,shareRequiredIP,shareRequiredUser,shareLimiteTime,apiSelect,defaultPlanID,historyLimit,leaderboardLimit,historyPlanShowLimit,needAuthorize,stringUserTitle,registerQQ,registerWechat,registerPhone,registerEmail,loginKeep,csQQ,csQQGroup,csWechat,csEmail,ezunLink,autoEzunLink,hk49plan1,hk49plan2,hk49plan3,hk49plan4,hk49plan5,hk49PlanPoet,hk49PlanPicture,outLinkName,outLinkUrl,baiduStatistics,updateUserPsw,submitUpdateUserLevel,updateUserQQ,updateUserWechat,updateUserPhone,updateUserEmail,mark1,mark2,mark3,mark4,mark5)
            VALUES ('$this->userID', '$this->siteLink', '$this->siteName', '$this->publicAuthorization', '$this->shareRequiredIP', '$this->shareRequiredUser','$this->shareLimiteTime', '$this->apiSelect', '$this->defaultPlanID', '$this->historyLimit', '$this->leaderboardLimit', '$this->historyPlanShowLimit', '$this->needAuthorize', '$this->stringUserTitle', '$this->registerQQ', '$this->registerWechat', '$this->registerPhone', '$this->registerEmail', '$this->loginKeep', '$this->csQQ', '$this->csQQGroup', '$this->csWechat', '$this->csEmail', '$this->ezunLink', '$this->autoEzunLink', '$this->hk49plan1', '$this->hk49plan2', '$this->hk49plan3', '$this->hk49plan4', '$this->hk49plan5', '$this->hk49PlanPoet', '$this->hk49PlanPicture', '$this->outLinkName', '$this->outLinkUrl', '$this->baiduStatistics', '$this->updateUserPsw', '$this->submitUpdateUserLevel', '$this->updateUserQQ', '$this->updateUserWechat', '$this->updateUserPhone', '$this->updateUserEmail', '$this->mark1', '$this->mark2', '$this->mark3', '$this->mark4', '$this->mark5')";
     
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
     * @param userinfo array('id'='',userID='');
     * @param n 输出几条数据
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

        $sql="SELECT  u.userName,a.* FROM webSetting a,user u WHERE a.userID=u.id ";

        if (array_key_exists("onleySiteLink", $userinfo)) { //用户账号
            $sql="SELECT DISTINCT siteLink FROM webSetting";
        }
        if (array_key_exists("userName", $userinfo)) { //用户账号
            $userName=$userinfo ["userName"]; 
            $sql="SELECT u.userName,a.*  FROM webSetting a,user u WHERE a.userID=u.id AND u.userName='$userName' ORDER BY a.userID";//ORDER BY a.id DESC ";  
        }
        if (array_key_exists("siteLink", $userinfo)) { //用户账号
            $this->siteLink=$userinfo ["siteLink"]; 
            $sql="SELECT u.userName,a.*  FROM webSetting a,user u WHERE a.userID=u.id AND a.siteLink LIKE '%$this->siteLink%' ORDER BY a.userID";//ORDER BY a.id DESC ";  
        }
        if (array_key_exists("userID", $userinfo)) { //用户账号
            $this->userID=$userinfo ["userID"]; 
            $sql="SELECT u.userName,a.*  FROM webSetting a,user u WHERE  a.userID=u.id AND (a.userID='$this->userID' OR u.agentDirect='$this->userID')  ORDER BY a.userID";  
        }
        if (array_key_exists("id", $userinfo)) { //用户id
            $this->id=$userinfo ["id"]; 
            $sql="SELECT u.userName,a.*  FROM webSetting a,user u WHERE  a.userID=u.id AND a.id='$this->id'  ORDER BY a.userID";
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
            $flag=array();
        }

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
        array_shift($infoOne);
        $infoOne["userID"]=$to;

        $toIsExist=$this->show(array("userID"=>$to));
        if($toIsExist==false){//空数组，或 false
            return $this->insert($infoOne);
        }else{
            return $this->update($infoOne);
        }
    }
    /**
     * update
     * @param  userinfo 键值对组成的关联array，会更新array内的指定id
     * @return Boolean false  失败，
     * @return Boolean true   成功，
     */
    public function update($userinfo=array())
    {

        $updateSqlArr=array();
        foreach ($userinfo as $key => $value) {
            $userinfo[$key] = trim($value); //去掉用户内容后面的空格.
            if($key!=="id" && $key!=="userID")array_push($updateSqlArr," ".$key."='".$value."' ");
        }
        $updateSqlStr=implode(",", $updateSqlArr);
        if(array_key_exists('id', $userinfo)) {$this->id=$userinfo ['id'];$updateSqlStr.="WHERE id='".$this->id."'";}
        if(array_key_exists('userID', $userinfo)) {$this->userID=$userinfo ['userID'];$updateSqlStr.="WHERE userID='".$this->userID."'";}
        $sql="UPDATE webSetting SET ".$updateSqlStr;

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
        $retval=mysqli_query($conn, "DELETE FROM webSetting WHERE id='$this->id'");
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
