<?php
$url = "http://www.baidu.com/link?url=APc1rns6rltG_LlZqbFx7JD1eQBowk13kFdJoYGxVCq&wd=%e5%87%bf%e5%a3%81%e8%80%85%e5%9d%9a&eqid=d5f26bc800077893000000065cff34fa";

$info = parse_url($url);

// 输出:  "http://www.baidu.com/suning?v=1&k=2#id"; 
// Array 
// ( 
// [scheme] => http 
// [host] => www.baidu.com
// [path] => /suning
// [query] => v=1&k=2
// [fragment] => id
// ) 


$fp = fsockopen($info['host'], 80,$errno, $errstr, 30);
fputs($fp,"GET {$info['path']}?{$info['query']} HTTP/1.1\r\n");
fputs($fp, "Host: {$info['host']}\r\n");
fputs($fp, "Connection: close\r\n\r\n");
$rewrite = '';
while(!feof($fp)) {
    $line = fgets($fp);
    if($line != "\r\n" ) {
        if(strpos($line,'Location:') !== false) {
            $rewrite = str_replace(array("\r","\n","Location: "),'',$line);
        }
    }else {
        break;
    }
}
var_dump($rewrite); //结果显示：string(22) "http://www.google.com/" 
?>