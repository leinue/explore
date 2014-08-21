<?php
require("functions/config.php");

$islogin=0;

require("includes/header.php");

if($islogin){
	require("includes/welcome.php");
	require("includes/footer.php");
}else{
	require("includes/main.php");}

?>