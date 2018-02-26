<?php
//如果需要设置允许所有域名发起的跨域请求，可以使用通配符 *
header("Access-Control-Allow-Origin: *");
include("../lib/config.php");
require_once "SmsSender.php";
require_once  "SmsVoiceSender.php";
use Qcloud\Sms\SmsSingleSender;
use Qcloud\Sms\SmsMultiSender;
use Qcloud\Sms\SmsVoicePromtSender;
use Qcloud\Sms\SmsVoiceVeriryCodeSender;


$dotype=explode("/",$_SERVER["REQUEST_URI"])[3]; //接口路径
switch ($dotype) {
case "sendcode":

if (empty($_GET["phone"])){exit('{"success": false,"info":"请输入手机号!"}');}
if (!preg_match("/^1[34578]{1}\d{9}$/",strval($_GET['phone']))){exit('{"success": false,"info":"手机号格式不正确!"}');}
$phone=strval($_GET['phone']);
$code = strval(rand('1000','9999'));
$appid = 1400048342;
$appkey = "d4805c8e03036f68d4c1472eb7c5ac4a";
$templId = 54675;


    $singleSender = new SmsSingleSender($appid, $appkey);
    $params[0] = $code;
    $result = $singleSender->sendWithParam("86", $phone, $templId, $params, "", "", "");
    $rsp = json_decode($result,true);
   // echo $result;


if($rsp["result"]==0){
echo '{"success": true,"info":"验证码发送成功!","phone":"'.$phone.'","sendtime":'.time().'}';


$sub["phone"]=$phone;
$sub["code"]=$code;
$sub["sendtime"]=time();
kadd('sms',json_encode($sub),$database);





}else{
exit('{"success": false,"info":"验证码发送失败,请稍后再试!"}');
}




break;//结束
default:
echo '{"success": false,"info":"未定义操作!!!！"}';
}