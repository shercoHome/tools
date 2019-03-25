<?php

date_default_timezone_set("Asia/Chongqing");

echo '<meta http-equiv="content-type" content="text/html;charset=utf-8">';


$pk10 = '0123456789';
//$name_str="长卢俊民|堵敖博学|步叔和歌|谢丘经业|三饭明知|纯狐昂雄|韦开俊达|陵阳自怡|步温元亮|霭牙兴贤|修鱼和平|宣于子琪|棼冒康时|不第康时|驸马泰平|安金鸿文|温孤正谊|付马高峰|伶舟新知|罔法元青|复生博实|敦洽力学|封父华采|馯臂兴贤|邓陵华荣|辗迟俊雅|公建凯旋|成纪志尚|堂溪鸿哲|公保雨伯|吐和昊天|空相凯乐|伯有温韦|归生温书|吐缶昊英|阪上博雅|叱豆英逸|温孤雅昶|温稽高懿|商瞿和风|古里向阳|公襄浩然|安平元明|公檮弘扬|赤松宾实|贡娄德业|公胜和悌|复隆良畴|广成建章|白象宏邈|敕勒开畅|吐火曾琪|邓林建茗|棼冒奇邃|京兆伟博|大季康泰|宥连正祥|邓林德寿|祁连明煦|白冥高朗|胡非建元|公锄景辉|公何永丰|祖龙良平|千乘星晖|耏门雨华|曹丘良骏|白公新翰|马矢雅珺|乞伏勇男|呼衍修文|公华伟懋|苞丘翰墨|柏成弘济|白玉弘雅|安末安康|盆成彭祖|古冶烨煜|柏成元勋|胥弥明亮|出就承颜|鬭强建中|长卢志业|公务兴国|长芦俊材|子阳修雅|石作阳嘉|霞露博达|刘王永丰|公上正青|车焜德宇|司寤涵涤|潜龙康成|邯郸意致|苍梧嘉祥|浩羊康裕|高唐阳夏|厨人承载|公仲志国|封贝俊力";
//$positon_str="万|千|百|十|个";
//$numbers_str="五|六|七|八";

// $name_arr=explode('|',$name_str);
// $positon_arr=explode('|',$positon_str);
// $numbers_arr=explode('|',$numbers_str);
// $name_arr_l=count($name_arr);
// $positon_arr_l=count($positon_arr);
// $numbers_arr_l=count($numbers_arr);

$name_="";
$positon_="";
$numbers_="";

$one_day_all_qi=1440;

//$plan["三饭明知"]["亚"]["八"]

$name_="";
$positon_="";
$numbers_="";
$pk10 = '0123456789';
$pk10_ar = str_split($pk10);

// $pc28='00010203040506070809101112131415161718192021222324252627';
// $pc28_ar = str_split($pc28, 2);
for ($x=1;$x<=1;$x++) { //100个计划

    $plan=array(); //一个计划
    for ($y=1;$y<=21;$y++) {//一个计划 里包含 "万|千|百|十|个" 5个位置
            //0-4，5位开奖号                      4-8码
            //5，和值特码                         无计划
            //6-10，5位开奖号各自的大小，          1码
            //11，和值大小                        1码
            //12-16，5位开奖号各自的单双，          1码
            //17，和值单双                        1码
            //18，五星定胆 例：1||9||3||5||8           1码
            //19，后三组三 例：1&&9    err                        5-10码
            //20，后三组六 例：1&&9&&5    err                     4-8码
            //////// 一共21
        $positon_arr=array();

        if ($y>=6&&$y<=19) {
            $min=1;
            $max=1;
        } elseif ($y==20) {
            $min=5;
            $max=10;
        } else {
            $min=4;
            $max=8;
        }
        for ($z=$min;$z<=$max;$z++) {//"四|五|六|七|八"; 几码

            $numbers_arr=array();
            for ($q=1;$q<=$one_day_all_qi;$q++) {//一天一共179期
                $random_sum=mt_rand(0, 45);
                $random_one=mt_rand(0, 9);
                switch ($y) {
                    case 1:
                    case 2:
                    case 3:
                    case 4:
                    case 5:
                        //数组乱序
                        shuffle($pk10_ar);
                        //数组取长度
                        $pk10_ar_plan=array_slice($pk10_ar, 0, $z);
                        //数组排序
                        sort($pk10_ar_plan);
                        //数组转字符串
                        $random_pk10_qi = implode(",", $pk10_ar_plan);
                        break;
                    case 6:
                        $random_pk10_qi="999";
                        break;
                    case 7:
                    case 8:
                    case 9:
                    case 10:
                    case 11:
                        $random_pk10_qi=getSize($random_one);
                        break;
                    case 12:
                        $random_pk10_qi=getSumSize($random_sum);
                    break;
                    case 13:
                    case 14:
                    case 15:
                    case 16:
                    case 17:
                        $random_pk10_qi=getOddOrEven($random_one);
                        break;
                    case 18:
                        $random_pk10_qi=getOddOrEven($random_sum);
                        break;
                    case 19:
                        $random_pk10_qi=$random_one;
                        break;
                    case 20://组三，5-10码
                        //数组乱序
                        shuffle($pk10_ar);
                        //数组取长度
                        $pk10_ar_plan=array_slice($pk10_ar, 0, $z);
                        //数组排序
                        sort($pk10_ar_plan);
                        //数组转字符串
                        $random_pk10_qi = implode(",", $pk10_ar_plan);
                        break;
                    case 21://组六，4-8码
                        //数组乱序
                        shuffle($pk10_ar);
                        //数组取长度
                        $pk10_ar_plan=array_slice($pk10_ar, 0, $z);
                        //数组排序
                        sort($pk10_ar_plan);
                        //数组转字符串
                        $random_pk10_qi = implode(",", $pk10_ar_plan);
                        break;
                    default:
                        break;

               }
                // //数组乱序
                // shuffle($pk10_ar);
                // //数组取长度
                // $pk10_ar_plan=array_slice($pk10_ar, 0, $z);
                // //数组排序
                // sort($pk10_ar_plan);
                // //数组转字符串
                // $random_pk10_qi = implode(",", $pk10_ar_plan);


                array_push($numbers_arr, $random_pk10_qi);///一个计划 里的 一个位置 的每一种码的每一期都有计划
            }

            array_push($positon_arr, $numbers_arr);///一个计划 里的 一个位置 有"四|五|六|七|八"码 四种买法
        }

        array_push($plan, $positon_arr);////一个计划 里包含 "万|千|百|十|个" 5个位置
    }
    $plan_json=json_encode($plan);

    add($x, $plan_json);
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
    if ($n<5) {
        return "小";
    } else {
        return "大";
    }
};
function getSumSize($n)
{
    if ($n<23) {
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
