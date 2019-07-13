<?php

date_default_timezone_set("Asia/Chongqing");

echo '<meta http-equiv="content-type" content="text/html;charset=utf-8">';

//[{"name":"定位胆","item":[{"name":"万位","item":[{"name":"四码","item":4},{"name":"五码","item":5},{"name":"六码","item":6},{"name":"七码","item":7}]},{"name":"千位","item":[{"name":"四码","item":4},{"name":"五码","item":5},{"name":"六码","item":6},{"name":"七码","item":7}]},{"name":"百位","item":[{"name":"四码","item":4},{"name":"五码","item":5},{"name":"六码","item":6},{"name":"七码","item":7}]},{"name":"十位","item":[{"name":"四码","item":4},{"name":"五码","item":5},{"name":"六码","item":6},{"name":"七码","item":7}]},{"name":"个位","item":[{"name":"四码","item":4},{"name":"五码","item":5},{"name":"六码","item":6},{"name":"七码","item":7}]}]},{"name":"大小定位","item":[{"name":"万位","item":[{"name":"一码","item":1}]},{"name":"千位","item":[{"name":"一码","item":1}]},{"name":"百位","item":[{"name":"一码","item":1}]},{"name":"十位","item":[{"name":"一码","item":1}]},{"name":"个位","item":[{"name":"一码","item":1}]}]},{"name":"单双定位","item":[{"name":"万位","item":[{"name":"一码","item":1}]},{"name":"千位","item":[{"name":"一码","item":1}]},{"name":"百位","item":[{"name":"一码","item":1}]},{"name":"十位","item":[{"name":"一码","item":1}]},{"name":"个位","item":[{"name":"一码","item":1}]}]},{"name":"和值","item":[{"name":"大小","item":[{"name":"四码","item":4}]},{"name":"单双","item":[{"name":"一码","item":1}]},{"name":"大小单双","item":[{"name":"一码","item":1}]}]},{"name":"五星","item":[{"name":"定胆","item":[{"name":"一码","item":1}]}]},{"name":"组三","item":[{"name":"前三","item":[{"name":"七码","item":7},{"name":"八码","item":8},{"name":"九码","item":9}]},{"name":"中三","item":[{"name":"七码","item":7},{"name":"八码","item":8},{"name":"九码","item":9}]},{"name":"后三","item":[{"name":"七码","item":7},{"name":"八码","item":8},{"name":"九码","item":9}]}]},{"name":"组六","item":[{"name":"前三","item":[{"name":"六码","item":6},{"name":"七码","item":7},{"name":"八码","item":8},{"name":"九码","item":9}]},{"name":"中三","item":[{"name":"六码","item":6},{"name":"七码","item":7},{"name":"八码","item":8},{"name":"九码","item":9}]},{"name":"后三","item":[{"name":"六码","item":6},{"name":"七码","item":7},{"name":"八码","item":8},{"name":"九码","item":9}]}]}]

