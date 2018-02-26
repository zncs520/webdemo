<?php 
ini_set('date.timezone','Asia/Shanghai');
error_reporting(E_ERROR);
header("Access-Control-Allow-Origin: *");
include("../../lib/config.php");
$uid=check_token($token,$database)["uid"];
$cost=$_GET["cost"]*100;
require_once "../lib/WxPay.Api.php";
require_once "WxPay.JsApiPay.php";
require_once 'log.php';
$logHandler= new CLogFileHandler("../logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);
//①、获取用户openid
$tools = new JsApiPay();
$openId = $tools->GetOpenid();
//②、统一下单
$input = new WxPayUnifiedOrder();
$input->SetBody("数据查询费(企相)");
$input->SetAttach("数据查询费(企相)");
$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
$input->SetTotal_fee($cost);
//$input->SetTotal_fee("1");
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag("test");
$input->SetNotify_url("https://api.namenb.com/app/wx/pay/notify.php");
$input->SetTrade_type("JSAPI");
$input->SetOpenid($openId);
$order = WxPayApi::unifiedOrder($input);
$jsApiParameters = $tools->GetJsApiParameters($order);
//获取共享收货地址js函数参数
$editAddress = $tools->GetEditAddressParameters();
//③、在支持成功回调通知中处理成功之后的事宜，见 notify.php
?>

<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/> 
<title>微信支付</title>
<script src="js/layer_mobile/layer.js"></script>
<script src="js/httpx.min.js"></script>
<script type="text/javascript">
//调用微信JS api 支付
function jsApiCall(){
WeixinJSBridge.invoke(
'getBrandWCPayRequest',
<?php echo $jsApiParameters; ?>,
function(res){
WeixinJSBridge.log(res.err_msg);
switch(res.err_msg) {
case 'get_brand_wcpay_request:cancel':
alert('用户取消支付！');
location.href = "/nb/?type=ucenter";
break;
case 'get_brand_wcpay_request:fail':
alert('支付失败！（'+res.err_desc+'）');
location.href = "/nb/?type=ucenter";
break;
case 'get_brand_wcpay_request:ok':




httpx.post("https://api.namenb.com/app/bill/pay/",{"token":"<?php echo $token ?>","cost":"<?php echo $cost ?>","state":1,"detail":<?php echo json_encode(json_encode($order)) ?>}, function(res) {


layer.open({content: JSON.parse(res).info,skin: 'msg',time: 2});
if(JSON.parse(res)["success"]){
alert('支付成功！');
location.href = "/nb/?type=ucenter";
}

});








break;
default:
alert(JSON.stringify(res));
location.href = "/nb/?type=ucenter";
break;
}
}
);
}

function callpay()
{
if (typeof WeixinJSBridge == "undefined"){
if( document.addEventListener ){
document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
}else if (document.attachEvent){
document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
}
}else{
jsApiCall();
}
}
</script>
</head>
<body>
<script>
layer.open({type: 2,shadeClose: false,content:"微信支付加载中..."});
callpay();
</script>
</body>
</html>