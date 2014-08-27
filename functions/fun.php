<?php
require('mysql.php');
require('sessions/sessions.php');

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

class accessExplore extends mysqlManager{

	public $regResult;
	public $pdo;

	function __construct(PDO $_pdo){$this->pdo=$_pdo;}

	function regExplore($email,$name,$password){

		date_default_timezone_set("Etc/GMT+8");

		$this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); //禁用prepared statements的仿真效果

		$userFolder="user/default/";
		$nowTime=date('Y-m-d H:i:s',time());
		$userIp=getIP();

		$sql="INSERT INTO `basicprofile`(`email`, `name`, `password`, `location`, `sex`, `intro`, `detailIntro`, `face`, `background`,`backgroundBlur`, `emailVerified`, `place`, `nowPlace`, `ip`, `regTime`, `lastLoginTime`) 
		VALUES (?,?,SHA1(?),'China','futa','explore','explore',?,?,?,0,'China','China',?,?,?)";

		$stmt=$this->pdo->prepare($sql);

		if($stmt!=false){

			$exeres=$stmt->execute(array($email, $name,$password,$userFolder."photo.jpg",$userFolder."background.jpg",$userFolder."backgroundBlur.jpg",$userIp,$nowTime,$nowTime)); 

			if($exeres){
				$sql_dynamic="INSERT INTO `dynamic`(`uid`, `dynamic`) VALUES (".$this->pdo->lastInsertId().",'注册了Explore')";
				$rowAffectedNum=$this->pdo->exec($sql_dynamic);

				if ($rowAffectedNum!=0) {
					$this->regResult=true;
				}else{$this->regResult=false;}

			}else{
				print_r($stmt->errorInfo());
				$this->regResult=false;
			}

		}else{$this->regResult=false;}
	}

	function loginIn($email,$password){

	}

}

$dbname="explore";
$host="localhost";
$dbVerifyName="root";
$dbVerifyPassword="xieyang";

try {
	$pdo=new PDO("mysql:dbname=$dbname;host=$host",$dbVerifyName,$dbVerifyPassword);
} catch (PDOException $e) {
	echo $e->getMessage();
}

$accEx=new accessExplore($pdo);
$accEx->regExplore('597055914@qq.com','ivy','7758521x');

?>