function getjs(arr) {for(var i= 0;i<arr.length;i++){document.write('<script language="javascript" src="'+document.currentScript.src.substring(0,document.currentScript.src.lastIndexOf('/'))+'/lib/'+arr[i]+'"></script>');}}
function dynamicLoadCss(url) {var head = document.getElementsByTagName('head')[0];var link = document.createElement('link');link.type='text/css';link.rel = 'stylesheet';link.href = url;head.appendChild(link);}
getjs([
"jquery.min.js",
"httpx.min.js",
"watch.min.js",
"store.legacy.min.js",
"vue.min.js",
"vue.filter.js",
"layer/layer.js",
"swiper/swiper.min.js",
"viewer/viewer.min.js",
"videojs/video.min.js",
"aliplayer/aliplayer.min.js",
"aliplayer/aliplayercomponents.min.js",
"socket.io.js",
"kindeditor/kindeditor-all-min.js",
"kindeditor/lang/zh-CN.js",
"barrager/jquery.barrager.js",
"spotlight/spotlight.js",
"lib.js"
]);
dynamicLoadCss(document.currentScript.src.substring(0,document.currentScript.src.lastIndexOf('/'))+"/css.css");
dynamicLoadCss(document.currentScript.src.substring(0,document.currentScript.src.lastIndexOf('/'))+"/lib/swiper/swiper.min.css");
dynamicLoadCss(document.currentScript.src.substring(0,document.currentScript.src.lastIndexOf('/'))+"/lib/viewer/viewer.min.css");
dynamicLoadCss(document.currentScript.src.substring(0,document.currentScript.src.lastIndexOf('/'))+"/lib/videojs/video.min.css");
dynamicLoadCss(document.currentScript.src.substring(0,document.currentScript.src.lastIndexOf('/'))+"/lib/aliplayer/aliplayer.min.css");
dynamicLoadCss(document.currentScript.src.substring(0,document.currentScript.src.lastIndexOf('/'))+"/lib/barrager/barrager.css");

dynamicLoadCss(document.currentScript.src.substring(0,document.currentScript.src.lastIndexOf('/'))+"/lib/spotlight/spotlight.css");

dynamicLoadCss(document.currentScript.src.substring(0,document.currentScript.src.lastIndexOf('/'))+"/lib/kindeditor/themes/default/default.css");