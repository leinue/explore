<?php
require("functions/config.php");

$userAccount=testInput($_GET['people']);

//初始化个人信息
$user=new userProfile($pdo);
$usercls=$user->loadProfile($userID);

if($userID=$user->userIsExist($userAccount)){

	//初始化关注/粉丝数据信息
	$focls=new followCls($pdo);

	//初始化个人分享
	$shacls=new sharingCls($pdo);
	$shalist=$shacls->loadSharing($userID[0]);

	if (!empty($_SESSION)) {
		$pageTitle="$userAccount - 探索";
	}else{header("Location:index.php");}


	require("includes/header.php");
?>

<div class="people-user-background-detail">
	<div class="people-user-heading">
		<div class="people-user-heading-left">
			<img src="user/ivydom/background-blur.jpg" alt="i<?php echo $usercls->getName(); ?>" width="260" height="265">
			<div class="people-user-heading-left-detail">
				<div class="people-user-photo">
					<img src="<?php echo $usercls->getFace(); ?>" alt="<?php echo $usercls->getName(); ?>" class="img-thumbnail" width="75" height="75">
				</div>
				<div class="people-user-detail">
					<div class="people-user-name"><?php echo $usercls->getName(); ?><span id="id-user" class="user-id"><?php echo $usercls->getUid(); ?></span></div>
					<div class="people-user-description"><?php echo $usercls->getIntro(); ?></div>
					<div class="people-user-accessed-record">被访问 NULL 次</div>
				</div>
			</div>
		</div>
		<div class="people-user-heading-right">
			<img src="<?php echo $usercls->getBackground(); ?>" alt="<?php echo $usercls->getName(); ?>" width="480" height="265">
		</div>
	</div>

	<div class="people-user-footer">
		<ul class="user-nav-pills" id="xxxxxxxx">
  			<li role="presentation"><a href="">去过 <?php echo $usercls->getPlaceNum(); ?></a></li>
  			<li role="presentation"><a href="">粉丝 <?php $count=$focls->getFollowerCount($userID[0]);if(!$count){echo '0';}else{echo $count;} ?></a></li>
  			<li role="presentation"><a href="">关注 <?php $count=$focls->getFollowCount($userID[0]);if(!$count){echo '0';}else{echo $count;} ?></a></li>
  			<li role="presentation"><a href="">分享 <?php $count=$shacls->getSharingAmount($userID[0]);if(!$count){echo '0'.$userID;}else{echo $count;} ?></a></li>
		</ul>
	</div>
</div>

<div class="people-user-lib">

	<div class="people-lib-left">
		<div class="people-lib-main-card">
			<textarea class="form-control" id="twitter-content" rows="3" onkeyup="alterBtnStatus()" required></textarea>
			<div class="people-lib-send-msg">
				<ul class="people-lib-send-msg-menu">
					<li title="图片"><span class="glyphicon glyphicon-picture"></span></li>
					<li title="#话题"><span class="glyphicon glyphicon-comment" onclick="addTopic()"></span></li>
					<li title="@某人"><span class="glyphicon glyphicon-volume-up" onclick="atSomeone()"></span></li>
					<li title="链接(支持音乐/视频)"><span class="glyphicon glyphicon-link"></span></li>
					<li id="secret-sharing" onclick="setPrivate()" title="设为私密"><span class="glyphicon glyphicon-lock"></span></li>
				</ul>
				<div class="people-lib-send-msg-button"><button type="button" onclick="sendSharing()" id="btn-twitter-send" class="btn btn-success btn-sm">发布</button></div>
			</div>
		</div>

		<div class="people-lib-main-card">
			<div class="lib-card-heading">基本信息<span class="lib-card-heading-right"><a href="column.php?column=setting">修改</a></span></div>
			<div class="lib-card-content">
				<ul>
					<li><span class="glyphicon glyphicon-envelope"></span> <?php echo $usercls->getEmail(); ?></li>
					<li><span class="glyphicon glyphicon-map-marker"></span> <?php echo $usercls->getLocation(); ?></li>
					<li><span class="glyphicon glyphicon-user"></span> <?php echo $usercls->getSex(); ?></li>
					<li><span class="glyphicon glyphicon-briefcase"></span> <?php echo $usercls->getIntro(); ?></li>
					<li><span class="glyphicon glyphicon-credit-card"></span> <?php echo $usercls->getRegTime(); ?></li>					
				</ul>
			</div>
		</div>
		<div class="people-lib-main-card">
			<div class="lib-card-heading">去过的地方 <span class="lib-card-heading-right">目前:<?php echo $usercls->getNowPlace(); ?></span></div>
			<div class="lib-card-content">
				<ul class="location-accessed">
					<?php 
						$placeAccessed=$usercls->getPlace();
						$placeNum=$usercls->getPlaceNum();
						if($placeNum==1){
							echo '<li>'.$placeAccessed.'</li>';
						}else{
							$eachPlace=explode(',',$placeAccessed);
							foreach ($eachPlace as $key => $value) {
								echo '<li>'.$value.' | </li>';}
						}
					?>
				</ul>
			</div>
		</div>
		<div class="sharing-panel-left-bottom" id="sharing-panel-left"></div>
	</div>

	<div class="people-lib-right" id="sharing-panel"></div>

</div>
<?php }else{
	header("Location:index.php");
}
?>

