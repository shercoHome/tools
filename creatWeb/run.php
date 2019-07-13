<?php


echo '<!DOCTYPE HTML><html lang="zh-CN"><head><meta charset="utf-8">';

define("DIR", dirname(__FILE__));
// require DIR . '/config.php';
// $json_result=array("code"=>"-2","msg"=>"null","data"=>array());
//array_rand(array,number)    从数组中随机选出一个或多个元素，并返回
//explode(separator,string,limit)
// file_get_contents() 把文件读入一个字符串。
// file() 将文件作为一个数组返回。数组中的每个单元都是文件中相应的一行
////////////////////////////////////////////////////////
//   {{duke_mainkey}}
//   {{duke_keyword}}
//   {{duke_des}}
//   {{duke_word1}}



    $random_keyword_lists = get_folder_files(DIR . '/list/random_keyword/');
    $random_keyword_array= file(DIR . "/list/random_keyword/" . varray_rand($random_keyword_lists));
    
    $random_keyword_lists2 = get_folder_files(DIR . '/list/random_keyword2/');
    $random_keyword2_array= file(DIR . "/list/random_keyword2/" . varray_rand($random_keyword_lists2));

    // varray_rand($random_keyword_array)
    $folder=DIR . "/temp/";
    $web_set_array= file(DIR . "/list/web.txt");

    $web_count=count($web_set_array);
    for ($webIndex=0;$webIndex<$web_count;$webIndex++) {
        $web_sets=explode(",", $web_set_array[$webIndex]);
        //kekejh.com,我是一个标题,阿坚木门
        $web_domain=trim($web_sets[0]);
        $web_title=trim($web_sets[1]);
        $web_company=trim($web_sets[2]);

        $list_file = get_folder_files($folder);

        $list_count=count($list_file);
        for ($i=0;$i<$list_count;$i++) {
            $list_file_name=$list_file[$i];
            $list_file_url=$folder.$list_file_name;

            $copy_file_url=DIR . "/".$web_domain."/".$list_file_name;

            $type=pathinfo($list_file_url,PATHINFO_EXTENSION);

            if($type!="html"&&$type!="htm"){

                if (!file_exists($web_domain)) {
                    mkdir($web_domain);
                   
                }

                if (is_file($list_file_url)) copy($list_file_url,$copy_file_url);
                if (is_dir($list_file_url)) copydir($list_file_url,$copy_file_url);
                


                echo $list_file_url." 直接复制<br>";
                continue;
            }

            //  var_dump($list_file_url);
            $moban_temp = file_get_contents($list_file_url);
            // {{ajian_domain}} 顶级域名
            // {{ajian_title}}主关键词  转码
            // {{ajian_tell}} qq和计划网址  转码
            // {{ajian_company}}企业名称  转码
            // {{ajian_random_abc}}随机字符串
            // {{ajian_random_keyword}}随机关键词  转码
            $moban_temp = preg_replace('/{{ajian_domain}}/', $web_domain, $moban_temp, -1);
            $moban_temp = preg_replace('/{{ajian_title}}/', toUnicode($web_title), $moban_temp, -1);
            $moban_temp = preg_replace('/{{ajian_company}}/', toUnicode($web_company), $moban_temp, -1);

            $ajian_tell_count = count(explode('{{ajian_tell}}', $moban_temp)) - 1;
            for ($t = 0; $t < $ajian_tell_count; $t++) {
                $moban_temp = preg_replace('/{{ajian_tell}}/', toUnicode(trim(varray_rand($random_keyword2_array))), $moban_temp, 1);
            }
           // $random_abc_count = count(explode('{{ajian_random_abc}}', $moban_temp)) - 1;
           // for ($t = 0; $t < $random_abc_count; $t++) {
          //      $moban_temp = preg_replace('/{{ajian_random_abc}}/', getRandomString(6), $moban_temp, 1);
        //    }

    $moban_temp = preg_replace('/{{ajian_random_abc}}/', getRandomString(6), $moban_temp, -1);


            $random_keyword_count = count(explode('{{ajian_random_keyword}}', $moban_temp)) - 1;
            for ($t = 0; $t < $random_keyword_count; $t++) {
                $moban_temp = preg_replace('/{{ajian_random_keyword}}/', toUnicode(trim(varray_rand($random_keyword_array))), $moban_temp, 1);
            }
            createHtml($web_domain, $list_file_name, $moban_temp);
        }

        echo $web_domain." 站点创建成功<br><hr><br>";
    }


function createHtml($mk_dir,$file_name, $str)
{
    $path=DIR . "/".$mk_dir."/".$file_name;
    if (!file_exists($mk_dir)) {
        mkdir($mk_dir);
    }
    file_put_contents($path, $str);
    echo $mk_dir." ".$file_name." 创建成功<br>";
}

/**
 * 复制文件夹
 * @param $source
 * @param $dest
 */
function copydir($source, $dest)
{
    if (!file_exists($dest)) mkdir($dest);
    $handle = opendir($source);
    while (($item = readdir($handle)) !== false) {
        if ($item == '.' || $item == '..') continue;
        $_source = $source . '/' . $item;
        $_dest = $dest . '/' . $item;
        if (is_file($_source)) copy($_source, $_dest);
        if (is_dir($_source)) copydir($_source, $_dest);
    }
    closedir($handle);
}


function get_folder_files($folder)
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
function varray_rand($arr)
{
    return $arr[array_rand($arr) ];
}
function getRandomString($n)
{
    //取随机n位字符串
    $strs="QWERTYUIOPASDFGHJKLZXCVBNM1234567890qwertyuiopasdfghjklzxcvbnm";
    $name=substr(str_shuffle($strs), mt_rand(0, strlen($strs)-11), $n);
    return $name;
}
function toUnicode($str){
    $c = mb_convert_encoding($str, 'HTML-ENTITIES', 'utf-8');
    return $c; //直接输出还是中国两个字
}