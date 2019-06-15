<?php

date_default_timezone_set("Asia/Chongqing");



class vrsxffc
{
    private $kjInterval;
    private $loopInterval;
    private $cookiePath;

    private $api;
    private $post_data;

    private $referURL;
    private $origin;

    

    private $nowTime;
    private $kjTime;
    private $jsTime;


    private $cookieStr;



    public function __construct()
    {
        $this->kjInterval = 1*60;
        $this->loopInterval = 2;

        $this->cookiePath="cookie.txt";

        $this->api = 'http://hts.vrbetapi.com/DrawHistory/GetRoadTrend';
        $lotteryGameID='34';
        $this->post_data=array(
            'lotteryGameID'=>$lotteryGameID,//VR水星分分彩
            'quantity'=>'120',//几条数据
        );

        $this->referURL='http://hts.vrbetapi.com/Bet/Index/'.$lotteryGameID;
        $this->origin='http://hts.vrbetapi.com';


        ////开奖时间，09:00:00~~ 次日 06：00:20
        $this->nowTime=strtotime(date("Y-m-d H:i:s"));
        $this->kjTime=strtotime(date("Y-m-d")." 09:00:00");
        $this->jsTime=strtotime(date("Y-m-d")." 06:01:00");

  

        $this->cookieStr="ASP.NET_SessionId=libb2mgsa0w10es0pswljwro; __RequestVerificationToken=zvopn-bPP9qmRWmnhUXpsh_Xj5X-qxvVwjh2q608p7li3jzB1b7zuYwUBeSBl_NvhiPmU6qY6bOzFY9ftGKJ-DIZa5L9fgMX11HA3Bw1zMc1; token=e02a3349f31ec4ae5c007da28893b068; random=1446; .AspNet.ApplicationCookie=xGeF9rmVruJVvTVWZLOo73NfB5JC92dSYe3o0011Zcz0CQnYpkllGsz2ieQEEhx1YaQqTob6XlD3zxaS3cBNmD1eQYPVbma3VBnOgkEO0updc3o0BLmlwUcFwUYUhwcLaXQ5Jkn1zJrbALZOiVAh_K0udQIqLB3khZXTWknJehDe1QNEEBM-74WMwWIVWliE1gLvwbXunVqe1L6b4BBRkLkAfWSoaJtHOEyb2siNUnpIUDxWGrasq6TwklARLk4s5yVu7SVQ2H9iYA7Yoe-tdgdyT1x4AB3VBbudnPnr7HAa-WT03p0oU1NghDiO5R08VJE-TY5XKTUAXPXkExzPlriQbFZu-ccTNjl9YBXBz1YK3BDUb8deYrFB-LUAo78svagUTBD1NFP5eVWQ2KBCPaFdM3ULiaUf7j7u0e4u1Fg_cRXDB8eK50Rrpuag0GJIHdz-Wt26u251JGCKaQ3SKcSJfWExge2X57-z_dD3ay4ReDHXy8P9DdNmcscUFamplpmhqTiq2HpMH2D2g29HvLyAKOml9VS8f72B7BuXc6E";
        
        $this->getCookie();
   


        if ($this->nowTime>$this->kjTime||$this->nowTime<$this->jsTime) {
            $startTime = microtime(true);
            $endTime = microtime(true);
            $runTime = $endTime-$startTime;

            do {
                $api_statu=$this->getApi();

                sleep($this->loopInterval);

                $endTime = microtime(true);
                $runTime = $endTime-$startTime;

                $m=gmstrftime('%M:%S', $runTime);
                echo $m." ___ ".$runTime." ___ <br> \n";
            } while ($runTime<$this->kjInterval && !$api_statu);
        }else{
            $this->getApi();//刷新cookie
        }
    }

