﻿<?php
date_default_timezone_set("Asia/Chongqing");
echo '<meta http-equiv="content-type" content="text/html;charset=utf-8">';

$str='[{"name":"定位胆","item":[{"name":"无","item":[{"name":"一码","item":1}]}]},{"name":"和值","item":[{"name":"特码","item":[{"name":"12码","item":12},{"name":"11码","item":11},{"name":"10码","item":10}]},{"name":"大小","item":[{"name":"一码","item":1}]},{"name":"单双","item":[{"name":"一码","item":1}]},{"name":"大小单双","item":[{"name":"一码","item":1}]},{"name":"三军定胆","item":[{"name":"一码","item":1}]}]}]';

$arr=json_decode($str);

$one_day_all_qi=288;
$name_="";
$positon_="";
$numbers_="";
$pk10 = '123456';
$pk10_ar = str_split($pk10);

$pc28='03040506070809101112131415161718';
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
                        
                  
                        $random_sum=mt_rand(3, 18);
                        $random_one=mt_rand(1, 6);
                        switch($temp2[$x2]->name){
                            case "特码":
                            //数组乱序
                            shuffle($pc28_ar);
                            //数组取长度
                            $pc28_ar_plan=array_slice($pc28_ar, 0, $temp4);
                            //数组排序
                            sort($pc28_ar_plan);
                            //数组转字符串
                            $random_pk10_qi = implode(",", $pc28_ar_plan);
                            break;
                            case "大小":
                            $random_pk10_qi=getSize($random_sum);
                            break;
                            case "单双":
                            $random_pk10_qi=getOddOrEven($random_sum);
                            break;
                            case "大小单双":
                            $random_pk10_qi=getSize($random_sum).getOddOrEven($random_sum);
                            break;
                            case "三军定胆":
                            $random_pk10_qi=$random_one;
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

    echo "<br>--".$path."--\n";

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
    if ($n<11) {
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
