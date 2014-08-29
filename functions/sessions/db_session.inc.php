<?php
$sdbc=NULL;//connects in all functions

function open_session(){
	global $sdbc;
	$sdbc=mysqli_connect('localhost','root','xieyang','explore');

	if(!$sdbc){return true;}else{return false;}
}

function close_session(){
	global $sdbc;

	return mysqli_close($sdbc);
}

function read_session($sid){
	global $sdbc;

	$sql=sprintf("SELECT `data` FROM `sessions` WHERE `id`='%s'",mysqli_real_escape_string($sdbc,$sid));
	$result=mysqli_query($sdbc,$sql);

	echo mysqli_error($sdbc);

	if($result){
		$cek=mysqli_num_rows($result);
		if($cek==1){
			list($data)=mysqli_fetch_array($result,MYSQLI_NUM);
		    return $data;
		}else{
			return '';
		}
	}else{
		echo "the query match zero elements";
	}
}

function write_session($sid,$data){
	global $sdbc;

	$sql=sprintf("REPLACE INTO `sessions` (`id`,`data`) VALUES('%s','%s')",
		mysqli_real_escape_string($sdbc,$sid),mysqli_real_escape_string($sdbc,$data));
	$result=mysqli_query($sdbc,$sql);

	if(mysqli_affected_rows($sdbc)>0){
		return true;
	}else return false;
}

function destory_session($sid){
	global $sdbc;

	$sql=sprintf("DELETE FROM `sessions` WHERE `id`='%s'",
		mysqli_real_escape_string($sdbc,$sid));
	$result=mysqli_query($sdbc,$sql);

	$_SESSION=array();
	if(mysqli_affected_rows($sdbc)>0){
		return true;
	}else return false;
}

function clean_session($expire){
	global $sdbc;

	$sql=sprintf("DELETE FROM `sessions` WHERE DATE_ADD(`last_accessed`,INTERVAL %d SECOND)<NOW()",
		(int)$expire);
	$result=mysqli_query($sdbc,$sql);

	if(mysqli_affected_rows($sdbc)>0){
		return true;
	}else return false;
}

session_set_save_handler('open_session', 'close_session', 'read_session', 'write_session', 'destory_session', 'clean_session');
session_start();
?>