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
    <script src="../js/verify.js"></script>

  </head>
  <body>

  <menu>
   <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php">
        <img alt="Explore" src="img/logo.png" width="25" height="25"> 探索</a>
    </div>

<?php
if(!empty($_SESSION)){
  $logUser=new userProfile($pdo);
  $usercls=$logUser->loadProfile($_SESSION['uid']);
?>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li <?php if($pageTitle=="探索") echo 'class="active"'; ?>><a href="index.php">主页</a></li>
        <li <?php if($pageTitle=="发现 - 探索") echo 'class="active"'; ?>><a href="column.php?column=explore">发现</a></li>
        <li <?php if($pageTitle=="热门地区 - 探索") echo 'class="active"'; ?>><a href="column.php?column=hotaeras">热门地方</a></li>
      </ul>      
      <ul class="nav navbar-nav" id="head-menu-right">
        <li <?php if($logUser->userIsExist($usercls->getName())){echo 'class="active"';} ?>><a href="people.php?people=<?php echo $usercls->getName(); ?>">个人中心</a></li>
        <li <?php if($pageTitle=="设置 - 探索") echo 'class="active"'; ?>><a href="column.php?column=setting">设置</a></li>
        <li <?php if($pageTitle=="消息通知 - 探索") echo 'class="active"'; ?>><a href="column.php?column=notifications">消息</a></li>
        <li ><a href="logout.php">退出</a></li>
      </ul>
    </div>
<?php
}
?>
     </div>
   </nav>
  </menu>