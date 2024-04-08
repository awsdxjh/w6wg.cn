<?php
/* 程序员阿鑫博客 www.cxyax.com */
$config = parse_ini_file('./config.ini');

$url = "https://bbs.binmt.cc/plugin.php?id=k_misign:sign&operation=qiandao&formhash=".$config['formhash']."&format=empty&inajax=1&ajaxtarget=";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIE, $config['cookie']); 
$response = curl_exec($ch);
curl_close($ch);

header('Content-Type: text/xml');
echo $response;
?>
