<?php

date_default_timezone_set("Asia/Chongqing");



class vrsxffc
{
    private $kjInterval;
    private $loopInterval;
    private $cookiePath;

    private $api;

    private $referURL;
    private $origin;

    private $nowTime;
    private $kjTime;
    private $jsTime;

    private $oneMID;
    private $sumMID;

    private $cookieStr;



    public function __construct()
    {
        $isLuck=true;
        //$isLuck=true;//幸运彩票 true   龙头彩票 false

        $isTEST=false;

        $dir= dirname(__FILE__);

        $this->kjInterval = 20*60;//每期20分钟  44期
        $this->loopInterval = 2;
        $this->oneMID=6;//1-10  小于6的为小
        $this->sumMID=12;// 和值为3-19   小于12的为小

        ////开奖时间，		09:30:00~~23:50:00    (实际在00:32:30左右抓到数据，最后一期在 23:55:30左右)  
        ////计划于09:32:00进入访问，下方的开奖时间要比计划任务设定的早一点
        $this->nowTime=strtotime(date("Y-m-d H:i:s"));
        $this->kjTime=strtotime(date("Y-m-d")." 09:30:00");//	13:09:51
        $this->jsTime=strtotime(date("Y-m-d")." 23:59:59");

        $this->cookiePath=$dir."/cookie.txt";
        if ($isLuck) {
            $this->cookiePath=$dir."/cookieIsLuck.txt";
        }
        $this->api = 'https://www.ezun889.com/lottery/commonLottery/getRecent5Records.html?code=bjpk10';
        if ($isLuck) {
            $this->api = 'https://luck.sdtiop.com/hall/pc/lottery/get-recent-close-expect.html?code=bjpk10';
        }
        $this->referURL='https://www.ezun889.com/lottery/pk10/xyft/index.html';
        if ($isLuck) {
            $this->referURL='https://luck.sdtiop.com/open1/index.html';
        }
        $this->Host='www.ezun889.com';
        if ($isLuck) {
            $this->Host='luck.sdtiop.com';
        }

        $this->cookieStr="_ga=GA1.2.1122988726.1547700251; _LANGUAGE=zh_CN; isAutoPay=true; BALANCE_HIDE=false; REFRESH_BALANCE_TIME=0; _gid=GA1.2.985156283.1562824143; ACCESS_TERMINAL=pc; SID=kfdmQlcXjBs02+BvtvNwCgaE0doAbLWyWwYH3hxovwaBwa2snEz/fHJ+FtxhLEz/LT5/4borO4XwGTAkwoyhUw==; UID=jlhtznre; _gat_gtag_UA_122667432_2=1; route=b69869a777c0b504c19cab11c578637a";
        
        $this->log("<br> __construct___ getCookie() ___  \n");
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
                $this->log("<br>--runTime=".$m." --".$runTime."--\n");
            } while ($runTime<$this->kjInterval && !$api_statu && !$isTEST);
        } else {
            $this->log("<br> __reset___ getCookie() ___  \n");;
            $this->getApi();//刷新cookie
        }
    }

    public function getApi()
    {
        $result = $this->getHtml();
        $json=json_decode($result);
        //  var_dump($json);
        //  return;
        if ($json!=null) {
            if (gettype($json)=="array") {
                //https://www.ezun889.com/lottery/pk10/xyft/index.html
                if (count($json)<=0) {
                    $this->log("<br> __".$result."___  \n");
                    return false;
                }
                // usort($json, function ($a, $b) { 排序
                //     return -strcmp($a->IssueNumber, $b->IssueNumber);
                // });
                //[{"id":3438390,"expect":"20190711104","code":"xyft","type":"pk10","openCode":null,
                //      "openTime":1562852680000,"closeTime":1562852620000,"openingTime":1562852320000,
                //      "gatherTime":null,"origin":null,"date":null,"advanceOpen":false,"orderNum":null,
                //       "fmOpenTime":"2019-07-11 21:44:40","codeMemo":"幸运飞艇","leftTime":0,"leftOpenTime":0}]
                $expect=$json[0]->expect;
                $opencode=$json[0]->openCode;
                $open_time=$json[0]->fmOpenTime;//date("Y-m-d H:i:s");
                if ($opencode==null) {
                    $this->log("<br>--opencode--null---- \n");
                    return false;
                }
                // $open_Date=$json[0]->Date;
    
                //开奖号码转为数组
                $array_opencode=explode(",", $opencode);
                /////////////////////////////////////////////
                //////////////// 开始 玩法 ///////////////////
                /////////////////////////////////////////////
                //定位胆
                $str1=$opencode;
                //大小定位  1、2、3、4、5时为“小”
                $str2=$this->getSize($array_opencode[0], $this->oneMID).","
                    .$this->getSize($array_opencode[1], $this->oneMID).","
                    .$this->getSize($array_opencode[2], $this->oneMID).","
                    .$this->getSize($array_opencode[3], $this->oneMID).","
                    .$this->getSize($array_opencode[4], $this->oneMID);
                //单双定位
                $str3=$this->getOddOrEven($array_opencode[0]).","
                    .$this->getOddOrEven($array_opencode[1]).","
                    .$this->getOddOrEven($array_opencode[2]).","
                    .$this->getOddOrEven($array_opencode[3]).","
                    .$this->getOddOrEven($array_opencode[4]);

                //冠亚和   1-10  和 和值为3-19 
                $opencode_sum = $array_opencode[0]+$array_opencode[1];
                $hzdx=$this->getSumSize($opencode_sum, $this->sumMID);//和值大小  小值为3-11
                $hzds=$this->getOddOrEven($opencode_sum); //和值单双
                $str4=$hzdx.",".$hzds.",".$hzdx.$hzds;
                // //和值
                // $opencode_sum = array_sum($array_opencode);
                // $hzdx=$this->getSumSize($opencode_sum, 23);//和值大小getSumSize  5位数，0~9，和值为0~45，小值为0-22
                // $hzds=$this->getOddOrEven($opencode_sum); //和值单双
                // $str4=$hzdx.",".$hzds.",".$hzdx.$hzds;
                // //龙虎和  以开奖结果的万位和个位作为基准，取万为龙，个为虎的数字进行大小比对的一种玩法
                // $str5=$this->getDragonOrTiger($array_opencode[0], $array_opencode[4]);
                // //五星定胆
                // $str6=implode("||", $array_opencode);
                // //组三
                // $str7=$this->getABB($array_opencode[0], $array_opencode[1], $array_opencode[2]).","
                //     .$this->getABB($array_opencode[1], $array_opencode[2], $array_opencode[3]).","
                //     .$this->getABB($array_opencode[2], $array_opencode[3], $array_opencode[4]);
                // //组六
                // $str8=$this->getABC($array_opencode[0], $array_opencode[1], $array_opencode[2]).","
                //     .$this->getABC($array_opencode[1], $array_opencode[2], $array_opencode[3]).","
                //     .$this->getABC($array_opencode[2], $array_opencode[3], $array_opencode[4]);

                $opencode = $str1."|||".$str2."|||".$str3."|||".$str4;

                /////////////////////////////////////////////
                //////////////// 结束 玩法 ///////////////////
                /////////////////////////////////////////////

                $json_new=(object)array("data"=>array((object)array("expect"=>$expect,"opencode"=>$opencode,"opentime"=>$open_time)));
                $json=$json_new;
                $result=json_encode($json);
          
                $expect=$json->data[0]->expect;
                  
                $file_name=$expect;
                $str=$result;
       
                $openDate=strtotime(substr($expect, 0, 8)."000001");
                $today=strtotime(date("Y-m-d")." 00:00:00");
                //{"data":[{"expect":"20190710170","opencode":"07,01,04,10,05,06,08,09,02,03","opentime":"2019-07-11 03:14:40"}]}
                // 开奖  13：09-00:00-次日04：04

                if ($this->nowTime>$this->jsTime && $openDate<$today) {//开奖结束之后，不再写入昨天的开奖
                    return false;
                }
                return $this->add($file_name, $str);
            } elseif (gettype($json)=="object") {
                //https://luck.sdtiop.com/hall/pc/lottery/get-recent-close-expect.html?code=xyft
                //{"error":0,"data":{"openCodeMemo":null,"expect":"20190711107","openCode":"03,08,07,02,01,09,10,06,04,05","openTime":1562853580000}}
                if (property_exists($json, "data")) {
                    $data__=$json->data;
    
                    if (gettype($json->data)=="array") {
                        $data__=$json->data[0];
                    }
                    $expect=$data__->expect;
                    $opencode=$data__->openCode;
                    $open_time = date('Y-m-d H:i:s', ($data__->openTime)/1000);

                    if ($opencode==null) {
                        $this->log("<br>--opencode--null----\n");
                        return false;
                    }

                    //开奖号码转为数组
                    $array_opencode=explode(",", $opencode);
                    /////////////////////////////////////////////
                    //////////////// 开始 玩法 ///////////////////
                    /////////////////////////////////////////////
                    //定位胆
                    $str1=$opencode;
                    //大小定位  0、1、2、3、4时为“小”
                    $str2=$this->getSize($array_opencode[0], $this->oneMID).","
                     .$this->getSize($array_opencode[1], $this->oneMID).","
                     .$this->getSize($array_opencode[2], $this->oneMID).","
                     .$this->getSize($array_opencode[3], $this->oneMID).","
                     .$this->getSize($array_opencode[4], $this->oneMID);
                    //单双定位
                    $str3=$this->getOddOrEven($array_opencode[0]).","
                     .$this->getOddOrEven($array_opencode[1]).","
                     .$this->getOddOrEven($array_opencode[2]).","
                     .$this->getOddOrEven($array_opencode[3]).","
                     .$this->getOddOrEven($array_opencode[4]);
                 //冠亚和   1-10  和 和值为3-19 
                 $opencode_sum = $array_opencode[0]+$array_opencode[1];
                 $hzdx=$this->getSumSize($opencode_sum, $this->sumMID);//和值大小  小值为3-11
                 $hzds=$this->getOddOrEven($opencode_sum); //和值单双
                 $str4=$hzdx.",".$hzds.",".$hzdx.$hzds;
                 // //和值
                 // $opencode_sum = array_sum($array_opencode);
                 // $hzdx=$this->getSumSize($opencode_sum, 23);//和值大小getSumSize  5位数，0~9，和值为0~45，小值为0-22
                 // $hzds=$this->getOddOrEven($opencode_sum); //和值单双
                 // $str4=$hzdx.",".$hzds.",".$hzdx.$hzds;
                 // //龙虎和  以开奖结果的万位和个位作为基准，取万为龙，个为虎的数字进行大小比对的一种玩法
                 // $str5=$this->getDragonOrTiger($array_opencode[0], $array_opencode[4]);
                 // //五星定胆
                 // $str6=implode("||", $array_opencode);
                 // //组三
                 // $str7=$this->getABB($array_opencode[0], $array_opencode[1], $array_opencode[2]).","
                 //     .$this->getABB($array_opencode[1], $array_opencode[2], $array_opencode[3]).","
                 //     .$this->getABB($array_opencode[2], $array_opencode[3], $array_opencode[4]);
                 // //组六
                 // $str8=$this->getABC($array_opencode[0], $array_opencode[1], $array_opencode[2]).","
                 //     .$this->getABC($array_opencode[1], $array_opencode[2], $array_opencode[3]).","
                 //     .$this->getABC($array_opencode[2], $array_opencode[3], $array_opencode[4]);
 
                 $opencode = $str1."|||".$str2."|||".$str3."|||".$str4;
 
                    /////////////////////////////////////////////
                    //////////////// 结束 玩法 ///////////////////
                    /////////////////////////////////////////////

                    $json_new=(object)array("data"=>array((object)array("expect"=>$expect,"opencode"=>$opencode,"opentime"=>$open_time)));
                    $json=$json_new;
                    $result=json_encode($json);
         
                    $expect=$json->data[0]->expect;
                    $file_name=$expect;
                    $str=$result;
      

                    $openDate=strtotime(substr($expect, 0, 8)."000001");
                    $today=strtotime(date("Y-m-d")." 00:00:00");
                    //{"data":[{"expect":"20190710170","opencode":"07,01,04,10,05,06,08,09,02,03","opentime":"2019-07-11 03:14:40"}]}
                    // 开奖  13：09-00:00-次日04：04
    
                    if ($this->nowTime>$this->jsTime && $openDate<$today) {//开奖结束之后，不再写入昨天的开奖
                        return false;
                    }

                    // $t=$json->data[0]->opentime;
                    // $opentime=strtotime($t);
                    // $today=date("Y-m-d")." 00:00:00";
                    // $today=strtotime($today);
    
                    // if ($this->nowTime>$this->kjTime && $opentime<$today) {//9点之后，不再写入昨天的开奖
                    //     return false;
                    // }
                    return $this->add($file_name, $str);
                } else {
                    var_dump($json);
                    return false;
                }
            }
        } else {
            $this->log("<br> --json==null--- result=".$result." -------\n");
        };
    }


    //get 方式
    public function getHtml()
    {
        $url=$this->api;
        //$html=file_get_contents($So360);
        // $useragent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.89 Safari/537.36';
        $timeout= 120;
        $dir            = dirname(__FILE__);
        $cookie_file    = $dir . '/cookie_file_getHTML.txt';
        $refer_url_array = [
        'ezun88'  => $this->referURL
        ];
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
        'Host:'.$this->Host,
        'Connection:keep-alive',
        'Cookie:'.$this->getCookie()
    );    //����ip
    $useragent=$agent_array[array_rand($agent_array, 1)];//��������
    $referurl = $refer_url_array[array_rand($refer_url_array, 1)];  //�����Դ��ַreferurl

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

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        curl_setopt($ch, CURLOPT_REFERER, $referurl);

        // 关闭SSL验证
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
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
        return $html;
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
            $this->log("<br>--getCookie:  no old add temp_cookie--\n");
        } else {
            $this->cookieStr=$contents;
            $this->log("<br>--getCookie:  had old SESSION_cookie--\n");
        }
        
        return  $this->cookieStr;
    }

    
    

    public function array_is_same($arr)
    {
        $l=count($arr);
        for ($i = 1; $i < $l; $i++) {
            if ($arr[$i] !== $arr[0]) {
                return false;
            }
        }
    
        return true;
    }
    public function getSize($n, $mid)
    {
        if ($n<$mid) {
            return "小";
        } else {
            return "大";
        }
    }
    public function getSumSize($sum, $mid)
    {
        if ($sum<$mid) {
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
    public function getDragonOrTiger($dragon, $tiger)
    {
        if ($dragon>$tiger) {
            return "龙";
        } elseif ($dragon<$tiger) {
            return "虎";
        } else {
            return "和";
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
        $this->log("<br>--try to add the result--\n");


        $mk_dir=dirname(__FILE__)."/txt-kj";
  
    
        $mk_day=date("Ymd");


        //{"data":[{"expect":"20190710170","opencode":"07,01,04,10,05,06,08,09,02,03","opentime":"2019-07-11 03:14:40"}]}
        // 开奖  13：09-00:00-次日04：04

        //   if ($this->nowTime>$this->jsTime && $openDate<$today) {//开奖结束之后，不再写入昨天的开奖
        //     return false;
        // }

        if ($this->nowTime < $this->kjTime) {
            $this->log("<br>--".date('Y-m-d H:i:s', $this->nowTime)."<".date('Y-m-d H:i:s', $this->kjTime)." todo -1 day--\n");


            $mk_day=date("Ymd", strtotime("-1 day"));
        }

        //$file_name=date("Ymd");

        $file_type="txt";
        

        $path=$mk_dir."/".$mk_day."/".$file_name.".".$file_type;

        $this->log("<br>--".$path."--\n");

        if (!file_exists($mk_dir)) {
            mkdir($mk_dir);
        }

        if (!file_exists($mk_dir."/".$mk_day)) {
            mkdir($mk_dir."/".$mk_day);
        }


        if (!file_exists($path)) {

       // $str = $file_name;

            file_put_contents($path, $str);

            $this->log("<br>-- ****** create succse ****** --\n");
            return true;
        } else {
            $this->log("<br>--create false--\n");

            return false;
        }
    }
    public function log($str)
    {
        echo $str;
        $mk_dir=dirname(dirname(__FILE__))."/__________log__________";
        if (!file_exists($mk_dir)) {
            mkdir($mk_dir);
        }
        $mk_dir.="/".substr(explode('.', basename(__FILE__))[0],4,-3);
        if (!file_exists($mk_dir)) {
            mkdir($mk_dir);
        }
        $path=$mk_dir."/".date("Ymd").".txt";
        $str=date('Y-m-d H:i:s')."__".$str.PHP_EOL;
        file_put_contents($path, $str, FILE_APPEND);
    }
}


new vrsxffc();
