<?php
require("functions/config.php");

$islogin=1;

$userAccount=$_GET['people'];

if ($islogin) {
	$pageTitle="$userAccount - 探索";
}else{header("Location:index.php");}


require("includes/header.php");



require("includes/footer.php");
?>