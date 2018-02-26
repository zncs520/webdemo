<?php
function mkdirs_pic($path){
if(!is_dir($path)){
mkdirs_pic(dirname($path));
if(!mkdir($path, 0777)){
return false;
}
}
return true;
}

function upimg($k,$upload_path,$uploadfile_name){
$file = $_FILES[$k];//得到传输的数据 
//得到文件名称
$name = $file['name'];
$type = strtolower(substr($name,strrpos($name,'.')+1)); //得到文件类型，并且都转化成小写
$allow_type = array('jpg','jpeg','gif','png'); //定义允许上传的类型
//判断文件类型是否被允许上传
if(!in_array($type, $allow_type)){
//如果不被允许，则直接停止程序运行
return ;
}
//判断是否是通过HTTP POST上传的
if(!is_uploaded_file($file['tmp_name'])){
//如果不是通过HTTP POST上传的
return ;
}
//开始移动文件到相应的文件夹
mkdirs_pic($upload_path);//创建目录
$newfile=$upload_path.$uploadfile_name.".".$type;
if(move_uploaded_file($file['tmp_name'],$newfile)){
simple_thumb($newfile, 120, null , $newfile.'_s');
simple_thumb($newfile, 600, null , $newfile.'_m');
//return 'https://api.bangbangrobotics.com/restful/sns/'.$newfile.'';

return $newfile;

}else{
return false;
}
}

function simple_thumb($src, $width = null, $height = null, $filename = null) {
if (!isset($width) && !isset($height))
return false;
if (isset($width) && $width <= 0)
return false;
if (isset($height) && $height <= 0)
return false;
 
$size = getimagesize($src);
if (!$size)
return false;
list($src_w, $src_h, $src_type) = $size;
$src_mime = $size['mime'];
switch($src_type) {
case 1 :
$img_type = 'gif';
break;
case 2 :
$img_type = 'jpeg';
break;
case 3 :
$img_type = 'png';
break;
case 15 :
$img_type = 'wbmp';
break;
default :
return false;
}
if (!isset($width))
$width = $src_w * ($height / $src_h);
if (!isset($height))
$height = $src_h * ($width / $src_w);
$imagecreatefunc = 'imagecreatefrom' . $img_type;
$src_img = $imagecreatefunc($src);
$dest_img = imagecreatetruecolor($width, $height);
imagecopyresampled($dest_img, $src_img, 0, 0, 0, 0, $width, $height, $src_w, $src_h);
$imagefunc = 'image' . $img_type;
if ($filename) {
$imagefunc($dest_img, $filename);
} else {
header('Content-Type: ' . $src_mime);
$imagefunc($dest_img);
}
imagedestroy($src_img);
imagedestroy($dest_img);
return true;
}
?>
