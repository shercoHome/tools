<?php
$origin = isset($_SERVER['HTTP_ORIGIN'])? $_SERVER['HTTP_ORIGIN'] : '';
$allow_origin = array(
    'http://localhost:8080',
    'http://192.168.0.117:8080',
    'http://192.168.0.117:8081',
    'http://www.beer668.cn',
    'http://www.ezun666.cn'
);
if (in_array($origin, $allow_origin)) {
    header('Access-Control-Allow-Origin:'.$origin);
}
$json_result=array("code"=>"-2","msg"=>"null","data"=>array());

if (is_array($_POST)&&count($_POST)>0) {
    if (isset($_POST["type"])) {
        if (strlen($_POST["type"])>0) {
            switch ($_POST["type"]) {
                case 'check':
                    checkUser($_POST["username"]);
                    break;
                case 'regist':
                    userRegister($_POST["username"], $_POST["password"], $_POST["aff"]);
                    break;
                case 'login':
                    userLogin($_POST["username"], $_POST["password"]);
                    break;
                case 'share':
                    addShare($_POST["shareCode"]);
                    break;
                default:
            }
        }
    }
}
//checkUser('zhangsan');
//userRegister('zhangsan', 'whatfuck');
//userLogin('zhangsan', 'whatfuck');
//addShare("e866c57eebb59cb2a3f2339d4c9a21f4");




/**
 * 登录
 * @param   $name 账号   $psw  密码
 * @return json_encode
 */
function userLogin($name, $psw)
{
    if (!isMatch($name)) {
        $json_result=array("code"=>"-1","msg"=>"账号错误","data"=>array());
    } elseif (!isMatch($psw)) {
        $json_result=array("code"=>"-1","msg"=>"密码错误","data"=>array());
    } else {
        require_once 'DB/DBuser.php';
        $DBuser=new DBuser();
        $isExist=$DBuser->select($name);
        if ($isExist) {//判断用户是否存在
            $DBpsw=$isExist[2];
            $inputPassWord=$DBuser->createPassWord($psw);
            if ($DBpsw==$inputPassWord) {


                //加入登录日志
                require_once 'DB/DBlog.php';
                $DBlog=new DBlog();
                if ($DBlog->check($name)) {
                    $DBlog->insert();
                };
                
                //刷新授权
                require_once 'DB/DBshare.php';
                $DBshare=new DBshare();
                $shareCode=$isExist[5];
                if ($DBshare->check($shareCode)) {
                    $shareArray=$DBshare->show();
                    //返回文本数据的内容 每一行一条数据
                    //每一行的内容：0-id  1-ip  2-time
                    //var_dump($shareArray);
                    $shareCount=count($shareArray);
                    // var_dump($shareCount);

                    // 在此读取配置表，对比授权要求，并更正授权状态
                    require_once 'DB/DBset.php';
                    $DBset=new DBset();
                    $json_set=$DBset->show();//读取配置表中
   
                    $userAuthorizeUpdate="0";
                    if($shareCount>=$json_set['shareRequired']){//对比授权要求
                        $userAuthorizeUpdate="1";
                    }
                    if($isExist[6]!=$userAuthorizeUpdate){
                        //授权有变，更正授权状态
                        $isExist[6]=$userAuthorizeUpdate;
                        $DBuser->alter($name,$userAuthorizeUpdate);
                    }
                    if (in_array($name, $json_set['authorizeWhite'])) {//白名单检测
                        $isExist[6]="2";//白名单授权，不写入会员列表
                    }

                    $isExist[8]=$shareCount;
                    $isExist[9]=$json_set['shareRequired'];
                } else {
                    // echo shareCode 不正确？ 程序出错了
                }

                //0-id 1-user 2-psw 3-time 4-ip 5-code 6-userAuthorize
                $json_result=array("code"=>"1","msg"=>"登录成功","data"=>$isExist);
            } else {
                $json_result=array("code"=>"0","msg"=>"密码错误","data"=>array());
            }
        } else {
            $json_result=array("code"=>"-1","msg"=>"账号不存在","data"=>array());
        }
    }
    echo json_encode($json_result);
}

/**
 * 检查用户名是否存在
 * @param   $name 账号
 * @return json_encode
 */
function checkUser($name)
{
    if (isMatch($name)) {
        require_once 'DB/DBuser.php';
        $DBuser=new DBuser();

        $json_result=array("code"=>"0","msg"=>"账号可用","data"=>array());

        if ($DBuser->select($name)) {//判断用户是否存在
            $json_result=array("code"=>"-1","msg"=>"账号已存在","data"=>array());
        }
    } else {
        $json_result=array("code"=>"-1","msg"=>"账号为6-15位英文字母、数字或下划线","data"=>array());
    }
    echo json_encode($json_result);
}

/**
 * 注册
 * @param    $name 账号   $psw  密码
 * @return json_encode
 */
function userRegister($name, $psw, $aff)
{
    if (!isMatch($name)) {
        $json_result=array("code"=>"-1","msg"=>"账号为6-15位英文字母、数字或下划线","data"=>array());
    } elseif (!isMatch($psw)) {
        $json_result=array("code"=>"-1","msg"=>"密码为6-15位英文字母、数字或下划线","data"=>array());
    } else {
        require_once 'DB/DBuser.php';
        $DBuser=new DBuser();
        if ($DBuser->select($name)) {//判断用户是否存在
            $json_result=array("code"=>"-1","msg"=>"账号已存在","data"=>array());
        } else {
            $userInfo=array("userName"=>$name,"userPassWord"=>$psw,"aff"=>$aff);
            $isInsert=$DBuser->insert($userInfo);
            if ($isInsert) {
                $json_result=array("code"=>"1","msg"=>"注册成功","data"=>$isInsert);
            } else {
                $json_result=array("code"=>"0","msg"=>"注册失败","data"=>array());
            }
        }
    }
    echo json_encode($json_result);
}
/**
 * 增加分享、访问次数
 * @param   $shareCode 分享码
 * @return json_encode
 */
function addShare($shareCode)
{
    require_once 'DB/DBshare.php';
    $DBshare=new DBshare();
    
    if ($DBshare->check($shareCode)) {
        if ($DBshare->insert()) {
            $json_result=array("code"=>"1","msg"=>"Share +1","data"=>array());
        } else {
            $json_result=array("code"=>"-1","msg"=>"Visits +1","data"=>array());
        }
    } else {
        $json_result=array("code"=>"-1","msg"=>"shareCode err","data"=>array());
    }
    echo json_encode($json_result);
}


function isMatch($str)
{
    if (preg_match('/^[a-zA-Z0-9_]{6,15}$/', $str)) {
        return true;
    } else {
        return false;
    }
}
