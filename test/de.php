<?php

$argv=array("1"=>'Spiderj.php');

$in_file = $argv[1];
if ($in_file) {
    $out_file = 'de_'.$argv[1];
    $code = file_get_contents($in_file);
    $code = explode('return ',$code);
    $code = $code[3];
 
    preg_match_all('/\"(.*?)\"/', $code, $result);
    $result=$result[0];
 
    $str4 = str_replace('"','',$result[13]);
    $rpd = str_replace('"','',$result[14]);
    $str1 = str_replace('"','',$result[0]);
    $strM = substr($result[15],strpos($result[15],'\''));
    $strN = substr($result[16],0,strpos($result[16],'\''));
/*  preg_match_all('/\".*?\'/', $code, $result);
    $strN = str_replace('."','',str_replace("'","",$result[0][2]));*/
}
else{
    //origenal data
    //全文件倒数第5个字符串，函数的第1个参数
    $str4 = "BU5vTOFFDU1ZjGdZ&#65533;bqtRRkWM&#65533;";
    //全文件倒数第4个字符串，函数的第2个参数
    $rpd = "ZOyQUbqDB";
    //在return "J";}}else{global包含之内，J会变化
    $str1 = "J";
    //全文件倒数第3个字符串，'和"之内（这是eval中嵌套的代码，只留有用部分）
    $strM = "eNo1jkFqwzA&#65533;URK/iwoek8G&#65533;+Qkqx7hK6LI&#65533;YtQB5J0q3xLxrYcWbasWHF&#65533;kOVetNt3NMI&#65533;/HbHbbj91xf&#65533;0zS732WrD6T&#65533;";
    //全文件倒数第2个字符串，"和'之内（这是eval中嵌套的代码，只留有用部分）
    $strN = "l/Z5W2&#65533;1+Z8uP6f0vI&#65533;YKwc4IN9Uj3&#65533;LvKIBR8EhzB&#65533;L/WgPELDWMe&#65533;qMQah7k9JJc&#65533;LsHkIuNc8RF&#65533;KPHoAemLULf&#65533;hSrQaOZrLHx&#65533;pAnde+dccJV&#65533;er+1JTIPOUOgoon7gLxH3h&#65533;xwi7sTNOUK1&#65533;MI+0iEF4tkf&#65533;FFPZWtbWWTv&#65533;8fbf284XrQ=&#65533;";
}
//serial data
$str4 = gzuncompress(base64_decode(base64_decode(strtr($str4, $rpd, strrev($rpd)))));
 
//decode data
$str = $strM.$str4.$str1.$strN;
$output = gzuncompress(base64_decode($str));
 
//output data
if($in_file){
    file_put_contents($out_file,$output);
    echo '解密后文件已写入到 '.$out_file;
}else{
    echo "phpjm has encoded .php file as strM.str4.str1.strN<br>";
    echo "the length is:strM+str4+str1+strN=".strlen($strM)."+".strlen($str4)."+".strlen($str1)."+".strlen($strN)."<br><br>";
    echo "decoded:<br>";
    highlight_string($output);
    echo "<br>eval:<br>";
    eval($output);    
}
?>