<?php

 $json_result=array("code"=>"1","msg"=>"planId success","data"=>array());


 require_once 'class.adminLimit.php';
 $DBadminLimit=new adminLimit();
 $__copyAdminLimit=$DBadminLimit->copy('2', '38');
var_dump( $__copyAdminLimit);
 exit();
    $userID="5";
    $loginLink="ezun668.com";$fromLink="baidu.com";$loginToken="2938490sd3jf3";

    require_once 'class.authorizationWBStatus.php';
    $authorizationWBStatus=new authorizationWBStatus();

    //echo json_encode($authorizationWBStatus);
    $t1= strtotime("2019-03-10 20:10:28");

    $t2=strtotime("-4 days");
    // echo date('Y-m-d H:i:s', $t2);
    echo  $t1;
    echo  "-";
    echo  $t2;
    echo  "=";
     echo  $t1-$t2;  // 》0  还没有到期

    require_once 'class.common.php';
    $common=new commonFun();
    //echo $common->caesar(base64_encode($common->add0str(1)));
    echo "<hr>";
    echo $common->encrypt("klasdjfkl3333");
    echo "<hr>";
    echo $common->decrypt("zqDE1JicmaPNY5VsZQ==");
    echo "<hr>";
    require_once 'class.shareIP.php';
    $shareIP=new shareIP();


    $re_list=$shareIP->show('6iP26i72');
    var_dump($re_list);

    require_once 'class.user.php';
    $user=new user();

    // $nextuserList=$user->showAgentListByAgentID('9');

    // var_dump($nextuserList);



    $userID="5";
    // $user->update(array(
    //     "id"=>$userID,
    //     "shareCode"=>$userID
    // ));

    $re=$user->isAdmin(array(
        "id"=>'4'
    ));

    //var_dump($re);

    //$user->insert("zhangsan","123qwe");

    //$re=$user->show();
    //$re=$user->show(array("userName"=>"zhangsan"));

   // echo json_encode($re);

//创建一个总代账号作为管理员

// $adminInfo=array(
//     "userName"=>"admin",
//     "userPsw"=>"123qwe",
//     "authorizationStatus"=>"3",//特别授权
//     "authorizationLimite"=>"0",//永久授权
//     "userLevel"=>"1",//总代
//     "agentStatus"=>"1"//是代理
// );
// $adminID=$user->insert($adminInfo);
$adminID="1";
//层次关系都指向自身
// $adminInfo2=array(
//     "id"=>$adminID,
//     "agentAdmin"=>$adminID,
//     "agentTop"=>$adminID,
//     "agentDirect"=>$adminID,
//     "creater"=>$adminID,
// );
// $user->update($adminInfo2);

// $userinfo2222=$user->show(array("id"=>$adminID));

//     echo "<br>".json_encode($userinfo2222);

    require_once 'class.logLogin.php';
    $logLogin=new logLogin();
    //插入登录日志
    // $toLogLogin=$logLogin->insert($userID,$loginLink,$fromLink,$loginToken);
    // if($toLogLogin===true){
    //     $json_result=array("code"=>"1","msg"=>"toLogLogin success","data"=>array());
    // }else{
    //     $json_result=array("code"=>"2","msg"=>"toLogLogin false","data"=>$toLogLogin);
    // }
    // echo json_encode($json_result);

    $userID="5";
    $token="4cf9503c19bf5151613c35721a0a0040";
    $webID="3";
    //检查token时效
    // $toCheckLogin=$logLogin->checkToken($userID,$token,$webID);
    // if($toCheckLogin===true){
    //     $json_result=array("code"=>"1","msg"=>"toCheckLogin success","data"=>array());
    // }else{
    //     $json_result=array("code"=>"2","msg"=>"toCheckLogin false","data"=>$toCheckLogin);
    // }
    // echo json_encode($json_result);

    $userID="1";
    //返回日志
    // $toShowLogin=$logLogin->show($userID,1);
    // if($toShowLogin){
    //     $json_result=array("code"=>"1","msg"=>"toShowLogin success","data"=>$toShowLogin);
    // }else{
    //     $json_result=array("code"=>"2","msg"=>"toShowLogin false","data"=>$toShowLogin);
    // }
    // echo json_encode($json_result);



    // require_once 'class.logSubmit.php';
    // $logSubmit=new logSubmit();
    // $re = $logSubmit->delete(1);
    // var_dump($re);
    


    /**
 * 增加分享、访问次数
 * @param   $shareCode 分享码
 * @return json_encode
 */
//addShare('aaa489126489123');
function addShare($shareCode)
{
    require_once 'class.shareIP.php';
    $shareIP=new shareIP();
    
    if ($shareIP->checkCode($shareCode)) {
        if ($shareIP->insert()) {
            $json_result=array("code"=>"1","msg"=>"Share +1","data"=>array());
        } else {
            $json_result=array("code"=>"-1","msg"=>"Visits +1","data"=>array());
        }
    } else {
        $json_result=array("code"=>"-1","msg"=>"shareCode err","data"=>array());
    }
    echo json_encode($json_result);
}
