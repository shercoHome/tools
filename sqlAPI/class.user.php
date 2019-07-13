<?php
date_default_timezone_set("Asia/Chongqing");
// id	唯一标识	0	自增，唯一	其它表中的userID
// userName	会员账号	zhangsan123	字母+数字+下划线		/^[a-zA-Z0-9_]{6,15}
// userPsw	会员密码	123qwe	md5加密，加盐createPassWord
// userQQ	联系QQ	isNull
// userWechat	联系微信	isNull
// userPhone	联系电话	isNull
// userEmail	联系邮箱	isNull
// verifyQQ	验证QQ	0	未验证0	已验证1
// verifyWechat	验证邮箱	0
// verifyPhone	验证微信	0
// verifyEmail	验证手机	0
// registerTime	注册时间	isNull
// registerIP	注册IP	isNull
// shareCode	分享码	id	share加上userID	组成分享链接
// authorizationStatus	授权状态	0	未授权0	已授权1	待授权2	特别授权3
// authorizationTime	授权时间	isNull	变更授权状态时修改
// userLevel	层级	3	总代1	次代2	会员3
// agentStatus	代理状态	0	不是代理0	是代理1	待审核2
// agentAdmin	归属管理	isNull	管理员（一般是总代）
// agentTop	归属总代	isNull	域名总代
// agentDirect	归属代理	isNull	直接上级代理
// userActive	会员状态	1	禁用0	正常1
// creater	注册人	userID	会员自己，或某管理员
// userTitle	用户头衔	1	1为普通,2,3,4,5....
// mark1	备注1	isNull
// mark2	备注1	isNull
// mark3	备注1	isNull
// mark4	备注1	isNull
// mark5	备注1	isNull
class user
{
    private $id;
    private $userName;
    private $userPsw;
    private $userQQ;
    private $userWechat;
    private $userPhone;
    private $userEmail;
    private $verifyQQ;
    private $verifyWechat;
    private $verifyPhone;
    private $verifyEmail;
    private $registerTime;
    private $registerIP;
    private $shareCode;
    private $authorizationStatus;
    private $authorizationTime;
    private $userLevel;
    private $agentStatus;
    private $agentAdmin;
    private $agentTop;
    private $agentDirect;
    private $userActive;
    private $creater;
    private $userTitle;
    private $fromLink;
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
        
