<?php
date_default_timezone_set("Asia/Chongqing");
// php实现对文本数据库的数据显示、加入、修改、删除、查询五大基本操作的方法。

// private $txtShareMk;  //储存分享码数据库的文件夹;
// private $txtShareFile;  //储存分享码数据库的文件，完整的路径和文件名;

// private $userShareCode;  //用户分享码,  文本的文件名

// 此文本数据库共有字段4个：
// private $shareID;  //用户分享码IP
// private $shareIP;  //用户分享码IP
// private $shareTime;   //用户分享码时间
// private $shareCount;   //用户分享码时间
// @abstract   TxtDB store
// @access     public
// @author
class DBshare
{
    private $txtShareMk;  //储存分享码数据库的文件夹;
    private $txtShareFile;  //储存分享码数据库的文件;

    private $userShareCode;  //用户分享码

    private $shareID;  //用户分享码IP
    private $shareIP;  //用户分享码IP
    private $shareTime;   //用户分享码时间
    private $shareCount;   //用户分享码时间


    public function __construct()
    {
        $this->txtShareMk=dirname(__FILE__)."/txt/share/";  //储存用户分享码数据库的文件夹;


        $this->shareID = '';    //用户ID 1，2，3，4
        $this->shareIP=$this->getIp();  //用户分享IP
        $this->shareTime= date("Y-m-d H:i:s");   //用户分享时间
        $this->shareCount=1;   //用户分享码次数
    }

    /**
     * 检测分享码是否存在
     * @return boolean 成功  true
     *  失败 false
     */
    public function check($userShareCode)
    {
        $this->userShareCode=$userShareCode;  //用户分享码
        $this->txtShareFile=$this->txtShareMk.$this->userShareCode.".txt";  //储存用户分享码数据库的文件;
        if (!file_exists($this->txtShareFile)) {
            return false;
        } else {
            $this->shareID = count(file($this->txtShareFile))+1;    //用户ID 1，2，3，4
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
        if (!$this->select($this->shareIP)) {//判断shareIP是否存在
            try {
                $fp = fopen($this->txtShareFile, "a"); //以只写模式打开userlist.txt文本文件,文件指针指向文件尾部.
                $str = $this->shareID . "|" . $this->shareIP . "|"
                . $this->shareTime ."|" . $this->shareCount ."|\r\n";
                //将所有用户的数据赋予变量$str，"|"的目的是用来今后作数据分割时的数据间隔符号。
                fwrite($fp, $str); //将数据写入文件
                fclose($fp); //关闭文件
                return true;
            } catch (Exception $e) {
                return false;
            }
        } else {//此ip增加1次访问记录
            $this->alter($this->shareIP);
            return false;
        };
    }

    public function show($userShareCode)
    {
        if ($this->check($userShareCode)) {
            //数据显示程序段
            if (file_exists($this->txtShareFile)) { //检测文件是否存在
                $array = file($this->txtShareFile); //将文件全部内容读入到数组$array
                $arr = array_reverse($array); //将$array里的数据安行翻转排列（即最后一行当第一行，依此类推）读入数组$arr的每一个单元（$arr[0]...）。
            }
            return $arr;
        } else {
            return array('err|err|code does not exist|');
        }
    }

    /**
     * 数据修改程序段
     * $userinfo array  要插入的用户信息列表
     * $userinfo["userid"]$userinfo["username"]$userinfo["usercreatetime"]$userinfo["userlogintime"]$userinfo["userloginip"]
     * @return boolean 成功  true
     *  失败 false
     */
    public function alter($shareIP)//ip访问次数加1
    {
        $list = file($this->txtShareFile); //读取整个userlist.txt文件到数组$list,数组每一个元素为一条用户($list[0]是第一条用户的数据、$list[1]是第二条用户的数据.....
        $n = count($list); //计算$list内容里的用户总数,并赋予变量$n

        if ($n > 0) { //如果用户数大于0
            $fp = fopen($this->txtShareFile, "w"); //则以只写模式打开文件userlist.txt
            for ($i = 0; $i < $n; $i ++) { //进入循环
                $f = explode("|", $list [$i]);

                if ($shareIP==$f[1]) { //将传用户userid与数组单元$list里内容进行字串匹配比较
                    // $f = explode("|", $list [$i]); //如果找到匹配，就以"|"作为分隔符,切开用户信息$list[$i](第$i条用户),并将这些数据赋予数组$f
                    $list [$i] = $f [0] . "|" . $f [1] . "|" . $this->shareTime . "|" . ($f [3]+1) . "|\r\n";
                    //将数组单元$list[$i]的内容用数组$f加上分隔符"|"代替。
                    break; //跳出循环
                }
            }//循环结束符
        }
        fclose($fp); //关闭文件
        $fwriteResult=file_put_contents($this->txtShareFile, $list);
        return $fwriteResult;
    }

    /**
     * 数据删除程序段
     * @param   $userid 用户id号
     * @return boolean true 成功
     * false 失败
     *
     */
    // public function delete($userid)
    // {
    //     $list = file($this->txtShareFile); //读取整个userlist.txt文件到数组$list,数组每一个元素为一条用户($list[0]是第一条用户的数据、$list[1]是第一条用户的数据.....
    //     $n = count($list); //计算$list内容里的用户总数,并赋予变量$n
    //     if ($n > 0) { //如果用户数大于0
    //         $fp = fopen($this->txtShareFile, "w"); //则以只写模式打开文件userlist.txt
    //         for ($i = 0; $i < $n; $i ++) { //进入循环

    //             $row = explode("|", $list [$i]);
    //             if ($userid==$row[0]) { //将发送过来的用户$userid与数组$list[$i]里的字串进行匹配比较
    //                 $list [$i] = ""; //如果匹配成功，则将$list[$i]清空（达到删除的目的）
    //                 break; //跳出循环
    //             }
    //         } //循环结束符
    //         for ($i = 0; $i <= $n; $i ++) { //进入循环
    //             fwrite($fp, $list [$i]); //将数组$list的每个单元为一行，写入文件userlist.txt
    //         } //循环结束符
    //         fclose($fp); //关闭文件
    //     }
    // }

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

        $list = file($this->txtShareFile); //读取整个userlist.txt文件到数组$list,
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
