<?php
date_default_timezone_set("Asia/Chongqing");
// authorizationWBStatus
// 英文字段	中文字段	默认值	属性
// id	唯一标识	0	自增，唯一
// userID	会员标识
// wbStatus	会员授权状态	白名单1	黑名单2
// updateTime	添加时间	自动初始化	自动更新
// updateIP	添加ip
// updater	操作人
// "记录特殊的授权状态，即授权白名单/黑名单；
// 1、查看会员userID的有没有在特别授权里
// 2、查看白/黑名单的成员
// 3、修改wbStatus
// 4、删除此记录"
class authorizationWBStatus
{
    private $id;
    private $userID;
    private $wbStatus;
    private $updateTime;
    private $updateIP;
    private $updater;
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
        $this->wbStatus = '0';
        $this->updateIP = $this->common->getIp();
        $this->updateTime = ''; //自动初始化，无需传人
        $this->updater = '';
    }
    /**
     * 插入新的分享，在ip不同的情况下有效
     * @param  无
     * @return Boolean false  失败，ip已存在
     * @return String  错误信息  失败
     * @return Boolean true    成功
     */
    public function insert($userinfo)
    {

        foreach ($userinfo as $key => $value) {
            $userinfo[$key] = trim($value); //去掉用户内容后面的空格.
        }
        if (array_key_exists('userID', $userinfo)) {
            $this->userID=$userinfo ['userID'];
        }
        if (array_key_exists('wbStatus', $userinfo)) {
            $this->wbStatus=$userinfo ['wbStatus'];
        }
        if (array_key_exists('updater', $userinfo)) {
            $this->updater=$userinfo ['updater'];
        }
        $checker=$this->check();
        $flag=false;
        if ($checker===false) {
            // 创建连接
            $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
            // 检测连接
            if ($conn->connect_error) {
                die("connect_error: " . $conn->connect_error);
                return $false;
            }
     
            $sql = "INSERT INTO authorizationWBStatus (userID, wbStatus, updateIP, updater)
            VALUES ('$this->userID', '$this->wbStatus', '$this->updateIP', '$this->updater')";
     
            if ($conn->query($sql) === true) {
                $flag=true;
                //同时更新会员表  白名单1	黑名单2
                if($this->wbStatus=="1"){

                    $now=date("Y-m-d H:i:s");
                    
                    $userSql="UPDATE user SET authorizationStatus='3',authorizationTime='$now' WHERE id='$this->userID'";
                     mysqli_query($conn, $userSql);
                }
            } else {
                die("INSERT_Error: " . $sql . "<br>" . $conn->error);
            }
            $conn->close();
        } elseif ($checker==$this->wbStatus) {//存在，一样，不更新
            $flag= false;
        } else {
            $flag=$this->update(array(
                "userID"=>$this->userID,
                "wbStatus"=>$this->wbStatus,
                "updater"=>$this->updater
            ));
        };
        return $flag;
    }

    /**
     * 查询并显示内容
     * @param code 分享码
     * @param n 输出几条数据
     * @return Boolean false 失败
     * @return Array  信息   成功
     */
    public function show($info)
    {

        $sql="SELECT a.*,u.userName FROM user u ,(SELECT wb.*,l.loginTime FROM authorizationWBStatus wb LEFT JOIN (select aaaaaa.* from (select * from logLogin order by loginTime desc) aaaaaa group by aaaaaa.userID) l ON wb.userID=l.userID ORDER BY l.loginTime DESC) a WHERE u.id=a.userID";
        foreach ($info as $key => $value) {
            $info[$key] = trim($value); //去掉用户内容后面的空格.
        }
        if (array_key_exists('userID', $info)) {
            $this->userID=$info ['userID'];
            $sql.=" AND a.userID='$this->userID'";
        }
        if (array_key_exists('agentAdmin', $info)) {
            $agentAdmin=$info ['agentAdmin'];
            $sql.=" AND (u.agentAdmin='$agentAdmin' OR u.id='$agentAdmin')";
        }
        if (array_key_exists('agentTop', $info)) {
            $agentTop=$info ['agentTop'];
            $sql.=" AND u.agentTop='$agentTop'";
        }
        if (array_key_exists('agentDirect', $info)) {
            $agentDirect=$info ['agentDirect'];
            $sql.=" AND (u.agentDirect='$agentDirect' OR u.id='$agentDirect')";
        }
        if (array_key_exists('wbStatus', $info)) {
            $this->wbStatus=$info ['wbStatus'];
            $sql.=" AND a.wbStatus='$this->wbStatus'";
        }else{
            $sql.=" AND a.wbStatus in (1,2)";
        }
        if (array_key_exists('updater', $info)) {
            $this->updater=$info ['updater'];
            $sql.=" AND a.userIupdaterD='$this->updater'";
        }

        $sql.=" ORDER BY a.updateTime DESC";

        if (array_key_exists('n', $info)) {
            $sql.=" limit ".$info ['n'];
        }

        $flag=false;
        // 创建连接
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // 检测连接
        if ($conn->connect_error) {
            die("connect_error: " . $conn->connect_error);
            return $flag;
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
     * 修改 白黑名单
     * @param  无
     * @return Boolean false  失败，
     * @return Boolean true   成功，
     */
    public function update($userinfo)
    {


        foreach ($userinfo as $key => $value) {
            $userinfo[$key] = trim($value); //去掉用户内容后面的空格.
        }
        if (array_key_exists('id', $userinfo)) {
            $this->id=$userinfo ['id'];
        }
        if (array_key_exists('userID', $userinfo)) {
            $this->userID=$userinfo ['userID'];
        }
        if (array_key_exists('wbStatus', $userinfo)) {
            $this->wbStatus=$userinfo ['wbStatus'];
        }
        if (array_key_exists('updater', $userinfo)) {
            $this->updater=$userinfo ['updater'];
        }

        $flag=false;

        // 创建连接
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // 检测连接
        if ($conn->connect_error) {
            die("connect_error: " . $conn->connect_error);
            return $flag;
        }

        $sql="UPDATE authorizationWBStatus SET wbStatus='$this->wbStatus',updater='$this->updater',updateIP='$this->updateIP' WHERE userID='$this->userID'";
        if (array_key_exists('id', $userinfo)) {
            $sql="UPDATE authorizationWBStatus SET wbStatus='$this->wbStatus',updater='$this->updater',updateIP='$this->updateIP' WHERE id='$this->id'";
        }

        $flag = mysqli_query($conn, $sql);


        if($flag){//同时更新会员表  0 白名单1	黑名单2
            if($this->wbStatus=="1"){

                
                $now=date("Y-m-d H:i:s");
                    
  

                if (array_key_exists('id', $userinfo)) {
                    $userSql="UPDATE user u,authorizationWBStatus,a SET u.authorizationStatus='3',u.authorizationTime='$now' WHERE a.userID=u.id AND a.id='$this->id'";
                }
                if (array_key_exists('userID', $userinfo)) {
                    $userSql="UPDATE user SET authorizationStatus='3',authorizationTime='$now' WHERE id='$this->userID'";
                }
                mysqli_query($conn, $userSql);
            }else{
                if (array_key_exists('id', $userinfo)) {
                    $userSql="UPDATE user u,authorizationWBStatus,a SET u.authorizationStatus='0' 
                    WHERE a.userID=u.id AND a.id='$this->id'";
                }
                if (array_key_exists('userID', $userinfo)) {
                    $userSql="UPDATE user SET authorizationStatus='0'
                    WHERE id='$this->userID'";
                }
                mysqli_query($conn, $userSql);
            }
        }

        $conn->close();
        return $flag;
    }
    /**
       * 检测会员是否存在黑白名单里表内
       * @param  uid 会员标识
       * @return Boolean false  失败，表示不在黑白名单里
       * @return String 会员授权状态  成功，白名单1，黑名单2
       */
    public function check($uid="")
    {
        if ($uid!=="") {
            $this->userID=$uid;  
        }
        
        $flag=false;
        // 创建连接
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // 检测连接
        if ($conn->connect_error) {
            die("connect_error: " . $conn->connect_error);
            return $flag;
        }

        $result = mysqli_query($conn, "SELECT id,wbStatus FROM authorizationWBStatus WHERE userID='$this->userID' limit 1");
        if ($result===false) {
            return $flag;
        }
        if ($result->num_rows > 0) {
            // 输出数据
            $row = mysqli_fetch_array($result);
            $flag=$row['wbStatus'].'';
        } else {
            $flag=false;
        }

        $conn->close();
        return $flag;
    }
    /**
     * delete
     * @param  id
     * @return Boolean false  失败，
     * @return Boolean true   成功，
     */
    public function delete($userinfo)
    {


        foreach ($userinfo as $key => $value) {
            $userinfo[$key] = trim($value); //去掉用户内容后面的空格.
        }
        if (array_key_exists('id', $userinfo)) {
            $this->id=$userinfo ['id'];
        }
        if (array_key_exists('userID', $userinfo)) {
            $this->id=$userinfo ['userID'];
        }
        $flag=false;
    
        // 创建连接
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // 检测连接
        if ($conn->connect_error) {
            die("connect_error: " . $conn->connect_error);
            return $flag;
        }
        $retval=mysqli_query($conn, "DELETE FROM authorizationWBStatus WHERE id='$this->id'");
        if (! $retval) {
            die('DELETE_ERR: ' . mysqli_error($conn));
            $flag=false;
        } else {
            $flag=true;
        }

        if($flag){//同时更新会员表  白名单1	黑名单2
            if($this->wbStatus=="1"){

                if (array_key_exists('id', $userinfo)) {
                    $userSql="UPDATE user u,authorizationWBStatus,a SET u.authorizationStatus='0' 
                    WHERE a.userID=u.id AND a.id='$this->id'";
                }
                if (array_key_exists('userID', $userinfo)) {
                    $userSql="UPDATE user SET authorizationStatus='3'
                    WHERE id='$this->userID'";
                }
                mysqli_query($conn, $userSql);
            }
        }

        $conn->close();
        return $flag;
    }
    public function __destruct()
    {
    }
}
