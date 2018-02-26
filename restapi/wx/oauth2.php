<?php
if (isset($_GET['code'])){
$access = get_url('https://api.weixin.qq.com/sns/oauth2/access_token?appid=wxc37b7dd89651117d&secret=a285527bde63e480da67a385573af490&code='.$_GET['code'].'&grant_type=authorization_code',"json");
$access_token = $access["access_token"];
$openid = $access["openid"];
$user = get_url('https://api.weixin.qq.com/sns/userinfo?access_token='.$access_token.'&openid='.$openid.'',"json");
//echo json_encode($user);


post_json('https://api.namenb.com/app/user/wxlogin/', json_encode($user),"json");
}else{
exit("NO CODE");
}








function post_json($url, $data_string,$v) {//post提交json数据
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// 跳过证书检查
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true); // 从证书中检查SSL加密算法是否存在
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Content-Type: application/json;charset=utf-8',
'Content-Length: ' . strlen($data_string))
);
ob_start();
curl_exec($ch);
$html = ob_get_contents();
ob_end_clean();
//$return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//return array($return_code, $html);
if($v=="json"){
return json_decode($html,true);
}else{
return $html;
}
}



function get_url($url,$v){//获取http api接口json数据
$html =file_get_contents($url);
if($v=="json"){
return json_decode($html,true);
}else{
return $html;
}
}
?>

<?php echo $user["nickname"] ?> <br />

<img src="<?php echo $user["headimgurl"] ?>" />