<script>

	function isOdd(num){
 		var a = parseInt(num);
 		switch(a%2){
  		case 0:
  			return true;
   			break;
  		case 1:
   			return false;
  	 		break;
 		}
	}

	function my_nl2br($s){  
		return str_replace("\n",'<br>',str_replace("\r",'<br>',str_replace("\r\n",'<br>',$s)));}

	var twitterContent;
	twitterContent=document.getElementById('twitter-content').value;
	
	if(twitterContent.length==0){document.getElementById('btn-twitter-send').disabled="true";}

	function alterBtnStatus(){document.getElementById('btn-twitter-send').disabled=false;}

	function addContent(idName,contentAdded){
		var doc=document.getElementById(idName);
		var originalText=doc.innerHTML;
		doc.innerHTML=originalText+contentAdded;	
	}

	function addTopic(){addContent('twitter-content','##');}

	function atSomeone(){addContent('twitter-content','@');}

	function setPrivate(){
		var doc=document.getElementById("secret-sharing");
		var _title=doc.title;
		if(_title=="设为私密"){
			doc.style.color="rgb(118,167,250)";
			doc.title="设为公开";
		}else{
			if(_title=="设为公开"){
			doc.style.color="rgb(162,162,162)";
			doc.title="设为私密";}
		}
	}

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
   	 					if(j<2 || !(isOdd(j))){
   	 						var sharingPanelDoc=document.getElementById('sharing-panel');
   	 						var str='<div class="people-lib-main-card"><div class="people-lib-main-card-twitter-heading"><div class="people-lib-twitter-heading-photo"><img src="'+jsonObj.sharing[j].face+'" alt="'+jsonObj.sharing[j].name+'" class="img-thumbnail" width="46" height="46"></div><div class="people-lib-twitter-detail"><div class="people-lib-twitter-detail-name"><a href="people.php?people='+jsonObj.sharing[j].name+'">'+jsonObj.sharing[j].name+'</a><div class="lib-twitter-detail-name-right"><div class="dropdown"><span class="caret"></span></div></div></div><div class="people-lib-twitter-detail-time-type"><span class="people-lib-card-twiiter-type">'+jsonObj.sharing[j].sharingType+'</span>  -  '+jsonObj.sharing[j].time+'</div></div></div><div class="people-lib-main-card-twitter-content">'+jsonObj.sharing[j].content+'</div><div class="people-lib-main-card-twitter-footer"><div class="btn-group"><button type="button" class="btn btn-default">赞('+jsonObj.sharing[j].likeNum+')</button><button type="button" class="btn btn-default">踩('+jsonObj.sharing[j].dislikeNum+')</button><button type="button" class="btn btn-default">收藏</button></div><div class="people-lib-twitter-footer-right"></div><div class="comment-input-enabled" id="id-comment-input-enabled"><textarea class="form-control" id="twitter-content" rows="3" onkeyup="alterBtnStatus()" required></textarea><div class="people-lib-send-msg"><ul class="people-lib-send-msg-menu"><li title="#话题"><span class="glyphicon glyphicon-comment"></span></li><li title="@某人"><span class="glyphicon glyphicon-volume-up"></span></li></ul><div class="people-lib-send-msg-button"><button type="button" id="btn-twitter-send" class="btn btn-success btn-sm">发布</button></div></div></div></div></div>';
   	 						sharingPanelDoc.innerHTML=sharingPanelDoc.innerHTML+str;
   	 					}else{
   	 						var sharingPanelDoc=document.getElementById('sharing-panel-left');
   	 						var str='<div class="people-lib-main-card"><div class="people-lib-main-card-twitter-heading"><div class="people-lib-twitter-heading-photo"><img src="'+jsonObj.sharing[j].face+'" alt="'+jsonObj.sharing[j].name+'" class="img-thumbnail" width="46" height="46"></div><div class="people-lib-twitter-detail"><div class="people-lib-twitter-detail-name"><a href="people.php?people='+jsonObj.sharing[j].name+'">'+jsonObj.sharing[j].name+'</a><div class="lib-twitter-detail-name-right"><div class="dropdown"><span class="caret"></span></div></div></div><div class="people-lib-twitter-detail-time-type"><span class="people-lib-card-twiiter-type">'+jsonObj.sharing[j].sharingType+'</span>  -  '+jsonObj.sharing[j].time+'</div></div></div><div class="people-lib-main-card-twitter-content">'+jsonObj.sharing[j].content+'</div><div class="people-lib-main-card-twitter-footer"><div class="btn-group"><button type="button" class="btn btn-default">赞('+jsonObj.sharing[j].likeNum+')</button><button type="button" class="btn btn-default">踩('+jsonObj.sharing[j].dislikeNum+')</button><button type="button" class="btn btn-default">收藏</button></div><div class="people-lib-twitter-footer-right"></div><div class="comment-input-enabled" id="id-comment-input-enabled"><textarea class="form-control" id="twitter-content" rows="3" onkeyup="alterBtnStatus()" required></textarea><div class="people-lib-send-msg"><ul class="people-lib-send-msg-menu"><li title="#话题"><span class="glyphicon glyphicon-comment"></span></li><li title="@某人"><span class="glyphicon glyphicon-volume-up"></span></li></ul><div class="people-lib-send-msg-button"><button type="button" id="btn-twitter-send" class="btn btn-success btn-sm">发布</button></div></div></div></div></div>';
   	 						sharingPanelDoc.innerHTML=sharingPanelDoc.innerHTML+str;
   	 					}
   	 				}
   	 			}

    		}
  		}
		xmlhttp.open("GET","request/getSharing.php?uid=15",true);
		xmlhttp.send();

	}

	function sendSharing(){

		var xmlhttp;
		var content=document.getElementById("twitter-content").value;

		if (content=="") {
  			alert("分享内容不能为空");
  			return;
  		}

  		var uid=document.getElementById("id-user").innerHTML;

  		var type='public';

  		if(document.getElementById("secret-sharing").title=="设为公开"){
  			type='private';
  		}else{
  			type='public';}

		if (window.XMLHttpRequest){//code for IE7+, Firefox, Chrome, Opera, Safari
  			xmlhttp=new XMLHttpRequest();
  		}else{//code for IE6, IE5
  			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
 		}
		xmlhttp.onreadystatechange=function(){
  			if (xmlhttp.readyState==4 && xmlhttp.status==200){
   	 			if(xmlhttp.responseText=='1'){
    				document.getElementById('sharing-panel').innerHTML="";
					document.getElementById('sharing-panel-left').innerHTML="";
					document.getElementById("twitter-content").value="";
    				getSharing();
    			}else{
    				alert('发送失败');
    			}
    		}
  		}
		xmlhttp.open("GET","request/newSharing.php?method=new&uid="+uid+"&content="+content+"&type="+type+"&img=0&sharingID=0",true);
		xmlhttp.send();
	}

	getSharing();

</script>

<?php
require("includes/footer.php");
?>