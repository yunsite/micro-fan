<?php require_once 'common.php'; ?>
<html>
	<head>
		<title><?php echo MF_NAME; ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
	<body>
		<div id="main">
			<!--获取用户数据-->
<?php
  $user = sql_query('SELECT * FROM ' . DB_PREFIX . 'user WHERE username ="' . $_COOKIE['login_user'] . '"');
  $user = mysql_fetch_object($user);
  $userid = $user -> administrator;
  $nickname = $user -> nickname;
  $email = $user -> mail;
?>
<!--结束-->
<form action="/action.php?act=update" method="POST">
	<p>昵称:<input type="text" name="nickname" value="<?php echo $nickname; ?>"></p>
	<p>邮箱:<input type="text" name="email" value="<?php echo $email; ?>"></p>
	<input type="hidden" name="userid" value="<?php echo $userid; ?>">
	<input type="hidden" name="type" value="m">
	<input type="submit" value="更新">
</form>
			      </div>
    </div>
	  <div id="menu">
		  <p class="s">
          0<a href="/m/index.php" accesskey="0">首页</a>
          <?php if($_SESSION['login']) {?>
          1<a href="/m/setting.php" accesskey="1">管理</a>
          2<a href="/action.php?act=logout&type=m" accesskey="2">退出</a>
          <?php } else { ?>
          1<a href="/m/login.php" accesskey="1">登录</a>
          <?php } ?>
      </p>
	  </div>
    <div id="footer">&copy; 2011 <?php echo MF_NAME; ?></div>
	</body>
</html>