<?php
date_default_timezone_set("Asia/Chongqing");
// id	唯一标识	0	自增，唯一
// shareCode	分享码
// createIP	ip
// createTime	时间	 自动初始化
// shareCount	访问次数
// shareExpired   分享是否过期  0未过期，1过期
// 分享IP表,以分享链接访问时触发
class letter
{
    private $id;
    private $userID;
    private $title;
    private $content;
    private $createTime;
    private $isDelete;
    private $isRead;
    private $creater;

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
        $this->userID='isNull';//用户id
        $this->title='无';//标题
        $this->content='无';//内容
        $this->createTime='isNull';//操作时间
        $this->isDelete='0';//已删除
        $this->isRead='0';//已读
        $this->creater='isNull';//提交人
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
            if($key=="userIDList"){continue;}
            $userinfo[$key] = trim($value); //去掉用户内容后面的空格.
        }
        if (array_key_exists('id', $userinfo)) {
            $this->id=$userinfo ['id'];
        }
        if (array_key_exists('userID', $userinfo)) {
            $this->userID=$userinfo ['userID'];
        }
        if (array_key_exists('title', $userinfo)) {
            $this->title=$userinfo ['title'];
        }
        if (array_key_exists('content', $userinfo)) {
            $this->content=$userinfo ['content'];
        }
        if (array_key_exists('createTime', $userinfo)) {
            $this->createTime=$userinfo ['createTime'];
        }
        if (array_key_exists('isDelete', $userinfo)) {
            $this->isDelete=$userinfo ['isDelete'];
        }
        if (array_key_exists('isRead', $userinfo)) {
            $this->isRead=$userinfo ['isRead'];
        }
        if (array_key_exists('creater', $userinfo)) {
            $this->creater=$userinfo ['creater'];
        }

        $flag=false;
    
        // 创建连接
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // 检测连接
        if ($conn->connect_error) {
            die("connect_error: " . $conn->connect_error);
            return $flag;
        }
     
        $sql = "INSERT INTO letter (userID,title,content,isDelete,isRead,creater)
            VALUES ('$this->userID', '$this->title', '$this->content', '$this->isDelete',  '$this->isRead', '$this->creater')";
     

        if (array_key_exists('userIDList', $userinfo)) {
            $userIDList=$userinfo ['userIDList'];
            $userIDListLenght=count($userIDList);
            $sql = "INSERT INTO letter (userID,title,content,isDelete,isRead,creater) VALUES ";
            $sql_arr=array();
            for ($x=0;$x<$userIDListLenght;$x++) {
                $userID = $userIDList[$x];
                array_push($sql_arr, "('$userID', '$this->title', '$this->content', '$this->isDelete',  '$this->isRead', '$this->creater')");
            }
            $sql_str=implode(",", $sql_arr);
            $sql.=$sql_str;
        }

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
     * @param code 分享码
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

        $sql="SELECT u.userName,agent.userName AS agentName, c.userName  AS createrName, l.* FROM user agent, user u,letter l,user c";

        $sql.=" WHERE (u.agentDirect = agent.id or u.agentTop = agent.id) AND u.id!=agent.id AND u.id=l.userID AND c.id=l.creater ";

        
        if (!array_key_exists("isDelete", $userinfo)) {
            $sql.=" AND l.isDelete='0'";
        }

        if (array_key_exists("agentName", $userinfo)) { //用户账号
            $agentName=$userinfo ["agentName"];
            $sql.=" AND agent.userName='$agentName'";
        }
        if (array_key_exists("agentID", $userinfo)) { //用户id
            $agentID=$userinfo ["agentID"];
            $sql.=" AND agent.id='$agentID'";
        }

        if (array_key_exists("id", $userinfo)) { //站内信id
            $this->id=$userinfo ["id"];
            $sql.=" AND l.id='$this->id'";
        }
        if (array_key_exists("userID", $userinfo)) { //用户id
            $userID=$userinfo ["userID"];
            $sql.=" AND u.id='$userID'";
        }
        if (array_key_exists("userName", $userinfo)) { //用户id
            $userName=$userinfo ["userName"];
            $sql.=" AND u.userName='$userName'";
        }

        $sql.=" GROUP BY l.id";

        //$sql.=" ORDER BY l.loginTime DESC";
        if (array_key_exists("sort", $userinfo)) {
            $sort = $userinfo ["sort"];
            if ($sort=="1") {
                $sql.=" ORDER BY l.createTime DESC";
            }// <el-option label="发送倒序" value="1"></el-option>
            if ($sort=="2") {
                $sql.=" ORDER BY l.createTime";
            }// <el-option label="发送顺序" value="2"></el-option>
            if ($sort=="3") {
                $sql.=" ORDER BY u.registerTime DESC, l.createTime DESC";
            }// <el-option label="注册倒序" value="3"></el-option>
            if ($sort=="4") {
                $sql.=" ORDER BY u.registerTime, l.createTime DESC";
            }// <el-option label="注册顺序" value="4"></el-option>
            if ($sort=="5") {
                $sql.=" ORDER BY l.isRead , l.createTime DESC";
            }// <el-option label="已读倒序" value="3"></el-option>
            if ($sort=="6") {
                $sql.=" ORDER BY l.isRead DESC, l.createTime DESC";
            }// <el-option label="已读顺序" value="4"></el-option>
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
            if ($key!=="id") {
                array_push($updateSqlArr, " ".$key."='".$value."' ");
            }
        }
        $updateSqlStr=implode(",", $updateSqlArr);
        if (array_key_exists('id', $userinfo)) {
            $this->id=$userinfo ['id'];
        }
        $sql="UPDATE letter SET $updateSqlStr WHERE id='$this->id'";
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

    public function __destruct()
    {
    }
}


// $test=new letter();
// $test->insert(array(
//     'userID'=>'906',
//     'title'=>'这是一个标题666666',
//     'content'=>'这是一个内容6666',
//     'isDelete'=>'0',
//     'isRead'=>'0',
//     ));
//     $test->insert(array(
//         'userID'=>'57',
//         'title'=>'这是一个标题666666',
//         'content'=>'这是一个内容6666',
//         'isDelete'=>'1',
//         'isRead'=>'0',
//         ));
//         $test->update(array(
//             'id'=>'14',
//             'title'=>'【修改一下】这是一个标题666666',
//             'content'=>'【修改一下】这是一个内容6666',
//             'isDelete'=>'1',
//             'isRead'=>'1',
//            ));

// var_dump($test->show(array(
//     'agentName'=>'cdadmin',
//     'isDelete'=>''
// )));
