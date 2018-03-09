<?php
include("lib/config.php");
$res= 查('user','["uid","nickname"]','{}',$database);
echo json_encode($res);
?>