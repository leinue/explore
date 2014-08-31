<?php

//载入个人信息
$logUser=new userProfile($pdo);
$usercls=$logUser->loadProfile($_SESSION['userid']);

//载入粉丝/关注列表
$focls=new followCls($pdo);
//$folist=$focls->loadFollow($_SESSION['userid']);

?>

<maincontent>

<div class="user-card">
	<div class="left-info">
		<div class="content-head-card">
			<h3>动态<span class="user-id" id="id-user"><?php echo $usercls->getUid(); ?></span></h3>
		</div>
			
		<div id="main-sharing-card-id"></div>

		<div class="refresh-column" id="main-card-sharing-more" onclick="getSharing()">更多</div>
	</div>

	<div class="right-info">
		<div class="user-background">
			<img src="<?php echo $usercls->getBackground(); ?>" alt="<?php echo $usercls->getName(); ?>" width="320" height="95">
		</div>

		<div class="profile-content">
		    <div class="user-photo">
		    	<img src="<?php echo $usercls->getFace(); ?>" alt="<?php echo $usercls->getName(); ?>" class="img-thumbnail" width="75" height="75">
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
		    		<a ref=""><p><?php $count=$focls->getFollowCount($_SESSION['userid']);if(!$count){echo '0';}else{echo $count;} ?></p></a>
		    	</div>
		    	<div class="detail-state-lable">
		    		<span class="help-block"><a ref="">粉丝</a></span>
		    		<a ref=""><p><?php $count=$focls->getFollowCount($_SESSION['userid']);if(!$count){echo '0';}else{echo $count;} ?></p></a>
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

<script>

	function getSharing(){

		if (window.XMLHttpRequest){//code for IE7+, Firefox, Chrome, Opera, Safari
  			xmlhttp=new XMLHttpRequest();
  		}else{//code for IE6, IE5
  			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
 		}

		xmlhttp.onreadystatechange=function(){
  			if (xmlhttp.readyState==4 && xmlhttp.status==200){
   	 			var jsonObj=eval("("+xmlhttp.responseText+")");
   	 			for(i in jsonObj){
   	 				for(j in i){
   	 					var sharingPanelDoc=document.getElementById('main-sharing-card-id');
   	 					var str='<div class="main-card"><div class="main-card-photo"><img src="'+jsonObj.sharing[j].face+'" alt="'+jsonObj.sharing[j].name+'" width="70" height="70" class="img-rounded"></div><div class="main-card-detail-info"><div class="full-name"><span><a href="people.php?people='+jsonObj.sharing[j].name+'">'+jsonObj.sharing[j].name+'</a></span><span class="at-account"><a href="people.php?people='+jsonObj.sharing[j].name+'">@'+jsonObj.sharing[j].name+'</a> - '+jsonObj.sharing[j].time+'</span></div><div class="user-blog-text">'+jsonObj.sharing[j].content+'</div><div class="user-blog-text-plus-img"><img src="" alt="" width="80" height="80"></div></div><div class="main-card-footer"><ul class="main-card-extension"><li><span class="glyphicon glyphicon-zoom-in"></span> <a href="">展开</a></li><li><span class="glyphicon glyphicon-screenshot"></span> <a href="" target="_blank">详细</a></li></ul><ul><li><span class="glyphicon glyphicon-info-sign"></span> <a href="">举报</a></li><li><span class="glyphicon glyphicon-ban-circle"></span> <a href="">不再提醒</a></li><li><span class="glyphicon glyphicon-heart"></span> <a href="">收藏</a></li><li><span class="glyphicon glyphicon-thumbs-up"></span> <a href="">赞</a></li><li><span class="glyphicon glyphicon-comment"></span> <a href="">评论</a></li></ul></div></div>';
						sharingPanelDoc.innerHTML=sharingPanelDoc.innerHTML+str;
   	 				}
   	 			}

    		}
  		}
  		var uid=document.getElementById('id-user').innerHTML;
		xmlhttp.open("GET","request/getSharing.php?uid="+uid,true);
		xmlhttp.send();
	}

	getSharing();
</script>