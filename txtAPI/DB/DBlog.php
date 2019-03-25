<?php
date_default_timezone_set("Asia/Chongqing");
// php实现对文本数据库的数据显示、加入、修改、删除、查询五大基本操作的方法。

// private $txtLogMk;  //储存登录日志数据库的文件夹;
// private $txtLogFile;  //储存登录日志数据库的文件，完整的路径和文件名;

// private $userName;  //用户登录日志,  文本的文件名

// 此文本数据库共有字段4个：
// private $logID;  //用户登录日志ID
// private $logIP;  //用户登录日志IP
// private $logTime;   //用户登录日志时间
// @abstract   TxtDB store
// @access     public
// @author
class DBlog
{
    private $txtLogMk;  //储存登录日志数据库的文件夹;
    private $txtLogFile;  //储存登录日志数据库的文件;

    private $userName;  //用户登录日志

    private $logID;  //用户登录日志IP
    private $logIP;  //用户登录日志IP
    private $logTime;   //用户登录日志时间



    public function __construct()
    {
        $this->txtLogMk=dirname(__FILE__)."/txt/log/";  //储存用户登录日志数据库的文件夹;
        $this->logID = '';    //用户ID 1，2，3，4
        $this->logIP=$this->getIp();  //用户登录日志IP
        $this->logTime= date("Y-m-d H:i:s");   //用户登录日志时间
    }

    /**
     * 检测登录日志是否存在
     * @return boolean 成功  true
     *  失败 false
     */
    public function check($userName)
    {
        $this->userName=$userName;  //用户登录日志
        $this->txtLogFile=$this->txtLogMk.$this->userName.".txt";  //储存用户登录日志数据库的文件;
        if (!file_exists($this->txtLogFile)) {
            return false;
        } else {
            $this->logID = count(file($this->txtLogFile))+1;    //用户ID 1，2，3，4
            return true;
        }
    }
    /**
     * 加入数据程序段。
     * $userinfo array  要插入的用户信息列表
     * $userinfo["userid"]$userinfo["username"]$userinfo["usercreatetime"]$userinfo["userlogintime"]$userinfo["userloginip"]
     * @return boolean 成功  true
     *  失败 false
     */
    public function insert()
    {
        try {
            $fp = fopen($this->txtLogFile, "a"); //以只写模式打开userlist.txt文本文件,文件指针指向文件尾部.
            $str = $this->logID . "|" . $this->logIP . "|"
                . $this->logTime ."|\r\n";
            //将所有用户的数据赋予变量$str，"|"的目的是用来今后作数据分割时的数据间隔符号。
                fwrite($fp, $str); //将数据写入文件
                fclose($fp); //关闭文件
                return true;
        } catch (Exception $e) {
            return false;
        }
    }
    public function show($userName)
    {
        if ($this->check($userName)) {
            if (file_exists($this->txtLogFile)) { //检测文件是否存在
                $array = file($this->txtLogFile); //将文件全部内容读入到数组$array
                $arr = array_reverse($array); //将$array里的数据安行翻转排列（即最后一行当第一行，依此类推）读入数组$arr的每一个单元（$arr[0]...）。
            }
            return $arr;
        }else{
            return array('err|err|user does not exist|');
        };
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
