<?php
require("functions/config.php");

$islogin=1;

$userAccount=$_GET['people'];

if ($islogin) {
	$pageTitle="$userAccount - 探索";
}else{header("Location:index.php");}


require("includes/header.php");
?>

<div class="people-user-background-detail">
	<div class="people-user-heading">
		<div class="people-user-heading-left">
			<img src="user/ivydom/background-blur.jpg" alt="ivydom" width="260" height="265">
			<div class="people-user-heading-left-detail">
				<div class="people-user-photo">
					<img src="user/ivydom/photo.jpg" alt="ivydom" class="img-thumbnail" width="75" height="75">
				</div>
				<div class="people-user-detail">
					<div class="people-user-name">ivydom</div>
					<div class="people-user-description">A Chinese stdudent who can write some computer programms.</div>
					<div class="people-user-accessed-record">被访问 0 次</div>
				</div>
			</div>
		</div>
		<div class="people-user-heading-right">
			<img src="user/ivydom/background.jpg" alt="ivydom" width="480" height="265">
		</div>
	</div>

	<div class="people-user-footer">
		<ul class="nav nav-pills" role="tablist" id="xxxxxxxx">
  			<li role="presentation"><a href="#">去过 0</a></li>
  			<li role="presentation"><a href="#">粉丝 0</a></li>
  			<li role="presentation"><a href="#">关注 0</a></li>
  			<li role="presentation"><a href="#">信息 0</a></li>
		</ul>
	</div>
</div>

<div class="people-user-lib">
	<div class="people-lib-left">
		
	</div>
	<div class="people-lib-right">
		
	</div>
</div>