<?php
// 获取QQ头像 昵称 https://xx.xx?qq=
header("Content-Type:application/json");
error_reporting(E_ALL^E_NOTICE^E_WARNING);

// 获取QQ号
$qq = $_GET["qq"];

// 过滤
if (trim(empty($qq))) {
    echo json_encode(array('msg' => 'null'),true);
}else{
    // 获取QQ用户信息
    $urlPre='https://users.qzone.qq.com/fcg-bin/cgi_get_portrait.fcg?uins=';
    $data=file_get_contents($urlPre.$qq);
    $data=iconv("GB2312","UTF-8",$data);
    $pattern = '/portraitCallBack\((.*)\)/is';
    preg_match($pattern,$data,$result);
    $result=$result[1];
    $qqname = json_decode($result, true)["$qq"][6];
    $qqavatar = "http://q1.qlogo.cn/g?b=qq&nk=".$qq."&s=100";

    // 开始判断这个QQ号是不是有真实用户信息返回
    if ($qqname) {
        // 如果有，就可以返回JSON数据
        echo json_encode(array('code' => '200','name' => $qqname,'avatar' => $qqavatar),true);
    }else{
        //如果没有，那么只能返回获取失败
        echo json_encode(array('msg' => 'error'),true);
    }
}
?>