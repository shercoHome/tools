<?php
echo '<meta http-equiv="content-type" content="text/html;charset=utf-8">';
$first = "网络时时彩骗局揭秘";
$second = "网络时时彩骗局揭秘_视频大全_高清在线观看";

$fl=mb_strlen($first);

$sl=similar_text($first, $second);
echo "<br>出现程度".($sl/$fl*100)."%";


echo "<br>出现次数=";


echo "<br>编辑距离=";
echo levenshtein ( $first , $second );

echo "<br>test=";
echo similar_text('王业楼的个人博客', '王业楼')/3;

echo "<br>林宝=";
echo similar_text("吉林禽人业公司灾","吉林宝源丰禽业公司火灾已致112人遇难",$p); 
echo "<br>p=";
echo $p;
?>