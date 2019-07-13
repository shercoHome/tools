<?php
date_default_timezone_set("Asia/Chongqing");
// id	唯一标识	0	自增，唯一
// switch	是否开启	1	关闭0，开启1
// lotteryID	彩种代号	js
// lotteryname	彩种名称
// link	彩种api链接
// dir	数据存储文件夹
// code	开奖号码个数
// strPlanName	计划名称		以|分割，数量为max
// strPosition	玩法		以|分割
// strQis	期数		以|分割，几期计划
// strNumbers	几码		以|分割，几码计划
// str_numbers_show	是否可选择几码	1|1|1|1|1|1|1|1|1|1	与玩法对应	
// maxPeriod	一天的期数
// intervalPeriod	每期间隔
// delayPeriod	封盘时间
// defaultPlanQi	默认几期	2	0为第一期
// defaultPlanPosition	默认玩法	0	第一种玩法
// defaultNumbers	默认几码	1	0为几码的第一个，参见strNumbers
                                
// "仅管理员可修改
// 1、新增Api
// 2、修改
// 3、开关"
class userInfoUpdateLog
{
    private $id;
    private $userID;
    private $infoType;
    private $infoValue;
    private $createTime;//自动
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

        // require_once 'class.common.php';
        // $this->common=new commonFun();
        
        $this->id='0';//自增，唯一
        $this->userID='isNull';//用户ID
        $this->infoType='isNull';//资料类型 微信 QQ 电话  或 邮箱
        $this->infoValue='isNull';//对应值
        $this->createTime='isNull'; //自动 时间
        $this->mark1='isNull';//备注1 
        $this->mark2='isNull';//备注2
        $this->mark3='isNull';//备注1
        $this->mark4='isNull';//备注1
        $this->mark5='isNull';//备注1
        
    }
    /**
     * 插入新的记录
     * @param userinfo array('userID'='',a=''...);
     * @return Boolean false  失败，ip已存在
     * @return String  错误信息  失败
     * @return Boolean true    成功
     */
    public function insert($userinfo)
    {
        if(array_key_exists('userID', $userinfo)) {$this->userID=$userinfo ['userID'];}
        if(array_key_exists('infoType', $userinfo)) {$this->infoType=$userinfo ['infoType'];}
        if(array_key_exists('infoValue', $userinfo)) {$this->infoValue=$userinfo ['infoValue'];}
        if(array_key_exists('createTime', $userinfo)) {$this->createTime=$userinfo ['createTime'];}
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
     
        $sql = "INSERT INTO userInfoUpdateLog (userID,infoType,infoValue)
            VALUES ('$this->userID', '$this->infoType', '$this->infoValue')";
     
        if ($conn->query($sql) === true) {
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
     * @param id
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

        $sql="SELECT * FROM userInfoUpdateLog ";//userID,infoType,infoValue
        $sql.=" WHERE 1 ";
        if (array_key_exists("userID", $userinfo)) { //
            $this->userID=$userinfo ["userID"]; 
            $sql.=" AND userID='$this->userID' ";  
        }
        if (array_key_exists("id", $userinfo)) { //
            $this->id=$userinfo ["id"]; 
            $sql.=" AND id='$this->id' ";  
        }
        if (array_key_exists("infoType", $userinfo)) { //
            $this->id=$userinfo ["infoType"]; 
            $sql.=" AND infoType='$this->infoType' ";  
        }

        if (array_key_exists("sort", $userinfo)) {
            $sort = $userinfo ["sort"]; 
            
            if($sort=="1"){$sql.=" ORDER BY id DESC";}// <el-option label="登录倒序" value="1"></el-option>
            if($sort=="2"){$sql.=" ORDER BY id";}// <el-option label="登录顺序" value="2"></el-option>
            if($sort=="3"){$sql.=" ORDER BY mark1 DESC";}// <el-option label="注册倒序" value="3"></el-option>
            if($sort=="4"){$sql.=" ORDER BY mark1";}// <el-option label="注册顺序" value="4"></el-option>
            if($sort=="5"){$sql.=" ORDER BY createTime DESC, mark1 DESC";}// <el-option label="授权倒序" value="5"></el-option>
            if($sort=="6"){$sql.=" ORDER BY createTime ,mark1";}// <el-option label="授权顺序" value="6"></el-option>

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
    public function __destruct()
    {
    }
}
