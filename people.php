<?php
require("functions/config.php");
$userAccount=testInput($_GET['people']);

if (!empty($_SESSION)) {
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
		<ul class="user-nav-pills" id="xxxxxxxx">
  			<li role="presentation"><a href="">去过 0</a></li>
  			<li role="presentation"><a href="">粉丝 0</a></li>
  			<li role="presentation"><a href="">关注 0</a></li>
  			<li role="presentation"><a href="">信息 0</a></li>
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
				</ul>
				<div class="people-lib-send-msg-button"><button type="button" id="btn-twitter-send" class="btn btn-success btn-sm">发布</button></div>
			</div>
		</div>

		<div class="people-lib-main-card">
			<div class="lib-card-heading">基本信息<span class="lib-card-heading-right"><a href="">修改</a></span></div>
			<div class="lib-card-content">
				<ul>
					<li><span class="glyphicon glyphicon-envelope"></span> 23333333@qq.com</li>
					<li><span class="glyphicon glyphicon-map-marker"></span> 中二之峰学院</li>
					<li><span class="glyphicon glyphicon-user"></span> ♂</li>
					<li><span class="glyphicon glyphicon-briefcase"></span> 中二病患者</li>
					<li><span class="glyphicon glyphicon-credit-card"></span> 专注拾荒三十年</li>					
				</ul>
			</div>
		</div>
		<div class="people-lib-main-card">
			<div class="lib-card-heading">去过的地方 <span class="lib-card-heading-right">目前:蛤蛤</span></div>
			<div class="lib-card-content">
				<ul class="location-accessed">
					<li>大连 |</li>
					<li>北京 |</li>
					<li>上海 |</li>
					<li>南京</li>
				</ul>			
			</div>
		</div>
	</div>

	<div class="people-lib-right">

		<div class="people-lib-main-card">
			<div class="people-lib-main-card-twitter-heading">
				<div class="people-lib-twitter-heading-photo">
			    	<img src="user/ivydom/photo.jpg" alt="ivydom" class="img-thumbnail" width="46" height="46">
				</div>
				<div class="people-lib-twitter-detail">
					<div class="people-lib-twitter-detail-name">
						<a href="">ivydom</a>
						<div class="lib-twitter-detail-name-right">
							<div class="dropdown">
								<span class="caret"></span>
							</div>
						</div>
					</div>
					<div class="people-lib-twitter-detail-time-type"><span class="people-lib-card-twiiter-type">私密分享</span>  -  2013年4月14日</div>
				</div>
			</div>

			<div class="people-lib-main-card-twitter-content">
				中国人均收入世界排名：1960年第78名，1970年第82，1976 年84，1980年第94，1990年第105，2008年第106，2010年第127；但中国GDP世界排名：1978年第15名，1990年第10，1995年第7，2000年第6，2007年第4，2010年第2。这是一个什么样的中国梦！？﻿
			</div>
			<div class="people-lib-main-card-twitter-footer">
				<div class="btn-group">
  					<button type="button" class="btn btn-default">赞</button>
  					<button type="button" class="btn btn-default">踩</button>
 					<button type="button" class="btn btn-default">收藏</button>
				</div>
				<div class="people-lib-twitter-footer-right">
					<div class="input-group" id="original-comment-layout">
						<input type="text" class="form-control" onfocus="deployCommentLayout(this)" placeholder="评论">
    				</div>
				</div>
				<div class="comment-input-enabled" id="id-comment-input-enabled">
					<textarea class="form-control" id="twitter-content" rows="3" onkeyup="alterBtnStatus()" required></textarea>
					<div class="people-lib-send-msg">
						<ul class="people-lib-send-msg-menu">
							<li title="#话题"><span class="glyphicon glyphicon-comment"></span></li>
							<li title="@某人"><span class="glyphicon glyphicon-volume-up"></span></li>
						</ul>
						<div class="people-lib-send-msg-button"><span onclick="packupCommentLayout()" class="lib-send-msg-button-left">↑收起</span><button type="button" id="btn-twitter-send" class="btn btn-success btn-sm">发布</button></div>
					</div>
    			</div>
			</div>
		</div>

		<div class="people-lib-main-card">
			<div class="people-lib-main-card-twitter-heading">
				<div class="people-lib-twitter-heading-photo">
			    	<img src="user/ivydom/photo.jpg" alt="ivydom" class="img-thumbnail" width="46" height="46">
				</div>
				<div class="people-lib-twitter-detail">
					<div class="people-lib-twitter-detail-name"><a href="">ivydom</a></div>
					<div class="people-lib-twitter-detail-time-type"><span class="people-lib-card-twiiter-type">私密分享</span>  -  2013年4月14日</div>
				</div>
			</div>

			<div class="people-lib-main-card-twitter-content">
				<span>一个桌面级的操作系统代码规模在千万行数量级，如果加上配套软件，总规模应该超过一亿行，如果再加上一个完整的软件生态系统，那么总规模应该不少于十亿行。那是不是投钱投人就够了？不是.</span>		
			    <img src="user/ivydom/background.jpg" alt="ivydom" width="120" height="120" />
			</div>

			<div class="people-lib-main-card-twitter-footer">
				<div class="btn-group">
  					<button type="button" class="btn btn-default">赞</button>
  					<button type="button" class="btn btn-default">踩</button>
 					<button type="button" class="btn btn-default">收藏</button>
				</div>
				<div class="people-lib-twitter-footer-right">
					<div class="input-group" id="original-comment-layout">
						<input type="text" class="form-control" onfocus="deployCommentLayout(this)" placeholder="评论">
    				</div>
				</div>
				<div class="comment-input-enabled" id="id-comment-input-enabled">
					<textarea class="form-control" id="twitter-content" rows="3" onkeyup="alterBtnStatus()" required></textarea>
					<div class="people-lib-send-msg">
						<ul class="people-lib-send-msg-menu">
							<li title="#话题"><span class="glyphicon glyphicon-comment"></span></li>
							<li title="@某人"><span class="glyphicon glyphicon-volume-up"></span></li>
						</ul>
						<div class="people-lib-send-msg-button"><span onclick="packupCommentLayout()" class="lib-send-msg-button-left">↑收起</span><button type="button" id="btn-twitter-send" class="btn btn-success btn-sm">发布</button></div>
					</div>
    			</div>
			</div>
		</div>

	</div>

</div>

<script>
	var twitterContent;
	twitterContent=document.getElementById('twitter-content').innerHTML;
	
	if(twitterContent.length==0){document.getElementById('btn-twitter-send').disabled="true";}

	function alterBtnStatus(){document.getElementById('btn-twitter-send').disabled=false;}

	function deployCommentLayout(x){
		x.style.visibility='hidden';
		document.getElementById('id-comment-input-enabled').style.visibility='visible';
		document.getElementById('id-comment-input-enabled').style.display='block';
	}

	function packupCommentLayout(){
		document.getElementById('original-comment-layout').style.visibility='visible';
		document.getElementById('id-comment-input-enabled').style.visibility='hidden';
		document.getElementById('id-comment-input-enabled').style.display='none';
	}

	function addContent(idName,contentAdded){
		var doc=document.getElementById(idName);
		var originalText=doc.innerHTML;
		doc.innerHTML=originalText+contentAdded;	
	}

	function addTopic(){addContent('twitter-content','##');}

	function atSomeone(){addContent('twitter-content','@');}
</script>

<?php
require("includes/footer.php");
?>