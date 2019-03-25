<?php

date_default_timezone_set("Asia/Chongqing");

$interval=2;// 每隔4s运行

$startTime = microtime(true);
$endTime = microtime(true);
$runTime = ($endTime-$startTime)*1000 . ' ms';

//  getApi();
// exit();

 
//if (date("G")<5||date("G")>13) {

    do {
        $api_statu=getApi();
        sleep($interval);

        $endTime = microtime(true);
        $runTime = $endTime-$startTime;

        $m=gmstrftime('%M:%S', $runTime);


        echo $m." ___ ";
    
        echo $runTime." ___ \n";
    } while ($runTime<5*60 && !$api_statu);
//}

function getApi()
{
    $api='http://t.apiplus.net/newly.do?code=bjpk10&format=json';
    $api="http://data.365rich.com/data/lottery/result/list?token=sWk2WzDa8MBg4679&type=3004&count=1";//&period=726945
    //[{"period":"726937","numbers":["7","3","1","6","4","5","8","2","10","9"],
    $api="https://www.ezun889.com/lottery/commonLottery/getRecent5Records.html?code=jspk10";
    $api="https://www.ezun889.com/lottery/commonLottery/getRecent5Records.html?code=xyft";
    $api="https://www.ezun889.com/lottery/commonLottery/getRecent5Records.html?code=cqssc";
    //{"id":2807912,"expect":"201901310859","code":"jspk10","type":"pk10","openCode":"07,01,02,04,05,03,08,06,09,10",
    //"openTime":1548915540000,"closeTime":1548915530000,"openingTime":1548915470000,"gatherTime":1548915540853,
    //"origin":"1","date":null,"orderNum":null,
    //"fmOpenTime":"2019-01-31 14:19:00","codeMemo":"极速PK10","leftTime":0,"leftOpenTime":0},
    // $result=file_get_contents($api);
    $result=getHtml($api);

    $json=json_decode($result);

 

    if ($json!=null) {
        if (gettype($json)=="array") {
            $expect=$json[0]->expect;
            $opencode=$json[0]->openCode;
        
            if ($opencode==null) {
                echo "<br>--opencode--null----";
                return false;
            }
         
            // $opencode = implode(",", $array_opencode);
            // $open_time = date('Y-m-d H:i:s', ($json[0]->open_date)/1000);
            $open_time = $json[0]->fmOpenTime;
            /////////////////////////////////
            //开奖号码转为数组
            $array_opencode=explode(",", $opencode);

            //定位胆
            $str1=$opencode;

            //大小定位
            $str2=getSize($array_opencode[0]).",".getSize($array_opencode[1]).",".getSize($array_opencode[2]).",".getSize($array_opencode[3]).",".getSize($array_opencode[4]);
  
            //单双定位
            $str3=getOddOrEven($array_opencode[0]).",".getOddOrEven($array_opencode[1]).",".getOddOrEven($array_opencode[2]).",".getOddOrEven($array_opencode[3]).",".getOddOrEven($array_opencode[4]);

            //和值
            $opencode_sum = array_sum($array_opencode);
            $str4=getSumSize($opencode_sum).",".getOddOrEven($opencode_sum).",".getSumSize($opencode_sum).getOddOrEven($opencode_sum);

            //五星定胆
            $str5=implode("||", $array_opencode);

            //组三
            $str6=getABB($array_opencode[0], $array_opencode[1], $array_opencode[2]).",".getABB($array_opencode[1], $array_opencode[2], $array_opencode[3]).",".getABB($array_opencode[2], $array_opencode[3], $array_opencode[4]);

            //组六
            $str7=getABC($array_opencode[0], $array_opencode[1], $array_opencode[2]).",".getABC($array_opencode[1], $array_opencode[2], $array_opencode[3]).",".getABC($array_opencode[2], $array_opencode[3], $array_opencode[4]);



        
            $opencode = $str1."|||".$str2."|||".$str3."|||".$str4."|||".$str5."|||".$str6."|||".$str7;
            ////////////////////////////
            echo $opencode;

            $json_new=(object)array("data"=>array((object)array("expect"=>$expect,"opencode"=>$opencode,"opentime"=>$open_time)));
            $json=$json_new;
            $result=json_encode($json);
      
            $expect=$json->data[0]->expect;
              
   
            $file_name=$expect;
            $str=$result;
   
            $t=$json->data[0]->opentime;
            $opentime=strtotime($t);
            $today=date("Y-m-d")." 00:00:00";
            $today=strtotime($today);

            if ($opentime>$today) {
                return add($file_name, $str);
            }
        } elseif (gettype($json)=="object") {
            if (property_exists($json, "data")) {
                $expect=$json->data[0]->expect;
                //  var_dump($expect);
   
                $file_name=$expect;
                $str=$result;
   
                $t=$json->data[0]->opentime;
                $opentime=strtotime($t);
                $today=date("Y-m-d")." 00:00:00";
                $today=strtotime($today);
                if ($opentime>$today) {
                    return add($file_name, $str);
                }
            } else {
                var_dump($json);
            }
        }
    };
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
function getABB($a, $b, $c)
{
    if ($a==$b&&$b==$c) {
        return "err";//豹子
    }
    if ($a==$b) {
        return $b."&&".$c;//组三
    }
    if ($b==$c) {
        return $a."&&".$c;//组三
    }
    if ($a==$c) {
        return $a."&&".$b;//组三
    }
    return "err";//组六
};
function getABC($a, $b, $c)
{
    if ($a==$b&&$b==$c) {
        return "err";//豹子
    }
    if ($a==$b||$b==$c||$a==$c) {
        return "err";//组三
    }
    return $a."&&".$b."&&".$c;//组六
};
function add($file_name, $str)
{

//echo '<!DOCTYPE HTML><html lang="zh-CN"><head><meta charset="utf-8"><title>*setTime</title></head><body>';

    $mk_dir="txt-kj";
  
    
    $mk_day=date("Ymd");

    //开奖时间，00:30~~    23：50
    //5点之前的（0-4点的开奖，归前一天）
    // if (date("G")<5) {
//    $mk_day=date("Ymd", strtotime("-1 day"));
    // }

    //$file_name=date("Ymd");

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


function getHtml($url)
{

    //$html=file_get_contents($So360);
    // $useragent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.89 Safari/537.36';
    $timeout= 120;
    $dir            = dirname(__FILE__);
    $cookie_file    = $dir . '/cookies/' . md5($_SERVER['REMOTE_ADDR']) . '.txt';
    $refer_url_array = [
        'ezun88'  => 'https://www.ezun889.com/lottery/pk10/jspk10/index.html',
        'ezgj999' => 'http://www.ezgj999.com/lottery/pk10/jspk10/index.html',
        'ezgj666' => 'http://www.ezgj666.com/lottery/pk10/jspk10/index.html'
    ];
    $agent_array=[
        //PC端的UserAgent
        "safari 5.1 – MAC"=>"Mozilla/5.0 (Windows NT 6.1) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.57 Safari/536.11",
        "safari 5.1 – Windows"=>"Mozilla/5.0 (Windows; U; Windows NT 6.1; en-us) AppleWebKit/534.50 (KHTML, like Gecko) Version/5.1 Safari/534.50",
        "Firefox 38esr"=>"Mozilla/5.0 (Windows NT 10.0; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0",
        "IE 11"=>"Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; .NET4.0C; .NET4.0E; .NET CLR 2.0.50727; .NET CLR 3.0.30729; .NET CLR 3.5.30729; InfoPath.3; rv:11.0) like Gecko",
        "IE 9.0"=>"Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0",
        "IE 8.0"=>"Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/4.0)",
        "IE 7.0"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0)",
        "IE 6.0"=>"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)",
        "Firefox 4.0.1 – MAC"=>"Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:2.0.1) Gecko/20100101 Firefox/4.0.1",
        "Firefox 4.0.1 – Windows"=>"Mozilla/5.0 (Windows NT 6.1; rv:2.0.1) Gecko/20100101 Firefox/4.0.1",
        "Opera 11.11 – MAC"=>"Opera/9.80 (Macintosh; Intel Mac OS X 10.6.8; U; en) Presto/2.8.131 Version/11.11",
        "Opera 11.11 – Windows"=>"Opera/9.80 (Windows NT 6.1; U; en) Presto/2.8.131 Version/11.11",
        "Chrome 17.0 – MAC"=>"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_0) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.56 Safari/535.11",
        "傲游（Maxthon）"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Maxthon 2.0)",
        "腾讯TT"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; TencentTraveler 4.0)",
        "世界之窗（The World） 2.x"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)",
        "世界之窗（The World） 3.x"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; The World)",
        "360浏览器"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; 360SE)",
        "搜狗浏览器 1.x"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Trident/4.0; SE 2.X MetaSr 1.0; SE 2.X MetaSr 1.0; .NET CLR 2.0.50727; SE 2.X MetaSr 1.0)",
        "Avant"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Avant Browser)",
        "Green Browser"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)",
        //移动端口
        "safari iOS 4.33 – iPhone"=>"Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5",
        "safari iOS 4.33 – iPod Touch"=>"Mozilla/5.0 (iPod; U; CPU iPhone OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5",
        "safari iOS 4.33 – iPad"=>"Mozilla/5.0 (iPad; U; CPU OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5",
        "Android N1"=>"Mozilla/5.0 (Linux; U; Android 2.3.7; en-us; Nexus One Build/FRF91) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1",
        "Android QQ浏览器 For android"=>"MQQBrowser/26 Mozilla/5.0 (Linux; U; Android 2.3.7; zh-cn; MB200 Build/GRJ22; CyanogenMod-7) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1",
        "Android Opera Mobile"=>"Opera/9.80 (Android 2.3.4; Linux; Opera Mobi/build-1107180945; U; en-GB) Presto/2.8.149 Version/11.10",
        "Android Pad Moto Xoom"=>"Mozilla/5.0 (Linux; U; Android 3.0; en-us; Xoom Build/HRI39) AppleWebKit/534.13 (KHTML, like Gecko) Version/4.0 Safari/534.13",
        "BlackBerry"=>"Mozilla/5.0 (BlackBerry; U; BlackBerry 9800; en) AppleWebKit/534.1+ (KHTML, like Gecko) Version/6.0.0.337 Mobile Safari/534.1+",
        "WebOS HP Touchpad"=>"Mozilla/5.0 (hp-tablet; Linux; hpwOS/3.0.0; U; en-US) AppleWebKit/534.6 (KHTML, like Gecko) wOSBrowser/233.70 Safari/534.6 TouchPad/1.0",
        "UC标准"=>"NOKIA5700/ UCWEB7.0.2.37/28/999",
        "UCOpenwave"=>"Openwave/ UCWEB7.0.2.37/28/999",
        "UC Opera"=>"Mozilla/4.0 (compatible; MSIE 6.0; ) Opera/UCWEB7.0.2.37/28/999",
        "微信内置浏览器"=>"Mozilla/5.0 (Linux; Android 6.0; 1503-M02 Build/MRA58K) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/37.0.0.0 Mobile MQQBrowser/6.2 TBS/036558 Safari/537.36 MicroMessenger/6.3.25.8　　　　　　　61 NetType/WIFI Language/zh_CN",
        "safari5.0"=>"Mozilla/5.0 (iPhone; U; CPU like Mac OS X) AppleWebKit/420.1 (KHTML, like Gecko) Version/3.0 Mobile/4A93 Safari/419.3",
        'google5.0' => 'Mozilla/5.0 (Windows; U; Windows NT 5.2) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.2.149.27 Safari/525.13'
    ];
    $ip_long = array(
        array('607649792', '608174079'), //36.56.0.0-36.63.255.255
        array('1038614528', '1039007743'), //61.232.0.0-61.237.255.255
        array('1783627776', '1784676351'), //106.80.0.0-106.95.255.255
        array('2035023872', '2035154943'), //121.76.0.0-121.77.255.255
        array('2078801920', '2079064063'), //123.232.0.0-123.235.255.255
        array('-1950089216', '-1948778497'), //139.196.0.0-139.215.255.255
        array('-1425539072', '-1425014785'), //171.8.0.0-171.15.255.255
        array('-1236271104', '-1235419137'), //182.80.0.0-182.92.255.255
        array('-770113536', '-768606209'), //210.25.0.0-210.47.255.255
        array('-569376768', '-564133889'), //222.16.0.0-222.95.255.255
    );
    $rand_key = mt_rand(0, 9);
    $ip= long2ip(mt_rand($ip_long[$rand_key][0], $ip_long[$rand_key][1]));//
    $header = array(
        'CLIENT-IP:'.$ip,
        'X-FORWARDED-FOR:'.$ip,
    );    //构造ip
    $useragent=$agent_array[array_rand($agent_array, 1)];//随机浏览器
    $referurl = $refer_url_array[array_rand($refer_url_array, 1)];  //随机来源网址referurl

  //  $header = array("Connection: Keep-Alive","Accept: text/html, application/xhtml+xml, */*", "Pragma: no-cache", "Accept-Language: zh-Hans-CN,zh-Hans;q=0.8,en-US;q=0.5,en;q=0.3","User-Agent: Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; WOW64; Trident/6.0)",'CLIENT-IP:'.$ip,'X-FORWARDED-FOR:'.$ip);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
    curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_ENCODING, "");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);

    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
    curl_setopt($ch, CURLOPT_REFERER, $referurl);
    $html = curl_exec($ch);
    if (curl_errno($ch)) {
        return 'error:' . curl_error($ch);
    }
 
    curl_close($ch);
    return $html;
}
