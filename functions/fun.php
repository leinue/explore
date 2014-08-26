<?php
require('mysql.php');

$cm=mysqlManager::getPDO();
$cm->connectMysql('explore','localhost','root','xieyang');

//$cm::$pdo->exec();

class regExplore extends mysqlManager{

	function __construct($email,$name,$password){

		date_default_timezone_set("Etc/GMT+8");

		parent::$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); //禁用prepared statements的仿真效果

		$userFolder="user/default/";
		$nowTime=time('Y-m-d H:m:s');
		$userIp=$_SERVER["REMOTE_ADDR"];

		$sql="INSERT INTO `basicprofile`(`email`, `name`, `password`, `location`, `sex`, `intro`, `detailIntro`, `face`, `background`,`backgroundBlur`, `emailVerified`, `place`, `nowPlace`, `ip`, `regTime`, `lastLoginTime`) VALUES (?,?,SHA1(?),China,futa,hh,23333,?,?,?,0,China,China,?,?,?)";

		$stmt=parent::$pdo->prepare($sql);
		$exeres=$stmt->execute(array($email, $name,$password,$userFolder."/photo.jpg",$userFolder."/background.jpg",$userFolder."/backgroundBlur.jpg",$userIp,$nowTime,$nowTime)); 

		if($exeres){
			echo '注册成功';
		}else{
			print_r($stmt->errorInfo()); 
		}
	}

}

$re=new regExplore('5dssd@sdsd.com','ieeee','reuttiysaa');

?>