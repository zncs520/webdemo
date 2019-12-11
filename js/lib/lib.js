function serialize(form) {//表单序列化
var form_arr = {};
for (var i = 0, len = form.elements.length; i < len; i++) {
var input = form.elements[i]
switch (input.type) {
case 'select-one':
case 'select-multiple':
if (input.name.length) { //只取有name的
var options = form.elements[i].options;
for (var j = 0, option_len = options.length; j < option_len; j++) {
var option = options[j];
if (option.selected) {
var option_value = '';
if (option.hasAttribute) {
option_value = option.hasAttribute('value') ? option.value : option.text;
} else {
option_value = option.attributes['value'].specified ? option.value : option.text;
}
//form_arr.push(encodeURIComponent(input.name) + '=' + encodeURIComponent(option_value));
form_arr[input.name]=input.value;
}
}
}
break;
case undefined:
case 'button':
case 'submit':
case 'file':
case 'reset':
break;
case 'checkbox':
case 'radio':
if (!input.checked) { //如果未选中，就break，选中了就执行default
break;
}
default:
if (input.name.length) {
//form_arr.push(encodeURIComponent(input.name) + '=' + encodeURIComponent(input.value));
form_arr[input.name]=input.value;
}
}
}
//return form_arr.join('&');
return form_arr;
}



function msg(v) {
layer.msg(v);
}
function MsgTts(str){//临时语音播报 TTS
httpx.get("http://api.greatorange.cn/box/altts/",{}, function(data) {
var ttsaudio = document.createElement('audio');
ttsaudio.autoplay="autoplay";
ttsaudio.src='https://nls-gateway.cn-shanghai.aliyuncs.com/stream/v1/tts?voice=Amei&appkey=tiFkz04PcrulyOVU&token='+JSON.parse(data)["token"]+'&text='+str+'&format=mp3&sample_rate=16000';
});
}

function checkvalue(value,check) {//必填验证
var res={};
res["success"]=true;
for(key in check){
if (typeof(value[key]) == "undefined" ||  value[key]==""){
//return(key+':'+check[key]);
res["success"]=false;
res["info"]= "请填写"+check[key];
}
}
return res;
}


/*垃圾X判断*/
function isIphoneX(){
	if(/iphone/gi.test(navigator.userAgent) && (screen.height == 812 && screen.width == 375)){
	console.log('垃圾X');
	}
//  return  ;
}

//获取url参数（支持中文）
function getUrlParam(key) {
// 获取参数
var url = window.location.search;
// 正则筛选地址栏
var reg = new RegExp("(^|&)" + key + "=([^&]*)(&|$)");
// 匹配目标参数
var result = url.substr(1).match(reg);
 //返回参数值
return result ? decodeURIComponent(result[2]) : null;
}


//vue解析数组
function vmup(vm, jdata) {
for(var o in jdata) {
Vue.set(vm, o, jdata[o]);
}
}



function add(id) {//加减input数值
var a = document.getElementById(id).value;
a++;
document.getElementById(id).value = a;
}
function sub(id) {
var b = document.getElementById(id).value;
b--;
document.getElementById(id).value = b;
}



function setTab(cursel, total, name) {//标题切换内容
for(i = 1; i <= total; i++) {
var con = document.getElementById(name + "tab_" + i);
console.log(con)
con.style.display = i == cursel ? "block" : "none";
//con.style.display=i==cursel?"block":"none";
}
}




