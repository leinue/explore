<?php
require("functions/config.php");

$islogin=1;

$column=$_GET['column'];

if($islogin){
	switch ($column) {
		case 'explore':
			$pageTitle="发现 - 探索";
			$pageRequired="explore.php";
			break;
		case 'setting':
			$pageTitle="设置 - 探索";
			$pageRequired="setting.php";
		    break;
		case 'hotaeras':
			$pageTitle="热门地区 - 探索";
			$pageRequired="hotaeras.php";
		    break;
		case 'notifications':
			$pageTitle="消息通知 - 探索";
			$pageRequired="notifications.php";
		    break;
		default:
			$pageTitle="探索";
			header("Location:index.php");
			break;
	}
}else{header("Location:index.php");}

require("includes/header.php");
require("includes/$pageRequired");

//require("includes/footer.php");
?>