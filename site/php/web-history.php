<?php
$time1=time();



    require_once 'HTTPRequester.php';


  
    $txtfilename="test.txt";

 if(is_array($_GET)&&count($_GET)>0){

    if (isset($_GET["f"])) {
        if(strlen($_GET["f"])>0){
            $txtfilename=$_GET["f"].".txt";
        }
    }
}


echo '<!Doctype html><html xmlns=http://www.w3.org/1999/xhtml><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" />';
echo '<title>查询'.$txtfilename.'</title></head><body>';
echo '<table><tr><th>域名</th><th>历史年数</th></tr>';


   $urls= getTxtcontent($txtfilename);

   //var_dump($urls);

   $urls_count=count($urls);
  
   $count_history=0;

   if($urls_count>0){
    //showHistory($urls[0],1,1);
    showHistory($urls,0,$urls_count,$count_history);
   }


   


   function showHistory($urlar,$i,$max,$var_count_history)
   {

    $url=trim($urlar[$i]);

    $markYear=0;
    $years="";

    $array = array(
        "url" => $url,
        "collection" => "web",
        "output" => "json"
    );
    $tool=new HTTPRequester();
    $content=$tool->HTTPGet("http://web.archive.org/__wb/sparkline",$array);

    $json=json_decode ($content);
    //{"is_live":false,"last_ts":null,"first_ts":null,"years":{}}
    //{"last_ts":"20180307062151","first_ts":"20071111181425","years":{"2016":[0

    //判断网络有没有正常
    if(!$content){
        echo "<tr><td>".$url."</td><td>false</td></tr>";
    }else{


                //判断有没有历史记录
        if(property_exists($json,'is_live')){

            if(!$json->is_live){
                echo "<tr><td>".$url."</td><td>0</td></tr>";
            }else{
                echo "<tr><td>".$url."</td><td>";
                var_dump($json->is_live);
                echo "</td></tr>";
            }
        }else{

                $objYear=$json->years;
                foreach ($objYear as $k => $arryV) {
                //  echo $k, ' => array length=', count($arryV), PHP_EOL;
            
                        if($k<2018){
                            
                            $markHistory=0;
                            foreach($arryV as $v){ 
                                if($v>0){
                                    $markHistory++;
                                }
                            } 
                
                            if($markHistory>0){
                                $markYear++;
                                $years="|".$k.$years;
                            //  echo $k;
                            //  echo "*****<br>";
                            }
                        }
                }
        }

    }

    if($markYear>0){
        //echo $url."||".$markYear.$years."<br>";
        echo "<tr><td>".$url."</td><td>".$markYear."</td></tr>";
        $var_count_history++;
    }
    if($i<$max-1){
        showHistory($urlar,$i+1,$max,$var_count_history);
    }else{

        echo '</table>';
        echo "<hr><br>有效的域名数：".$var_count_history;
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


$time2=time()-$time1;
echo "<br>共查询【".$urls_count."】个域名，用时：";
echo $time2;
echo "秒，平均每条用时".$time2/$urls_count."秒";
echo "</body></html>";
?>
