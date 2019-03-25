<?php
date_default_timezone_set("Asia/Chongqing");
// id	唯一标识	0	自增，唯一
// creater	提交人userID		谁提交
// actor	更改对象userID		让谁变更
// form	表名		哪个表
// formKey	字段名		哪个字段
// formValue	变更值		变为什么
// submitTime	提交时间		数据库自动添加
// doneTime	操作时间		需要程序手动更改
// result	操作结果		未操作0，成功1，失败2
                        
// 提交授权状态变更、授权时间变更、联系方式变更……
class logSubmit
{
    //////////字段/////
    private $id;
    private $creater;
    private $actor;
    private $form;
    private $formKey;
    private $formValue;
    private $submitTime;//数据库自动添加
    private $doneTime;
    private $result;
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

        $this->id = '';//数据库自动添加
        $this->creater = '';
        $this->actor = '';
        $this->form = '';
        $this->formKey = '';
        $this->formValue = '';
        $this->submitTime = '';//数据库自动添加
        $this->doneTime = '';
        $this->result = '0';
    }

    /**
     * insert
     * @param  creater 提交人userID
     * @param  actor 更改对象userID
     * @param  form  表名
     * @param  formKey 字段名
     * @param  formValue 变更值
     * @return Boolean false  失败，
     * @return Boolean true   成功，
     */
    public function insert($creater, $actor, $form, $formKey, $formValue)
    {
        $this->creater = $creater;
        $this->actor = $actor;
        $this->form = $form;
        $this->formKey = $formKey;
        $this->formValue = $formValue;

        $flag=false;

        // 创建连接
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // 检测连接
        if ($conn->connect_error) {
            die("connect_error: " . $conn->connect_error);
            return $flag;
        }
 
        $sql = "INSERT INTO logSubmit (creater, actor, form, formKey, formValue, result)
        VALUES ('$this->creater', '$this->actor', '$this->form', '$this->formKey', '$this->formValue', '$this->result')";
 
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
     * update 更新token的时间
     * @param  id 唯一标识
     * @param  submitResult 操作结果
     * @return Boolean false  失败，
     * @return Boolean true   成功，
     */
    public function update($id, $submitResult)
    {
        $flag=false;

        $this->id=$id;
        $this->result=$submitResult;
        // 创建连接
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // 检测连接
        if ($conn->connect_error) {
            die("connect_error: " . $conn->connect_error);
            return $flag;
        }
        $now=date("Y-m-d H:i:s");
        $sql="UPDATE logSubmit SET doneTime='$now',result='$this->result'
       WHERE id='$this->id'";

        $flag = mysqli_query($conn, $sql);

        $conn->close();
        return $flag;
    }
  
    /**
     * 查询并显示内容
     * @param player 提交人'creater' 或 更改对象'actor'
     * @param uid 会员标识
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

        $sql="SELECT a.*,b.userName AS actorName,bb.userName AS createName FROM logSubmit a LEFT JOIN user b on a.actor=b.id LEFT JOIN user bb on a.creater=bb.id";

        if (array_key_exists("actor", $userinfo)) { //用户id
            $this->actor=$userinfo ["actor"]; 
            $sql="SELECT * FROM logSubmit WHERE actor='$this->actor' ";  
        }
        if (array_key_exists("creater", $userinfo)) { //用户id
            $this->creater=$userinfo ["creater"]; 
            $sql="SELECT * FROM logSubmit WHERE creater='$this->creater' ";  
        }
        if (array_key_exists("id", $userinfo)) { //权限表id
            $this->id=$userinfo ["id"]; 
            $sql="SELECT * FROM logSubmit WHERE id='$this->id' ";
        }

        $sql.=" ORDER BY submitTime DESC ";

        if (array_key_exists("n", $userinfo)) { //权限表id
            $n=$userinfo ["n"]; 
            $sql.=" limit ".$n;
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
        $now=date("Y-m-d H:i:s");
        $retval=mysqli_query($conn, "DELETE FROM logSubmit WHERE id='$this->id'");
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
