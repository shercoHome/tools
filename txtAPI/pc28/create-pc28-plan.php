<?php

date_default_timezone_set("Asia/Chongqing");

echo '<meta http-equiv="content-type" content="text/html;charset=utf-8">';




$str='[{"name":"定位胆","item":[{"name":"百","item":[{"name":"四码","item":4},{"name":"五码","item":5},{"name":"六码","item":6},{"name":"七码","item":7}]},{"name":"十","item":[{"name":"四码","item":4},{"name":"五码","item":5},{"name":"六码","item":6},{"name":"七码","item":7}]},{"name":"个","item":[{"name":"四码","item":4},{"name":"五码","item":5},{"name":"六码","item":6},{"name":"七码","item":7}]}]},{"name":"和值","item":[{"name":"特码","item":[{"name":"14码","item":14}]},{"name":"大小","item":[{"name":"四码","item":4}]},{"name":"单双","item":[{"name":"一码","item":1}]},{"name":"大小单双","item":[{"name":"一码","item":1}]},{"name":"色波","item":[{"name":"一码","item":1}]}]}]';

$arr=json_decode($str);

$one_day_all_qi=179;
$name_="";
$positon_="";
$numbers_="";
$pk10 = '0123456789';
$pk10_ar = str_split($pk10);

$pc28='00010203040506070809101112131415161718192021222324252627';
$pc28_ar = str_split($pc28, 2);

$len1=count($arr);
for($x=1;$x<=50;$x++) { //100个计划

    $planOne=array();
    for ($x1=0;$x1<$len1;$x1++) { //玩法
        //$arr[$x1]->name="定位胆"   "和值"
        $temp2=$arr[$x1]->item;
        $len2=count($temp2);

        $type_arr=array();
        for ($x2=0;$x2<$len2;$x2++) { //10个定位
         //$temp2[$x2]->name="百" 十  个        "特码" "大小" "单双""大小单双" "色波"
            $temp3=$temp2[$x2]->item;
            $len3=count($temp3);

            $positon_arr=array();
            for ($x3=0;$x3<$len3;$x3++) {//码

                $temp4=$temp3[$x3]->item;

                $numbers_arr=array();
                for ($q=1;$q<=$one_day_all_qi;$q++) {//一天一共179期

                    if($arr[$x1]->name=="定位胆"){
                        //数组乱序
                        shuffle($pk10_ar);
                        //数组取长度
                        $pk10_ar_plan=array_slice($pk10_ar, 0, $temp4);
                        //数组排序
                        sort($pk10_ar_plan);
                        //数组转字符串
                        $random_pk10_qi = implode(",", $pk10_ar_plan);
                    }else{
                        
                        $random_one=mt_rand(0, 27);
                        switch($temp2[$x2]->name){
                            case "特码":
                            //数组乱序
                            shuffle($pc28_ar);
                            //数组取长度
                            $pc28_ar_plan=array_slice($pc28_ar, 0, 14);
                            //数组排序
                            sort($pc28_ar_plan);
                            //数组转字符串
                            $random_pk10_qi = implode(",", $pc28_ar_plan);
                            break;
                            case "大小":
                            $random_pk10_qi=getSize($random_one);
                            break;
                            case "单双":
                            $random_pk10_qi=getOddOrEven($random_one);
                            break;
                            case "大小单双":
                            $random_pk10_qi=getSize($random_one).getOddOrEven($random_one);
                            break;
                            case "色波":
                            $random_pk10_qi=getColor($random_one);
                            break;
                        }
                    }
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



// $name_="";
// $positon_="";
// $numbers_="";

// $one_day_all_qi=179;

// //$plan["三饭明知"]["亚"]["八"]

// $name_="";
// $positon_="";
// $numbers_="";
// $pk10 = '0123456789';
// $pk10_ar = str_split($pk10);

// $pc28='00010203040506070809101112131415161718192021222324252627';
// $pc28_ar = str_split($pc28, 2);
// for ($x=1;$x<=100;$x++) { //100个计划

//     $plan=array(); //一个计划
//     for ($y=1;$y<=8;$y++) {
//         $positon_arr=array();
//         for ($z=4;$z<=8;$z++) {//; 几码，本计划没有用到几码

//             $numbers_arr=array();
//             for ($q=1;$q<=$one_day_all_qi;$q++) {//一天一共179期
//                 $random_one=mt_rand(0, 27);
//                 switch ($y) {
//                 case 4:
//                     //数组乱序
//                     shuffle($pc28_ar);
//                     //数组取长度
//                     $pc28_ar_plan=array_slice($pc28_ar, 0, 14);
//                     //数组排序
//                     sort($pc28_ar_plan);
//                     //数组转字符串
//                     $random_pk10_qi = implode(",", $pc28_ar_plan);
//                     break;
//                 case 5:
//                    $random_pk10_qi=getSize($random_one);
//                    break;
//                 case 6:
//                    $random_pk10_qi=getOddOrEven($random_one);
//                    break;
//                 case 7:
//                    $random_pk10_qi=getSize($random_one).getOddOrEven($random_one);
//                    break;
//                 case 8:
//                    $random_pk10_qi=getColor($random_one);
//                    break;
//                 default:
//                     //数组乱序
//                     shuffle($pk10_ar);
//                     //数组取长度
//                     $pk10_ar_plan=array_slice($pk10_ar, 0, $z);
//                     //数组排序
//                     sort($pk10_ar_plan);
//                     //数组转字符串
//                     $random_pk10_qi = implode(",", $pk10_ar_plan);
//                 break;

//                }

//                 array_push($numbers_arr, $random_pk10_qi);///一个计划 里的 一个位置 的每一种码的每一期都有计划
//             }

//             array_push($positon_arr, $numbers_arr);///一个计划 里的 一个位置 有"四|五|六|七|八"码 四种买法
//         }

//         array_push($plan, $positon_arr);////一个计划 里包含 "1|2|3|和|大小|单双|大小单双|色波" 5种玩法
//     }
//     $plan_json=json_encode($plan);

//     add($x, $plan_json);
// }

 
  
  
function add($file_name, $str)
{

//echo '<!DOCTYPE HTML><html lang="zh-CN"><head><meta charset="utf-8"><title>*setTime</title></head><body>';

    $mk_dir="txt-plan";
  
    
    $mk_day=date("Ymd");

    if (date("h")<1) {
        $mk_day=date("Ymd", strtotime("-1 day"));
    }


    $file_type="txt";
        

    $path=$mk_dir."/".$mk_day."/".$file_name.".".$file_type;

    echo $path."-------";

    if (!file_exists($mk_dir)) {
        mkdir($mk_dir);
    }

    if (!file_exists($mk_dir."/".$mk_day)) {
        mkdir($mk_dir."/".$mk_day);
    }


    if (!file_exists($path)) {

       // $str = $file_name;

        file_put_contents($path, $str);

        echo "create succse \n";
        return true;
    } else {
        echo "create false \n";

        return false;
    }
}

function getSize($n)
{
    if ($n<14) {
        return "小";
    } else {
        return "大";
    }
};
function getOddOrEven($n)
{
    if ((abs($n)+2)%2==1) {
        return "单";
    } else {
        return "双";
    }
};
function getColor($n)
{
    if ((abs($n)+3)%3==1) {
        return "绿";
    } elseif ((abs($n)+3)%3==2) {
        return "蓝";
    } else {
        return "红";
    }
};
