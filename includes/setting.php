<?php

//载入个人信息
$logUser=new userProfile($pdo);
$usercls=$logUser->loadProfile($_SESSION['uid']);

//载入我的收藏
$collections=new collectionCls($pdo);

//修改资料
if($_POST['saveProfile']=='saveProfile'){

	$wholeName=testInput($_POST['wholeName']);
	$location=testInput($_POST['location']);
	$sex=testInput($_POST['sex']);
	$intro=testInput($_POST['intro']);
	$nowPlace=testInput($_POST['nowPlace']);
	$place=testInput($_POST['place']);
	$detailIntro=testInput($_POST['detailIntro']);

	$wholeProfile=array(
		'全名'=>$wholeName,
		'地点'=>$location,
		'性别'=>$sex,
		'一句话介绍'=>$intro,
		'现在在哪'=>$nowPlace,
		'去过多少地方'=>$place,
		'详细介绍'=>$detailIntro);

	$flag=0;//记录用户资料填写的是否合格,小于0为不合格

	foreach ($wholeProfile as $key => $value) {
		if(strlen($value)==0){
			echo $key."不能为空";
			$flag=$flag-1;
		}
	}

	if($flag>=0){
		$editResult=$logUser->editProfile($_SESSION['uid'],$wholeProfile);
		if(!$editResult){
			echo '修改失败';
		}else{
			echo '修改成功';
		}
	}

}

?>

<div class="user-card">
	<div class="user-setting-left">

		<div class="setting-user-card">
			<div class="setting-change-ptoto">
				<div class="lib-card-heading">图片</div>
				<div class="setting-face">
					<span class="setting-face-background-title">头像</span>					
					<img src="user/ivydom/photo.jpg" alt="ivydom" width="70" height="70" class="img-rounded">
  					<div class="btn-group">
    					<button type="button" class="btn btn-default">更换头像</button>
  					</div>
  					<span class="setting-help-block">您的个人象征</span>
				</div>
				<div class="setting-background">
					<span class="setting-face-background-title">背景</span>					
					<img src="user/ivydom/background.jpg" alt="ivydom" width="70" height="70" class="img-rounded">
  					<div class="btn-group">
    					<button type="button" class="btn btn-default">更换背景</button>
  					</div>
  					<span class="setting-help-block">.jpg|.png|.bmp</span>		
				</div>
			</div>
		</div>

		<div class="setting-user-card">
			<div class="setting-email">
				<div class="lib-card-heading">目前邮箱:<?php echo $usercls->getEmail(); ?></div>
				<div class="input-group">
					<input type="text" class="form-control" placeholder="请输入新邮箱">
    			</div>
    			<div class="setting-card-footer-email">
    				<button type="button" class="btn btn-info">保存更改</button>
				</div>
			</div>
		</div>

		<div class="setting-user-card">
			<div class="setting-password">
				<div class="lib-card-heading">更改密码</div>
				<div class="input-group">
					<input type="password" class="form-control" placeholder="请输入原密码">
    			</div>
    			<span class="help-block"></span>
    			<div class="input-group">
					<input type="password" class="form-control" placeholder="请输入新密码">
    			</div>
    			<span class="help-block"></span>
    			<div class="input-group">
					<input type="password" class="form-control" placeholder="请确认新密码">
    			</div>
    			<span class="help-block">更改密码后需要重新登录</span>
				<div class="setting-card-footer-password">
    				<button type="button" class="btn btn-info">保存更改</button>
				</div>
			</div>
		</div>

	</div>
	<div class="user-setting-right">

		<div class="setting-user-card">
			<div class="setting-profile">
				<div class="lib-card-heading">基本资料</div>
				<form action="column.php?column=setting" method="post">
				<div class="input-group">
					<input type="text" name="wholeName" class="form-control" value="<?php echo $usercls->getName(); ?>" placeholder="全名">
    			</div>
    			<span class="help-block">全名,可以随便取</span>
   				<div class="input-group">
					<input type="text" name="location" class="form-control" value="<?php echo $usercls->getLocation(); ?>" placeholder="地点">
    			</div>
    			<span class="help-block">地点,比如"中二之峰学院"</span>
    			<div class="input-group">
					<input type="text" name="sex" class="form-control" value="<?php echo $usercls->getSex(); ?>" placeholder="性别">
    			</div>
    			<span class="help-block">性别,人妖,变性人,futa,我们都可以接受</span>
				<div class="input-group">
					<input type="text" name="intro" class="form-control" value="<?php echo $usercls->getIntro(); ?>" placeholder="一句话名片">
    			</div>
    			<span class="help-block">一句话介绍,比如,专注拾荒三十年,限15个字</span>
				<div class="input-group">
					<input type="text" name="nowPlace" class="form-control" value="<?php echo $usercls->getNowPlace(); ?>" placeholder="目前在什么地方">
    			</div>
    			<span class="help-block">现在所在的地方,比如"火星"</span>
				<textarea class="form-control" id="twitter-content" name="place" rows="2" onkeyup="alterBtnStatus()" required><?php echo $usercls->getPlace(); ?></textarea>
    			<span class="help-block">你去过多少地方?用英文逗号分割.</span>
				<textarea class="form-control" id="twitter-content" name="detailIntro" rows="2" onkeyup="alterBtnStatus()" required><?php echo $usercls->getDetailIntro(); ?></textarea>
				<span class="help-block">160个字的个人介绍</span>
				<div class="setting-card-footer">
    				<button type="submit" name="saveProfile" value="saveProfile" class="btn btn-default">保存更改</button>
				</div>
				</form>
			</div>
		</div>

		<div class="setting-user-card">
			<div class="setting-notification">
				<div class="lib-card-heading">消息通知</div>
				<div class="setting-notification-checkbox">
					<label class="checkbox">
  						<input type="checkbox" id="inlineCheckbox1" value="option1"> 有人关注我
					</label>
					<label class="checkbox">
  						<input type="checkbox" id="inlineCheckbox1" value="option1"> 有人提到我
					</label>
					<label class="checkbox">
  						<input type="checkbox" id="inlineCheckbox1" value="option1"> 有人赞了我的分享
					</label>
					<label class="checkbox">
  						<input type="checkbox" id="inlineCheckbox1" value="option1"> 有人评论了我的分享
					</label>
					<label class="checkbox">
  						<input type="checkbox" id="inlineCheckbox1" value="option1"> 我不接受任何消息
					</label>
				</div>
				<div class="setting-card-footer-notification">
    				<button type="button" class="btn btn-default">保存更改</button>
				</div>
			</div>
		</div>

	</div>

	<div class="setting-card-user-mid">
		<div class="lib-card-heading">欢迎 <a href=""><?php echo $usercls->getName(); ?></a></div>
		<div class="setting-card-user-welcome-content">
			<ul>
			 	<a href=""><li><span class="glyphicon glyphicon-heart"></span> 我的收藏(0)</li></a>
			 	<a href=""><li><span class="glyphicon glyphicon-pencil"></span> 邀请朋友来探索</li></a>
			 	<a href=""><li><span class="glyphicon glyphicon-file"></span> 我的草稿(0)</li></a>
			</ul>
		</div>
	</div>
	
</div>
