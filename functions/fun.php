<?php
require('mysql.php');

class toolKit{

	function getIP(){
		global $ip;
		if (getenv("HTTP_CLIENT_IP"))
			$ip = getenv("HTTP_CLIENT_IP");
		else if(getenv("HTTP_X_FORWARDED_FOR"))
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		else if(getenv("REMOTE_ADDR"))
			$ip = getenv("REMOTE_ADDR");
		else $ip = "Unknow";
		return $ip;
	}
	
}

class regExplore extends mysqlManager{

	public $regResult;

	function __construct($email,$name,$password){

		date_default_timezone_set("Etc/GMT+8");

		parent::$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); //禁用prepared statements的仿真效果

		$userFolder="user/default/";
		$nowTime=date('Y-m-d H:i:s',time());

		$objToolKit=new toolKit;
		$userIp=$objToolKit->getIP();

		$sql="INSERT INTO `basicprofile`(`email`, `name`, `password`, `location`, `sex`, `intro`, `detailIntro`, `face`, `background`,`backgroundBlur`, `emailVerified`, `place`, `nowPlace`, `ip`, `regTime`, `lastLoginTime`) 
		VALUES (?,?,SHA1(?),'China','futa','hh','23333',?,?,?,0,'China','China',?,?,?)";
			
		$stmt=parent::$pdo->prepare($sql);

		if($stmt!=false){
			$exeres=$stmt->execute(array($email, $name,$password,$userFolder."photo.jpg",$userFolder."background.jpg",$userFolder."backgroundBlur.jpg",$userIp,$nowTime,$nowTime)); 

			if($exeres){
				$this->regResult=true;
			}else{
				print_r($stmt->errorInfo());
				$this->regResult=false;
			}
		}else{$this->regResult=false;}
		
	}

}

$cm=mysqlManager::getPDO();
$cm->connectMysql('explore','localhost','root','xieyang');

//$cm::$pdo

//$re=new regExplore('597055914','ivy','77585219966');

?>