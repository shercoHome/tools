<?php

class SiteDomain {
    /**
     * @description Make HTTP-GET call
     * @param       $url
     * @param       array $params
     * @return      HTTP-Response body or an empty string if the request fails or is empty
     */
    public static function Baidu($url) {
        $baidu="http://www.baidu.com/s?wd=site:".$url;
        $html=file_get_contents($baidu);
        
        $coding = mb_detect_encoding($html);
        if ($coding != "UTF-8" || !mb_check_encoding($html, "UTF-8"))
        $html = mb_convert_encoding($html, 'utf-8', 'GBK,UTF-8,ASCII');
        
        $patternt = '|该网站共有.*个网页被百度收录|isU';
        $patternt2='|找到相关结果数约.*个|isU';
        //找到相关结果数约5个
        preg_match_all($patternt, $html, $matchest);
        
        preg_match_all($patternt2, $html, $matchest2);
            
        $baiduTitle="Null";
        $patternt3='|<h3 class="t">.*</h3>|isU';
        preg_match_all($patternt3, $html, $matchest3);
        if(count($matchest3[0])>0){
            $baiduTitle="";
            $pa='|<a .*</a>|isU';
            foreach ( $matchest3[0] as $h3) {
                preg_match_all($pa, $h3, $matchest_a);
                $baiduTitle.="<br>".$matchest_a[0][0];
            }

        }

        if(count($matchest[0])>0){
        
            $html = $matchest[0][0];
        
            $patternt = '|<b.*</b>|isU';
            preg_match_all($patternt, $html, $matchest);
            
            $html = $matchest[0][0];
            $html = substr($html,22);
            $html = substr($html,0,-4);
        
        }else if(count($matchest2[0])>0){
        
            $html = $matchest2[0][0];
            $html = substr($html,24);
            $html = substr($html,0,-3);
        
        }else{
            $html = "0";
        }
            

        
        
        return $html."|@|".$baiduTitle;
        

    }

    public static function So360($url) {
        $So360="http://www.so.com/s?q=site:".$url;
        //$html=file_get_contents($So360);
        $useragent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.89 Safari/537.36';
        $timeout= 120;
        $dir            = dirname(__FILE__);
        $cookie_file    = $dir . '/cookies/' . md5($_SERVER['REMOTE_ADDR']) . '.txt';
        
        $ch = curl_init($So360);
        curl_setopt($ch, CURLOPT_FAILONERROR, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
        curl_setopt($ch, CURLOPT_ENCODING, "" );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_AUTOREFERER, true );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout );
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout );
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10 );
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        curl_setopt($ch, CURLOPT_REFERER, 'http://www.google.com/');
        $html = curl_exec($ch);
        if(curl_errno($ch))
        {
            echo 'error:' . curl_error($ch);
        }
     
        curl_close($ch);
      
        $coding = mb_detect_encoding($html);
        if ($coding != "UTF-8" || !mb_check_encoding($html, "UTF-8"))
        $html = mb_convert_encoding($html, 'utf-8', 'GBK,UTF-8,ASCII');
        
        $patternt = '|该网站约.*个网页被360搜索收录|isU';
        $patternt2='|找到相关结果约.*个|isU';
        $patternt3 = '|<p class="info">备案号：.*</p>|isU';
        //备案号：京ICP证030173号
        //<p class="info">备案号：无</p>
        //<p class="info">备案号：京ICP证030173号</p>
        //该网站约20个网页被360搜索收录
        //找到相关结果约1个
        //抱歉，未找到和 相关的网页。
        preg_match_all($patternt, $html, $matchest);
        
        preg_match_all($patternt2, $html, $matchest2);

        preg_match_all($patternt3, $html, $matchest3);
        
        $beian="無";
        if(count($matchest3[0])>0){
            $beian = $matchest3[0][0];
            $beian = substr($beian,28);
            $beian = substr($beian,0,-4);

        }
        if(count($matchest[0])>0){
        
            $html = $matchest[0][0];
    
            $html = substr($html,12);
            $html = substr($html,0,-27);
        
        }else if(count($matchest2[0])>0){
        
            $html = $matchest2[0][0];
            $html = substr($html,21);
            $html = substr($html,0,-3);
        
        }else{
            $html = "0";
        }
        
        
        
        return $html."|+|".$beian;
        

    }
    
}




?>