    public function getApi()
    {
        $result = $this->getHtml();
        //  [{"SequenceNumber":"0617","Date":"20190602","WinningNumber":"5,4,2,1,5","IssueNumber":"201906020617"}]
        $json=json_decode($result);

      // var_dump($json);
    
        if ($json!=null) {
            if (gettype($json)=="array") {
                if (count($json)<=0) {
                    echo "---- ".$result." ----";
                    return false;
                }
                usort($json,function ($a, $b){
                    return -strcmp($a->IssueNumber, $b->IssueNumber);
                });
    
                $expect=$json[0]->IssueNumber;
                $opencode=$json[0]->WinningNumber;
                $open_time=date("Y-m-d H:i:s");
                $open_Date=$json[0]->Date;
    
    
                //开奖号码转为数组
                $array_opencode=explode(",", $opencode);
    
                //定位胆
                $str1=$opencode;
                
                //大小定位
                $str2=$this->getSize($array_opencode[0]).",".$this->getSize($array_opencode[1]).",".$this->getSize($array_opencode[2]).",".$this->getSize($array_opencode[3]).",".$this->getSize($array_opencode[4]);
                  
                //单双定位
                $str3=$this->getOddOrEven($array_opencode[0]).",".$this->getOddOrEven($array_opencode[1]).",".$this->getOddOrEven($array_opencode[2]).",".$this->getOddOrEven($array_opencode[3]).",".$this->getOddOrEven($array_opencode[4]);
                
                //和值
                $opencode_sum = array_sum($array_opencode);
                $str4=$this->getSumSize($opencode_sum).",".$this->getOddOrEven($opencode_sum).",".$this->getSumSize($opencode_sum).$this->getOddOrEven($opencode_sum);
                
                //五星定胆
                $str5=implode("||", $array_opencode);
                
                //组三
                $str6=$this->getABB($array_opencode[0], $array_opencode[1], $array_opencode[2]).",".$this->getABB($array_opencode[1], $array_opencode[2], $array_opencode[3]).",".$this->getABB($array_opencode[2], $array_opencode[3], $array_opencode[4]);
                
                //组六
                $str7=$this->getABC($array_opencode[0], $array_opencode[1], $array_opencode[2]).",".$this->getABC($array_opencode[1], $array_opencode[2], $array_opencode[3]).",".$this->getABC($array_opencode[2], $array_opencode[3], $array_opencode[4]);
    
                $opencode = $str1."|||".$str2."|||".$str3."|||".$str4."|||".$str5."|||".$str6."|||".$str7;
                ////////////////////////////
                echo $opencode;
    
                // $opencode = implode(",", $array_opencode);
                // $open_time = date('Y-m-d H:i:s', ($json[0]->open_date)/1000);
                //$open_time = $json[0]->fmOpenTime;
                $json_new=(object)array("data"=>array((object)array("expect"=>$expect,"opencode"=>$opencode,"opentime"=>$open_time)));
                $json=$json_new;
                $result=json_encode($json);
          
                $expect=$json->data[0]->expect;
                  
                $file_name=$expect;
                $str=$result;
       
                $openDate=strtotime($open_Date."000001");
                $today=strtotime(date("Y-m-d")." 00:00:00");
    
                if ($this->nowTime>$this->kjTime && $openDate<$today) {//9点之后，不再写入昨天的开奖
                    return false;
                }
                return $this->add($file_name, $str);
            } elseif (gettype($json)=="object") {
                //{"error":0,"data":{"openCodeMemo":null,"expect":"201902060911","openCode":"04,01,03,10,07,02,09,08,05,06","openTime":1549437060000}}
                if (property_exists($json, "data")) {
                    $data__=$json->data;
    
                    if (gettype($json->data)=="array") {
                        $data__=$json->data[0];
                    }
                    $expect=$data__->expect;
                    $opencode=$data__->openCode;
                    $open_time = date('Y-m-d H:i:s', ($data__->openTime)/1000);
                    ;
    
                    if ($opencode==null) {
                        echo "<br>--opencode--null----";
                        return false;
                    }
                    // $opencode = implode(",", $array_opencode);
                    // $open_time = date('Y-m-d H:i:s', ($json[0]->open_date)/1000);
    
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
    
                    if ($this->jnowTime>$this->jkjTime && $opentime<$today) {//9点之后，不再写入昨天的开奖
                        return false;
                    }
                    return $this->add($file_name, $str);
                } else {
                    var_dump($json);
                    return false;
                }
            }
        }else{
            echo " <br> \n ----- result=".$result." -------- <br> \n";
        };
    }



