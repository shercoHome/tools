﻿<?php 

date_default_timezone_set("Asia/Chongqing");

echo '<meta http-equiv="content-type" content="text/html;charset=utf-8">';

$str='[{"name":"定位胆","item":[{"name":"冠","item":[{"name":"四码","item":4},{"name":"五码","item":5},{"name":"六码","item":6},{"name":"七码","item":7}]},{"name":"亚","item":[{"name":"四码","item":4},{"name":"五码","item":5},{"name":"六码","item":6},{"name":"七码","item":7}]},{"name":"季","item":[{"name":"四码","item":4},{"name":"五码","item":5},{"name":"六码","item":6},{"name":"七码","item":7}]}]}]';

$arr=json_decode($str);

$one_day_all_qi=44;
$name_="";
$positon_="";
$numbers_="";
$pk10 = '01020304050607080910';
$pk10_ar = str_split($pk10,2);


for($x=1;$x<=50;$x++) { //100个计划
    $len1=count($arr);
    $planOne=array();
    for ($x1=0;$x1<$len1;$x1++) { //玩法

        $temp2=$arr[$x1]->item;
        $len2=count($temp2);

        $type_arr=array();
        for ($x2=0;$x2<$len2;$x2++) { //10个定位
        
            $temp3=$temp2[$x2]->item;
            $len3=count($temp3);

            $positon_arr=array();
            for ($x3=0;$x3<$len3;$x3++) {//码

                $temp4=$temp3[$x3]->item;

                $numbers_arr=array();
                for ($q=1;$q<=$one_day_all_qi;$q++) {//一天一共179期

                    //数组乱序
                    shuffle($pk10_ar);
                    //数组取长度
                    $pk10_ar_plan=array_slice($pk10_ar, 0, $temp4);
                    //数组排序
                    sort($pk10_ar_plan);
                    //数组转字符串
                    $random_pk10_qi = implode(",", $pk10_ar_plan);

                    array_push($numbers_arr, $random_pk10_qi);
                }
                array_push($positon_arr, $numbers_arr);
            }
            array_push($type_arr, $positon_arr);
        }
        array_push($planOne, $type_arr);
    }

    $plan_json=json_encode($planOne);

    add($x,$plan_json);
}
 
  
  
function add($file_name,$str){

//echo '<!DOCTYPE HTML><html lang="zh-CN"><head><meta charset="utf-8"><title>*setTime</title></head><body>';

$mk_dir="txt-plan"; 
  
    
$mk_day=date("Ymd");

if(date("h")<1){

   $mk_day=date("Ymd",strtotime("-1 day"));     

}


$file_type="txt";
		

$path=$mk_dir."/".$mk_day."/".$file_name.".".$file_type;

echo $path."-------";

if(!file_exists($mk_dir)){mkdir ($mk_dir);  }

if(!file_exists($mk_dir."/".$mk_day)){mkdir ($mk_dir."/".$mk_day);  }


if (!file_exists($path)){

       // $str = $file_name;

        file_put_contents($path, $str);

        echo "create succse \n";
return true;

    }

else{
	echo "create false \n";

return false;

}

}


    
      
    ?>