function pushtoken(arr,tokendata) {//跨域推送TOKEN
for(var i= 0;i<arr.length;i++){
document.write('<iframe style="display:none;" src="'+arr[i]+'?udata='+tokendata+'&time='+(new Date()).valueOf()+'"></iframe>');
}
}
function Base64() {
_keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
this.encode = function (input) {
var output = "";
var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
var i = 0;
input = _utf8_encode(input);
while (i < input.length) {
chr1 = input.charCodeAt(i++);
chr2 = input.charCodeAt(i++);
chr3 = input.charCodeAt(i++);
enc1 = chr1 >> 2;
enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
enc4 = chr3 & 63;
if (isNaN(chr2)) {
enc3 = enc4 = 64;
} else if (isNaN(chr3)) {
enc4 = 64;
}
output = output +
_keyStr.charAt(enc1) + _keyStr.charAt(enc2) +
_keyStr.charAt(enc3) + _keyStr.charAt(enc4);
}
return output;
}
this.decode = function (input) {
var output = "";
var chr1, chr2, chr3;
var enc1, enc2, enc3, enc4;
var i = 0;
input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");
while (i < input.length) {
enc1 = _keyStr.indexOf(input.charAt(i++));
enc2 = _keyStr.indexOf(input.charAt(i++));
enc3 = _keyStr.indexOf(input.charAt(i++));
enc4 = _keyStr.indexOf(input.charAt(i++));
chr1 = (enc1 << 2) | (enc2 >> 4);
chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
chr3 = ((enc3 & 3) << 6) | enc4;
output = output + String.fromCharCode(chr1);
if (enc3 != 64) {
output = output + String.fromCharCode(chr2);
}
if (enc4 != 64) {
output = output + String.fromCharCode(chr3);
}
}
output = _utf8_decode(output);
return output;
}
 
// private method for UTF-8 encoding
_utf8_encode = function (string) {
string = string.replace(/\r\n/g,"\n");
var utftext = "";
for (var n = 0; n < string.length; n++) {
var c = string.charCodeAt(n);
if (c < 128) {
utftext += String.fromCharCode(c);
} else if((c > 127) && (c < 2048)) {
utftext += String.fromCharCode((c >> 6) | 192);
utftext += String.fromCharCode((c & 63) | 128);
} else {
utftext += String.fromCharCode((c >> 12) | 224);
utftext += String.fromCharCode(((c >> 6) & 63) | 128);
utftext += String.fromCharCode((c & 63) | 128);
}
}
return utftext;
}
_utf8_decode = function (utftext) {
var string = "";
var i = 0;
var c = c1 = c2 = 0;
while ( i < utftext.length ) {
c = utftext.charCodeAt(i);
if (c < 128) {
string += String.fromCharCode(c);
i++;
} else if((c > 191) && (c < 224)) {
c2 = utftext.charCodeAt(i+1);
string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
i += 2;
} else {
c2 = utftext.charCodeAt(i+1);
c3 = utftext.charCodeAt(i+2);
string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
i += 3;
}
}
return string;
}
}
//var base = new Base64();
//AA=base.encode("我是谁");
//base.decode(AA);




function isJSON(str) {
if (typeof str == 'string') {
try {
var obj=JSON.parse(str);
if(typeof obj == 'object' && obj ){
return true;
}else{
return false;
}

} catch(e) {
console.log('error：'+str+'!!!'+e);
return false;
}
}
console.log('It is not a string!')
}

function EN_JSON(obj) {
return JSON.stringify(obj);
}

function DE_JSON(str) {
if(isJSON(str)){
return JSON.parse(str);
}else{
console.log('非对象格式!');
return false;
}
}


//数组插入下拉菜单
function getArray(str){
return str.split("||");
}

//console.log(getArray("{$Info(9)$}"));
//var seletarr =getArray("{$Info(9)$}");
//var obj = document.getElementById("kechengse");
//for (var i = 0; i < seletarr.length; i++) {
//obj.options.add(new Option(seletarr[i],seletarr[i]));
//}

//合并对象
function extend(target, source) {
for (var obj in source) {
target[obj] = source[obj];
}
return target;
}

// 测试
var a = {a: 1, b: 2};
var b = {a: 2, b: 3, c: 4};
var c = extend(a, b);
console.log(c);


//响应式图片自动缩放
function imgwidth(id) {
var wrap=document.getElementById(id);
var imgs=wrap.getElementsByTagName('img');
console.log(imgs.length);
for(var i in imgs){
imgs[i].index=i;
if(imgs[i].width > window.screen.width){
imgs[i].width=window.screen.width*0.9;
imgs[i].height=imgs[i].naturalHeight*((window.screen.width*0.9)/imgs[i].naturalWidth);	
}
//imgs[i].onclick=function(){
//alert(this.index);
//console.log(this.index);
// }
}
}
// window.onload = function () {
// //imgwidth("divid");
// };

// 把字符串中的汉字转换成Unicode
function toUnicodeFun(data){
  if(data == '' || typeof data == 'undefined') return '请输入汉字';
   var str =''; 
   for(var i=0;i<data.length;i++){
      str+="\\u"+data.charCodeAt(i).toString(16);
   }
   return str;
}

// var resultUnicode = toUnicodeFun('中国'); // \u4e2d\u56fd
// console.log(resultUnicode);


function toChineseWords(data){
    if(data == '' || typeof data == 'undefined') return '请输入十六进制unicode';
    data = data.split("\\u");
    var str ='';
    for(var i=0;i<data.length;i++){
        str+=String.fromCharCode(parseInt(data[i],16).toString(10));
    }
    return str;
}

