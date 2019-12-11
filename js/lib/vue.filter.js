
function vmup(vm,jdata){
for(var o in jdata){
Vue.set(vm,o,jdata[o]);
}
}

Vue.filter('time', function (timeStamp) {//value为13位的时间戳
var date = new Date();  
date.setTime(timeStamp * 1000);  
var y = date.getFullYear();  
var m = date.getMonth() + 1;  
m = m < 10 ? ('0' + m) : m;  
var d = date.getDate();  
d = d < 10 ? ('0' + d) : d;  
var h = date.getHours();
h = h < 10 ? ('0' + h) : h;
var minute = date.getMinutes();
var second = date.getSeconds();
minute = minute < 10 ? ('0' + minute) : minute;  
second = second < 10 ? ('0' + second) : second; 
return y + '-' + m + '-' + d+' '+h+':'+minute+':'+second;
});


Vue.filter('timenow', function (timeStamp) {
var d_minutes,d_hours,d_days;
var timeNow = parseInt(new Date().getTime()/1000);
var d;
d = timeNow - timeStamp;
d_days = parseInt(d/86400);
d_hours = parseInt(d/3600);
d_minutes = parseInt(d/60);
if(d_days>0 && d_days<4){
return d_days+"天前";
}else if(d_days<=0 && d_hours>0){
return d_hours+"小时前";
}else if(d_hours<=0 && d_minutes>0){
return d_minutes+"分钟前";
}else{
var s = new Date(timeStamp*1000);
// s.getFullYear()+"年";
return (s.getMonth()+1)+"月"+s.getDate()+"日";
}
});


Vue.filter('baseimg', function (str) {
return 'https://api.bangbangrobotics.com/say/pictures/' + str + '_s';
});

Vue.filter('sex', function (str) {
if(str == 0){return '未知';}
if(str == 1){return '先生';}
if(str == 2){return '女士';}
});

Vue.filter('format_time', function (str) {
return str.replace('T00:00:00', '');
//return str;
});