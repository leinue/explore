<?php

//载入个人信息
$logUser=new userProfile($pdo);
$usercls=$logUser->loadProfile($_SESSION['uid']);

//载入粉丝/关注列表
$focls=new followCls($pdo);
//$folist=$focls->loadFollow($_SESSION['uid']);

?>

<maincontent>

<div class="user-card">
	<div class="left-info">
		<div class="content-head-card">
			<h3>动态</h3>
		</div>

		<div class="main-card">

			<div class="main-card-photo">
				<img src="<?php echo $usercls->getFace(); ?>" alt="<?php echo $usercls->getName(); ?>" width="70" height="70" class="img-rounded"> 
			</div>

			<div class="main-card-detail-info">
				<div class="full-name">
					<span><a href=""><?php echo $usercls->getName(); ?></a></span>
					<span class="at-account"><a href="">@<?php echo $usercls->getName(); ?></a> - 7小时</span>
				</div>

				<div class="user-blog-text">
					<span>dsgdfgfd<br>dsgdfgfd<br>dsgdfgfd<br>dsgdfgfd<br>dsgdfgfd<br>dsgdfgfd<br>dsgdfgfd<br></span>
				</div>
			</div>

			<div class="main-card-footer">
			    <ul class="main-card-extension">
			    	<li><span class="glyphicon glyphicon-zoom-in"></span> <a href="">展开</a></li>
			    	<li><span class="glyphicon glyphicon-screenshot"></span> <a href="" target="_blank">详细</a></li>
			    </ul>
				<ul>
					<li><span class="glyphicon glyphicon-info-sign"></span> <a href="">举报</a></li>
					<li><span class="glyphicon glyphicon-ban-circle"></span> <a href="">不再提醒</a></li>
					<li><span class="glyphicon glyphicon-heart"></span> <a href="">收藏</a></li>
					<li><span class="glyphicon glyphicon-thumbs-up"></span> <a href="">赞</a></li>
					<li><span class="glyphicon glyphicon-comment"></span> <a href="">评论</a></li>
				</ul>
			</div>

		</div>

		<div class="main-card">

			<div class="main-card-photo">
				<img src="user/ivydom/photo.jpg" alt="<?php echo $usercls->getName(); ?>" width="70" height="70" class="img-rounded"> 
			</div>

			<div class="main-card-detail-info">
				<div class="full-name">
					<span><a href=""><?php echo $usercls->getName(); ?></a></span>
					<span class="at-account"><a href="">@<?php echo $usercls->getName(); ?></a> - 7小时</span>
				</div>

				<div class="user-blog-text">
					<span>dsgdfgfd<br>dsgdfgfd<br>dsgdfgfd<br>dsgdfgfd<br>dsgdfgfd<br>dsgdfgfd<br>dsgdfgfd<br></span>
				</div>
				<div class="user-blog-text-plus-img">
					<img src="user/ivydom/background.jpg" alt="<?php echo $usercls->getName(); ?>" width="80" height="80">
				</div>
			</div>

			<div class="main-card-footer">
			    <ul class="main-card-extension">
			    	<li><span class="glyphicon glyphicon-zoom-in"></span> <a href="">展开</a></li>
			    	<li><span class="glyphicon glyphicon-screenshot"></span> <a href="" target="_blank">详细</a></li>
			    </ul>
				<ul>
					<li><span class="glyphicon glyphicon-info-sign"></span> <a href="">举报</a></li>
					<li><span class="glyphicon glyphicon-ban-circle"></span> <a href="">不再提醒</a></li>
					<li><span class="glyphicon glyphicon-heart"></span> <a href="">收藏</a></li>
					<li><span class="glyphicon glyphicon-thumbs-up"></span> <a href="">赞</a></li>
					<li><span class="glyphicon glyphicon-comment"></span> <a href="">评论</a></li>
				</ul>
			</div>

		</div>
		<div class="refresh-column">更多</div>
	</div>

	<div class="right-info">
		<div class="user-background">
			<img src="user/ivydom/background.jpg" alt="<?php echo $usercls->getName(); ?>" width="320" height="95">
		</div>

		<div class="profile-content">
		    <div class="user-photo">
		    	<img src="user/ivydom/photo.jpg" alt="<?php echo $usercls->getName(); ?>" class="img-thumbnail" width="75" height="75">
		    </div>
		    <div class="basic-profile">
		    	<a ref=""><h4><?php echo $usercls->getName(); ?></h4></a>
		    	<span class="help-block"><a ref="">@<?php echo $usercls->getName(); ?></a></span>
		    </div>
		    <div class="statelable">
		    	<div class="detail-state-lable">
		    		<span class="help-block"><a ref="">去过</a></span>
		    		<a ref=""><p><?php echo $usercls->getPlaceNum(); ?></p></a>
		    	</div>
		    	<div class="detail-state-lable">
		    		<span class="help-block"><a ref="">关注</a></span>
		    		<a ref=""><p><?php $count=$focls->getFollowCount($_SESSION['uid']);if(!$count){echo '0';}else{echo $count;} ?></p></a>
		    	</div>
		    	<div class="detail-state-lable">
		    		<span class="help-block"><a ref="">粉丝</a></span>
		    		<a ref=""><p><?php $count=$focls->getFollowCount($_SESSION['uid']);if(!$count){echo '0';}else{echo $count;} ?></p></a>
		    	</div>
		    </div>
		</div>
		
		<div class="right-hot-info">
			<div class="hot-info-heading">
				<span>热门地方</span>
			</div>
			<div class="setting-card-user-welcome-content">
				<ul>
			 		<a href=""><li><span class="glyphicon glyphicon-user"></span> 江泽民</li></a>
			 		<a href=""><li><span class="glyphicon glyphicon-user"></span> 温家宝</li></a>
			 		<a href=""><li><span class="glyphicon glyphicon-user"></span> 糊紧掏</li></a>
					<a href=""><li><span class="glyphicon glyphicon-user"></span> 习近平</li></a>
					<a href=""><li><span class="glyphicon glyphicon-user"></span> 李克强</li></a>
				</ul>
			</div>
		</div>
	</div>
</div>

</maincontent>
