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

	function regExplore($email,$name,$password){//已写入动态

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

	function refreshUser(){
		$sql_login="SELECT * FROM `basicprofile`";
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

	private $name;
	private $email;
	private $uid;
	private $location;
	private $sex;
	private $occupation;
	private $intro;
	private $detailIntro;
	private $face;
	private $background;
	private $backgroundBlur;
	private $emailVerified;
	private $place;
	private $nowPlace;
	private $sharingNum;
	private $ip;
	private $regTime;
	private $lastLoginTime;

	function getName(){return $this->name;}

	function getEmail(){return $this->email;}

	function getUid(){return $this->uid;}

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

/*************************************************************************/

/**
* dynamiCls
*/
class dynamiCls{
	
	private $pdo;

	function __construct(){$this->pdo=$_pdo;}

	function loadDynamic($uid){

		$sql_dynamic="SELECT * FROM `dynamic` WHERE `uid`=?";
		$stmt=$this->pdo->prepare($sql_dynamic);

		$res=$stmt->execute(array($uid));

		$stmt->setFetchMode(PDO::FETCH_CLASS,'dynamic');

		if ($res) {
			if($_dynamic=$stmt->fetchAll()) {
				return $_dynamic;
			}else{
				return false;}
		}else{
			return false;}
	}

	function writeDynamic($uid,$dy){

		$sql="INSERT INTO `dynamic`(`uid`, `dynamic`) VALUES ($uid,'$dy')";
		$rows=$this->pdo->exec($sql);
		switch ($rows) {
			case 0:
				return false;
				break;
			default:
				return true;
				break;
		}

	}
}

/**
* dynamic
*/
class dynamic{
	
	private $dynamicID;
	private $uid;
	private $dynamic;
	private $time;

	function getDynamicID(){return $this->dynamicID;}

	function getUid(){return $this->uid;}

	function getDynamic(){return $this->dynamic;}

	function getTime(){return $this->time;}
}

/*************************************************************************/

/**
* notification
*/
class notification{

	private $notificationID;
	private $uid;
	private $content;
	private $notiType;//notifcation or mension
	private $notiTime;
	
	function getNotificationID(){return $this->notificationID;}

	function getUid(){return $this->uid;}

	function getContent(){return $this->content;}

	function getNotiType(){return $this->notiType;}

	function getNotiTime(){return $this->notiTime;}
}

/**
* draft
*/
class draft{

	private $draftID;
	private $uid;
	private $content;
	private $editTime;
	
	function getDraftID(){return $this->draftID;}

	function getUid(){return $this->uid;}

	function getContent(){return $this->content;}

	function getEditTime(){return $this->editTime;}
}

/**
* collection
*/
class collection{
	
	private $collectionID;
	private $uid;
	private $collectTime;
	private $sharingID;

	function getCollectionID(){return $this->collectionID;}

	function getUid(){return $this->uid;}

	function getCollectTime(){return $this->collectTime;}

	function getSharingID(){return $this->sharingID;}
}

/*************************************************************************/

/**
* sharing
*/
class sharingCls{

	private $pdo;
	
	function __construct($_pdo){$this->pdo=$_pdo;}

	function newSharing($uid,$type,$content,$img){
		$sql="INSERT INTO `sharing`( `uid`, `sharingType`, `content`, `img`, `commentAmount`, `likeAmount`, `dislikeAmount`, `tipOff`) 
		VALUES (?,?,?,?,0,0,0,0)";
		$stmt=$this->pdo->prepare($sql);

		if($stmt){
			if($stmt->execute(array($uid,$type,$content,$img))){

				$sql="UPDATE `basicprofile` SET `sharingNum`=`sharingNum`+1 WHERE `uid`=$uid";
				$rows=$this->pdo->exec($sql);
				switch ($rows) {
					case 0:
						return false;
						break;
					default:
						return true;
						break;
				}

			}else{return false;}
		}else{return false;}
	}

	function deleteSharing($uid,$sharingID){
		$sql="DELETE FROM `sharing` WHERE `uid`=$uid and `sharingID`=$sharingID";
		$rows=$this->pdo->exec($sql);

		if($rows!=0){
			$sql="UPDATE `basicprofile` SET `sharingNum`=`sharingNum`-1 WHERE `uid`=$uid";
			$rows=$this->pdo->exec($sql);
			if($rows!=0){return true;}else{
				return false;}
		}else{
			return false;}
	}

	function loadSharing($uid){

		$sql_sharing="SELECT * FROM `sharing` WHERE `uid`=?";
		$stmt=$this->pdo->prepare($sql_sharing);

		$res=$stmt->execute(array($uid));

		$stmt->setFetchMode(PDO::FETCH_CLASS,'sharing');

		if ($res) {
			if($_sharing=$stmt->fetchAll()) {
				return $_sharing;
			}else{
				return false;}
		}else{
			return false;}

	}

	function getSharingAmount($uid){

		$sql="SELECT `sharingNum`FROM `basicprofile` WHERE `uid`=$uid";
		$r=$this->pdo->query($sql);

		if($row=$r->fetch()){
			return $row[0];
		}else return false;

	}

}

class sharing{

	private $sharingID;
	private $uid;
	private $time;
	private $sharingType;
	private $content;
	private $img;
	private $commentAmount;
	private $likeAmount;
	private $dislikeAmount;
	private $tipOff;//举报
	
	function getSharingID(){return $this->sharingID;}

	function getUid(){return $this->uid;}

	function getTime(){return $this->time;}

	function getSharingType(){return $this->sharingType;}

	function getContent(){return $this->content;}

	function getImg(){return $this->img;}

	function getCommentAmount(){return $this->commentAmount;}

	function getLikeAmount(){return $this->likeAmount;}

	function getDislikeAmount(){return $this->dislikeAmount;}

	function getTipOff(){return $this->tipOff;}

}

/*************************************************************************/

class comment{

	private $commentID;
	private $uid;
	private $sharingID;
	private $content;
	private $tiem;
	
	function getCommentID(){return $this->commentID;}

	function getUid(){return $this->uid;}

	function getSharingID(){return $this->sharingID;}

	function getContent(){return $this->content;}

	function getTiem(){return $this->tiem;}

}

/**********************************************************************/

class like{

	private $likeID;
	private $sharingID;
	private $time;
	private $count;
	
	function getLikeID(){return $this->likeID;}

	function getSharingID(){return $this->sharingID;}

	function getTime(){return $this->time;}

	function getCount(){

	}
}

class dislike{

	private $dislikeID;
	private $sharingID;
	private $time;
	private $count;
	
	function getDislikeID(){return $this->dislikeID;}

	function getSharingID(){return $this->sharingID;}

	function getTime(){return $this->time;}

	function getCount(){

	}

}

/**********************************************************************/

class noAttentionTo{

	private $attentionID;
	private $sharingID;
	private $uid;
	
	function getAttentionID(){return $this->attentionID;}

	function getSharingID(){return $this->sharingID;}

	function getUid(){return $this->uid;}

}

/**
* follow
*/
class followCls{

	private $pdo;
	
	function __construct(PDO $_pdo){$this->pdo=$_pdo;}

	function follow($uid,$uidFollowed){
		$sql="INSERT INTO `follow`( `uid`, `followID`,`followerID`) VALUES ($uid,$uidFollowed,0)";

		try {
			$rows=$this->pdo->exec($sql);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
		
		if($rows!=0){
			$sql="INSERT INTO `follow`( `uid`,`followID`, `followerID`) VALUES ($uidFollowed,0,$uid)";
			$rows=$this->pdo->exec($sql);
			if($rows!=0){return true;}else{
				return false;
			}
		}else{return false;}
	}

	function unFollow($uid,$uidUnFollowed){//返回受影响的行数
		$sql="DELETE FROM `follow` WHERE `uid`=$uid and `followID`=$uidUnFollowed";
		$rows=$this->pdo->exec($sql);
		
		if($rows!=0){
			$sql="DELETE FROM `follow` WHERE `uid`=$uidUnFollowed and `followerID`=$uid";
			$rows=$this->pdo->exec($sql);
			if($rows!=0){return true;}else{
				return false;
			}
		}else{return false;}
	}

	function isFollow($uid,$uidChecked){
		$sql="SELECT * FROM `follow` WHERE `uid`=? and `followID`=?";
		$stmt=$this->pdo->prepare($sql);
		$stmt->execute(array($uid,$uidChecked));

		$result=$stmt->fetch();
		if($result!=NULL){
			return true;
		}else{return false;}
	}

	function isFollower($uid,$uidChecked){
		$sql="SELECT * FROM `follow` WHERE `uid`=? and `followerID`=?";
		$stmt=$this->pdo->prepare($sql);
		$stmt->execute(array($uid,$uidChecked));

		$result=$stmt->fetch();
		if($result!=NULL){
			return true;
		}else{return false;}		
	}
	
	function loadFollow($uid){
		$sql="SELECT * FROM `follow` WHERE `uid`=?";
		$stmt=$this->pdo->prepare($sql);
		$res=$stmt->execute(array($uid));

		$stmt->setFetchMode(PDO::FETCH_CLASS,'follow');

		if ($res) {
			if($_follow=$stmt->fetchAll()) {
				return $_follow;
			}else{
				return false;}
		}else{
			return false;}
	}

	function removeFans($uid,$uidRemoved){//返回受影响的行数
		$sql="DELETE FROM `follow` WHERE `uid`=$uid and `followerID`=$uidRemoved";
		$rows=$this->pdo->exec($sql);
		
		if($rows!=0){
			$sql="DELETE FROM `follow` WHERE `uid`=$uidRemoved and `followID`=$uid";
			$rows=$this->pdo->exec($sql);
			if($rows!=0){return true;}else{
				return false;
			}
		}else{return false;}
	}

}

class follow{

	private $indexID;
	private $uid;
	private $followID; 
	private $followerID;
	private $followTime;
	
	function getIndexID(){return $this->indexID;}

	function getUid(){return $this->uid;}

	function getFollowID(){return $this->followID;}

	function getFollowTime(){return $this->followTime;}

	function getFollowerCount(){

	}

	function getFollowCount(){

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

//$accEx->regExplore('59705591@qq.com','ivy','7758521x');
$user_=$accEx->loginIn('597055914@qq.com','775521x');
//$dynamic_=$accEx->loadDynamic($user_->getUid());
//echo $dynamic_->getDynamic();
//session_start();
//echo $user_->getName();

$fo=new followCls($pdo);
//$fo->follow(1,2);
//$fo->unFollow(1,2);
//$fo->isFollow(1,2)
//$foo=$fo->loadFollow(1);
//$fo->removeFans(2,1);

$sha=new sharingCls($pdo);
//$sha->newSharing(9,'public','hhhhhhhhhhhhh','');
//$sha->deleteSharing(9,3);
//$_sharing=$sha->loadSharing(9);
//print_r($_sharing[1]->getContent());
//$sha->getSharingAmount(9);

$dy=new dynamiCls($pdo);
$dy->writeDynamic(9,'hhhhh');
?>