<?php
require('mysql.php');


$cm=mysqlManager::getPDO();
$cm->connectMysql('explore','localhost','root','xieyang');

interface regExplore{
	function reg($username,$password,$email);
}

?>