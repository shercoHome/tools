<?php
  // 爬虫核心功能：获取网页源码
  error_reporting(0);

  $firstOne=2836;
  $endOne=$firstOne-16;

  getUrl($firstOne,$endOne);

  function getUrl($i,$endOne){

    $url ="http://www.dawanghui.com/qiye/".$i.".html";
    $html = file_get_contents($url);
    // 通过 php 的 file_get_contents 函数获取百度首页源码，并传给 $html 变量
    // 通过 preg_replace 函数使页面源码由多行变单行
     $htmlOneLine = preg_replace("/\r|\n|\t/","",$html);
  
  
    // echo $html;
     // 通过 preg_match 函数提取获取页面的标题信息
     //<a href="http://www.sqs.com.cn/" target="_blank" title="汇通科技官网" textvalue="http://www.sqs.com.cn/">http://www.sqs.com.cn/</a>
     preg_match('/textvalue=.{0,40}com/',$htmlOneLine,$titleArr);
  
     // 由于 preg_match 函数的结果是数组的形式
     $title = $titleArr[0];

       // 通过 echo 函数输出标题信息
     echo $title;
     echo "<br>";
     $i--;
     if($i>$endOne){
        getUrl($i,$endOne);
     }
  }


 
?>