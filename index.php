<?php
require("functions/config.php");

$islogin=0;

if($islogin){
	$pageTitle="探索";
}else{
	$pageTitle="登录";
}

require("includes/header.php");

if($islogin){
	require("includes/welcome.php");
}else{
	require("includes/main.php");}

require("includes/footer.php");
?>