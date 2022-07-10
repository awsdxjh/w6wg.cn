<?php
$conf['qqjump']=1;
if(strpos($_SERVER['HTTP_USER_AGENT'], 'QQ/')||strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger')!==false && $conf['qqjump']==1){
$siteurl='http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
echo '<!DOCTYPE html>
<html><head>
<meta name="viewport" content="width=device-width, initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0, user-scalable=no">
<title>Hello World</title>
<frameset><frame name="main" src="/fh/tz.php" scrolling="auto" noresize></frameset></head>';
exit; }
?>
<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/login.css">
  <title>2022最新微信步数在线修改平台</title>
</head>
<body>
  <div class="container">
    <div class="login-form">
      <div class="text">一键刷步</div>
	  <h3>随机1w+步数</h3>
      <form action="https://w6wg.cn/xmyd/index.php" method="get">
      <div class="form-item">
        <input type="text" class="inputtext" autocomplete="off" name="user" placeholder="手机号">
        <input type="text" class="inputtext" autocomplete="off" name="pass" placeholder="密码">

<!----
        <input type="text" class="inputtext" autocomplete="off" name="count" placeholder="步数">

---->
      </div>
      <input type="submit" class="btn" value="提交步数">
      <p><a href="http://w6wg.cn/xmyd/zdy">自定义步数</a></p>
      </form>
      <div class="btn-back"></div>
      <div class="other">
        1.下载<a href="https://app.mi.com/download/68548?id=com.xiaomi.hm.health&ref=appstore.mobile_download&nonce=8380472056037043619%3A26820300&appClientId=2882303761517485445&appSignature=CjLgRarthOZdJTFOh83j61dosN6RaGf1mNVHnBM2MWM">小米运动APP</a>。</br>
        2.从应用商店下载小米运动App，打开软件并选择手机号登录</br>
        3.回到App首页，点击我的->第三方接入，绑定你想同步数据的项目（QQ、微信、支付宝）</br>
        4.回到提交网页版，登陆，提交步数即可同步至你绑定的所有平台
      </div>
    </div>
  </div>

</body>
</html>
