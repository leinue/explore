<?php

class mysqlManager{

	protected $pdo;

	function __construct(PDO $_pdo){$this->pdo=$_pdo;}

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
    `sharingNum` int not null,
    `ip` text not null,
    `regTime` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `lastLoginTime` TIMESTAMP not null,
    primary key(`uid`)
    )default charset=utf8;", 
		'draft'=>"create table `userDraft`( `draftID` int not null auto_increment, `uid` int not null, `content` text not null, `editTime` timestamp, primary key(`draftID`) )default charset=utf8;",
		'collection'=>"create table `collection`( `collectionID` int not null auto_increment, `uid` int not null, `colleTtime` timestamp not null, `sharingID` int not null, primary key(`collectionID`) )default charset=utf8;",
		'sharing'=>"create table `sharing`( `sharingID` int not null auto_increment, `uid` int not null, `time` timestamp not null, `sharingType` ENUM('public','private'), `content` text not null, `img` text not null, `commentAmount` int not null, `likeAmount` int not null, `dislikeAmount` int not null, `tipOff` int not null, primary key(`sharingID`) )default charset=utf8;",
		'comment'=>"create table `comment`( `commentID` int not null auto_increment, `uid` int not null, `sharingID` int not null, `content` text not null, `tiem` timestamp not null, primary key(`commentID`) )default charset=utf8;",
		'_like'=>"create table `_like`( `likeID` int not null auto_increment, `uid` int not null,`sharingID` int not null, `time` timestamp not null, primary key(`likeID`) )default charset=utf8;",
		'dislike'=>"create table `dislike`( `dislikeID` int not null auto_increment, `uid` int not null,`sharingID` int not null, `time` timestamp not null, primary key(`dislikeID`) )default charset=utf8;",
		'noAttentionTo'=>"create table `noAttentionTo`( `attentionID` int not null auto_increment, `sharingID` int not null, `uid` int not null, primary key(`attentionID`) )default charset=utf8;",
		'follow'=>"create table `follow`( `indexID` int not null auto_increment, `uid` int not null, `followID` int not null, `followerID` int not null,`followTime` timestamp, primary key(`indexID`) )default charset=utf8;",
		'notification'=>"create table `notification`( `notificationID` int not null auto_increment, `uid` int not null, `content` text not null, `notiType` ENUM('mension','notification'), `notiTime` timestamp not null, primary key(`notificationID`) )default charset=utf8;",
		'dynamic'=>"create table `dynamic`( `dynamicID` int not null auto_increment, `uid` int not null, `dynamic` text not null, `time` timestamp, primary key(`dynamicID`) )default charset=utf8;",
		'sessions'=>"create table `sessions`( `sessions_id` int not null auto_increment, `data` text not null, `last_accessed` timestamp, primary key(`sessions_id`) )default charset=utf8;"
		);
	
		foreach ($sql as $key => $value) {
			try {
				$this->pdo->query($sql[$key]);
			} catch (PDOException $e) {
				echo $e->getMessage();
			}
		}
		
	}

}


?>