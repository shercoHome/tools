<?php
date_default_timezone_set("Asia/Chongqing");
// private $n_qi_plan;      n期计划
// private $plan_id;        计划代号 0-9999
// private $plan_positon;   冠 亚
// private $plan_numbers;   四码
// private $latest_limit;   统计最近n期的胜率
// private $api;            文件夹名称 pk10    k10-js   pk10-js-xy
// private $kj_history;     当日开奖记录： 关联数组（期号=>开奖号码）
// private $authorize;      是否授权查看下一期计划预测
// private $authorize_msg;      授权提示信息
class WinRate
{
    private $n_qi_plan;
    private $plan_id;
    private $plan_positon;
    private $plan_numbers;
    private $latest_limit;
    private $api;
    private $kj_history;
    private $authorize;
    private $authorize_msg;

    //具有构造函数的类会在每次创建新对象时先调用此方法，所以非常适合在使用对象之前做一些初始化工作。
    public function __construct($a="pk10",$p=2,$n=0,$l=10,$q=1,$i=-1,$authorize="0")
    {
        $this->api=$a;  //文件夹名称 pk10    k10-js   pk10-js-xy

        $this->plan_positon=$p; //冠 亚
        $this->plan_numbers=$n;  //四码
        $this->latest_limit=$l;  //统计最近n期的胜率

        $this->n_qi_plan=$q; //n期计划
        $this->plan_id=$i; //计划代号 0-9999

        $this->authorize=$authorize;
        $this->authorize_msg="点,击,授,权";

        $this->kj_history=$this->get_today_kj();
        return $this->kj_history;
    }
    public function getAllRate()
    {
        $win_rate_s=array();
        for ($i=1;$i<=100;$i++) {
            $this->plan_id=$i;
            $kj_result=$this->getOneRate();
            $kj_rate=$kj_result['rate'];
            $countWin=$kj_result['countWin'];
            array_push($win_rate_s, array("id"=>$i,"rate"=>$kj_rate,"countWin"=>$countWin));
        }
        return $win_rate_s;
    }
    public function getOneRate()
    {
        
        $api_=$this->api;
        $plan__id=$this->plan_id;
        $plan__positon=$this->plan_positon;
        $plan__numbers=$this->plan_numbers;
        $latest__limit=$this->latest_limit;
        $kj__history=$this->kj_history;
     
        $n_qi_plan=$this->n_qi_plan;

        $authorize=$this->authorize;

        $authorize_msg=$this->authorize_msg;
    
        if($plan__id==-1){
            return json_encode(array("plan"=>'no id',"rate"=>0));
        }

        // echo "这是".$n_qi_plan."期计划<br>";
        $plan_dir=$api_."/txt-plan/".date("Ymd")."/";
    
        $plan_file=$plan_dir.$plan__id.".txt";
        $plan_str=$this->get_file_content($plan_file);
        $plan_arr=json_decode($plan_str);
    
        /////////////
        reset($kj__history);//- 将数组的内部指针指向第一个元素。，并返回该元素的值。​
        ////今天最新-期，期号
        $this_day_last_qi=key($kj__history);//- 返回数组内部指针指向的元素的索引（即：键值）
    
    
        /////////////
        end($kj__history);//- 函数将数组内部指针指向最后一个元素，并返回该元素的值。​
        ////今天第一期，期号
        $this_day_first_qi=key($kj__history);//- 返回数组内部指针指向的元素的索引（即：键值）
    
        // if (count($kj__history)>=$latest__limit) {
        //     $latest_kj__history = array_slice($kj__history, 0, $latest__limit, true);
        // } else {
        //     $latest__limit=count($kj__history);
        //     $latest_kj__history=$kj__history;
        // }
    
        $kj_count=$this_day_last_qi-$this_day_first_qi+1;
    
        $win_rate=0;
        $plan_result=array();
    
        $kj_a=$kj__history;//$latest_kj__history
        $kj_c=$kj_count;//$latest__limit
    
        ////////////   最近 limit 期， kj_a = array(   期号 kj_q  =>   开奖结果 kj_code)
        ////////////   今天第一期 this_day_first_qi，共kj_c期
     
        $result=1;//$n_qi_plan
        $mark=0;//记录一个计划，用了几期，不能超过$n_qi_plan
        $markMark=0;// //记录一个计划重复了几次（即，记录mark） ，用于输出

        $countWin=0;//记录最近中奖了几期;

        for ($n=1;$n<=$kj_c;$n=$n+1) {
            $kj_q=$this_day_last_qi-$kj_c+$n;
            $today_qi=$kj_q-$this_day_first_qi;//0-178，获取对应的计划 key
          
            /////////////////  获取计划  ///////////////
            $plan_one= $plan_arr[$plan__positon][$plan__numbers][$today_qi-$mark];
    
            ///////////////// 开奖号码 ///////////////
            $kj_q=$kj_q."";
            if (!array_key_exists($kj_q,$kj_a)){
                continue;
            }
            //  var_dump($kj_q);
            $kj_code=$kj_a[$kj_q];
            $kj_code_ar=explode(',', $kj_code);
            //$kj_code_one=$kj_code_ar[$plan__positon]+0;
            //$kj_code_one=($kj_code_one==10)?"0":($kj_code_one."");
            $kj_code_one=$kj_code_ar[$plan__positon];  
            ///////////////  判断中奖  //////////////
            //$r=strpos($plan_one, $kj_code_one);//函数查找kj_code_one字符串在另一字符串plan_one中第一次出现的位置。
    
            $r=$this->checkResult($plan_one, $kj_code_one);

            if ($r===false) {
                $result=-1;///本期【不中奖】
    
                if ($n_qi_plan>1) {//这是一个多期计划（有传入id 和 plan时默认为1期计划）
    
                    if ($mark+1< $n_qi_plan) {//下一期是不是要重复此计划，（看重复次数，有没有超过，预设期数n_qi_plan）
                        $mark++;//下一次准备重复本期计划
                        $markMark=$mark;//记录此计划重复了几次
                    } else {
                        $markMark=$mark+1; //记录此计划重复了几次
                        $mark=0;//上限N期计划，都不中奖，输出结果，重置mark
                    }
                } else {
                    $markMark=$mark+1;//记录此计划重复了几次
                    $mark=0;//不中奖，不是要某个Id的计划，重置mark
                }
            } else {
                $result=1;///本期【中奖】
    
                $markMark=$mark+1; //记录此计划重复了几次
                $mark=0;//中奖了，直接输出结果，重置mark
            }
    
    
            /////////////输出一条结果（$mark=0 或 最后一期）////////////
            if ($mark===0 || $n==$kj_c) {
                if ($mark!==0) {//计划未完成
                    $kj_q++;
                    $today_qi++;
                    $markMark++;
                    $kj_code="-1";
                    $kj_code_one="未";
                    $result="未";

                    if($authorize=="0"){
                        $plan_one=$authorize_msg;
                    }
                }else{
                    if($result==1){
                        $countWin++;
                    }else{
                        $countWin=0;
                    }
                }


    
                //array_push(
                array_unshift(//2019-03-10 13:00:21修改，倒序输出
                    $plan_result,
                    array(
                        "period"=>$kj_q,
                        "todayPeriod"=>$today_qi+1,
                        "openCode"=>$kj_code,
                        "openCodeOne"=>$kj_code_one,
                        "planOne"=>$plan_one,
                        "result"=>$result,
                        "markMark"=>$markMark,
                        "periods"=>($kj_q-$markMark+1)."~".($kj_q-$markMark+$n_qi_plan),
                        "mark"=>$mark
                    )
                );
            }
        }
       
        /////////////数组截取 latest__limit 期数///////////
        $p_r_c=count($plan_result);
        if ($mark!==0) {//计划未完成
            $latest__limit++;
        }
        if ($p_r_c>$latest__limit) {
            //$plan_result_limit = array_slice($plan_result, -1*$latest__limit, $latest__limit, false);
            $plan_result_limit = array_slice($plan_result,0, $latest__limit, false);//2019-03-10 13:00:21修改，倒序输出
        } else {
            $plan_result_limit=$plan_result;
        }
        /////////////计算胜率 latest__limit 期数///////////
        $p_r_c=count($plan_result_limit);

        if ($mark!==0) {//计划未完成
            $p_r_c--;
        }



        for ($x=0;$x<$p_r_c;$x++) {
            $r= $plan_result_limit[$x]["result"];
            if ($r!="未") {
                $win_rate+=$r;
            }
        }
        $win_rate=(($p_r_c-$win_rate)/2+$win_rate)/$p_r_c;

        /////////////加入未开奖的///////////
        $latest_one_plan=$plan_arr[$plan__positon][$plan__numbers][$kj_c];
        if ($mark!==0) {//计划未完成
        // $latest_one_plan=$plan_arr[$plan_positon][$plan_numbers][$kj_c-$markMark];
        // $markMark++;
        } else {
            $markMark=1;

            if($authorize=="0"){
                $latest_one_plan=$authorize_msg;
            }


        //array_push(
        array_unshift(//2019-03-10 13:00:21修改，倒序输出
            $plan_result_limit,
            array(
                "period"=>$this_day_last_qi+1,
                "todayPeriod"=>$this_day_last_qi-$this_day_first_qi+1+1,
                "openCode"=>'-1',
                "openCodeOne"=>'未',
                "planOne"=>$latest_one_plan,
                "result"=>'未',
                "markMark"=>$markMark,
                "periods"=>($this_day_last_qi+1-$markMark+1)."~".($this_day_last_qi+1-$markMark+$n_qi_plan),
                "mark"=>$mark
            )
        );
        }

        ////////////////////
        //krsort($plan_result_limit);
        return array("plan"=>$plan_result_limit,"rate"=>$win_rate,"countWin"=>$countWin);
    }
    private function get_today_kj()
    {
        $dir=$this->api."/txt-kj/".date("Ymd");
        $handler = opendir($dir);
        // 2、循环的读取目录下的所有文件
        /*
        其中$filename = readdir($handler)是每次循环的时候将读取的文件名赋值给$filename，为了不
        陷于死循环，所以还要让$filename !== false。一定要用!==，因为如果某个文件名如果叫’0′，或者某
        些被系统认为是代表false，用!=就会停止循环
        */
        $kj_qihao_value=array();
        while (($filename = readdir($handler)) !== false) {
            //   3、目录下都会有两个文件，名字为’.'和‘..’，不要对他们进行操作
            if ($filename !="." && $filename !="..") {
                //   4、进行处理
                //这里简单的用echo来输出文件名
                // array_push($txt_filename_qihao, $filename);//尾部添加  0,726528~32,726560
                //array_unshift($txt_filename_qihao,$filename);//头部添加元素
                $kj= $this->get_file_content($dir."/".$filename);
                $kj_json=json_decode($kj);
                $key=$kj_json->data[0]->expect;
                $val=$kj_json->data[0]->opencode;
                $kj_qihao_value[$key]=$val;
            }
        }
        // 5、关闭目录
        closedir($handler);
        krsort($kj_qihao_value);//ksort() - 根据键，以升序对关联数组进行排序
        return $kj_qihao_value;
    }
    private function get_file_content($file_name)
    {
        $myfile = fopen($file_name, "r") or die("Unable to open file!");
        $content_=  fgets($myfile);
        fclose($myfile);
        return $content_;
    }
    private function checkResult($plan,$kj)
    {
    
        $flag=false;
        if (mb_strpos($kj, "||", 0, "utf-8")!==false) {//或
            //函数查找 || 字符串在另一字符串$kj中第一次出现的位置。
            $kj_arr=explode("||", $kj);
            $kj_arr_count=count($kj_arr);
            $mark=0;
            for ($iii=0;$iii<$kj_arr_count;$iii++) {
                $kj_item=$kj_arr[$iii];
                if (mb_strpos($plan, $kj_item, 0, "utf-8")!==false) {
                    $mark++;
                    $flag=true;
                    break;
                }
            }
        }elseif(mb_strpos($kj, "&&", 0, "utf-8")!==false){//且
            $kj_arr=explode("&&", $kj);
            $kj_arr_count=count($kj_arr);
            $mark=0;
            for ($iii=0;$iii<$kj_arr_count;$iii++) {
                $kj_item=$kj_arr[$iii];
                if (mb_strpos($plan, $kj_item, 0, "utf-8")!==false) {
                    $mark++;
                }
            }
            if ($mark==$kj_arr_count) {
                $flag=true;
            };
        }else{
            if(mb_strpos($plan, $kj, 0, "utf-8")!==false){
                $flag=true;
            };
        }
        return $flag;
    }
}
