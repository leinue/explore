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

function testInput($data){
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
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
				return -1;//名字重复
			}
		}else{
		return -2;/*邮箱重复*/}
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
* user profile
*/
class userProfile{

	private $pdo;

	function __construct($_pdo){$this->pdo=$_pdo;}

	function loadProfile($uid){

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

	function editProfile($uid,$profile){

		$sql="UPDATE `basicprofile` SET `name`=?,`location`=?,`sex`=?,`intro`=?,`nowPlace`=?,`place`=?,`detailIntro`=? WHERE `uid`=$uid";

		$stmt=$this->pdo->prepare($sql);

		if($stmt){
			$exer=$stmt->execute($profile);
			return $exer;
		}else{
			return false;}
	}

	function VerifyEmail($uid){

		$sql="UPDATE `basicprofile` SET `emailVerified`=1 WHERE `uid`=?";

		$stmt=$this->pdo->prepare($sql);

		if($stmt){
			$exer=$stmt->execute(array($uid));
			return $exer;
		}else{
			return false;}
	}

	function changePassword($uid,$newPassword){

		$sql="UPDATE `basicprofile` SET `password`=SHA1(?) WHERE `uid`=?";

		$stmt=$this->pdo->prepare($sql);

		if($stmt){
			$exer=$stmt->execute(array($newPassword,$uid));
			return $exer;
		}else{
			return false;}
	}

	function checkPassword($uid,$oldPassword){

		$sql="SELECT `email` FROM `basicprofile` WHERE `uid`=? and `password`=SHA1(?)";

		$stmt=$this->pdo->prepare($sql);

		if($stmt){
			$exer=$stmt->execute(array($uid,$oldPassword));
			if($exer){
				return $row=$stmt->fetch();
			}
		}else{
			return false;}
	}

	function changeEmail($uid,$newEmail){

		$sql="UPDATE `basicprofile` SET `email`=? WHERE `uid`=?";

		$stmt=$this->pdo->prepare($sql);

		if($stmt){
			$exer=$stmt->execute(array($newEmail,$uid));
			return $exer;
		}else{
			return false;}
	}

	function editPhoto($uid,$newPhoto){

		$sql="UPDATE `basicprofile` SET `face`=? WHERE `uid`=?";

		$stmt=$this->pdo->prepare($sql);

		if($stmt){
			$exer=$stmt->execute(array($newPhoto,$uid));
			return $exer;
		}else{
			return false;}
	}

	function editBackground($uid,$newBackground){

		$sql="UPDATE `basicprofile` SET `background`=? WHERE `uid`=?";

		$stmt=$this->pdo->prepare($sql);

		if($stmt){
			$exer=$stmt->execute(array($newBackground,$uid));
			return $exer;
		}else{
			return false;}
	}

	function userIsExist($userName){

		$sql="SELECT `uid` FROM `basicprofile` WHERE `name`=?";

		$stmt=$this->pdo->prepare($sql);

		if($stmt){
			$exer=$stmt->execute(array($userName));
			if($exer){
				return $row=$stmt->fetch();
			}
		}else{
			return false;}		
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

	function getPlaceNum(){
		if(strlen($this->place)==0){
			return '0';
		}else{
			return count(explode(',', $this->place));
		}
	}
}

/*************************************************************************/

/**
* dynamiCls
*/
class dynamiCls{
	
	private $pdo;

	function __construct(PDO $_pdo){$this->pdo=$_pdo;}

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
* notificationCls
*/
class notificationCls{

	private $pdo;
	
	function __construct(PDO $_pdo){$this->pdo=$_pdo;}

	function loadNotification($uid){

		$sql_sharing="SELECT * FROM `notification` WHERE `uid`=?";
		$stmt=$this->pdo->prepare($sql_sharing);

		$res=$stmt->execute(array($uid));

		$stmt->setFetchMode(PDO::FETCH_CLASS,'notification');

		if ($res) {
			if($_notification=$stmt->fetchAll()) {
				return $_notification;
			}else{
				return false;}
		}else{
			return false;}
	}

	function writeNotification($uid,$content,$type){

		$sql="INSERT INTO `notification`(`uid`,`content`,`notiType`) VALUES (?,?,?)";
		$stmt=$this->pdo->prepare($sql);
		if($stmt){
			$r=$stmt->execute(array($uid,$content,$type));
			return $r;
		}else{
			return false;}
	}
}

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

/*************************************************************************/

/**
* draftCls
*/
class draftCls{

	private $pdo;
	
	function __construct(PDO $_pdo){$this->pdo=$_pdo;}

	function loadDraft($uid){

		$sql_sharing="SELECT * FROM `draft` WHERE `uid`=?";
		$stmt=$this->pdo->prepare($sql_sharing);

		$res=$stmt->execute(array($uid));

		$stmt->setFetchMode(PDO::FETCH_CLASS,'draft');

		if ($res) {
			if($_draft=$stmt->fetchAll()) {
				return $_draft;
			}else{
				return false;}
		}else{
			return false;}
	}

	function writeDraft($uid,$content){

		$sql="INSERT INTO `draft`(`uid`,`content`) VALUES (?,?)";
		$stmt=$this->pdo->prepare($sql);
		if($stmt){
			$r=$stmt->execute(array($uid,$content));
			return $r;
		}else{
			return false;}
	}

	function removeDraft($uid,$draftID){
		$sql="DELETE FROM `draft` WHERE `uid`=$uid and `draftID`=$draftID";
		$rows=$this->pdo->exec($sql);
		return $rows;
	}

	function getDraftAmount($uid){
		$sql="SELECT * FROM `draft` WHERE `uid`=$uid";
		$stmt=$this->pdo->prepare($sql);

		if($stmt){
			$stmt->execute(array($uid));
			$row=$stmt->fetchAll();
			if($row){
				return count($row);
			}else{return false;}
		}else{
			return false;}
	}
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

/*************************************************************************/

/**
* collectionCls
*/
class collectionCls{

	private $pdo;
	
	function __construct(PDO $_pdo){$this->pdo=$_pdo;}

	function loadCollections($uid){

		$sql_sharing="SELECT * FROM `collection` WHERE `uid`=?";
		$stmt=$this->pdo->prepare($sql_sharing);

		$res=$stmt->execute(array($uid));

		$stmt->setFetchMode(PDO::FETCH_CLASS,'collection');

		if ($res) {
			if($_collection=$stmt->fetchAll()) {
				return $_collection;
			}else{
				return false;}
		}else{
			return false;}
	}

	function writeCollection($uid,$sharingID){
		$sql="INSERT INTO `collection`(`uid`,`sharingID`) VALUES ($uid,$sharingID)";
		$rows=$this->pdo->exec($sql);
		return $rows;
	}

	function isCollected($uid,$collectionID){

		$sql="SELECT * FROM `collection` WHERE `uid`=? and `collectionID`=?";
		$stmt=$this->pdo->prepare($sql);
		$stmt->execute(array($uid,$collectionID));

		$result=$stmt->fetch();
		if($result!=NULL){
			return true;
		}else{return false;}
	}

	function removeCollection($uid,$collectionID){
		$sql="DELETE FROM `collection` WHERE `uid`=$uid and `collectionID`=$collectionID";
		$rows=$this->pdo->exec($sql);
		return $rows;
	}

	function getCollectionAmount($uid){

		$sql="SELECT * FROM `collection` WHERE `uid`=$uid";
		$stmt=$this->pdo->prepare($sql);

		if($stmt){
			$stmt->execute(array($uid));
			$row=$stmt->fetchAll();
			if($row){
				return count($row);
			}else{return false;}
		}else{
			return false;}
	}
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
	
	function __construct(PDO $_pdo){$this->pdo=$_pdo;}

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

		$sql="SELECT `sharingNum`FROM `basicprofile` WHERE `uid`=?";

		$stmt=$this->pdo->prepare($sql);

		if($stmt){
			$stmt->execute(array($uid));
			$row=$stmt->fetchAll();
			if($row){
				return count($row);
			}else{return false;}
		}else{
			return false;}
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

/**
* comment
*/
class commentCls{
	
	private $pdo;

	function __construct(PDO $_pdo){$this->pdo=$_pdo;}

	function loadComment($sharingID){

		$sql="SELECT * FROM `comment` WHERE `sharingID`=?";
		$stmt=$this->pdo->prepare($sql);
		$res=$stmt->execute(array($sharingID));

		$stmt->setFetchMode(PDO::FETCH_CLASS,'comment');

		if ($res) {
			if($_comment=$stmt->fetchAll()) {
				return $_comment;
			}else{
				return false;}
		}else{
			return false;}

	}

	function writeComment($uid,$sharingID,$content){

		$sql="INSERT INTO `comment`(`uid`, `sharingID`, `content`) VALUES (?,?,?)";
		$stmt=$this->pdo->prepare($sql);
		$result=$stmt->execute(array($uid,$sharingID,$content));

		if($result){

			$sql="UPDATE `sharing` SET `commentAmount`=`commentAmount`+1 WHERE `uid`=$uid and `sharingID`=$sharingID";
			$rows=$this->pdo->exec($sql);
			switch ($rows) {
				case 0:
					return false;
					break;
				default:
					return true;
					break;
			}

		}else{
			return false;}
	}

	function isComment($uid,$sharingID){

		$sql="SELECT * FROM `comment` WHERE `uid`=? and `sharingID`=?";
		$stmt=$this->pdo->prepare($sql);
		$stmt->execute(array($uid,$sharingID));

		$result=$stmt->fetch();
		if($result!=NULL){
			return true;
		}else{return false;}
	}

	function deleteComment($uid,$sharingID){

		$sql="DELETE FROM `comment` WHERE `uid`=$uid and `sharingID`=$sharingID";
		$rows=$this->pdo->exec($sql);

		if($rows!=0){
			$sql="UPDATE `sharing` SET `commentAmount`=`commentAmount`-1 WHERE `uid`=$uid and `sharingID`=$sharingID";
			$rows=$this->pdo->exec($sql);
			if($rows!=0){return true;}else{
				return false;}
		}else{
			return false;}
	}

}

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

/**
* LAD的父类
*/
class PLAD{

	protected function writeData($pdo,$method,$uid,$sharingID){
		//method=1 like;method=2 dislike
		switch ($method) {
			case 1:
				$sql="INSERT INTO `_like`( `uid`, `sharingID`) VALUES ($uid,$sharingID)";
				break;
			case 2:
				$sql="INSERT INTO `dislike`( `uid`, `sharingID`) VALUES ($uid,$sharingID)";
				break;
		}

		try {
			$rows=$pdo->exec($sql);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
		
		if($rows!=0){

			switch ($method) {
				case 1:
					$sql="UPDATE `sharing` SET `likeAmount`=`likeAmount`+1 WHERE `uid`=$uid and `sharingID`=$sharingID";
					break;
				case 2:
					$sql="UPDATE `sharing` SET `dislikeAmount`=`dislikeAmount`+1 WHERE `uid`=$uid and `sharingID`=$sharingID";
					break;
			}

			$rows=$pdo->exec($sql);
			if($rows!=0){return true;}else{
				return false;
			}
		}else{return false;}
	}

	protected function loadData($pdo,$method,$uid){
		//method=1 like;method=2 dislike

		switch ($method) {
			case 1:
				$sql="SELECT * FROM `_like` WHERE `uid`=?";
				break;
			case 2:
				$sql="SELECT * FROM `dislike` WHERE `uid`=?";
				break;
		}

		$stmt=$pdo->prepare($sql);
		$res=$stmt->execute(array($uid));

		switch ($method) {
			case 1:
				$stmt->setFetchMode(PDO::FETCH_CLASS,'like');
				break;
			case 2:
				$stmt->setFetchMode(PDO::FETCH_CLASS,'dislike');
				break;
		}

		if ($res) {
			if($_attention=$stmt->fetchAll()) {
				return $_attention;
			}else{
				return false;}
		}else{
			return false;}
	}

	protected function check($pdo,$method,$uid,$sharingID){
		//method=1 like;method=2 dislike
		switch ($method) {
			case 1:
				$sql="SELECT * FROM `_like` WHERE `sharingID`=? and `uid`=?";
				break;
			case 2:
				$sql="SELECT * FROM `dislike` WHERE `sharingID`=? and `uid`=?";
				break;
		}

		$stmt=$this->pdo->prepare($sql);
		$stmt->execute(array($sharingID,$uid));

		$result=$stmt->fetch();
		if($result!=NULL){
			return true;
		}else{return false;}
	}

	protected function undo($pdo,$method,$uid,$sharingID){
		//method=1 like;method=2 dislike
		switch ($method) {
			case 1:
				$sql="DELETE FROM `_like` WHERE `uid`=$uid and `sharingID`=$sharingID";
				break;
			case 2:
				$sql="DELETE FROM `dislike` WHERE `uid`=$uid and `sharingID`=$sharingID";
				break;
		}

		$rows=$pdo->exec($sql);

		if($rows!=0){

			switch ($method) {
				case 1:
					$sql="UPDATE `sharing` SET `likeAmount`=`likeAmount`-1 WHERE `uid`=$uid and `sharingID`=$sharingID";
					break;
				case 2:
					$sql="UPDATE `sharing` SET `dislikeAmount`=`dislikeAmount`-1 WHERE `uid`=$uid and `sharingID`=$sharingID";
					break;
			}

			$rows=$pdo->exec($sql);
			if($rows!=0){return true;}else{
				return false;
			}
		}else{return false;}
	}

	protected function numIssue($pdo,$method,$uid,$sharingID){
		//method=1 like;method=2 dislike
		switch ($method) {
			case 1:
				$sql="SELECT * FROM `_like` WHERE `uid`=? and `sharingID`=?";
				break;
			case 2:
				$sql="SELECT * FROM `dislike` WHERE `uid`=? and `sharingID`=?";
				break;
		}

		$stmt=$pdo->prepare($sql);

		if($stmt){
			$stmt->execute(array($uid,$sharingID));
			$row=$stmt->fetchAll();
			if($row){
				return count($row);
			}else{return false;}
		}else{
			return false;}		
	}
}

class like{

	private $likeID;
	private $uid;
	private $sharingID;
	private $time;
	
	function getLikeID(){return $this->likeID;}

	function getSharingID(){return $this->sharingID;}

	function getTime(){return $this->time;}

}

/**
* like and dislike
*/
class LAD extends PLAD{

	private $pdo;
	
	function __construct(PDO $_pdo){$this->pdo=$_pdo;}

	function writeLike($uid,$sharingID){return parent::writeData($this->pdo,1,$uid,$sharingID);}

	function writeDislike($uid,$sharingID){return parent::writeData($this->pdo,2,$uid,$sharingID);}

	function loadLike($uid){return parent::loadData($this->pdo,1,$uid);}

	function loadDislike($uid){return parent::loadData($this->pdo,2,$uid);}

	function isLike($uid,$sharingID){return parent::check($this->pdo,1,$uid,$sharingID);}

	function isDislike($uid,$sharingID){return parent::check($this->pdo,2,$uid,$sharingID);}

	function unLike($uid,$sharingID){return parent::undo($this->pdo,1,$uid,$sharingID);}

	function unDislike($uid,$sharingID){return parent::undo($this->pdo,2,$uid,$sharingID);}

	function getLikeNum($uid,$sharingID){return parent::numIssue($this->pdo,1,$uid,$sharingID);}

	function getDislikeNum($uid,$sharingID){return parent::numIssue($this->pdo,2,$uid,$sharingID);}

}

class dislike{

	private $dislikeID;
	private $uid;
	private $sharingID;
	private $time;
	
	function getDislikeID(){return $this->dislikeID;}

	function getSharingID(){return $this->sharingID;}

	function getTime(){return $this->time;}

}

/**********************************************************************/

/**
* noAttentionTo
*/
class noAttentionToCls{

	private $pdo;
	
	function __construct(PDO $_pdo){$this->pdo=$_pdo;}

	function loadAttention($uid){
		$sql="SELECT * FROM `noattentionto` WHERE `uid`=?";
		$stmt=$this->pdo->prepare($sql);
		$res=$stmt->execute(array($uid));

		$stmt->setFetchMode(PDO::FETCH_CLASS,'noAttentionTo');

		if ($res) {
			if($_attention=$stmt->fetchAll()) {
				return $_attention;
			}else{
				return false;}
		}else{
			return false;}
	}

	function writeAttention($uid,$sharingID){
		$sql="INSERT INTO `noattentionto`(`sharingID`, `uid`) VALUES ($sharingID,$uid)";
		$rows=$this->pdo->exec($sql);
		return $rows;
	}

	function isNoAttention($uid,$sharingID){
		//检查sharingID是否对uid不再提醒
		$sql="SELECT * FROM `noattentionto` WHERE `sharingID`=? and `uid`=?";
		$stmt=$this->pdo->prepare($sql);
		$stmt->execute(array($sharingID,$uid));

		$result=$stmt->fetch();
		if($result!=NULL){
			return true;
		}else{return false;}
	}
}

class noAttentionTo{

	private $attentionID;
	private $sharingID;
	private $uid;
	
	function getAttentionID(){return $this->attentionID;}

	function getSharingID(){return $this->sharingID;}

	function getUid(){return $this->uid;}

}

/**********************************************************************/
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

	function getCount($method,$uid){
		//method=2 follow;method=1 follower
		switch ($method) {
			case 1:
				$sql="SELECT `followerID` FROM `follow` WHERE `uid`=?";
				break;
			case 2:
				$sql="SELECT `followID` FROM `follow` WHERE `uid`=?";
				break;
		}

		$stmt=$this->pdo->prepare($sql);

		if($stmt){
			$stmt->execute(array($uid));
			$row=$stmt->fetchAll();
			if($row){
				return count($row);
			}else{return false;}
		}else{
			return false;}
	}

	function getFollowerCount($uid){$this->getCount(1,$uid);}

	function getFollowCount($uid){$this->getCount(2,$uid);}

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

}

?>