$str='[{"name":"定位胆","item":[{"name":"万","item":[{"name":"四码","item":4},{"name":"五码","item":5},{"name":"六码","item":6},{"name":"七码","item":7}]},{"name":"千","item":[{"name":"四码","item":4},{"name":"五码","item":5},{"name":"六码","item":6},{"name":"七码","item":7}]},{"name":"百","item":[{"name":"四码","item":4},{"name":"五码","item":5},{"name":"六码","item":6},{"name":"七码","item":7}]},{"name":"十","item":[{"name":"四码","item":4},{"name":"五码","item":5},{"name":"六码","item":6},{"name":"七码","item":7}]},{"name":"个","item":[{"name":"四码","item":4},{"name":"五码","item":5},{"name":"六码","item":6},{"name":"七码","item":7}]}]},{"name":"大小定位","item":[{"name":"万","item":[{"name":"一码","item":1}]},{"name":"千","item":[{"name":"一码","item":1}]},{"name":"百","item":[{"name":"一码","item":1}]},{"name":"十","item":[{"name":"一码","item":1}]},{"name":"个","item":[{"name":"一码","item":1}]}]},{"name":"单双定位","item":[{"name":"万","item":[{"name":"一码","item":1}]},{"name":"千","item":[{"name":"一码","item":1}]},{"name":"百","item":[{"name":"一码","item":1}]},{"name":"十","item":[{"name":"一码","item":1}]},{"name":"个","item":[{"name":"一码","item":1}]}]},{"name":"和值","item":[{"name":"大小","item":[{"name":"四码","item":4}]},{"name":"单双","item":[{"name":"一码","item":1}]},{"name":"大小单双","item":[{"name":"一码","item":1}]}]},{"name":"龙虎","item":[{"name":"万个","item":[{"name":"一码","item":1}]}]},{"name":"五星","item":[{"name":"定胆","item":[{"name":"一码","item":1}]}]},{"name":"组三","item":[{"name":"前三","item":[{"name":"七码","item":7},{"name":"八码","item":8},{"name":"九码","item":9}]},{"name":"中三","item":[{"name":"七码","item":7},{"name":"八码","item":8},{"name":"九码","item":9}]},{"name":"后三","item":[{"name":"七码","item":7},{"name":"八码","item":8},{"name":"九码","item":9}]}]},{"name":"组六","item":[{"name":"前三","item":[{"name":"六码","item":6},{"name":"七码","item":7},{"name":"八码","item":8},{"name":"九码","item":9}]},{"name":"中三","item":[{"name":"六码","item":6},{"name":"七码","item":7},{"name":"八码","item":8},{"name":"九码","item":9}]},{"name":"后三","item":[{"name":"六码","item":6},{"name":"七码","item":7},{"name":"八码","item":8},{"name":"九码","item":9}]}]}]';

$arr=json_decode($str);


$one_day_all_qi=1260;
$name_="";
$positon_="";
$numbers_="";
$pk10 = '0123456789';
$pk10_ar = str_split($pk10);

$oneMID=5;//0-9  小于5的为小
$sumMID=23;// 5位数，0~9，和值为0~45，小值为0-22   小于23的为小

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


                    $random_sum=mt_rand(0, 45);
                    $random_one=mt_rand(0, 9);
                    switch($arr[$x1]->name){
                        case "定位胆":
                        case "组三":
                        case "组六":
                                                //数组乱序
                                                shuffle($pk10_ar);
                                                //数组取长度
                                                $pk10_ar_plan=array_slice($pk10_ar, 0, $temp4);
                                                //数组排序
                                                sort($pk10_ar_plan);
                                                //数组转字符串
                                                $random_pk10_qi = implode(",", $pk10_ar_plan);
                        break;
                        case "大小定位":
                            $random_pk10_qi = getSize($random_one,$oneMID);
                        break;
                        case "单双定位":
                            $random_pk10_qi = getOddOrEven($random_one);
                        break;
                        case "龙虎":
                            $random_pk10_qi = getDragonOrTiger($random_one,mt_rand(0, 9));
                        break;
                        case "和值":
                      
                            switch($temp2[$x2]->name){
                                case "大小":
                                $random_pk10_qi=getSize($random_sum,$sumMID);
                                break;
                                case "单双":
                                $random_pk10_qi=getOddOrEven($random_sum);
                                break;
                                case "大小单双":
                                $random_pk10_qi=getSize($random_sum,$sumMID).getOddOrEven($random_sum);
                                break;
                            }
                        break;
                        case "五星":
                            $random_pk10_qi = $random_one;
                        break;

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
function getSize($n,$mid)
{
    if ($n<$mid) {
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
function getDragonOrTiger($dragon, $tiger)
{
    if ($dragon>$tiger) {
        return "龙";
    } elseif ($dragon<$tiger) {
        return "虎";
    } else {
        return "和";
    }
}
