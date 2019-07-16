<?php
date_default_timezone_set("Asia/Chongqing");
$origin = isset($_SERVER['HTTP_ORIGIN'])? $_SERVER['HTTP_ORIGIN'] : '';
$allow_origin = array(
    'http://localhost:8080',
    'http://192.168.0.117:8080',
    'http://192.168.0.117:8081',
    'http://www.beer668.cn',
    'http://duke.com:8080',
    'http://duke.com:8081',
    'http://www.ezun666.cn',
    'http://plan.dachengplan.com',
    'http://apiforadmin.dachengplan.com',
    'http://apiforplan.dachengplan.com',
    'http://admin.dachengplan.com'
);
$file_path=dirname(__FILE__).'/class.websetting.php';
try {
    if (file_exists($file_path)) {

        require_once $file_path;
        $DBwebsetting=new websetting();
        $webInfo=array('onleySiteLink'=>'onleySiteLink');
        $arLink=$DBwebsetting->show($webInfo);

        for ($i=0;$i<count($arLink);$i++) {
            array_push($allow_origin, "http://".$arLink[$i]["siteLink"].":8080");
            array_push($allow_origin, "http://".$arLink[$i]["siteLink"]);
        }

    } else {
       // throw new Exception('allow_origin: websetting file is not exists');
    }
} catch (Exception $e) {
  //  echo $e->getMessage();
}
if (in_array($origin, $allow_origin)) {
    header('Access-Control-Allow-Origin:'.$origin);
}
