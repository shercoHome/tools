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
class api
{
    private $id;
    private $switch;
    private $lotteryID;
    private $lotteryname;
    private $link;
    private $dir;
    private $code;
    private $strPlanName;
    private $strPosition;
    private $strQis;
    private $strNumbers;
    private $str_numbers_show;
    private $maxPeriod;
    private $intervalPeriod;
    private $delayPeriod;
    private $defaultPlanQi;
    private $defaultPlanPosition;
    private $defaultNumbers;
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
        
        $this->id='0';//唯一标识
        $this->switch='0';//是否开启
        $this->lotteryID='xy';//彩种代号
        $this->lotteryname='幸运极速PK10';//彩种名称
        $this->link='http://154.92.177.252/api/';//彩种api链接
        $this->dir='pk10-js-xy';//数据存储文件夹
        $this->code='10';//开奖号码个数
        $this->strPlanName='百折不挠|金蝉脱壳|百里挑一|金玉满堂|壮志凌云|霸王别姬|天上人间|不吐不快|海阔天空|情非得已|满腹经纶|坚定不移|春暖花开|奋发图强|黄道吉日|天下无双|偷天换日|两小无猜|卧虎藏龙|珠光宝气|簪缨世族|花花公子|绘声绘影|国色天香|相亲相爱|八仙过海|金玉良缘|掌上明珠|皆大欢喜|生财有道|极乐世界|情不自禁|坚持不懈|魑魅魍魉|龙生九子|持之以恒|勇往直前|高山流水|卧薪尝胆|壮志凌云|金枝玉叶|四海一家|穿针引线|无忧无虑|坚毅顽强|三位一体|落叶归根|相见恨晚|惊天动地|滔滔不绝|相濡以沫|长生不死|原来如此|女娲补天|三皇五帝|斗志昂扬|水木清华|破釜沉舟|天涯海角|牛郎织女|倾国倾城|飘飘欲仙|福星高照|朝气蓬勃|永无止境|学富五车|饮食男女|英雄豪杰|国士无双|力争上游|万家灯火|石破天惊|精忠报国|养生之道|覆雨翻云|六道轮回|鹰击长空|日日夜夜|厚德载物|锲而不舍|万里长城|黄金时代|出生入死|一路顺风|随遇而安|千军万马|棋逢对手|叶公好龙|至死不懈|守株待兔|凤凰于飞|一生一世|花好月圆|世外桃源|韬光养晦|坚忍不拔|青梅竹马|风花雪月|英勇无畏|总而言之';//计划名称
        $this->strPosition='[{"name":"定位胆","item":[{"name":"冠","item":[{"name":"四码","item":4},{"name":"五码","item":5},{"name":"六码","item":6},{"name":"七码","item":7}]},{"name":"亚","item":[{"name":"四码","item":4},{"name":"五码","item":5},{"name":"六码","item":6},{"name":"七码","item":7}]},{"name":"季","item":[{"name":"四码","item":4},{"name":"五码","item":5},{"name":"六码","item":6},{"name":"七码","item":7}]}]}]';//玩法
        $this->strQis='一期|二期|三期|四期|五期';//期数
        $this->strNumbers='isNull';//几码
        $this->str_numbers_show='isNull';//
        $this->maxPeriod='1440';//一天的期数
        $this->intervalPeriod='60';//每期间隔
        $this->delayPeriod='10';//封盘时间
        $this->defaultPlanQi='2';//默认几期
        $this->defaultPlanPosition='0';//默认玩法
        $this->defaultNumbers='1';//默认几码
        $this->mark1='0';//备注1 排序（数字大在前）
        $this->mark2='pk10';//备注2 分类
        $this->mark3='00:00:00|-|23:59:59';//备注3 开奖时间
        $this->mark4='isNull';//备注1
        $this->mark5='isNull';//备注1
        
    }
    /**
     * 插入新的用户
     * @param userinfo array('userID'='',a=''...);
     * @return Boolean false  失败，ip已存在
     * @return String  错误信息  失败
     * @return Boolean true    成功
     */
    public function insert($userinfo)
    {
        if(array_key_exists('switch', $userinfo)) {$this->switch=$userinfo ['switch'];}
        if(array_key_exists('lotteryID', $userinfo)) {$this->lotteryID=$userinfo ['lotteryID'];}
        if(array_key_exists('lotteryname', $userinfo)) {$this->lotteryname=$userinfo ['lotteryname'];}
        if(array_key_exists('link', $userinfo)) {$this->link=$userinfo ['link'];}
        if(array_key_exists('dir', $userinfo)) {$this->dir=$userinfo ['dir'];}
        if(array_key_exists('code', $userinfo)) {$this->code=$userinfo ['code'];}
        if(array_key_exists('strPlanName', $userinfo)) {$this->strPlanName=$userinfo ['strPlanName'];}
        if(array_key_exists('strPosition', $userinfo)) {$this->strPosition=$userinfo ['strPosition'];}
        if(array_key_exists('strQis', $userinfo)) {$this->strQis=$userinfo ['strQis'];}
        if(array_key_exists('strNumbers', $userinfo)) {$this->strNumbers=$userinfo ['strNumbers'];}
        if(array_key_exists('str_numbers_show', $userinfo)) {$this->str_numbers_show=$userinfo ['str_numbers_show'];}
        if(array_key_exists('maxPeriod', $userinfo)) {$this->maxPeriod=$userinfo ['maxPeriod'];}
        if(array_key_exists('intervalPeriod', $userinfo)) {$this->intervalPeriod=$userinfo ['intervalPeriod'];}
        if(array_key_exists('delayPeriod', $userinfo)) {$this->delayPeriod=$userinfo ['delayPeriod'];}
        if(array_key_exists('defaultPlanQi', $userinfo)) {$this->defaultPlanQi=$userinfo ['defaultPlanQi'];}
        if(array_key_exists('defaultPlanPosition', $userinfo)) {$this->defaultPlanPosition=$userinfo ['defaultPlanPosition'];}
        if(array_key_exists('defaultNumbers', $userinfo)) {$this->defaultNumbers=$userinfo ['defaultNumbers'];}
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
     
        $sql = "INSERT INTO api (switch,lotteryID,lotteryname,link,dir,code,strPlanName,strPosition,strQis,strNumbers,str_numbers_show,maxPeriod,intervalPeriod,delayPeriod,defaultPlanQi,defaultPlanPosition,defaultNumbers)
            VALUES ('$this->switch', '$this->lotteryID', '$this->lotteryname', '$this->link', '$this->dir', '$this->code', '$this->strPlanName', '$this->strPosition', '$this->strQis', '$this->strNumbers', '$this->str_numbers_show', '$this->maxPeriod', '$this->intervalPeriod', '$this->delayPeriod', '$this->defaultPlanQi', '$this->defaultPlanPosition', '$this->defaultNumbers')";
     
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

        $sql="SELECT * FROM api ";
        $sql.=" WHERE 1 ";
        if (array_key_exists("lotteryID", $userinfo)) { //
            $this->lotteryID=$userinfo ["lotteryID"]; 
            $sql.=" AND lotteryID='$this->lotteryID' ";  
        }
        if (array_key_exists("id", $userinfo)) { //
            $this->id=$userinfo ["id"]; 
            $sql.=" AND id='$this->id' ";  
        }
        if (array_key_exists("switch", $userinfo)) { //
            $this->id=$userinfo ["switch"]; 
            $sql.=" AND switch='$this->switch' ";  
        }
        


        if (array_key_exists("sort", $userinfo)) {
            $sort = $userinfo ["sort"]; 
            
            if($sort=="1"){$sql.=" ORDER BY id DESC";}// <el-option label="登录倒序" value="1"></el-option>
            if($sort=="2"){$sql.=" ORDER BY id";}// <el-option label="登录顺序" value="2"></el-option>
            if($sort=="3"){$sql.=" ORDER BY mark1 DESC";}// <el-option label="注册倒序" value="3"></el-option>
            if($sort=="4"){$sql.=" ORDER BY mark1";}// <el-option label="注册顺序" value="4"></el-option>
            if($sort=="5"){$sql.=" ORDER BY switch DESC, mark1 DESC";}// <el-option label="授权倒序" value="5"></el-option>
            if($sort=="6"){$sql.=" ORDER BY switch ,mark1";}// <el-option label="授权顺序" value="6"></el-option>

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

    /**
     * update
     * @param  userinfo	是否开启	1	关闭0，开启1
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
        $sql="UPDATE api SET $updateSqlStr WHERE id='$this->id'";

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

    /**
     * delete
     * @param  id
     * @return Boolean false  失败，
     * @return Boolean true   成功，
     */
    public function delete($userinfo=array())
    {


        foreach ($userinfo as $key => $value) {
            $userinfo[$key] = trim($value); //去掉用户内容后面的空格.
        }

  
        
        if (array_key_exists('lotteryID', $userinfo)) {
            $this->lotteryID=$userinfo ['lotteryID'];

            $sql="DELETE FROM api WHERE lotteryID='$this->lotteryID'";
        }

        if (array_key_exists('id', $userinfo)) {
            $this->id=$userinfo ['id'];

            $sql="DELETE FROM api WHERE id='$this->id'";
        }
      


        $flag=false;

        // 创建连接
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // 检测连接
        if ($conn->connect_error) {
            die("connect_error: " . $conn->connect_error);
            return $flag;
        }
        $retval=mysqli_query($conn, $sql);
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
