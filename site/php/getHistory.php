<?php


$r="-1";

require_once 'HTTPRequester.php';
require_once 'SiteDomain.php';
require_once 'GetTitle.php';

 if(is_array($_GET)&&count($_GET)>0){

    if (isset($_GET["d"])) {

        if(strlen($_GET["d"])>0){

            $url=$_GET["d"];
            $url=trim($url);


            $history="-";//查询失败
            if (isset($_GET["h"])&&$_GET["h"]=="1") {
                $array = array(
                    "url" => $url,
                    "collection" => "web",
                    "output" => "json"
                );
                $tool=new HTTPRequester();
                $history=$tool->HTTPGet("http://web.archive.org/__wb/sparkline",$array);

            }

            $SiteDomain=new SiteDomain();
            $SiteBaidu="-";//查询失败
            if (isset($_GET["b"])&&$_GET["b"]=="1") {
                $SiteBaidu=$SiteDomain->Baidu($url);
            }
            $SiteSo360="-|+|-";//查询失败
            if (isset($_GET["s"])&&$_GET["s"]=="1") {
                $SiteSo360=$SiteDomain->So360($url);
            }

            $GetTitle=new GetTitle();
            $TitleDefault="-";//查询失败
            if (isset($_GET["td"])&&$_GET["td"]=="1") {
                $TitleDefault=$GetTitle->Natural($url);
            }
            $TitleSpider="-";//查询失败
            if (isset($_GET["ts"])&&$_GET["ts"]=="1") {
                $TitleSpider=$GetTitle->Spider($url);
            }

            $r=$history."|+|".$SiteBaidu."|+|".$SiteSo360."|+|".$TitleDefault."|+|".$TitleSpider;
        }
    }
}

echo $r;
?>
