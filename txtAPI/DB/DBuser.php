<?php
date_default_timezone_set("Asia/Chongqing");
// php实现对文本数据库的数据显示、加入、修改、删除、查询五大基本操作的方法。
// 此文本数据库共有字段9个：
//     private $userId;    //用户ID 1，2，3，4
//     private $userName;  //用户账号
//     private $userPassWord;  //用户密码
//     private $userCreateTime;   //用户注册时间
//     private $userCreateIP;  //注册IP
//     private $userAff;  //注册来源
//     private $userShareCode;  //用户分享码
//     private $userAuthorize;  //用户授权状态0，1（ 默认0，未授权）
// @abstract   TxtDB store
// @access     public
// @author
class DBuser
{
    private $txtUserUrl;  //储存用户数据库的文本路径;
    private $txtUserMk;  //储存用户日志数据库的文件夹;
    private $txtShareMk;  //储存用户日志数据库的文件夹;

    private $userId;    //用户ID 1，2，3，4
    private $userName;  //用户账号
    private $userPassWord;  //用户密码
    private $userCreateTime;   //用户注册时间
    private $userCreateIP;  //注册IP
    private $userAff;  //注册来源
    private $userShareCode;  //用户分享码
    private $userAuthorize;  //用户授权状态0，1（ 默认0，未授权）

    public function __construct()
    {
        $this->txtUserUrl=dirname(__FILE__)."/txt/user.txt";  //储存数据库的文本路径;

        if (!file_exists($this->txtUserUrl)) {
            file_put_contents($this->txtUserUrl, '');
        } 

        $this->txtUserMk=dirname(__FILE__)."/txt/log/";  //储存用户日志数据库的文件夹;
        $this->txtShareMk=dirname(__FILE__)."/txt/share/";  //储存用户日志数据库的文件夹;
        $this->userId = count(file($this->txtUserUrl))+1;    //用户ID 1，2，3，4
        $this->userName="";  //用户账号
        $this->userPassWord="";  //用户密码
        $this->userCreateTime= date("Y-m-d H:i:s");   //用户注册时间
        $this->userCreateIP=$this->getIp();  //注册IP
        $this->userAff="default";  //注册来源
        $this->userShareCode="";  //用户分享码
        $this->userAuthorize="0";  //用户授权状态0，1（ 默认0，未授权）
    }
    /**
     * 加入数据程序段。
     * $userinfo array  要插入的用户信息列表
     * $userinfo["userid"]$userinfo["username"]$userinfo["usercreatetime"]$userinfo["userlogintime"]$userinfo["userloginip"]
     * @return boolean 成功  true
     *  失败 false
     */
    public function insert($userinfo)
    {
        foreach ($userinfo as $key => $value) {
            $key = trim($value); //去掉用户内容后面的空格.
        }
        $this->userId = count(file($this->txtUserUrl))+1;    //用户ID 1，2，3，4
        $this->userName=$userinfo ["userName"];  //用户账号
        $this->userPassWord=$this->createPassWord($userinfo ["userPassWord"]);  //用户密码
        $this->userAff=$userinfo ["aff"];//注册来源
       // $this->userCreateTime= date("Y-m-d H:i:s");   //用户注册时间
        //$this->userCreateIP=$this->getIp();  //注册IP
        $this->userShareCode=$this->createShareCode();
        ;  //用户分享码
        $this->userAuthorize="0";  //用户授权状态0，1（ 默认0，未授权）

        if (!$this->select($this->userName)) {//判断用户是否存在
            try {
                $fp = fopen($this->txtUserUrl, "a"); //以只写模式打开userlist.txt文本文件,文件指针指向文件尾部.
                $str = $this->userId . "|" . $this->userName . "|"
                . $this->userPassWord ."|" . $this->userCreateTime ."|"
                . $this->userCreateIP ."|" . $this->userShareCode ."|"
                . $this->userAuthorize . "|".$this->userAff."|\r\n";
                //将所有用户的数据赋予变量$str，"|"的目的是用来今后作数据分割时的数据间隔符号。
                fwrite($fp, $str); //将数据写入文件
                fclose($fp); //关闭文件

                $this->createThisUserTxt();  //生成用户登录日志
                $this->createThisUserShareCode();  //生成用户分享日志

                return true;
            } catch (Exception $e) {
                return false;
            }
        } else {
            return false;
        };
    }

    public function show()
    {
        //数据显示程序段
        if (file_exists($this->txtUserUrl)) { //检测文件是否存在
            $array = file($this->txtUserUrl); //将文件全部内容读入到数组$array
            $arr = array_reverse($array); //将$array里的数据安行翻转排列（即最后一行当第一行，依此类推）读入数组$arr的每一个单元（$arr[0]...）。
        }
        return $arr;
    }

