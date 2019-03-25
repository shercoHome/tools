<?php
date_default_timezone_set("Asia/Chongqing");
// id	唯一标识	0	自增，唯一			
// shareCode	分享码					
// createIP	ip					
// createTime	时间					
// userID	时间		在分享链接下注册的会员id			
// 分享注册表,以分享注册访问时触发											
class shareRegister
{
    private $id;  
    private $shareCode;
    private $createIP;
    private $createTime;
    private $userID;
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
        $this->shareCode = ''; 
        $this->createIP = $this->common->getIp();
        $this->createTime = ''; //自动初始化，无需传人
        $this->userID = ''; 
    }

    /**
     * 检测分享码是否存在于user表内
     * @param  shareCode 分享码
     * @return Boolean false  失败，表示无此分享码
     * @return Boolean true  成功，表示有分享码
     */
    public function checkCode($shareCode)
    {
        $this->shareCode=$shareCode;  //用户分享码
        $flag=false;
        // 创建连接
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // 检测连接
        if ($conn->connect_error) {
            die("connect_error: " . $conn->connect_error);
            return $flag;
        }

        $result = mysqli_query($conn, "SELECT id FROM user WHERE shareCode=$shareCode limit 1");
        if($result===false){
            return $flag;
        }
        if ($result->num_rows > 0) {
            // 输出数据
            $row = mysqli_fetch_array($result);
            $flag=true;
        }else{
            $flag=false;
        }

        $conn->close();
        return $flag;
    }

    /**
     * 检测ip是否存在于分享表内
     * @param  无
     * @return Boolean false  失败，表示无此ip 
     * @return String  返回id  成功 
     */
    public function checkIP()
    {

        $flag=false;
        // 创建连接
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // 检测连接
        if ($conn->connect_error) {
            die("connect_error: " . $conn->connect_error);
            return $flag;
        }

        $result = mysqli_query($conn, "SELECT id FROM shareRegister WHERE createIP=$this->createIP limit 1");
        if($result===false){
            return $flag;
        }
        if ($result->num_rows > 0) {
            // 输出数据
            $row = mysqli_fetch_array($result);
            $this->id=$row['id'];
            $flag=$this->id;
        }else{
            $flag=false;
        }
        
        $conn->close();
        return $flag;
    }

    /**
     * 插入新的分享，在ip不同的情况下有效
     * @param  无
     * @return Boolean false  失败，ip已存在 
     * @return String  错误信息  失败 
     * @return Boolean true    成功
     */
    public function insert($uid)
    {
        $this->userID=$uid;

        if ($this->checkIP()===false) {//ip 不存在
            $flag=false;
            // 创建连接
            $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
            // 检测连接
            if ($conn->connect_error) {
                die("connect_error: " . $conn->connect_error);
                return $flag;
            }
     
            $sql = "INSERT INTO shareRegister (shareCode, createIP, userID)
            VALUES ('$this->shareCode', '$this->createIP', '$this->userID')";
     
            if ($conn->query($sql) === true) {
                $flag=true;
            } else {
                die("INSERT_Error: " . $sql . "<br>" . $conn->error);
                return $flag;
            }
            
            $conn->close();
            return $flag;
        } else {//ip存在
            return false;
        };
    }

    /**
     * 查询并显示内容
     * @param shareCode 分享码
     * @param n 输出几条数据
     * @return Boolean false 失败 
     * @return Array  信息   成功
     */
    public function show($shareCode='', $n='')
    {
        if($shareCode!=='')$this->shareCode=$shareCode;
        
        $flag=false;
        // 创建连接
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // 检测连接
        if ($conn->connect_error) {
            die("connect_error: " . $conn->connect_error);
            return $flag;
        }

        $sql="SELECT * FROM shareRegister WHERE shareCode=".$shareCode." ORDER BY createTime DESC limit ".$n;
        if($n===''){
            $sql="SELECT * FROM shareRegister WHERE shareCode=".$shareCode." ORDER BY createTime DESC";
        }

        $result = mysqli_query($conn,$sql);
        if($result===false){
            return $flag;
        }
        if ($result->num_rows > 0) {
            // 输出数据
            $arr=array();
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($arr,$row);
           }
            $flag= $arr;
        }else{
            $flag=false;
        }

        $conn->close();
        return $flag;
    }
    public function __destruct()
    {
    }
}
