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
 $domainlll="http://www.dawanghui.com";
 $lib= "/qiye/";
 $lib="/zonghe/";
 $n="";
 $ccc=50; //、抓取的最大页面数


 if(is_array($_GET)&&count($_GET)>0){

	  if (isset($_GET["d"])) {
		$domainlll=$_GET["d"];
	  }
	  if (isset($_GET["l"])) {
		$lib=$_GET["l"];
	  }
	  if (isset($_GET["n"])) {
		$n="index_".$_GET['n'].".html";
	  }
 }
 $url=$domainlll.$lib.$n."?".time();



 echo "<br>";
 echo "*************开始 向下*****************************";
 echo "<br>";
 echo $url."<br>";
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




echo "//////////////////";

///////////////////
$patternt = '|newslist.*</ul>|isU';
preg_match_all($patternt, $html, $matches);

$html = $matches[0][0];


$patternt = '|href=".*html|isU';
preg_match_all($patternt, $html, $matches);
/////////////////////////


$arrli=$matches[0];

$newArrli=array();
$i=1;


foreach ($arrli as $value) {

	if($i>=$ccc){break;}

	$i=$i+1;
	
	$value=substr($value,6);

	array_push($newArrli,$value);
	
	//$ss_url=$domainlll.$lib.$value.".html";

	$ss_url=$domainlll.$value;



	get_html($ss_url);

}


function get_html($url){
  
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

$patternt = '|sdcms_content.*</div>|isU';
preg_match_all($patternt, $html, $matchest);


$html = $matchest[0][0];

$patternt = '|<a.*</a>|isU';
preg_match_all($patternt, $html, $matchest);


var_dump( $matchest);

echo "<br>";
}


echo "************* 结束 *****************************";
?>

</body>
</html>