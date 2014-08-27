<?php
require('mysql.php');
require('sessions/db_session.inc.php');

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

	public $pdo;

	function __construct(PDO $_pdo){$this->pdo=$_pdo;}

	function regExplore($email,$name,$password){

		if(!($this->emailIsExist($email))){

			if(!($this->nameIsExist($name))){
				date_default_timezone_set("Etc/GMT+8");

				$this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); //禁用prepared statements的仿真效果

				$userFolder="user/default/";
				$nowTime=date('Y-m-d H:i:s',time());
				$userIp=getIP();

				$sql="INSERT INTO `basicprofile`(`email`, `name`, `password`, `location`, `sex`, `intro`, `detailIntro`, `face`, `background`,`backgroundBlur`, `emailVerified`, `place`, `nowPlace`,`sharingNum`, `ip`, `regTime`, `lastLoginTime`) 
				VALUES (?,?,SHA1(?),'China','futa','explore','explore',?,?,?,0,'China','China',0,?,?,?)";

				$stmt=$this->pdo->prepare($sql);

				if($stmt!=false){

					$exeres=$stmt->execute(array($email, $name,$password,$userFolder."photo.jpg",$userFolder."background.jpg",$userFolder."backgroundBlur.jpg",$userIp,$nowTime,$nowTime)); 

					if($exeres){
						$sql_dynamic="INSERT INTO `dynamic`(`uid`, `dynamic`) VALUES (".$this->pdo->lastInsertId().",'注册了Explore')";
						$rowAffectedNum=$this->pdo->exec($sql_dynamic);

						if ($rowAffectedNum!=0) {
							return true;
						}else{return false;}

					}else{
						print_r($stmt->errorInfo());
						return false;
					}

				}else{return false;}
			}else{
				echo '名字重复';
			}
		}else{echo '邮箱重复';}
	}

	function emailIsExist($email){return $this->isExist(1,$email);}

	function nameIsExist($name){return $this->isExist(2,$name);}

	function isExist($method,$info){
		//$method=1 email;$method=2 name
		switch ($method) {
			case 1:
				$sql="SELECT * FROM `basicprofile` WHERE `email`=?";
				break;
			case 2:
				$sql="SELECT * FROM `basicprofile` WHERE `name`=?";
			    break;
		}
		
		$stmt=$this->pdo->prepare($sql);

		if($stmt!=false){
			if($stmt->execute(array($info))){
				$row=$stmt->fetch();
				return $row;
			}
		}
	}

	function loginIn($email,$password){//返回user类

		$sql_login="SELECT * FROM `basicprofile` WHERE `email`=? and `password`=SHA1(?)";
		$stmt=$this->pdo->prepare($sql_login);

		$res=$stmt->execute(array($email,$password));

		$stmt->setFetchMode(PDO::FETCH_CLASS,'user');

		if ($res) {
			if($_user=$stmt->fetch()) {
				return $_user;
			}else{
				return false;}
		}else{
			return false;}
	}

	function logout(user $_user){
		unset($user);
		session_destroy();
		session_write_close();
	}

}

/**
* user
*/
class user{

	protected $name;
	protected $email;
	protected $uid;
	protected $location;
	protected $sex;
	protected $occupation;
	protected $intro;
	protected $detailIntro;
	protected $face;
	protected $background;
	protected $backgroundBlur;
	protected $emailVerified;
	protected $place;
	protected $nowPlace;
	protected $sharingNum;
	protected $ip;
	protected $regTime;
	protected $lastLoginTime;

	function getName(){return $this->name;}

	function getEmail(){return $this->email;}

	function getuid(){return $this->uid;}

	function getLocation(){return $this->location;}

	function getSex(){return $this->sex;}

	function getOccupation(){return $this->occupation;}

	function getIntro(){return $this->intro;}

	function getDetailIntro(){return $this->detailIntro;}

	function getFace(){return $this->face;}

	function getBackground(){return $this->background;}

	function getBackgroundBlur(){return $this->backgroundBlur;}

	function getEmailVerified(){return $this->emailVerified;}

	function getPlace(){return $this->place;}

	function getNowPlace(){return $this->nowPlace;}

	function getIP(){return $this->ip;}

	function getRegTime(){return $this->regTime;}

	function getLastLogin(){return $this->lastLoginTime;}
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

$accEx->regExplore('59705591@qq.com','ivy','7758521x');
//$user_=$accEx->loginIn('597055914@qq.com','7758521x');
//session_start();
//echo $user_->getName();
?>