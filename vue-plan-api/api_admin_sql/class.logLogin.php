<?php
date_default_timezone_set("Asia/Chongqing");
// id	唯一标识	0	自增，唯一
// userID	会员标识
// loginTime	时间		数据库自动添加
// loginIP	IP
// loginLink	登录的网址
// fromLink	来源网址
// loginToken	会话状态	isNull	用来记录登录状态
// loginTokenTime		loginTime
// "用账号密码登录时会增加一条记录，并随机生成一个token
// token会返回到前端
// 前端在检查登录状态时，回传userID和token，后端检查token
//         1、token不存在，则是未登录状态
//         2、token存在，查看生成时间loginTokenTime，对比当前时间，是否超时
//                  a、超时则退出登录，b、未超时--刷新loginTokenTime"
class logLogin
{
    //////////字段/////
    private $id;
    private $userID;
    private $loginTime;//数据库自动添加
    private $loginIP;
    private $loginLink;
    private $fromLink;
    private $loginToken;
    private $loginTokenTime;
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

        $this->id = '';
        $this->userID = '';
        $this->loginIP=$this->common->getIp();
        $this->loginLink = '';
        $this->fromLink = '';
        $this->loginToken = '';
        $this->loginTokenTime = date("Y-m-d H:i:s");
    }

    /**
     * insert
     * @param  userID 会员标识
     * @param  loginLink 登录的网址
     * @param  fromLink 来源网址
     * @param  loginToken 会话状态
     * @return Boolean false  失败，
     * @return Boolean true   成功，
     */
    public function insert($userID, $loginLink, $fromLink)
    {
        $this->userID = $userID;
        $this->loginLink = $loginLink;
        $this->fromLink = $fromLink;

        $flag=false;

        // 创建连接
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // 检测连接
        if ($conn->connect_error) {
            die("connect_error: " . $conn->connect_error);
            return $flag;
        }
 
        $sql = "INSERT INTO logLogin (userID, loginIP, loginLink, fromLink, loginToken, loginTokenTime)
        VALUES ('$this->userID', '$this->loginIP', '$this->loginLink', '$this->fromLink', '$this->loginToken', '$this->loginTokenTime')";
 
        $result = mysqli_query($conn, $sql);
        if ($result=== true) {
          //  echo "New record has id: " . mysqli_insert_id($conn);
            $flag=true;
        } else {
            die("INSERT_Error: " . $sql . "<br>" . $conn->error);
            return $flag;
        }
        
        $conn->close();
        return $flag;
    }
    /**
     * update 更新token的时间
     * @param  无
     * @return Boolean false  失败，
     * @return Boolean true   成功，
     */
    public function update()
    {
        $flag=false;

        // 创建连接
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // 检测连接
        if ($conn->connect_error) {
            die("connect_error: " . $conn->connect_error);
            return $flag;
        }
        $now=date("Y-m-d H:i:s");
        
        $sql="UPDATE logLogin SET loginTokenTime='$now'
       WHERE id='$this->id'";

        $flag = mysqli_query($conn, $sql);

        $conn->close();
        return $flag;
    }
    /**
     * checkToken 检测token是否有效，有效时会刷新token时间
     * @param  userID 会员标识
     * @param  token 会话状态
     * @return Boolean false  失败，连接不正常，
     * @return Boolean true   成功，token有效
     * @return String  失败信息   失败，token有效
     */
    public function checkToken($userID,$token)
    {
        require_once 'class.common.php';
        $__common=new commonFun();
        $__temp =$__common->decrypt($token);
        $__tempAr=explode("|",$__temp);

        $userIDFromToken=$__tempAr[1];//登录用户
        if($userIDFromToken!=$userID){
            return false;
        }
        $webID=$__tempAr[2];//登录的网站id
        $loginKeep=$__tempAr[3];//登录有效时长  分钟

        $flag=false;
        // 创建连接
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // 检测连接
        if ($conn->connect_error) {
            die("connect_error: " . $conn->connect_error);
            return $flag;
        }

        $result = mysqli_query($conn, "SELECT id, loginToken, loginTokenTime FROM logLogin WHERE userID=$userID ORDER BY loginTime DESC limit 2");
        if ($result===false) {
            return $flag;
        }
        if ($result->num_rows > 0) {
            $row = mysqli_fetch_array($result);
            $this->id=$row['id'];
            if ($row['loginToken']==$token) {//token正常
                $cha=$this->common->checkTime($row['loginTokenTime']);
                if ($cha>0) {
                    $flag= "token time err";
                } elseif ($cha>-$loginKeep*60) {
                    $flag=true;
                    $this->update();
                } else {
                    $flag= "token time out";
                }
            } else {
                $flag= "token err";
            }
        }

        $conn->close();
        return $flag;
    }

    /**
     * 查询并显示内容
     * @param uid 会员标识
     * @param n 输出几条数据
     * @return Boolean false 失败
     * @return Array  信息   成功
     */
    public function show($uid, $n=10)
    {
        $this->userID=$uid;

        $flag=false;
        // 创建连接
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // 检测连接
        if ($conn->connect_error) {
            die("connect_error: " . $conn->connect_error);
            return $flag;
        }

        $result = mysqli_query($conn, "SELECT * FROM logLogin WHERE userID=$uid ORDER BY loginTime DESC limit $n");
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
    // public function createToken($username){
    //     $this->loginToken = md5 ($username.date("Y-m-d H:i:s")."what a fuck token is to long!!!");
    //     return $this->loginToken;
    // }
    /**
     * 查询并显示内容
     * @param userID 会员标识
     * @param loginWebID 登录的网站
     * @return loginTokenTime 登录过期时间
     * @return Array  信息   成功
     */
    public function createToken($userID,$loginWebID,$loginkeep,$userAuthorize){
        //md5 取值范围仅限于 0-9 和 a-f
        $token_id = md5 ($userID.date("Y-m-d H:i:s")."what a fuck token is to long!!!");
        $temp=$token_id."|".$userID."|".$loginWebID."|".$loginkeep."|".$userAuthorize;
        require_once 'class.common.php';
        $common=new commonFun();
        $this->loginToken =$common->encrypt($temp);
        return $this->loginToken;
    }
    
    
    public function __destruct()
    {
    }
}
