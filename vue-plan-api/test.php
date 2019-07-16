<?php 
date_default_timezone_set("Asia/Chongqing");

$mk_day=date("Ymd");


 $nowtime=date("Y-m-d H:i:s");
 echo "<br>nowtime=" . $nowtime;
 $firstTime=date("Y-m-d")." 04:09:00";

 echo "<br>firstTime=" .  $firstTime;


 if (strtotime($nowtime)<strtotime($firstTime)) {
     $mk_day=date("Ymd", strtotime("-1 day"));
 }
 echo "<br>".$mk_day;
?>