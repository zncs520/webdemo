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

