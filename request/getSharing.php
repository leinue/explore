<?php
require('..\functions\config.php');

//getSharing.php?uid=15

$uid=testInput($_GET['uid']);

$flag=0;

if(strlen($uid)==0){
	echo 'the value of uid can not be NULL';
	$flag=$flag-1;
}

if($flag>=0){
	if(!($pdo)){
		echo '-1';//链接数据库失败
	}elseif(empty($_SESSION)){
		echo '-2';//用户没有登录
	}else{
		$getSha=new sharingCls($pdo);
		$sharingList=$getSha->loadSharing($uid);
		foreach ($sharingList as $key => $value) {
			$jsonData=$jsonData.'{"uid":"'.$value->getUid().'","time":"'.$value->getTime().'","sharingType":"'.$value->getSharingType().'","img":"'.$value->getImg().'","content":"'.$value->getContent().'","commentNum":"'.$value->getCommentAmount().'","likeNum":"'.$value->getLikeAmount().'","dislikeNum":"'.$value->getDislikeAmount().'"},';
		}
		$jsonData=substr_replace($jsonData,"",-1,1);
		echo "{sharing:[".$jsonData."]}";
	}	
}


session_write_close();
?>