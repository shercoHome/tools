<?php

//php推送示例
echo '<!Doctype html><html xmlns=http://www.w3.org/1999/xhtml><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';

$urls= getTxtcontent("baiduPush.txt");



$urls_count=count($urls);



if($urls_count>0){
 baidu_push($urls,0,$urls_count);
}

function baidu_push($urls_temp,$urls_i,$urls_count)
{

    echo $urls_i."】".$urls_temp[$urls_i];
    $urls = array(
        'http://www.'.$urls_temp[$urls_i],
    );

    $api = 'http://data.zz.baidu.com/urls?site=www.'.$urls_temp[$urls_i].'&token=JDqvQ4jdSimYzsFa';
    $ch = curl_init();
    $options =  array(
        CURLOPT_URL => $api,
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => implode("\n", $urls),
        CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
    );
    curl_setopt_array($ch, $options);
    $result = curl_exec($ch);
    echo $result;
    echo "<br>";
    if(($urls_i+1)<$urls_count){

        baidu_push($urls_temp,$urls_i+1,$urls_count);
    }
}






/*
 * 逐行读取TXT文件 
 */
function getTxtcontent($txtfile){
	$file = @fopen($txtfile,'r');
	$content = array();
	if(!$file){
		return 'file open fail';
	}else{
		$i = 0;
		while (!feof($file)){
			$content[$i] = mb_convert_encoding(fgets($file),"UTF-8","GBK,ASCII,ANSI,UTF-8");
			$i++ ;
		}
		fclose($file);
		$content = array_filter($content); //数组去空
	}
 
    return $content;
}
?>