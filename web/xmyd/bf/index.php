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

<?php
error_reporting(0);//抑制所有错误
/**
 *  小米运动刷步
 *  Daen QQ1330166565
 *  2021年12月23日22:28:30
 */
 
 
$do = $_GET["do"];
if($do == 'shuabu'){
	echo shuabu($_GET['user'],$_GET['pass'],$_GET['count']);
	return;
}


function shuabu($user,$pass,$count){
	if($count>99999){$json = array("status"=>0,"msg"=>'步数最大限制为99999',);return json_encode($json);}
	if($user==''){$json = array("status"=>0,"msg"=>'小米运动账号不能为空',);return json_encode($json);}
	if($pass==''){$json = array("status"=>0,"msg"=>'小米运动密码不能为空',);return json_encode($json);}
	if($count==''){$json = array("status"=>0,"msg"=>'小米运动步数不能为空',);return json_encode($json);}
	$access = login($user,$pass);
	if($access == ''){
		$json = array(
			"status"=>0,
			"msg"=>'小米运动账号或者密码错误',
		);
		return json_encode($json);
	}
	$user_json = get_user($access);
	$user_id = get_user_id($user_json);
	$app_token = get_app_token($user_json);
	$return = json_decode(load($user_id,$app_token,$count),true);
	if($return['code']=='1'){
		$json = array(
			"status"=>1,
			"msg"=>'success',
			"author"=>'Daen',
			"qq"=>'1511942692'
		);
	}else{
		$json = array(
			"status"=>0,
			"msg"=>$json['message'],
			"author"=>'Daen',
			"qq"=>'1511942692'
		);
	}
	return json_encode($json);
}	
function login($user,$pass){//登录,成功返回access，失败返回空
	$data_url = 'https://api-user.huami.com/registrations/+86'.$user.'/tokens';
	$post_data = array(
		"client_id" => "HuaMi",
		"country_code" => "CN",
		"password" => $pass,
		"redirect_uri" => "https%3A//s3-us-west-2.amazonaws.com/hm-registration/successsignin.html",
		"state" => "REDIRECTION",
		"token" => "access"
	);
	$return = curl_sport($data_url,$post_data,1);
	if(strexists($return,'access')){
		return GetBetween($return,'access=','&');
	}else{
		return '';
	}
}
function get_user($access){//获取用户信息，json类型
	$data_url = 'https://account.huami.com/v2/client/login';
	$post_data="allow_registration=false&app_name=com.xiaomi.hm.health&app_version=4.1.0&code=".$access."&country_code=CN&device_id=device_id_type=uuid&device_model=phone&dn=api-user.huami.com%2Capi-mifit.huami.com%2Capp-analytics.huami.com&grant_type=access_token&lang=zh_CN&os_version=1.5.0&source=com.xiaomi.hm.health&third_name=huami_phone";
	$return = curl_sport($data_url,$post_data,0);
	return $return;		
}
function load($user_id,$app_token,$count){//提交步数
	$data_url = 'https://api-mifit-cn.huami.com/v1/data/band_data.json';
	//$last_deviceid = 'FC30D8FFFE3E028A';
	$last_deviceid = 'DA932FFFFE8816E7';
	$data = 'data_json=[{"summary":"{\"stp\":{\"runCal\":7,\"cal\":111,\"conAct\":0,\"stage\":[],\"ttl\":【步数】,\"dis\":3102,\"rn\":2,\"wk\":43,\"runDist\":146,\"ncal\":0},\"v\":5,\"goal\":2000}","data":[{"stop":1439,"value":"","did":"【last_deviceid】","tz":32,"src":24,"start":0}],"data_hr":"","summary_hr":"{\"ct\":0,\"id\":[]}","date":"【今日日期】"}]&device_type=0&enableMultiDevice=1&last_deviceid=【last_deviceid】&last_source=24&last_sync_data_time=【10位时间戳】&userid=【用户ID】&uuid=';
	$post_data=str_replace('【步数】',$count,$data);
	$post_data=str_replace('【last_deviceid】',$last_deviceid,$post_data);
	$post_data=str_replace('【用户ID】',$user_id,$post_data);
	$post_data=str_replace('【今日日期】',date("Y-m-d",time()),$post_data);
	$post_data=str_replace('【10位时间戳】',time(),$post_data);
	$post_data=str_replace('【初始10位时间戳】',strtotime(date("Y-m-d",time())),$post_data);
	$return = curl_sport($data_url,$post_data,0,$app_token);
	return $return;		
}
function get_user_id($user_json){//解析user_json，获取user_id
	$json = json_decode($user_json,true);
	return $json['token_info']['user_id'];		
}
function get_app_token($user_json){//解析user_json，获取app_token
	$json = json_decode($user_json,true);
	return $json['token_info']['app_token'];		
}
//取出文本中间文本
function GetBetween($content,$start,$end){
	$r = explode($start, $content);
	if (isset($r[1])){
		$r = explode($end, $r[1]);
		return $r[0];
	}
	return '';
}
//此应用专用curl，返回response_header
function curl_sport($url,$post=0,$type=0,$request=''){//GET\POST网络请求
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);	
	if($post){
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
	}
	if($request!=''){
		$httpheader[] = "apptoken:".$request;
		curl_setopt($ch, CURLOPT_HTTPHEADER, $httpheader);
	}
	//返回 response_header, 该选项非常重要,如果不为 true, 只会获得响应的正文
	curl_setopt($ch, CURLOPT_HEADER, $type);
	curl_setopt($ch, CURLINFO_HEADER_OUT, true);
	curl_setopt($ch, CURLOPT_AUTOREFERER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	$ret = curl_exec($ch);
	curl_close($ch);
	return $ret;
}

function strexists($string, $find) {//取字符串中是否包含指定字符串
	return !(strpos($string, $find) === FALSE);
}

?>
