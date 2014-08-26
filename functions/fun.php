<?php
require('mysql.php');

//connect mysql
$cm=mysqlManager::getPDO();
$cm->connectMysql('explore','localhost','root','xieyang');

//$cm::$pdo->exec("INSERT INTO `basicprofile`(`email`, `name`, `password`, `location`, `sex`, `intro`, `detailIntro`, `face`, `background`, `emailVerified`, `place`, `nowPlace`, `ip`, `regTime`, `lastLoginTime`) VALUES ( '597055914@qq.com','ivy',SHA1('77585219966'),'huo','futa','hhhhh','23333','ss','aaa',0,'hhh','hh','sdfsf','2012-10-20 20:00;00','2012-10-20 20:00;00')");

/**
* reg in explore
*/
class regExplore extends mysqlManager{

	function __construct($unsafe_email,$unsafe_name,$unsafe_password){

		date_default_timezone_set("Etc/GMT+8");

		$email=mysqli_escape_string($dbc,$unsafe_email);
		$email=parent::$pdo->quote($unsafe_email);

		$name=mysqli_escape_string($dbc,$unsafe_name);
		$name=parent::$pdo->quote($unsafe_name);

		$password=mysqli_escape_string($dbc,$unsafe_password);
		$password=parent::$pdo->quote($unsafe_password);

		$userFolder="user/default/";

		$nowTime=time('Y-m-d H:m:s');

		$userIp=$_SERVER["REMOTE_ADDR"];
		
		try {
			parent::$pdo->exec("INSERT INTO `basicprofile`(
			`email`, `name`, `password`, `location`, `sex`, `intro`, `detailIntro`, `face`, `background`,`backgroundBlur`, `emailVerified`, `place`, `nowPlace`, `ip`, `regTime`, `lastLoginTime`) 
		VALUES ( '".$email."','".$name."',SHA1('".$password."'),'China','futa','hh','23333','".$userFolder."/photo.jpg"."','".$userFolder."/background.jpg"."','".$userFolder."/background-blur.jpg"."',0,'China','China','".$userIp."','".$nowTime."','".$nowTime."')");
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	
	}

}

$re=new regExplore('597055914@qq.com','ivy','77585219966');

?>