// var resultChineseWords = toChineseWords("\u4e2d\u56fd"); 
// console.log(resultChineseWords);//中国











function diff(obj1,obj2){//判断2对象是否相等
var o1 = obj1 instanceof Object;
var o2 = obj2 instanceof Object;
if(!o1 || !o2){/*  判断不是对象  */
return obj1 === obj2;
}
if(Object.keys(obj1).length !== Object.keys(obj2).length){
return false;
//Object.keys() 返回一个由对象的自身可枚举属性(key值)组成的数组,例如：数组返回下表：let arr = ["a", "b", "c"];console.log(Object.keys(arr))->0,1,2;
}
for(var attr in obj1){
var t1 = obj1[attr] instanceof Object;
var t2 = obj2[attr] instanceof Object;
if(t1 && t2){
return diff(obj1[attr],obj2[attr]);
}else if(obj1[attr] !== obj2[attr]){
return false;
}
}
return true;
}

// 打开视频
window.onload = function () {
document.body.appendChild($('<div id="layerplayercon" style="display:none;overflow: hidden;"><video id="layerplayer" class="video-js vjs-big-play-centered" controls preload="auto" width="864"></video></div>').get(0));
};
function layervideo(url,title){//
var playerobj = videojs("layerplayer", {autoplay: true});
playerobj.width("864");
playerobj.src({type: "video/mp4", src:url});
playerobj.play();
layer.open({
type: 1,
title: title,
maxmin: false,
closeBtn: 1,
resize:false,
area: '864px',
skin: 'layui-layer-nobg', //没有背景色
shadeClose: false,
shade: false,
content: $("#layerplayercon"),
cancel: function(){
playerobj.pause();
}
});
}


function photoview(id){

var kphoto=new Viewer(document.getElementById(id),{url:"data-big",movable:true,
toolbar: {
zoomIn: {show:1,size:"large"},
zoomOut:{show:1,size:"large"},
oneToOne: {show:1,size:"large"},
reset: 0,
prev: {show:1,size:"large"},
play: 0,
next: {show:1,size:"large"},
rotateLeft: {show:1,size:"large"},
rotateRight: 0,
flipHorizontal: 1,
flipVertical: 0,
},
navbar:false
});

return kphoto;
}

function kedit(id){

KindEditor.ready(function(K) {
K.create('textarea[id="'+id+'"]', {
resizeType : 1,
allowPreviewEmoticons : false,
allowImageUpload : false,
afterBlur: function(){this.sync();},
items : [
'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
'insertunorderedlist', '|', 'emoticons', 'image', 'link']
});
});

}

function kdate(id){
laydate.render({
  elem: '#'+id, //指定元素
  type: 'datetime',
  lang:'cn',
done: function(value, date, endDate){
    console.log(value); //得到日期生成的值，如：2017-08-18
    console.log(date); //得到日期时间对象：{year: 2017, month: 8, date: 18, hours: 0, minutes: 0, seconds: 0}
    console.log(endDate); //得结束的日期时间对象，开启范围选择（range: true）才会返回。对象成员同上。
  }
  
});
}
//Pdf阅读器
function pdfview(tit,url){layer.open({type: 2,title: tit,shadeClose: false,shade:false,maxmin: true,skin: 'layui-layer-nobg',area: ['1366px', '870px'],content: 'http://static.namenb.com/web/js/lib/pdfviewer/web/?file='+url+'#page=1'});}


function touchHandler(event){
var touches = event.changedTouches,
first = touches[0],
type = "";
switch(event.type){
case "touchstart": type = "mousedown"; break;
case "touchmove":  type = "mousemove"; break;        
case "touchend":   type = "mouseup";   break;
default:           return;
}
//initMouseEvent(type, canBubble, cancelable, view, clickCount, screenX, screenY, clientX, clientY, ctrlKey, altKey, shiftKey, metaKey, button, relatedTarget);
var simulatedEvent = document.createEvent("MouseEvent");
simulatedEvent.initMouseEvent(type, true, true, window, 1, first.screenX, first.screenY, first.clientX, first.clientY, false, false, false, false, 0/*left*/, null);
first.target.dispatchEvent(simulatedEvent);
//event.preventDefault();
event.stopPropagation();
}
function init() {
document.addEventListener("touchstart", touchHandler, true);
document.addEventListener("touchmove", touchHandler, true);
document.addEventListener("touchend", touchHandler, true);
document.addEventListener("touchcancel", touchHandler, true);    
}
init();


