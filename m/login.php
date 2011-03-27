<?php require_once 'common.php'; ?>
<html>
	<head>
		<title><?php echo MF_NAME; ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
	<body>
		<div id="main">
			<form action="/action.php?act=login" method="POST">
	      用户名:<input type="text" name="user" value="<?php echo $_COOKIE['login_user']; ?>">
	      密  码:<input type="password" name="password" value="<?php echo $_COOKIE['login_password']; ?>">
	      <input type="hidden" name="type" value="m">
	      <input type="submit" value="提交">
      </form>
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