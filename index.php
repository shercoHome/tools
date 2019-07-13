<?php
date_default_timezone_set("Asia/Chongqing");


class ip
{
    private $file;
    private $indexPage;
    private $ipWhite;
    private $ip;

    public function __construct()
    {
       // require 'sql.php';
        $this->file =  'ipWhite.txt';//先读取文件
        $txtArray= file($this->file);
        foreach ($txtArray as $key => $value) {
            $txtArray[$key] = trim($value); //去掉用户内容后面的空格.
        }
        
         array_shift($txtArray);
         
        $this->indexPage=array_shift($txtArray);

        if(empty($this->indexPage)){$this->indexPage="index.html";}
  
        $this->ipWhite =$txtArray;

        $this->ip=$this->get();

    }

    public function get(){
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
    public function check(){
        if($this->checkWhite()){
            return true; 
        };
        return !$this->checkCN();//大陆不可访问
    }
    public function checkWhite(){
        if (in_array($this->ip, $this->ipWhite)) {
            return true;
        }else{
            return false;
        }
    }
    public function checkCN()
    {
        $content = file_get_contents('http://ip.taobao.com/service/getIpInfo.php?ip='.$this->ip);
        $banned = json_decode(trim($content), true);
        $lan = strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']);
        if (!empty($banned['data']['country_id']) && $banned['data']['country_id'] == 'CN') {//|| strstr($lan, 'zh')
            return true;
        } else {
            return false;
        }
    }

    public function __go()
    {
	require $this->indexPage;
    }
    public function __stop(){
        header('HTTP/1.0 404 Not Found');
        echo 'HTTP / 1.0 404 Not Found.';
    }
}


$DBip=new ip();
if($DBip->check()){
    $DBip->__go();
}else{
    $DBip->__stop();
}
?>