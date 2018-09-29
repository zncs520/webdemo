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
alert("非对象!");
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

//搜索json
var edata={"data":[
{"kk":"pp","kk1":"pp1"},
{"kk":"pp1"},
{"kk":"pp"}
]};
function getarrdata(arr,key,value){//搜索json
var res={};
for (var i=0;i<arr.length;i++){
if(arr[i][key]==value){res[i]=arr[i]}
}
return res;
}
console.log(getarrdata(edata["data"],"kk","pp"));




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

window.onload = function () {
imgwidth("divid");
};









