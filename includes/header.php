<!DOCTYPE html>
<html lang="zh-cn">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $pageTitle; ?></title>

    <!-- Bootstrap -->
    <link href="http://cdn.bootcss.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/style.css">

  </head>
  <body>

  <menu>
   <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">
        <img alt="Explore" src="img/logo.png" width="25" height="25"> 探索</a>
    </div>

<?php
if(!$islogin){
?>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">主页</a></li>
        <li><a href="#">发现</a></li>
        <li><a href="#">热门地方</a></li>
        <li><a href="#">找人</a></li>
      </ul>      
      <ul class="nav navbar-nav" id="head-menu-right">
        <li><a href="#">个人中心</a></li>
        <li><a href="#">设置</a></li>
        <li><a href="#">消息</a></li>
        <li><a href="#">退出</a></li>
      </ul>
    </div>
<?php
}
?>
     </div>
   </nav>
  </menu>