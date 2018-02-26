<?php
//如果需要设置允许所有域名发起的跨域请求，可以使用通配符 *
header("Access-Control-Allow-Origin: *");
include("../lib/config.php");
include("../lib/uppics.php");
$dotype=explode("/",$_SERVER["REQUEST_URI"])[3]; //接口路径
switch ($dotype) {
case "add":
$res= kselect('user','["uid","nickname"]','{}',$database);
echo json_encode($res);
break;//结束




case "smslogin":
if(!preg_match("/^1[34578]{1}\d{9}$/",$REC["phone"])){exit('{"success": false,"info":"手机号格式不正确哟!"}');}
if (empty($REC["code"])) {exit('{"success": false,"info":"请填写验证码!"}');}

$code = kselect('sms','["id","phone","code"]','{"phone":"'.$REC["phone"].'","chktime":"0","ORDER":{"sendtime":"DESC"}}',$database)["data"][0];
if ($REC["code"]!=$code["code"]) {exit('{"success": false,"info":"验证码不正确!"}');}
//kupdate('sms', '{"id":"'.$code["id"].'"}','{"chktime":"'.time().'"}',$database);



$sub=post_data(["phone"]);//取指定的post值
$user = kselect('user','["uid","openid","nickname","sex","headimgurl","phone"]','{"phone":"'.$REC["phone"].'"}',$database);
if($user["total"]<1){
$sub["regtime"]=time();
$tmp=kadd('user',json_encode($sub),$database);

$uid=$tmp["last_id"];
kadd('bill','{"uid":"'.$uid.'","cost":300,"paytime":'.time().',"state":1,"source":9}',$database);//9手机新用户(phone)注册活动

$user = kselect('user','["uid","openid","nickname","sex","headimgurl","phone"]','{"phone":"'.$REC["phone"].'"}',$database);
}else{
$sub["logintime"]=time();
kupdate('user', '{"phone":"'.$REC["phone"].'"}',json_encode($sub),$database);
}
$res= $user["data"][0];

$res["success"]=true;
$res["info"]="登录成功";

$res["token"]=authcode('{"uid":"'.$res["uid"].'","extime":"'.strtotime(date('Y-m-t')).'"}');

kupdate('user', '{"uid":"'.$res["uid"].'"}','{"token":"'.$res["token"].'"}',$database);

if(empty($res["phone"])){$res["isphone"]=false;}else{$res["isphone"]=true;}
echo json_encode($res);


break;//结束






case "wxlogin":
if (empty($REC["openid"])) {exit('{"success": false,"info":"参数错误!"}');}

$sub=post_data(["openid","nickname","sex","headimgurl","language","country","province","city"]);//取指定的post值
$sub["privilege"]=json_encode($REC["privilege"]);
$user = kselect('user','["uid","openid","nickname","sex","headimgurl","phone"]','{"openid":"'.$sub["openid"].'"}',$database);
if($user["total"]<1){
$sub["regtime"]=time();
$tmp=kadd('user',json_encode($sub),$database);
$uid=$tmp["last_id"];
kadd('bill','{"uid":"'.$uid.'","cost":200,"paytime":'.time().',"state":1,"source":9}',$database);//9新用户(wx)注册活动


$user = kselect('user','["uid","openid","nickname","sex","headimgurl","phone"]','{"openid":"'.$sub["openid"].'"}',$database);
}else{
$sub["logintime"]=time();
kupdate('user', '{"openid":"'.$sub["openid"].'"}',json_encode($sub),$database);
}
$res= $user["data"][0];
$res["token"]=authcode('{"uid":"'.$res["uid"].'","extime":"'.strtotime(date('Y-m-t')).'"}');

kupdate('user', '{"uid":"'.$res["uid"].'"}','{"token":"'.$res["token"].'"}',$database);

if(empty($res["phone"])){$res["isphone"]=false;}else{$res["isphone"]=true;}
echo json_encode($res);


break;//结束












case "bphone":
$uid=check_token($token,$database)["uid"];
$sub=post_data(["phone"]);//取指定的post值
$sub["uid"]=$uid;


//$sub["time"]=time();

if(!preg_match("/^1[34578]{1}\d{9}$/",$REC["phone"])){exit('{"success": false,"info":"手机号格式不正确哟!"}');}
if (empty($REC["code"])) {exit('{"success": false,"info":"请填写验证码!"}');}


$code = kselect('sms','["id","phone","code"]','{"phone":"'.$REC["phone"].'","chktime":"0","ORDER":{"sendtime":"DESC"}}',$database)["data"][0];
if ($REC["code"]!=$code["code"]) {exit('{"success": false,"info":"验证码不正确!"}');}
//kupdate('sms', '{"id":"'.$code["id"].'"}','{"chktime":"'.time().'"}',$database);


if(kselect('user','["phone"]','{"phone":"'.$REC["phone"].'"}',$database)["total"]>0){
exit('{"success": false,"info":"该手机号已注册,请用短信登录!"}');
}

kadd('bill','{"uid":"'.$uid.'","cost":200,"paytime":'.time().',"state":1,"source":9}',$database);//9新用户(wx)注册活动


kupdate('user', '{"uid":"'.$uid.'"}','{"phone":"'.$REC["phone"].'"}',$database);//执行绑定

$user = kselect('user','["uid","nickname","sex","headimgurl","phone"]','{"uid":"'.$uid.'"}',$database);
$res= $user["data"][0];
$res["success"]=true;
$res["phone"]=$REC["phone"];
$res["info"]="绑定成功!";
$res["isphone"]=true;


$res["token"]=authcode('{"uid":"'.$uid.'","extime":"'.strtotime(date('Y-m-t')).'"}');

kupdate('user', '{"uid":"'.$res["uid"].'"}','{"token":"'.$res["token"].'"}',$database);

echo json_encode($res);

break;//结束


case "user_face":
$uid= check_token($token)["uid"];
if (!empty($_FILES)){
$upload_path = "upload/face/";
$uploadfile_name = $uid;

//$uploadfile_name = time().strval(rand('1000','9999')); 
//$uploadfile_name = "123"; 

$i=0;
foreach ($_FILES as $k=>$v){
$pics[$i++] = upimg($k,$upload_path,$uploadfile_name."_".$i);
}
}else{
exit('{"success": false,"info":"请选择要上传的图片!"}');
}
//echo json_encode($pics);
kupdate('user','{"uid":"'.$uid.'"}','{"face":"'.$pics[0].'"}',$database);//存
$res= kselect('user','["uid","nickname","phone","face"]','{"uid":"'.$uid.'"}',$database);
$res["data"][0]["face"]="http://api.chinavcr.com:8080/rest/".$res["data"][0]["face"];


echo json_encode($res);
break;//结束

    
    


default:
exit('{"success": false,"info":"未定义操作!!!！"}');
}
?>
