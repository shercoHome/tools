<?php
date_default_timezone_set("Asia/Chongqing");
// id	唯一标识	0	自增，唯一
// shareCode	分享码
// createIP	ip
// createTime	时间	 自动初始化
// shareCount	访问次数
// shareExpired   分享是否过期  0未过期，1过期
// 分享IP表,以分享链接访问时触发
class shareIP
{
    private $id;
    private $shareCode;
    private $createIP;
    private $createTime;
    private $shareCount;
    private $shareExpired;

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
        $this->shareCount = 1;
        $this->shareExpired = 0;
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

        $result = mysqli_query($conn, "SELECT id FROM user WHERE shareCode='$shareCode' limit 1");
        if ($result===false) {
            return $flag;
        }
        if ($result->num_rows > 0) {
            // 输出数据
            $row = mysqli_fetch_array($result);
            $flag=true;
        } else {
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

        $result = mysqli_query($conn, "SELECT id,shareCount FROM shareIP WHERE createIP='$this->createIP' limit 1");
        if ($result===false) {
            return $flag;
        }
        if ($result->num_rows > 0) {
            // 输出数据
            $row = mysqli_fetch_array($result);
            $this->id=$row['id'];
            $this->shareCount=$row['shareCount'];
            $flag=$this->id;
        } else {
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
    public function insert()
    {
        if ($this->checkIP()===false) {//ip 不存在

    
            $flag=false;
    
            // 创建连接
            $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
            // 检测连接
            if ($conn->connect_error) {
                die("connect_error: " . $conn->connect_error);
                return $flag;
            }
     
            $sql = "INSERT INTO shareIP (shareCode, createIP, shareCount, shareExpired)
            VALUES ('$this->shareCode', '$this->createIP', '$this->shareCount', '$this->shareExpired')";
     
            if ($conn->query($sql) === true) {
                $flag=true;
            } else {
                die("INSERT_Error: " . $sql . "<br>" . $conn->error);
                return $flag;
            }
            
            $conn->close();
            return $flag;
        } else {//ip存在，此ip增加1次访问记录
            $this->update();
            return false;
        };
    }

    /**
     * 查询并显示内容
     * @param code 分享码
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

        $sql="SELECT * FROM shareIP WHERE shareCode='".$this->shareCode."' AND shareExpired=0 ORDER BY createTime DESC limit ".$n;
        if($n===''){
            $sql="SELECT * FROM shareIP WHERE shareCode='".$this->shareCode."' AND shareExpired=0 ORDER BY createTime DESC";
        }
        
        $result = mysqli_query($conn, $sql);

        if ($result===false) {
            return array();
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
     * 增加分享ip的访问次数
     * @param  无
     * @return Boolean false  失败，
     * @return Boolean true   成功，
     */
    public function update()//ip访问次数加1
    {
        $flag=false;

        // 创建连接
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // 检测连接
        if ($conn->connect_error) {
            die("connect_error: " . $conn->connect_error);
            return $flag;
        }
        $newShareCount=$this->shareCount+1;
        $sql="UPDATE shareIP SET shareCount='$newShareCount'
       WHERE id='$this->id'";

        $flag = mysqli_query($conn, $sql);

        $conn->close();
        return $flag;
    }

        /**
     * 分享过期
     * @param  shareCode
     * @return Boolean false  失败，
     * @return Boolean true   成功，
     */
    public function expired($shareCode)//ip访问次数加1
    {
        $flag=false;

        // 创建连接
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // 检测连接
        if ($conn->connect_error) {
            die("connect_error: " . $conn->connect_error);
            return $flag;
        }

        $sql="UPDATE shareIP SET shareExpired='1' WHERE shareCode='$shareCode'";

        $flag = mysqli_query($conn, $sql);

        $conn->close();
        return $flag;
    }

    public function __destruct()
    {
    }
}
