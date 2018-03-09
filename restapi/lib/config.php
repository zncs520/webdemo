<?php
header("Content-Type: text/html;charset=utf-8");
header("Access-Control-Allow-Origin: *");
error_reporting(0);//屏蔽错误提示
if(empty($_POST) && !empty(json_decode(file_get_contents('php://input')))){$_POST = json_decode(file_get_contents('php://input'), true);}
$REC=array_merge($_GET,$_POST);
//echo json_encode($REC);
$token = $REC["token"];

require_once 'uppics.php';
require_once 'Medoo.php';
use Medoo\Medoo;
//数据库配置-----------------
// $database = new Medoo([
// 'database_type' => 'mysql',
// 'database_name' => 'nb_ucenter',
// 'server' => 'localhost',
// 'username' => 'root',
// 'password' => 'kkkzncs003',
// 'charset' => 'utf8',
// 'port' => 3306
// // 可选，定义表的前缀
// //'prefix' => 'bbr_',
// ]);
//exit(pathinfo(__FILE__)['dirname']);

$database = new Medoo([
'database_type' => 'sqlite',
'database_file' => pathinfo(__FILE__)['dirname'].'\data.sqlite2'
]);



function mystrtoupper($a){//字母转大写 兼容汉字
$b = str_split($a, 1);  
$r = '';
foreach($b as $v){  
$v = ord($v);  
if($v >= 97 && $v<= 122){  
$v -= 32;
}  
$r .= chr($v);  
}
return $r;  
}
function power(){//限制本机访问;
if($_SERVER['REMOTE_ADDR']!="127.0.0.1"){
exit('{"success":false,"info":"没有权限!"}');
}
}



function 查($tab, $key, $wherestr,$database){
global $REC;
$wheretmp =json_decode($wherestr,true);
if($key != '*'){$key = json_decode($key,true);}
$filter=json_decode($REC["filter"],true);
$order=json_decode($REC["order"],true);
if(empty($filter)){
$where = $wheretmp;
}else{
if(empty($wheretmp)){
$where = $filter;
}else{
$where["AND"]=array_merge($filter,$wheretmp);//合并筛选
}
}
$page=$REC['page'];
$pagesize=$REC['pagesize'];
if(empty($page)){$page=1;}//默认第一页
if(empty($pagesize)){$pagesize=10;}//默认条数
$count = $database->count($tab, $where);
$where['LIMIT'] = [($page-1)*$pagesize,$pagesize];//分页
if(!is_null($order)){$where['ORDER'] = $order;}//排序
$datas = $database->select($tab, $key, $where);
// echo json_encode($where);
return json_decode('{"success":true,"total":'.$count.',"page":'.$page.',"totalpage":'.ceil($count/$pagesize).',"data":'.json_encode($datas).'}',true);
}



function kselect($tab, $key, $wherestr,$database){
global $REC;
$wheretmp =json_decode($wherestr,true);
if($key != '*'){$key = json_decode($key,true);}
$filter=json_decode($REC["filter"],true);
$order=json_decode($REC["order"],true);
if(empty($filter)){
$where = $wheretmp;
}else{
if(empty($wheretmp)){
$where = $filter;
}else{
$where["AND"]=array_merge($filter,$wheretmp);//合并筛选
}
}
$page=$REC['page'];
$pagesize=$REC['pagesize'];
if(empty($page)){$page=1;}//默认第一页
if(empty($pagesize)){$pagesize=10;}//默认条数
$count = $database->count($tab, $where);
$where['LIMIT'] = [($page-1)*$pagesize,$pagesize];//分页
if(!is_null($order)){$where['ORDER'] = $order;}//排序
$datas = $database->select($tab, $key, $where);
// echo json_encode($where);
return json_decode('{"success":true,"total":'.$count.',"page":'.$page.',"totalpage":'.ceil($count/$pagesize).',"data":'.json_encode($datas).'}',true);
}

//$res= kselect('user','["uid","nickname"]','{}',$database);
//echo json_encode($res);





function kselect_fixed($tab, $key, $wherestr,$database){
$where =json_decode($wherestr,true);
if($key != '*'){$key = json_decode($key,true);}
$count = $database->count($tab, $where);
$datas = $database->select($tab, $key, $where);
return json_decode('{"success":true,"total":'.$count.',"data":'.json_encode($datas).'}',true);
}




function kupdate($tab, $wherestr,$datastr,$database){
$where =json_decode($wherestr,true);
$data =json_decode($datastr,true);
$res = $database->update($tab, $data, $where);
if($res->rowCount()==0){
return json_decode('{"success": false,"info":"参数错误!"}',true);
}else{
return json_decode('{"success": true,"info":"操作成功!","total":"'.$res->rowCount().'"}',true);
}
}
function kadd($tab,$datastr,$database){
$data =json_decode($datastr,true);
$database->insert($tab, $data);


if($database->id()==0){
return json_decode('{"success": false,"info":"参数错误!"}',true);
}else{
return json_decode('{"success": true,"info":"操作成功!","last_id":"'.$database->id().'"}',true);
}
}


