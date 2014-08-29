<?php

function setUser(){

}

if($_POST['eLogin']=='eLogin'){

  $email=testInput($_POST['elEmail']);
  $password=testInput($_POST['elPassword']);

  if(strlen($email)==0 || strlen($password)==0){
    echo '邮箱或密码不能为空';
  }else{
    $logUser=$accEx->loginIn($email,$password);
    if(!$logUser){
      echo '登录失败';
    }else{
      $_SESSION['username']=$name;
      $_SESSION['useremail']=$email;
      $_SESSION['userid']=$logUser->getUid();
      header('Location:index.php');
    }
  }

}

if($_POST['eReg']=='eReg'){

  $email=testInput($_POST['eEmail']);
  $name=testInput($_POST['eName']);
  $password=testInput($_POST['ePassword']);

  if(strlen($email)==0 || strlen($name)==0 || strlen($password)==0){
    echo '邮箱,名字或密码不能为空';
  }else{
    $regResult=$accEx->regExplore($email,$name,$password);
    if(!$regResult){
      echo '注册失败';
    }elseif($regResult===-1){
      echo '名字重复';
    }elseif($regResult===-2){
      echo '邮箱重复';
    }else{
      //配置SESSION,用户登录记录
      $_SESSION['username']=$name;
      $_SESSION['useremail']=$email;
      $_SESSION['userid']=$pdo->lastInsertId()+4;
      header('Location:index.php');
    }
  }

}

?>


   <content>
   	<div class="front-welcome">
   		<div class="hero-title">
        	<h1 class="hero-site"><a href="">Explore</a></h1>
        	<h2 class="hero-tagline">
        	探索,通过不同的视角观看世界
        	</h2>
   		</div>
   		<div class="hero-join">

   			<div class="panel panel-default" id="welcome-form">
  				<div class="panel-body">
          <form method="post" action="index.php">
  					<div class="form-group">
    					<input type="email" name="elEmail" class="form-control" id="exampleInputEmail1" placeholder="请输入邮箱帐号">
  					</div>
  					<div class="form-group">
    					<input type="password" name="elPassword" class="form-control" id="exampleInputPassword1" placeholder="请输入密码">
  					</div>
  					<button type="submit" name="eLogin" value="eLogin" class="btn btn-default">登录</button>
       				 	<label>
       				 	<input type="checkbox"> 
       				 	<span class="help-block-personal">记住我</span>
       				 	</label>
            <span><a href="">忘记密码?</a></span>
          </form>
  				</div>
			</div>

   			<div class="panel panel-default" id="welcome-form">
  				<div class="panel-heading" id="heading-color">
    				<h3 class="panel-title">新来探索?注册</h3>
  				</div>
  				<div class="panel-body">
          <form method="post" action="index.php">
  					<div class="form-group">
    					<input type="text" name="eName" class="form-control" placeholder="请输入姓名">
  					</div>
  					<div class="form-group">
    					<input type="email" name="eEmail" class="form-control" id="exampleInputEmail1" placeholder="请输入邮箱">
  					</div>
  					<div class="form-group">
    					<input type="password" name="ePassword" class="form-control" id="exampleInputPassword1" placeholder="请输入密码">
  					</div>
  					<button type="submit" value="eReg" name="eReg" class="btn btn-info">注册</button>
  					<span class="help-block-personal">注册后我们会发送一封确认邮件</span>
  				</form>
          </div>
  				</div>
			</div>

   		</div>   		
   	</div>
   </content>

