<?php
date_default_timezone_set("Asia/Chongqing");


class ip
{
    private $file;
    private $indexPage;
    private $ipWhite;
    private $ip;

    private $ipMarkFIle;
    private $ipMark;

    public function __construct()
    {
        // require 'sql.php';
        //把中国的ip缓存，下次不再访问 淘宝IP库
        $this->ipMarkFIle =  'txt/ipMark.txt';//先读取文件
        if (!file_exists($this->ipMarkFIle)) {
            file_put_contents($this->ipMarkFIle, '');
        }
        $ipMarkArray= file($this->ipMarkFIle);
        foreach ($ipMarkArray as $key => $value) {
            $ipMarkArray[$key] = trim($value); //去掉用户内容后面的空格.
        }
        $this->ipMark =$ipMarkArray;


        $this->file =  'txt/ipWhite.txt';//先读取文件
        $txtArray= file($this->file);
        foreach ($txtArray as $key => $value) {
            $txtArray[$key] = trim($value); //去掉用户内容后面的空格.
        }
        
        array_shift($txtArray);
         
        $this->indexPage=array_shift($txtArray);

        if (empty($this->index)) {
            $this->index="index.html";
        }
  
        $this->ipWhite =$txtArray;

        $this->ip=$this->get();

       // $this->ip="113.117.213.241";


        $this->api = 'http://ip.taobao.com/service/getIpInfo.php?ip='.$this->ip;
    }

    public function get()
    {
        if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) {
            $ip = getenv("HTTP_CLIENT_IP");
        } elseif (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) {
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        } elseif (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) {
            $ip = getenv("REMOTE_ADDR");
        } elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } else {
            $ip = "unknown";
        }

        if ($ip=="::1") {
            $ip = "local";
        }
        return $ip;
    }
    public function check()
    {
        if ($this->checkWhite()) {
      //      var_dump("__white__");
            return true;
        };
        if ($this->checkMark()) {
       //     var_dump("__mark__");
            return true;
        };
        return $this->checkCN();
    }
    public function checkWhite()
    {
     //   echo "<br>checkWhite<br>";
     //   var_dump($this->ipWhite);
        if (in_array($this->ip, $this->ipWhite)) {
        //    echo "<br>true<br>";
            return true;
        } else {
        //    echo "<br>false<br>";
            return false;
        }
    }
    public function checkMark()
    {
      //  echo "<br>checkMark<br>";
      //  var_dump($this->ipMark);
        if (in_array($this->ip, $this->ipMark)) {
       //     echo "<br>true<br>";
            return true;
        } else {
        //    echo "<br>false<br>";
            return false;
        }
    }
    public function checkCN()
    {
        $content =$this->getHtml();// file_get_contents('http://ip.taobao.com/service/getIpInfo.php?ip='.$this->ip);
        $banned = json_decode(trim($content), true);
        $lan = strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']);
      //  var_dump($content);
       // var_dump($banned);

        //error:The requested URL returned error: 502 Bad Gateway
        //NULL
        if (!empty($banned['code']) && $banned['code']=="1") {

           // var_dump ("xxxxxxxxxxx  false xxxxxxxxxxx");

            return true;
        }
        if ($banned==null) {

            //var_dump ("xxxxxxxxxxx  NULL xxxxxxxxxxx");
            return true;
        }
        if (!empty($banned['data']['country_id']) && $banned['data']['country_id'] == 'CN') {//|| strstr($lan, 'zh')

            //把中国的ip缓存，下次不再访问 淘宝IP库
            file_put_contents($this->ipMarkFIle, $this->ip."\r\n", FILE_APPEND);


            return true;
        } else {
            return false;
        }
    }

    public function __go()
    {
        require $this->indexPage;
    }
    public function __stop()
    {
        header('HTTP/1.0 404 Not Found');
        echo 'HTTP / '.$this->ip.' 404 Not Found.';
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
        'Connection:keep-alive'
    );    //����ip
    $useragent=$agent_array[array_rand($agent_array, 1)];//��������

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

        // 关闭SSL验证
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $html = curl_exec($ch);
        if (curl_errno($ch)) {
            return 'error:' . curl_error($ch);
        }


        curl_close($ch);
        return $html;
    }
}


$DBip=new ip();
if ($DBip->check()) {
    $DBip->__go();
} else {
    $DBip->__stop();
}