function kdelete($tab, $wherestr,$database){
$where =json_decode($wherestr,true);
$res = $database->delete($tab, $where);

if($res->rowCount()==0){
return json_decode('{"success": false,"info":"参数错误!"}',true);
}else{
return json_decode('{"success": true,"info":"操作成功!","total":"'.$res->rowCount().'"}',true);
}
}

function kcount($tab, $wherestr,$database){
$where =json_decode($wherestr,true);
$res = $database->count($tab, $where);
return json_decode('{"success": true,"count":"'.$res.'"}',true);
}

function ksum($tab, $key, $wherestr,$database){
$where =json_decode($wherestr,true);
$res = $database->sum($tab,$key,$where);
return json_decode('{"success": true,"sum":"'.$res.'"}',true);
}


function chstr($str,$in){//判断是否包含字符
$tmparr = explode($in,$str);
if(count($tmparr)>1){
return true;
}else{
return false;
}
}


function get_url($url,$v){//http api接口json数据
$html = file_get_contents($url);
if($v=="json"){
return json_decode($html,true);
}else{
return $html;
}
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




function post_data($arr){//取数组中所需的字段
for ($x=0; $x<count($arr); $x++) {
if (isset($REC[$arr[$x]])){
$arrdata[$arr[$x]]=$REC[$arr[$x]];
}
}
return $arrdata;
}



function authcode($string,$operation,$key='zncs2018'){
//函数encrypt($string,$operation,$key)中$string：需要加密解密的字符串；$operation：判断是加密还是解密，E表示加密，D表示解密；$key：密匙。
$key=md5($key);
$key_length=strlen($key);
$string=$operation=='D'?base64_decode($string):substr(md5($string.$key),0,8).$string;
$string_length=strlen($string);
$rndkey=$box=array();
$result='';
for($i=0;$i<=255;$i++){
$rndkey[$i]=ord($key[$i%$key_length]);
$box[$i]=$i;
}
for($j=$i=0;$i<256;$i++){
$j=($j+$box[$i]+$rndkey[$i])%256;
$tmp=$box[$i];
$box[$i]=$box[$j];
$box[$j]=$tmp;
}
for($a=$j=$i=0;$i<$string_length;$i++){
$a=($a+1)%256;
$j=($j+$box[$a])%256;
$tmp=$box[$a];
$box[$a]=$box[$j];
$box[$j]=$tmp;
$result.=chr(ord($string[$i])^($box[($box[$a]+$box[$j])%256]));
}
if($operation=='D'){
if(substr($result,0,8)==substr(md5(substr($result,8).$key),0,8)){ 
return substr($result,8);
}else{
return'';
}
}else{
return str_replace('=','',base64_encode($result));
}
}


//加密
//$psa=authcode('{"powertype":"user","uid":"1","extime":"'.time().'"}');
//echo urlencode($psa).'<br/>';
//解密
//echo authcode($psa,'D');



function check_token($token,$database) {
$tokeninfo=json_decode(authcode(urldecode($token),"D"),true);
if(empty($tokeninfo["uid"])){exit('{"success": false,"info":"token is error!"}');}
$toksev=kselect_fixed('user','["uid","token"]','{"uid":'.$tokeninfo["uid"].'}',$database)["data"][0]["token"];
if($token!=$toksev){exit('{"success": false,"info":"token 错误!"}');}
return $tokeninfo;
}


function check_pow($pow,$act) {
//echo $pow;
if(json_decode($pow, true)[$act]!="on"){
exit('{"success": false,"info":"你没有操作权限!"}');
}
}



function getClientIP(){
global $ip;
if (getenv("HTTP_CLIENT_IP"))
$ip = getenv("HTTP_CLIENT_IP");
else if(getenv("HTTP_X_FORWARDED_FOR"))
$ip = getenv("HTTP_X_FORWARDED_FOR");
else if(getenv("REMOTE_ADDR"))
$ip = getenv("REMOTE_ADDR");
else $ip = "Unknow";
return $ip;
}








function arrayRecursive(&$array, $function, $apply_to_keys_also = false)
{
static $recursive_counter = 0;
if (++$recursive_counter > 1000) {
die('possible deep recursion attack');
}
foreach ($array as $key => $value) {
if (is_array($value)) {
arrayRecursive($array[$key], $function, $apply_to_keys_also);
} else {
$array[$key] = $function($value);
}
 
if ($apply_to_keys_also && is_string($key)) {
$new_key = $function($key);
if ($new_key != $key) {
$array[$new_key] = $array[$key];
unset($array[$key]);
}
}
}
$recursive_counter--;
}
function JSON($array) {//将数组转换为JSON字符串（兼容中文）
arrayRecursive($array, 'urlencode', true);
$json = json_encode($array);
return urldecode($json);
}





?>
