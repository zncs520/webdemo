function getjs(arr) {
for(var i= 0;i<arr.length;i++){
document.write('<script language="javascript" src="'+document.currentScript.src.substring(0,document.currentScript.src.lastIndexOf('/'))+'/lib/'+arr[i]+'"></script>');
}
}
getjs([
"jquery.min.js",
"httpx.min.js",
"watch.min.js",
"store.legacy.min.js",
"vue.min.js",
"vue.filter.js",
"layer/layer.js",
"cityselect.js",
"lib.js"


]);
//alert(document.currentScript.src.substring(0,document.currentScript.src.lastIndexOf('/'))); 