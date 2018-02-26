<?php
include("lib/config.php");
$res= kselect('user','["uid","nickname"]','{}',$database);
echo json_encode($res);
?>