        $this->id='0';//自增，唯一
        $this->userName='zhangsan123';//字母+数字+下划线
        $this->userPsw='7482e91c0b04c5fcd286f800e66d1aa9';//md5加密，加盐createPassWord ,默认123456
        $this->userQQ='isNull';//
        $this->userWechat='isNull';//
        $this->userPhone='isNull';//
        $this->userEmail='isNull';//
        $this->verifyQQ='0';//未验证0
        $this->verifyWechat='0';//
        $this->verifyPhone='0';//
        $this->verifyEmail='0';//
        $this->registerTime='isNull';//自动
        $this->registerIP=$this->common->getIp();
        $this->shareCode='1';//以userid加密
        $this->authorizationStatus='0';//未授权0
        $this->authorizationTime='0000-00-00 00:00:00';//变更授权状态时修改
        $this->userLevel='3';//总代1
        $this->agentStatus='0';//不是代理0
        $this->agentAdmin='isNull';//管理员（一般是总代）
        $this->agentTop='isNull';//域名总代
        $this->agentDirect='isNull';//直接上级代理
        $this->userActive='1';//禁用0
        $this->creater='self';//会员自己，或某管理员
        $this->userTitle='1';//1为普通,2,3,4,5....
        $this->fromLink='直接输入网址';//
        $this->mark1='isNull';//
        $this->mark2='isNull';//
        $this->mark3='isNull';//
        $this->mark4='isNull';//
        $this->mark5='isNull';//
    }
    /**
     * 插入新的用户
     * @param userinfo array('userID'='',a=''...);
     * @return Boolean false  失败，ip已存在
     * @return String  错误信息  失败
     * @return String  返回id    成功
     */
    public function insert($userinfo)
    {
        foreach ($userinfo as $key => $value) {
            $userinfo[$key] = trim($value); //去掉用户内容后面的空格.
        }
        if (array_key_exists('id', $userinfo)) {
            $this->id=$userinfo ['id'];
        }
        if (array_key_exists('userName', $userinfo)) {
            $this->userName=$userinfo ['userName'];
        }
        if (array_key_exists('userPsw', $userinfo)) {
            $this->userPsw=$this->createPassWord($userinfo ['userPsw']);
        }
        if (array_key_exists('userQQ', $userinfo)) {
            $this->userQQ=$userinfo ['userQQ'];
        }
        if (array_key_exists('userWechat', $userinfo)) {
            $this->userWechat=$userinfo ['userWechat'];
        }
        if (array_key_exists('userPhone', $userinfo)) {
            $this->userPhone=$userinfo ['userPhone'];
        }
        if (array_key_exists('userEmail', $userinfo)) {
            $this->userEmail=$userinfo ['userEmail'];
        }
        if (array_key_exists('verifyQQ', $userinfo)) {
            $this->verifyQQ=$userinfo ['verifyQQ'];
        }
        if (array_key_exists('verifyWechat', $userinfo)) {
            $this->verifyWechat=$userinfo ['verifyWechat'];
        }
        if (array_key_exists('verifyPhone', $userinfo)) {
            $this->verifyPhone=$userinfo ['verifyPhone'];
        }
        if (array_key_exists('verifyEmail', $userinfo)) {
            $this->verifyEmail=$userinfo ['verifyEmail'];
        }
        if (array_key_exists('registerTime', $userinfo)) {
            $this->registerTime=$userinfo ['registerTime'];
        }
        if (array_key_exists('registerIP', $userinfo)) {
            $this->registerIP=$userinfo ['registerIP'];
        }
        if (array_key_exists('shareCode', $userinfo)) {
            $this->shareCode=$userinfo ['shareCode'];
        }
        if (array_key_exists('authorizationStatus', $userinfo)) {
            $this->authorizationStatus=$userinfo ['authorizationStatus'];
        }
        if (array_key_exists('authorizationTime', $userinfo)) {
            $this->authorizationTime=$userinfo ['authorizationTime'];
        }
        if (array_key_exists('userLevel', $userinfo)) {
            $this->userLevel=$userinfo ['userLevel'];
        }
        if (array_key_exists('agentStatus', $userinfo)) {
            $this->agentStatus=$userinfo ['agentStatus'];
        }
        if (array_key_exists('agentAdmin', $userinfo)) {
            $this->agentAdmin=$userinfo ['agentAdmin'];
        }
        if (array_key_exists('agentTop', $userinfo)) {
            $this->agentTop=$userinfo ['agentTop'];
        }
        if (array_key_exists('agentDirect', $userinfo)) {
            $this->agentDirect=$userinfo ['agentDirect'];
        }
        if (array_key_exists('userActive', $userinfo)) {
            $this->userActive=$userinfo ['userActive'];
        }
        if (array_key_exists('creater', $userinfo)) {
            $this->creater=$userinfo ['creater'];
        }
        if (array_key_exists('userTitle', $userinfo)) {
            $this->userTitle=$userinfo ['userTitle'];
        }
        if (array_key_exists('fromLink', $userinfo)) {
            $this->fromLink=$userinfo ['fromLink'];
        }
        if (array_key_exists('mark1', $userinfo)) {
            $this->mark1=$userinfo ['mark1'];
        }
        if (array_key_exists('mark2', $userinfo)) {
            $this->mark2=$userinfo ['mark2'];
        }
        if (array_key_exists('mark3', $userinfo)) {
            $this->mark3=$userinfo ['mark3'];
        }
        if (array_key_exists('mark4', $userinfo)) {
            $this->mark4=$userinfo ['mark4'];
        }
        if (array_key_exists('mark5', $userinfo)) {
            $this->mark5=$userinfo ['mark5'];
        }
        $flag=false;
        // 创建连接
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // 检测连接
        if ($conn->connect_error) {
            die("connect_error: " . $conn->connect_error);
            return $flag;
        }
     
        $sql = "INSERT INTO user (userName,userPsw,userQQ,userWechat,userPhone,userEmail,verifyQQ,verifyWechat,verifyPhone,verifyEmail,registerIP,shareCode,authorizationStatus,authorizationTime,userLevel,agentStatus,agentAdmin,agentTop,agentDirect,userActive,creater,userTitle,fromLink)
            VALUES ('$this->userName', '$this->userPsw', '$this->userQQ', '$this->userWechat', '$this->userPhone', '$this->userEmail', '$this->verifyQQ', '$this->verifyWechat', '$this->verifyPhone', '$this->verifyEmail', '$this->registerIP', '$this->shareCode', '$this->authorizationStatus', '$this->authorizationTime', '$this->userLevel', '$this->agentStatus', '$this->agentAdmin', '$this->agentTop', '$this->agentDirect', '$this->userActive', '$this->creater', '$this->userTitle', '$this->fromLink')";
     
        $result = mysqli_query($conn, $sql);
        if ($result=== true) {
            $this->id=mysqli_insert_id($conn);
            $flag=$this->id;

            //将资料备份到 userInfoUpdateLog 表  开始
            if (array_key_exists('userQQ', $userinfo)||array_key_exists('userWechat', $userinfo)||array_key_exists('userPhone', $userinfo)||array_key_exists('userEmail', $userinfo)) {
                require_once 'class.userInfoUpdateLog.php';
                $this->userInfoUpdateLog=new userInfoUpdateLog();
                if($this->userQQ!="isNull"){
                    $this->userInfoUpdateLog->insert(array("userID"=>$this->id,"infoType"=>'userQQ',"infoValue"=>$this->userQQ));
                }
                if($this->userWechat!="isNull"){
                    $this->userInfoUpdateLog->insert(array("userID"=>$this->id,"infoType"=>'userWechat',"infoValue"=>$this->userWechat));
                }
                if($this->userPhone!="isNull"){
                    $this->userInfoUpdateLog->insert(array("userID"=>$this->id,"infoType"=>'userPhone',"infoValue"=>$this->userPhone));
                }
                if($this->userEmail!="isNull"){
                    $this->userInfoUpdateLog->insert(array("userID"=>$this->id,"infoType"=>'userEmail',"infoValue"=>$this->userEmail));
                }  
            }
            //将资料备份到 userInfoUpdateLog 表  结束


        } else {
            die("INSERT_Error: " . $sql . "<br>" . $conn->error);
            return $flag;
        }
            
        $conn->close();
            
        return $flag;
    }

    /**
     * 查询并显示内容
     * @param userinfo array('id'='',userName='');
     * @param n 输出几条数据
     * @return Boolean false 失败            
     * @return Array  信息   成功 可能为空  注意：array()==false，返回true,即可判断有没有存在
     * 
     * return==false; //true 用户不存在（含false,array()空值）
     * return!=false; //true 用户存在 array(有值)
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

        $sql="SELECT u.*,l.loginTime,agent.userName AS agentName FROM user agent, user u LEFT JOIN (select aaaaaa.* from (select * from logLogin order by loginTime desc) aaaaaa group by aaaaaa.userID) l ON u.id=l.userID ";

        $sql.=" WHERE 1 AND u.agentDirect = agent.id ";

        if (array_key_exists("userName", $userinfo)) { //用户账号
            $this->userName=$userinfo ["userName"];
            $sql.=" AND u.userName='$this->userName'";
        }
        if (array_key_exists("id", $userinfo)) { //用户id
            $this->id=$userinfo ["id"];
            $sql.=" AND u.id='$this->id'";
        }

        if (array_key_exists("agentAdmin", $userinfo)) { //用户id
            $this->agentAdmin=$userinfo ["agentAdmin"];
            $sql.=" AND u.agentAdmin='$this->agentAdmin'";
        }

        if (array_key_exists("agentTop", $userinfo)) { //用户id
            $this->agentTop=$userinfo ["agentTop"];
            $sql.=" AND u.agentTop='$this->agentTop'";
        }

        if (array_key_exists("agentDirect", $userinfo)) { //用户id
            $this->agentDirect=$userinfo ["agentDirect"];
            $sql.=" AND u.agentDirect='$this->agentDirect'";
        }

        if (array_key_exists("authorizationStatus", $userinfo)) { //用户id
            $this->authorizationStatus=$userinfo ["authorizationStatus"];
            $sql.=" AND u.authorizationStatus='$this->authorizationStatus'";
        }

        //$sql.=" ORDER BY l.loginTime DESC";
        if (array_key_exists("sort", $userinfo)) {
            $sort = $userinfo ["sort"]; 
            if($sort=="1"){$sql.=" ORDER BY l.loginTime DESC";}// <el-option label="登录倒序" value="1"></el-option>
            if($sort=="2"){$sql.=" ORDER BY l.loginTime";}// <el-option label="登录顺序" value="2"></el-option>
            if($sort=="3"){$sql.=" ORDER BY u.registerTime DESC";}// <el-option label="注册倒序" value="3"></el-option>
            if($sort=="4"){$sql.=" ORDER BY u.registerTime";}// <el-option label="注册顺序" value="4"></el-option>
            if($sort=="5"){$sql.=" ORDER BY u.authorizationTime DESC";}// <el-option label="授权倒序" value="5"></el-option>
            if($sort=="6"){$sql.=" ORDER BY u.authorizationTime";}// <el-option label="授权顺序" value="6"></el-option>
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
     * 查询a是不是b的（隔代）下线
     * @param topID 会员的直接上线（晋升为总代了）;
     * @return Boolean false 失败
     */
    public function changeAgentTop($topID)
    {
        if ($topID==='') {
            return false;
        }

        $sql="UPDATE user SET agentTop='".$topID."' WHERE agentDirect='$topID'";

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
     * 查询a是不是b的（隔代）下线
     * @param a 会员在user表中的ID;
     * @param b 代理在user表中的ID;
     * @return Boolean false 失败
     */
    public function isAfromB($child, $father)
    {
        $flag=false;
       
        // 创建连接
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // 检测连接
        if ($conn->connect_error) {
            die("connect_error: " . $conn->connect_error);
            return $flag;
        }

        $continue=true;
        while ($continue) {
            $sql="SELECT agentAdmin,agentTop,agentDirect FROM user WHERE id='".$child."'";

            $result = mysqli_query($conn, $sql);

            if ($result===false) {
                $flag="id does not exist";//"id不正常，不再继续";
                $continue=false;
            } else {
                $row = mysqli_fetch_assoc($result);
                if ($row['agentAdmin']==$father||$row['agentTop']==$father||$row['agentDirect']==$father) {
                    $flag=true;
                    //找到父级 返回true
                    $continue=false;
                } else {
                    if ($row['agentAdmin']==$child || $row['agentTop']==$child) {
                        //"查到总代这一层了，不再继续";
                        $continue=false;
                    } else {
                        //继续向上查询

                        //$flag="agentDirect:".$row['agentDirect'];
                       

                        $child=$row['agentDirect'];
                    }
                }
            }
        }
        $conn->close();
        return $flag;
    }
    /**
     * 查询并显示代理的直接会员
     * @param agentID 代理在user表中的ID;
     * @return Boolean false 失败
     * @return Array  信息   成功
     */
    public function showUserListByAgentID($userinfo=array())
    {
        foreach ($userinfo as $key => $value) {
            $userinfo[$key] = trim($value); //去掉用户内容后面的空格.
        }

        if (array_key_exists("agentID", $userinfo)) { 
            $agentID=$userinfo ["agentID"]; 
        }else{
            return false;
        }
        $flag=false;
        // 创建连接
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // 检测连接
        if ($conn->connect_error) {
            die("connect_error: " . $conn->connect_error);
            return $flag;
        }

       // $sql="SELECT u.*,l.loginTime FROM user u LEFT JOIN (select aaaaaa.* from (select * from logLogin order by loginTime desc) aaaaaa group by aaaaaa.userID) l ON u.id=l.userID WHERE u.agentDirect='".$agentID."'";
       //2019年6月29日 10:53:46 增加显示代理的账号
        $sql="SELECT u.*,l.loginTime,agent.userName AS agentName FROM user agent, user u LEFT JOIN (select aaaaaa.* from (select * from logLogin order by loginTime desc) aaaaaa group by aaaaaa.userID) l ON u.id=l.userID WHERE u.agentDirect = agent.id AND u.agentDirect='".$agentID."'";

       

        if (array_key_exists("sort", $userinfo)) {
                $sort = $userinfo ["sort"]; 
                
                if($sort=="1"){$sql.=" ORDER BY l.loginTime DESC";}// <el-option label="登录倒序" value="1"></el-option>
                if($sort=="2"){$sql.=" ORDER BY l.loginTime";}// <el-option label="登录顺序" value="2"></el-option>
                if($sort=="3"){$sql.=" ORDER BY u.registerTime DESC";}// <el-option label="注册倒序" value="3"></el-option>
                if($sort=="4"){$sql.=" ORDER BY u.registerTime";}// <el-option label="注册顺序" value="4"></el-option>
                if($sort=="5"){$sql.=" ORDER BY u.authorizationTime DESC";}// <el-option label="授权倒序" value="5"></el-option>
                if($sort=="6"){$sql.=" ORDER BY u.authorizationTime";}// <el-option label="授权顺序" value="6"></el-option>

        }else{
            $sql.=" ORDER BY l.loginTime DESC";
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
    }/**
     * 查询并显示代理的直接代理
     * @param agentID 代理在user表中的ID;
     * @return Boolean false 失败
     * @return Array  信息   成功
     */
    public function showAgentListByAgentID($agentID='')
    {
        if ($agentID==='') {
            return false;
        }
        $flag=false;
        // 创建连接
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // 检测连接
        if ($conn->connect_error) {
            die("connect_error: " . $conn->connect_error);
            return $flag;
        }

        $sql="SELECT * FROM user WHERE agentStatus='1' AND agentDirect='".$agentID."'";


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
     * @param  userinfo 键值对组成的关联array，会更新array内的指定id
     * @return Boolean false  失败，
     * @return Boolean true   成功，
     */
    public function update($userinfo=array())
    {
        $updateSqlArr=array();
        foreach ($userinfo as $key => $value) {
            $userinfo[$key] = trim($value); //去掉用户内容后面的空格.

            if ($key=="userPsw") {
                $value=$this->createPassWord($value);
            }

            if ($key=="shareCode") {
                $value=$this->common->caesar(base64_encode($this->common->add0str($value)));
            };

            //授权用户时, 记录当前授权时间
            if ($key=="authorizationStatus" && ($value=="1" || $value=="3")) {
                array_push($updateSqlArr, " authorizationTime='".date("Y-m-d H:i:s")."' ");
            };
            
            
            

            if ($key!=="id") {
                array_push($updateSqlArr, " ".$key."='".$value."' ");
            }
        }
        $updateSqlStr=implode(",", $updateSqlArr);
        if (array_key_exists('id', $userinfo)) {
            $this->id=$userinfo ['id'];
        }
        $sql="UPDATE user SET $updateSqlStr WHERE id='$this->id'";

        $flag=false;
        // 创建连接
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // 检测连接
        if ($conn->connect_error) {
            die("connect_error: " . $conn->connect_error);
            return $flag;
        }
        $flag = mysqli_query($conn, $sql);

        //将资料备份到 userInfoUpdateLog 表  开始

        if (array_key_exists('userQQ', $userinfo)) {
            $this->userQQ=$userinfo ['userQQ'];
        }
        if (array_key_exists('userWechat', $userinfo)) {
            $this->userWechat=$userinfo ['userWechat'];
        }
        if (array_key_exists('userPhone', $userinfo)) {
            $this->userPhone=$userinfo ['userPhone'];
        }
        if (array_key_exists('userEmail', $userinfo)) {
            $this->userEmail=$userinfo ['userEmail'];
        }
        if (array_key_exists('userQQ', $userinfo)||array_key_exists('userWechat', $userinfo)||array_key_exists('userPhone', $userinfo)||array_key_exists('userEmail', $userinfo)) {
            require_once 'class.userInfoUpdateLog.php';
            $this->userInfoUpdateLog=new userInfoUpdateLog();
            if($this->userQQ!="isNull"){
                $this->userInfoUpdateLog->insert(array("userID"=>$this->id,"infoType"=>'userQQ',"infoValue"=>$this->userQQ));
            }
            if($this->userWechat!="isNull"){
                $this->userInfoUpdateLog->insert(array("userID"=>$this->id,"infoType"=>'userWechat',"infoValue"=>$this->userWechat));
            }
            if($this->userPhone!="isNull"){
                $this->userInfoUpdateLog->insert(array("userID"=>$this->id,"infoType"=>'userPhone',"infoValue"=>$this->userPhone));
            }
            if($this->userEmail!="isNull"){
                $this->userInfoUpdateLog->insert(array("userID"=>$this->id,"infoType"=>'userEmail',"infoValue"=>$this->userEmail));
            }  
        }
        //将资料备份到 userInfoUpdateLog 表  结束

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
        $retval=mysqli_query($conn, "DELETE FROM user WHERE id='$this->id'");
        if (! $retval) {
            die('DELETE_ERR: ' . mysqli_error($conn));
            $flag=false;
        } else {
            $flag=true;
        }
        $conn->close();
        return $flag;
    }

    /**
     * 是不是管理员
     * @param userinfo array('id'='',userName='');
     * @param n 输出几条数据
     * @return Boolean false 其它
     * @return Array  true  是管理员
     * @return String  userLevel   总代1，次代2，会员3
     */
    public function isAdmin($userinfo=array(), $n=1)
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

        $sql="SELECT * FROM user limit $n";

        if (array_key_exists("userName", $userinfo)) { //用户账号
            $this->userName=$userinfo ["userName"];
            $sql="SELECT id,agentAdmin,userLevel FROM user WHERE userName='$this->userName' limit $n";
        }
        if (array_key_exists("id", $userinfo)) { //用户id
            $this->id=$userinfo ["id"];
            $sql="SELECT id,agentAdmin,userLevel FROM user WHERE id=$this->id limit $n";
        }
        $result = mysqli_query($conn, $sql);

        if ($result===false) {
            return $flag;
        }
        if ($result->num_rows > 0) {
            // 输出数据
            $arr=array();
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['agentAdmin']==='0') {
                    $flag=true;
                } else {
                    $flag=$row['userLevel'];
                }
            }
        } else {
            $flag=false;
        }

        $conn->close();
        return $flag;
    }


    /**
     * 加密
     * @param passWord 明文;
     * @return String 密文
     */
    public function createPassWord($passWord)
    {
        return md5($passWord."createPassWord");
    }
    public function __destruct()
    {
    }
}
