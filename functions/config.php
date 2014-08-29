<?php
require('fun.php');

$pageTitle="探索";

//配置数据库信息
$dbname="explore";
$host="localhost";
$dbVerifyName="root";
$dbVerifyPassword="xieyang";

//初始化用户系统
try {
	$pdo=new PDO("mysql:dbname=$dbname;host=$host",$dbVerifyName,$dbVerifyPassword);
} catch (PDOException $e) {
	echo $e->getMessage();
}

$accEx=new accessExplore($pdo);
/*
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
//$fo->getFollowerCount(2);

$sha=new sharingCls($pdo);
//$sha->newSharing(9,'public','hhhhhhhhhhhhh','');
//$sha->deleteSharing(9,3);
//$_sharing=$sha->loadSharing(9);
//print_r($_sharing[1]->getContent());
//$sha->getSharingAmount(9);

$dy=new dynamiCls($pdo);
//$_dy=$dy->loadDynamic(9);
//$dy->writeDynamic(9,'hhhhh');

$na=new noAttentionToCls($pdo);
//$na->writeAttention(1,2);
//$na->isNoAttention(1,2)

$cm=new commentCls($pdo);
//$cm->writeComment(9,4,'23333333');
//if($cm->isComment(9,4)){echo 'dsds';}
//$cm->deleteComment(9,4);

$ladd=new LAD($pdo);
//$ladd->writeLike(9,4);
//$ladd->unLike(9,4);

$up=new userProfile($pdo);
//$up->checkPassword(9,"7758521x");*/

?>