    /**
     * 数据修改程序段
     * $userName,以用户名为查询标识 
     * $index,要更新的字段位置，默认为6，授权状态
     * $newValue, 新的值
     * @return boolean 成功  true
     *  失败 false
     */
    public function alter($userName, $newValue, $index=6)
    {
        $index = trim($index); //去掉用户内容后面的空格.
        $newValue = trim($newValue); //去掉用户内容后面的空格.
        $userName = trim($userName); //去掉用户内容后面的空格.

        $list = file($this->txtUserUrl); //读取整个userlist.txt文件到数组$list,数组每一个元素为一条用户($list[0]是第一条用户的数据、$list[1]是第二条用户的数据.....
        $n = count($list); //计算$list内容里的用户总数,并赋予变量$n

        if ($n > 0) { //如果用户数大于0
            $fp = fopen($this->txtUserUrl, "w"); //则以只写模式打开文件userlist.txt
            for ($i = 0; $i < $n; $i ++) { //进入循环
                $f = explode("|", $list [$i]);

                if ($userName==$f[1]) { //将传用户userid与数组单元$list里内容进行字串匹配比较
                    // $f = explode("|", $list [$i]); //如果找到匹配，就以"|"作为分隔符,切开用户信息$list[$i](第$i条用户),并将这些数据赋予数组$f
                    $f[$index] = $newValue;
                    $list [$i] = $f [0] . "|" . $f [1] . "|" . $f [2] . "|" . $f [3] . "|" . $f [4]  . "|" . $f [5] . "|" . $f [6] . "|" . $f [7] . "|\r\n";
                    //将数组单元$list[$i]的内容用数组$f加上分隔符"|"代替。
                    break; //跳出循环
                }
            }//循环结束符
        }
        fclose($fp); //关闭文件
        $fwriteResult=file_put_contents($this->txtUserUrl, $list);
        return $fwriteResult;
    }

    /**
     * 数据删除程序段
     * @param   $userid 用户id号
     * @return boolean true 成功
     * false 失败
     *
     */
    public function delete($userid)
    {
        $list = file($this->txtUserUrl); //读取整个userlist.txt文件到数组$list,数组每一个元素为一条用户($list[0]是第一条用户的数据、$list[1]是第一条用户的数据.....
        $n = count($list); //计算$list内容里的用户总数,并赋予变量$n
        if ($n > 0) { //如果用户数大于0
            $fp = fopen($this->txtUserUrl, "w"); //则以只写模式打开文件userlist.txt
            for ($i = 0; $i < $n; $i ++) { //进入循环

                $row = explode("|", $list [$i]);
                if ($userid==$row[0]) { //将发送过来的用户$userid与数组$list[$i]里的字串进行匹配比较
                    $list [$i] = ""; //如果匹配成功，则将$list[$i]清空（达到删除的目的）
                    break; //跳出循环
                }
            } //循环结束符
            for ($i = 0; $i <= $n; $i ++) { //进入循环
                fwrite($fp, $list [$i]); //将数组$list的每个单元为一行，写入文件userlist.txt
            } //循环结束符
            fclose($fp); //关闭文件
        }
    }

    /**
     * 数据查询程序段
     * @param $userid 用户ID号
     * @return boolean 成功返回ture
     * 失败返回 false
     *
     */
    public function select($username)
    {
        $mark = 0;

        $list = file($this->txtUserUrl); //读取整个userlist.txt文件到数组$list,
        //数组每一个元素为一条用户($list[0]是第一条用户的数据、$list[1]是第二条用户的数据.....
        $n = count($list); //计算$list内容里的用户总数,并赋予变量$n
        $username = trim($username);
        // $username_match='/'.$username.'/i';
        if (! $username) { //如果$username为假
           // echo "您没有输入任何关键字！"; //作相关显示
            return false;
        } else {
            if ($n > 0) { //如果用户数大于0
                for ($i = 0; $i < $n; $i ++) { //进入循环

                    $row = explode("|", $list [$i]);

                    $list_name=$row[1];

                    if ($list_name==$username) { //输入的关键字与数组$list[$i]里的字串进行匹配比较
                        $mark = 1; //如果找到匹配，就以"|"作为分隔符,切开用户信息$list[$i](第$i条用户),并将这些数据赋予数组$row.并将变量$id赋予1，以便作为是否找到匹配的判断。
                      //  list($userid, $username, $usercreatetime, $userlogintime, $userloginip) = $row; //将数组$row里的单元数据按顺序赋予括号里的变量
                        //echo $username;
                        return $row;
                    }
                }//循环结束符
            }
        }
        if ($mark == 0) {
            //echo "没有找到与关键字匹配的用户！";
            return false;
        }
    }
    /**
     * 返回当前客户端ip
     * @param
     * @return  $ip
     * 失败返回 unknown
     *
     */
    public function getIp()
    {
        if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) {
            $ip = getenv("HTTP_CLIENT_IP");
        } elseif (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) {
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        } elseif (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) {
            $ip = getenv("REMOTE_ADDR");
        } elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } else {
            $ip = "unknown";
        }
        return $ip;
    }

    /**
     * 生成并返回用户的分享码
     * @param $userName
     * @return  $ip
     * 失败返回 unknown
     *
     */
    public function createShareCode()
    {
        return md5($this->userName."createShareCode");
    }

    /**
     * 生成并返回加密后的密码
     * @param $passWord
     * @return  md5
     * 失败返回 unknown
     *
     */
    public function createPassWord($passWord)
    {
        return md5($passWord."createPassWord");
    }
    /**
     * 生成用户登录日志
     * @param $passWord
     * @return  md5
     * 失败返回 unknown
     *
     */
    public function createThisUserTxt()
    {
        $this->add($this->txtUserMk.$this->userName.".txt","");
    }
    /**
     * 生成用户分享日志
     * @param $passWord
     * @return  md5
     * 失败返回 unknown
     *
     */
    public function createThisUserShareCode()
    {
        $this->add($this->txtShareMk.$this->userShareCode.".txt","");
    }


    
    public function add($path, $str)
    {
        if (!file_exists($path)) {
            file_put_contents($path, $str);
            return true;
        } else {
            return false;
        }
    }

    
    public function __destruct()
    {
    }
}
