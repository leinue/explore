<?php
require("functions/config.php");
//a.com/column.php?column=explore
//a.com/column.php?column=hotaeras
//a.com/people.php?people=ivydom
//a.com/column.php?column=notifications
//a.com/column.php?column=setting

require("includes/header.php");

//判断是否登录
if(empty($_SESSION)){
	require("includes/welcome.php");
}else{
	require("includes/main.php");}

require("includes/footer.php");
?>