<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Language" content="zh-cn" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>爬虫啊</title>
<body>



<?php
// 允许所有域访问


//  get_html("http://www.dawanghui.com/food/2300.html");
//  exit();

 header("Access-Control-Allow-Origin: *");
 $domainlll="http://www.lvse.cn/zhongguo";

 $ccc=50; //、抓取的最大页面数


 if(is_array($_GET)&&count($_GET)>0){

	  if (isset($_GET["d"])) {
		$domainlll=$_GET["d"];
	  }
 }
 $url=$domainlll;


 echo "<br>";
 echo "<br>";
 echo "<br>";
 echo "***开始 向下***";
 echo "<br>";
 echo substr($url,18)."<br>";
 echo "----------------------------------";
 echo "<br>";
 $ch = curl_init();
 
 $timeout = 10;
  
 curl_setopt($ch, CURLOPT_URL, $url);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
 curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
 curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/34.0.1847.131 Safari/537.36');
 curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
 $html = curl_exec($ch);
$coding = mb_detect_encoding($html);
if ($coding != "UTF-8" || !mb_check_encoding($html, "UTF-8"))
$html = mb_convert_encoding($html, 'utf-8', 'GBK,UTF-8,ASCII');



///////////////////
// $patternt = '|newslist.*</ul>|isU';
// preg_match_all($patternt, $html, $matches);

// $html = $matches[0][0];


// $patternt = '|href=".*html|isU';
// preg_match_all($patternt, $html, $matches);
/////////////////////////

$patternt = '|<a target="_blank" class="visit out_link" site_id=".*</a>|isU';
preg_match_all($patternt, $html, $matches);

$arrli=$matches[0];


foreach ($arrli as $value) {




	$patternt = '|"http.*com|isU';
	preg_match_all($patternt, $value, $matches);


	if(count($matches)>0){
		if(count($matches[0])>0){
			echo $matches[0][0];
			echo "<br>";
		}

	}



	//var_dump($matches);
	


}


echo "************* 结束 ************";
?>

</body>
</html>