    public function getHtml()
    {
        $post_data=$this->post_data;
    
        $url=$this->api;

        $referURL=$this->referURL;
    
        if (empty($url) || empty($post_data)) {
            return false;
        }
        
       
    
        $o = "";
        foreach ($post_data as $k => $v) {
            $o.= "$k=" . urlencode($v). "&" ;
        }
        $post_data = substr($o, 0, -1);
    
    
        $postUrl = $url;
        $curlPost = $post_data;
        $timeout= 120;
        $refer_url_array = [
            'ezun88'  => $referURL,
        ];
        $dir            = dirname(__FILE__);
        $cookie_file    = $dir . '/cookies/' . md5($_SERVER['REMOTE_ADDR']) . '.txt';
        $agent_array=[
            //PC�˵�UserAgent
            "safari 5.1 �C MAC"=>"Mozilla/5.0 (Windows NT 6.1) AppleWebKit/536.11 (KHTML, like Gecko) Chrome/20.0.1132.57 Safari/536.11",
            "safari 5.1 �C Windows"=>"Mozilla/5.0 (Windows; U; Windows NT 6.1; en-us) AppleWebKit/534.50 (KHTML, like Gecko) Version/5.1 Safari/534.50",
            "Firefox 38esr"=>"Mozilla/5.0 (Windows NT 10.0; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0",
            "IE 11"=>"Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; .NET4.0C; .NET4.0E; .NET CLR 2.0.50727; .NET CLR 3.0.30729; .NET CLR 3.5.30729; InfoPath.3; rv:11.0) like Gecko",
            "IE 9.0"=>"Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0",
            "IE 8.0"=>"Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/4.0)",
            "IE 7.0"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.0)",
            "IE 6.0"=>"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)",
            "Firefox 4.0.1 �C MAC"=>"Mozilla/5.0 (Macintosh; Intel Mac OS X 10.6; rv:2.0.1) Gecko/20100101 Firefox/4.0.1",
            "Firefox 4.0.1 �C Windows"=>"Mozilla/5.0 (Windows NT 6.1; rv:2.0.1) Gecko/20100101 Firefox/4.0.1",
            "Opera 11.11 �C MAC"=>"Opera/9.80 (Macintosh; Intel Mac OS X 10.6.8; U; en) Presto/2.8.131 Version/11.11",
            "Opera 11.11 �C Windows"=>"Opera/9.80 (Windows NT 6.1; U; en) Presto/2.8.131 Version/11.11",
            "Chrome 17.0 �C MAC"=>"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_7_0) AppleWebKit/535.11 (KHTML, like Gecko) Chrome/17.0.963.56 Safari/535.11",
            "���Σ�Maxthon��"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Maxthon 2.0)",
            "��ѶTT"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; TencentTraveler 4.0)",
            "����֮����The World�� 2.x"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)",
            "����֮����The World�� 3.x"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; The World)",
            "360�����"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; 360SE)",
            "�ѹ������ 1.x"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Trident/4.0; SE 2.X MetaSr 1.0; SE 2.X MetaSr 1.0; .NET CLR 2.0.50727; SE 2.X MetaSr 1.0)",
            "Avant"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; Avant Browser)",
            "Green Browser"=>"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1)",
            //�ƶ��˿�
            "safari iOS 4.33 �C iPhone"=>"Mozilla/5.0 (iPhone; U; CPU iPhone OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5",
            "safari iOS 4.33 �C iPod Touch"=>"Mozilla/5.0 (iPod; U; CPU iPhone OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5",
            "safari iOS 4.33 �C iPad"=>"Mozilla/5.0 (iPad; U; CPU OS 4_3_3 like Mac OS X; en-us) AppleWebKit/533.17.9 (KHTML, like Gecko) Version/5.0.2 Mobile/8J2 Safari/6533.18.5",
            "Android N1"=>"Mozilla/5.0 (Linux; U; Android 2.3.7; en-us; Nexus One Build/FRF91) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1",
            "Android QQ����� For android"=>"MQQBrowser/26 Mozilla/5.0 (Linux; U; Android 2.3.7; zh-cn; MB200 Build/GRJ22; CyanogenMod-7) AppleWebKit/533.1 (KHTML, like Gecko) Version/4.0 Mobile Safari/533.1",
            "Android Opera Mobile"=>"Opera/9.80 (Android 2.3.4; Linux; Opera Mobi/build-1107180945; U; en-GB) Presto/2.8.149 Version/11.10",
            "Android Pad Moto Xoom"=>"Mozilla/5.0 (Linux; U; Android 3.0; en-us; Xoom Build/HRI39) AppleWebKit/534.13 (KHTML, like Gecko) Version/4.0 Safari/534.13",
            "BlackBerry"=>"Mozilla/5.0 (BlackBerry; U; BlackBerry 9800; en) AppleWebKit/534.1+ (KHTML, like Gecko) Version/6.0.0.337 Mobile Safari/534.1+",
            "WebOS HP Touchpad"=>"Mozilla/5.0 (hp-tablet; Linux; hpwOS/3.0.0; U; en-US) AppleWebKit/534.6 (KHTML, like Gecko) wOSBrowser/233.70 Safari/534.6 TouchPad/1.0",
            "UC��׼"=>"NOKIA5700/ UCWEB7.0.2.37/28/999",
            "UCOpenwave"=>"Openwave/ UCWEB7.0.2.37/28/999",
            "UC Opera"=>"Mozilla/4.0 (compatible; MSIE 6.0; ) Opera/UCWEB7.0.2.37/28/999",
            "΢�����������"=>"Mozilla/5.0 (Linux; Android 6.0; 1503-M02 Build/MRA58K) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/37.0.0.0 Mobile MQQBrowser/6.2 TBS/036558 Safari/537.36 MicroMessenger/6.3.25.8��������������61 NetType/WIFI Language/zh_CN",
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
            'Host:hts.vrbetapi.com',
            'Connection:keep-alive',
            'Origin:'.$this->origin,
            'Cookie:'.$this->getCookie()
        );
        $useragent=$agent_array[array_rand($agent_array, 1)];//��������
        $referurl = $refer_url_array[array_rand($refer_url_array, 1)];  //�����Դ��ַreferurl


        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_COOKIEFILE,  $cookie_file);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_ENCODING, "");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        curl_setopt($ch, CURLOPT_REFERER, $referurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
    
        $html = curl_exec($ch);
        if (curl_errno($ch)) {
            return 'error:' . curl_error($ch);
        }
    
        $info = curl_getinfo($ch);
    
        $httpHeaderSize = $info['header_size'];  //header字符串体积
        $pHeader = substr($html, 0, $httpHeaderSize); //获得header字符串
        $pRes = substr($html, $httpHeaderSize); //获得 返回值 字符串
        $pHeader = $this->http_header_to_arr($pHeader);
        if (isset($pHeader["Set-Cookie"])) {
            $this->addCookie($pHeader["Set-Cookie"]);
        }
        curl_close($ch);
        return $pRes;
    }





    public function http_header_to_arr($header_str)
    {
        $header_list = explode("\n", $header_str);
        $header_arr = [];
        foreach ($header_list as $key => $value) {
            if (strpos($value, ':') === false) {
                continue;
            }
            list($header_key, $header_value) = explode(":", $value, 2);
            $header_arr[$header_key] = trim($header_value);
        }
        if (isset($header_arr['Content-MD5'])) {
            $header_arr['md5'] = bin2hex(base64_decode($header_arr['Content-MD5']));
        }
        return $header_arr;
    }

    public function addCookie($str)
    {
  
        file_put_contents($this->cookiePath, $str);
    }
    public function getCookie()
    {
        
        if (!file_exists($this->cookiePath)) {
            file_put_contents($this->cookiePath, '');
        }
        $contents = file_get_contents($this->cookiePath);

        if (strlen($contents)<10) {
            $this->addCookie($this->cookieStr);
            echo " <br> \n -----getCookie:  no old add temp_cookie-------- <br> \n";
        } else {
            $this->cookieStr=$contents;
            echo " <br> \n -----getCookie:  had old SESSION_cookie -------- <br> \n";
        }
     //   echo $this->cookieStr;
        return  $this->cookieStr;
    }


    

    public function getSize($n)
    {
        if ($n<5) {
            return "小";
        } else {
            return "大";
        }
    }
    public function getSumSize($n)
    {
        if ($n<23) {
            return "小";
        } else {
            return "大";
        }
    }
    public function getOddOrEven($n)
    {
        if ((abs($n)+2)%2==1) {
            return "单";
        } else {
            return "双";
        }
    }
    public function getABB($a, $b, $c)
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
    }
    public function getABC($a, $b, $c)
    {
        if ($a==$b&&$b==$c) {
            return "err";//豹子
        }
        if ($a==$b||$b==$c||$a==$c) {
            return "err";//组三
        }
        return $a."&&".$b."&&".$c;//组六
    }
    public function add($file_name, $str)
    {

        echo "try to add the result-> <br> \n";
        $mk_dir="txt-kj";
  
    
        $mk_day=date("Ymd");

        if (date("G")<7) {
            $mk_day=date("Ymd", strtotime("-1 day"));
        }

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

            echo "create succse <br> \n";
            return true;
        } else {
            echo "create false <br> \n";

            return false;
        }
    }
}


new vrsxffc();