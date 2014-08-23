<?php

require("functions/config.php");
//a.com/column.php?column=explore
//a.com/column.php?column=hotaeras
//a.com/people.php?people=ivydom
//a.com/column.php?column=notifications
//a.com/column.php?column=setting
$islogin=1;

require("includes/header.php");

if(!$islogin){
	require("includes/welcome.php");
}else{
	require("includes/main.php");}

require("includes/footer.php");
?>