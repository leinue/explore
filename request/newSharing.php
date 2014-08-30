<?php
require('..\functions\config.php');

//newSharing.php?method=new&uid=15&content=2333333&type=public&img=0&sharingID=0

$method=testInput($_GET['method']);//delete||new
$uid=testInput($_GET['uid']);
$content=testInput($_GET['content']);
$type=testInput($_GET['type']);//public||private
$img=testInput($_GET['img']);//没有写0
$sharingID=testInput($_GET['sharingID']);

$requestQueue=array(
	'method'=>$method,
	'uid'=>$uid,
	'content'=>$content,
	'type'=>$type,
	'img'=>$img,
	'sharingID'=>$sharingID);

$flag=0;

foreach ($requestQueue as $key => $value) {
	if(strlen($value)==0){
		echo "the value of $key can not be NULL<br>";
		$flag=$flag-1;
	}
}

if($flag>=0){
	if(!($pdo)){
		echo '-1';//链接数据库失败
	}elseif(empty($_SESSION)){
		echo '-2';//用户没有登录
	}else{
		$newSha=new sharingCls($pdo);
		switch ($method) {
			case 'delete':
				if(!($newSha->deleteSharing($uid,$sharingID))){
					echo '-4';/*删除失败*/
				}else{
					echo '2';
				}
				break;
			case 'new':
				if(!($newSha->newSharing($uid,$type,$content,$img))){
					echo '-5';/*发送失败*/
				}else{
					echo '1';
				}
				break;
			default:
				return '-3';//METHOD不匹配
				break;
		}
	}
}

unset($newSha);

session_write_close();
?>