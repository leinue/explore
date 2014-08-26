<?php

class mysqlManager{
	
	static $pdo=NULL;

	private function __construct(){}
	private function __clone(){}

	static function getPDO(){
		if(self::$pdo==NULL){
			self::$pdo=new mysqlManager();
		}

		return self::$pdo;
	}

	function connectMysql($dbname,$host,$name,$password){
		try {
			self::$pdo=new PDO("mysql:dbname=$dbname;host=$host",$name,$password);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	function iniTable(){

		$sql=array(
		'bacicTable'=>"CREATE TABLE `basicProfile`(
    `uid` int not null auto_increment,
    `email` text not null,
    `name` VARCHAR(30) not null,
    `password` char(40) not null,
    `location` text not null,
    `sex` text(10) not null,
    `intro` text(15) not null,
    `detailIntro` text(160) not null,
    `face` text not null,
    `background` text not null,
    `backgroundBlur` text not null,
    `emailVerified` int(2) not null,
    `place` text,
    `nowPlace` text,
    `ip` text not null,
    `regTime` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `lastLoginTime` TIMESTAMP not null,
    primary key(`uid`)
    )default charset=utf8;", 
		'draft'=>"create table `userDraft`( `draftID` int not null auto_increment, `uid` int not null, `content` text not null, `editTime` timestamp, primary key(`draftID`) )default charset=utf8;",
		'collection'=>"create table `collection`( `collectionID` int not null auto_increment, `uid` int not null, `colleTtime` timestamp not null, `sharingID` int not null, primary key(`collectionID`) )default charset=utf8;",
		'sharing'=>"create table `sharing`( `sharingID` int not null auto_increment, `uid` int not null, `time` timestamp not null, `sharingType` ENUM('public','private'), `content` text not null, `img` text not null, `commentAmount` int not null, `likeAmount` int not null, `dislikeAmount` int not null, `tip-off` int not null, primary key(`sharingID`) )default charset=utf8;",
		'comment'=>"create table `comment`( `commentID` int not null auto_increment, `uid` int not null, `sharingID` int not null, `content` text not null, `tiem` timestamp not null, primary key(`commentID`) )default charset=utf8;",
		'like'=>"create table `_like`( `likeID` int not null auto_increment, `sharingID` int not null, `time` timestamp not null, primary key(`likeID`) )default charset=utf8;",
		'dislike'=>"create table `dislike`( `dislikeID` int not null auto_increment, `sharingID` int not null, `time` timestamp not null, primary key(`dislikeID`) )default charset=utf8;",
		'noAttentionTo'=>"create table `noAttentionTo`( `attentionID` int not null auto_increment, `sharingID` int not null, `uid` int not null, primary key(`attentionID`) )default charset=utf8;",
		'follow'=>"create table `follow`( `indexID` int not null auto_increment, `uid` int not null, `followID` int not null, `followTime` timestamp, primary key(`indexID`) )default charset=utf8;",
		'notification'=>"create table `notification`( `notificationID` int not null auto_increment, `uid` int not null, `content` text not null, `notiType` ENUM('mension','notification'), `notiTime` timestamp not null, primary key(`notificationID`) )default charset=utf8;",
		'dynamic'=>"create table `dynamic`( `dynamicID` int not null auto_increment, `uid` int not null, `dynamic` text not null, `time` timestamp, primary key(`dynamicID`) )default charset=utf8;"
		);
	
		foreach ($sql as $key => $value) {
			try {
			self::$pdo->query($sql[$key]);
			} catch (PDOException $e) {
			echo $e->getMessage();
			}
		}
		
	}

}


?>