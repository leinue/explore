
<div class="user-card">

	<div class="left-info">
		<div class="content-head-card">
			<h3 id="noti-title">通知</h3>
		</div>

		<div class="notification-main-card">

			<div class="main-card-photo">
				<img src="user/ivydom/photo.jpg" alt="ivydom" width="70" height="70" class="img-rounded"> 
			</div>

			<div class="main-card-detail-info">
				<div class="full-name">
					<span><a href="">ivydom</a></span>
					<span class="at-account"><a href="">@ivydom</a> - 7小时</span>
				</div>

				<div class="user-blog-text">
					<span>@ivydom @github</span>
				</div>
			</div>

		</div>
	</div>

	<div class="right-info">
		<div class="notification-menu-first" onclick="eventNotification()"><span class="glyphicon glyphicon-hand-left"></span> 通知</div>
		<div class="notification-menu-second" onclick="eventMension()"><span class="glyphicon glyphicon-hand-left"></span> 提到</div>
	</div>	

</div>

<script type="text/javascript">
	function eventNotification(){document.getElementById('noti-title').innerHTML="通知";}

	function eventMension(){document.getElementById('noti-title').innerHTML="提及";}
</script>
