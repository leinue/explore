<?php
require('db_session.inc.php');
?>
<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <title>DB SESSION TEST</title>
</head>

<body>

<?php

if(empty($_SESSION)){
	$_SESSION['xieyang']='umxieyang';
	$_SESSION['maomao']='umaomao';
	$_SESSION['that']='blue';

	echo '<p>SESSION DATA STORED</p>';
}else{
	echo '<p>SESSION DATA EXISTS<pre>'.print_r($_SESSION)."<pre></p>";
}

if(isset($_GET['logout'])){
	session_destroy();

	echo '<p>SESSION DESTORYED</p>';
}else{
	echo '<a href="sessions.php?logout=true">logout</a>';
}

echo '<p>SESSION DATA<pre>'.print_r($_SESSION,1)."<pre></p>";

session_write_close();
?>

</body>
</html>