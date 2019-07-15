<?php
date_default_timezone_set("Asia/Chongqing");
echo '<!DOCTYPE HTML><html lang="zh-CN"><head><meta charset="utf-8">';
define("DIR", dirname(__FILE__));
define("FaDIR", dirname(dirname(__FILE__)));
class Web
{
    private $temp_dir;
    private $web_dir;
    private $webIndex;
    private $moban_temp;
    public function __construct()
    {
        $this->temp_dir=DIR . "/temp";
        $this->web_dir=FaDIR . "/wwwroot";
        $this->webIndex=0;
        $this->moban_temp="";
    }
    public function CREATE_ALL_WEB(){
        $webConfig=$this->GET_TXT_LIST("ajian_domain"); // {{ajian_domain}} 顶级域名
        $__LISTS__=$webConfig["lists"];
        $__COUNT__=$webConfig["count"];
        for ($j=0;$j<$__COUNT__;$j++) {
            $__WEB__DOMAIN=trim($__LISTS__[$j]);
            $this->CREATE_ONE_WEB($__WEB__DOMAIN,$j);
        }
    }
    public function CREATE_ONE_WEB($__WEB__DOMAIN,$j){
        $this->webIndex=$j;
        $__WEB__DOMAIN=trim($__WEB__DOMAIN);

        $__TEMP__LISTS = $this->GET_FOLDER_FILES($this->temp_dir);
        $__TEMP__FILE__COUNT=count($__TEMP__LISTS);
        for ($i=0;$i<$__TEMP__FILE__COUNT;$i++) {
            $__TEMP__ONE__NAME=$__TEMP__LISTS[$i];
            $__TEMP__ONE__FULL__URL=$this->temp_dir."/".$__TEMP__ONE__NAME;
            $__COPY_TO_FULL_URL=$this->web_dir."/".$__WEB__DOMAIN."/".$__TEMP__ONE__NAME;
            $type=pathinfo($__TEMP__ONE__FULL__URL, PATHINFO_EXTENSION);
            if ($type!="html"&&$type!="htm") {
                if (!file_exists($this->web_dir."/".$__WEB__DOMAIN)) {
                    mkdir($this->web_dir."/".$__WEB__DOMAIN);
                }
                if (is_file($__TEMP__ONE__FULL__URL)) {
                    copy($__TEMP__ONE__FULL__URL, $__COPY_TO_FULL_URL);
                }
                if (is_dir($__TEMP__ONE__FULL__URL)) {
                    $this->COPY_DIR($__TEMP__ONE__FULL__URL, $__COPY_TO_FULL_URL);
                }
                echo "<br> ".$__TEMP__ONE__FULL__URL." >>>>>> copy directly \n";
                continue;
            }
            $this->moban_temp = file_get_contents($__TEMP__ONE__FULL__URL);
            $this->MOBAN_TEMP_REPLACE($this->GET_TXT_LIST("ajian_title"));//主关键词
            $this->MOBAN_TEMP_REPLACE($this->GET_TXT_LIST("ajian_company"));//企业名称
            $this->MOBAN_TEMP_REPLACE($this->GET_TXT_LIST("ajian_tell"));//qq和计划网址
            $this->MOBAN_TEMP_REPLACE($this->GET_TXT_LIST("ajian_random_keyword"));
            $this->MOBAN_TEMP_REPLACE($this->GET_TXT_LIST("ajian_random_keyword2"));
            $this->MOBAN_TEMP_REPLACE($this->GET_TXT_LIST("ajian_random_keyword3"));
            $this->MOBAN_TEMP_REPLACE($this->GET_TXT_LIST("ajian_random_keyword4"));
            $this->MOBAN_TEMP_REPLACE($this->GET_TXT_LIST("ajian_random_keyword5"));
            $this->MOBAN_TEMP_RANDOM_STRING();// {{ajian_random_6_abc}}随机字符串(每一个页相同，不同页面随机)
            $this->MOBAN_TEMP_ALLRANDOM_STRING();// {{ajian_true_random_6_abc}}随机字符串（同一页里，每个随机）
            $this->MOBAN_TEMP_ALLRANDOM_DATETIME();// {{ajian_true_random_7_datetime}}最近7天内随机时间
            $this->CREATE_HTML($__WEB__DOMAIN, $__TEMP__ONE__NAME);
        }
        echo "<br> ".$__WEB__DOMAIN." >>>>>> webSite Create Success<br><hr> \n";
    }
    public function RANDOM_DATE($lastday=1,$begintime="", $endtime="") {  
        $begin = $endtime == "" ?strtotime("-".$lastday." day") : strtotime($begintime);  
        $end = $endtime == "" ?strtotime("now") : strtotime($endtime);  
        $timestamp = rand($begin, $end);  
        return date("Y-m-d H:i:s", $timestamp);  
    }
    public function MOBAN_TEMP_ALLRANDOM_DATETIME()
    {//"/ajian(_true)?_random(\_?\d?)_abc/i",
        $random_keyword_count=preg_match_all ("/{{ajian_true_random(\_?\d?)_datetime}}/", $this->moban_temp,$pat_array);
        for ($t = 0; $t < $random_keyword_count; $t++) {
            $__PREG__KEY__=$pat_array[0][$t];
            $__PREG__='/'.$__PREG__KEY__.'/';
            $__MATCH__=$pat_array[1][$t];
            $num=$__MATCH__==""?7:substr($__MATCH__,1);
            $this->moban_temp = preg_replace($__PREG__, $this->RANDOM_DATE($num),$this->moban_temp, 1);
        }
    }
    public function MOBAN_TEMP_ALLRANDOM_STRING()
    {//"/ajian(_true)?_random(\_?\d?)_abc/i",
        $random_keyword_count=preg_match_all ("/{{ajian_true_random(\_?\d?)_abc}}/", $this->moban_temp,$pat_array);
        for ($t = 0; $t < $random_keyword_count; $t++) {
            $__PREG__KEY__=$pat_array[0][$t];
            $__PREG__='/'.$__PREG__KEY__.'/';
            $__MATCH__=$pat_array[1][$t];
            $num=$__MATCH__==""?6:substr($__MATCH__,1);
            $this->moban_temp = preg_replace($__PREG__, $this->RANDOM_STRING($num),$this->moban_temp, 1);
        }
    }
    public function MOBAN_TEMP_RANDOM_STRING()
    {

        $random_keyword_count=preg_match_all ("/{{ajian_random(\_?\d?)_abc}}/", $this->moban_temp,$pat_array);
        for ($t = 0; $t < $random_keyword_count; $t++) {
            $__PREG__KEY__=$pat_array[0][$t];
            $__PREG__='/'.$__PREG__KEY__.'/';
            $__MATCH__=$pat_array[1][$t];
            $num=$__MATCH__==""?6:substr($__MATCH__,1);
            $this->moban_temp = preg_replace($__PREG__, $this->RANDOM_STRING($num), $this->moban_temp, -1);
        }
    }
    public function MOBAN_TEMP_REPLACE($txtArr = null)
    {
        $__PREG__='/{{'.$txtArr["tempKey"].'}}/';
        $__LISTS__=$txtArr["lists"];
        if ($txtArr["toRandom"]) {
            $__PREG__KEY__COUNT__=preg_match_all ($__PREG__, $this->moban_temp,$pat_array);
            for ($t = 0; $t < $__PREG__KEY__COUNT__; $t++) {
                $__WORD__=trim($this->V_ARRAY_RAND($__LISTS__));
                $__WORD__=$txtArr["toUnicode"]?$this->TO_UNICODE($__WORD__):$__WORD__;
                $this->moban_temp = preg_replace($__PREG__, $__WORD__, $this->moban_temp, 1);
            }
        } else {
            $__WORD__=trim($__LISTS__[$this->webIndex]);
            $__WORD__=$txtArr["toUnicode"]?$this->TO_UNICODE($__WORD__):$__WORD__;
            $this->moban_temp = preg_replace($__PREG__, $__WORD__, $this->moban_temp, -1);
        }
    }
    public function GET_TXT_LIST($keyword = null)
    {
        if ($keyword==null) {
            return false;
        }
        $keyword_lists = file(DIR . '/list/'.$keyword.".txt");
        $setting_str=  array_shift($keyword_lists);
        $setting=explode("|", trim($setting_str));
        $needToUnicode=$setting[0]=="转码";
        $needToRandom=$setting[1]=="随机";
        return array(
             "tempKey"=>$keyword,
             "toUnicode"=>$needToUnicode,
             "toRandom"=>$needToRandom,
             "lists"=>$keyword_lists,
             "count"=>count($keyword_lists)
         );
    }
    public function CREATE_HTML($mk_dir, $file_name)
    {
        $path=$this->web_dir ."/". $mk_dir."/".$file_name;
        if (!file_exists($this->web_dir ."/". $mk_dir)) {
            mkdir($this->web_dir ."/". $mk_dir);
        }
        file_put_contents($path, $this->moban_temp);
        echo "<br> ".$path." 创建成功 \n";
    }
    /**
     * 复制文件夹
     * @param $source
     * @param $dest
     */
    public function COPY_DIR($source, $dest)
    {
        if (!file_exists($dest)) {
            mkdir($dest);
        }
        $handle = opendir($source);
        while (($item = readdir($handle)) !== false) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            $_source = $source . '/' . $item;
            $_dest = $dest . '/' . $item;
            if (is_file($_source)) {
                copy($_source, $_dest);
            }
            if (is_dir($_source)) {
                $this->COPY_DIR($_source, $_dest);
            }
        }
        closedir($handle);
    }
    
    public function GET_FOLDER_FILES($folder)
    {
        $fp = opendir($folder);
        while (false != $file = readdir($fp)) {
            if ($file != '.' && $file != '..') {
                $file = "$file";
                $arr_file[] = $file;
            }
        }
        closedir($fp);
        return $arr_file;
    }
    public function V_ARRAY_RAND($arr)
    {
        return $arr[array_rand($arr) ];
    }
    public function RANDOM_STRING($n)
    {
        //取随机n位字符串
        $strs="QWERTYUIOPASDFGHJKLZXCVBNM1234567890qwertyuiopasdfghjklzxcvbnm";
        $name=substr(str_shuffle($strs), mt_rand(0, strlen($strs)-11), $n);
        return $name;
    }
    public function TO_UNICODE($str)
    {
        $c = mb_convert_encoding($str, 'HTML-ENTITIES', 'utf-8');
        return $c;
    }
}
$myJob=new Web();
$myJob->CREATE_ALL_WEB();

//$myJob->CREATE_ONE_WEB("xxx.com",2);
