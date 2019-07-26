<?php

class GetTitle {
    /**
     * @description Make HTTP-GET call
     * @param       $url
     * @param       array $params
     * @return      HTTP-Response body or an empty string if the request fails or is empty
     */
    public static function Natural($url) {
        $url="http://".$url;
        $defaultAgent= 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.89 Safari/537.36';
        $baiduSpider="Mozilla/5.0 (compatible; Baiduspider/2.0; +http://www.baidu.com/search/spider.html)";

        $useragent =$defaultAgent;

        $timeout= 120;
        $dir            = dirname(__FILE__);
        $cookie_file    = $dir . '/cookies/' . md5($_SERVER['REMOTE_ADDR']) . '.txt';
        
        $ch = curl_init($url);
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
            return 'error:' . curl_error($ch);
        }
     
        curl_close($ch);
      
        $coding = mb_detect_encoding($html);
        if ($coding != "UTF-8" || !mb_check_encoding($html, "UTF-8"))
        $html = mb_convert_encoding($html, 'utf-8', 'GBK,UTF-8,ASCII');
        
        $patternt = '|<title>.*</title>|isU';
        $patternt2='|<meta name="keywords".*>|isU';
        $patternt3 = '|<meta name="description".*>|isU';

        preg_match_all($patternt, $html, $matchest);
        
        preg_match_all($patternt2, $html, $matchest2);

        preg_match_all($patternt3, $html, $matchest3);


        $html1="";$html2="";$html3="";
        if(count($matchest[0])>0){
        
            $html1 = $matchest[0][0];
    
            $html1 = substr($html1,7);
            $html1 = substr($html1,0,-8);
        
        }
        
        if(count($matchest2[0])>0){
        
            $html2 = $matchest2[0][0];
            $html2 = substr($html2,6);
            $html2 = substr($html2,0,-1);
        
        }
        
        if(count($matchest3[0])>0){
            $html3 = $matchest3[0][0];
            $html3 = substr($html3,6);
            $html3 = substr($html3,0,-1);

        }
        
        
        $html= $html1.'<br>'.$html2.'<br>'.$html3;
        
        
        return $html;
        

    }

    public static function Spider($url) {
        $url="http://".$url;
        $defaultAgent= 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/44.0.2403.89 Safari/537.36';
        $baiduSpider="Mozilla/5.0 (compatible; Baiduspider/2.0; +http://www.baidu.com/search/spider.html)";

        $useragent =$baiduSpider;

        $timeout= 120;
        $dir            = dirname(__FILE__);
        $cookie_file    = $dir . '/cookies/' . md5($_SERVER['REMOTE_ADDR']) . '.txt';
        
        $ch = curl_init($url);
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
            return 'error:' . curl_error($ch);
        }
     
        curl_close($ch);
      
        $coding = mb_detect_encoding($html);
        if ($coding != "UTF-8" || !mb_check_encoding($html, "UTF-8"))
        $html = mb_convert_encoding($html, 'utf-8', 'GBK,UTF-8,ASCII');
        
        $patternt = '|<title>.*</title>|isU';
        $patternt2='|<meta name="keywords" content=.*>|isU';
        $patternt3 = '|<meta name="description" content=.*>|isU';

        preg_match_all($patternt, $html, $matchest);
        
        preg_match_all($patternt2, $html, $matchest2);

        preg_match_all($patternt3, $html, $matchest3);


        $html1="";$html2="";$html3="";
        if(count($matchest[0])>0){
        
            $html1 = $matchest[0][0];
    
            $html1 = substr($html1,7);
            $html1 = substr($html1,0,-8);
        
        }
        
        if(count($matchest2[0])>0){
        
            $html2 = $matchest2[0][0];
            $html2 = substr($html2,6);
            $html2 = substr($html2,0,-1);
        
        }
        
        if(count($matchest3[0])>0){
            $html3 = $matchest3[0][0];
            $html3 = substr($html3,6);
            $html3 = substr($html3,0,-1);

        }
        
        
        $html= $html1.'<br>'.$html2.'<br>'.$html3;
        
        
        return $html;

    }
    
}




?>