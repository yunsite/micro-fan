<?php require_once 'common.php'; ?>
<html>
	<head>
		<title><?php echo MF_NAME; ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
	<body>
		<div id="main">
			<?php
  	  $entry = sql_query('SELECT * FROM ' . DB_PREFIX . 'entry WHERE id ="' . $_GET['id'] . '"');
  	  $entry = mysql_fetch_object($entry);
			$userid = $entry -> userid;
			if ($userid == 0) { 
			  $nickname = $entry -> nickname;
			} else {
			  $user = sql_query('SELECT * FROM ' . DB_PREFIX . 'user WHERE administrator ="' . $userid . '"');
			  $user = mysql_fetch_object($user);
			  $nickname = $user -> nickname;
			}
      ?>				      
			      <div id="reply_post_<?php echo $_GET['id']; ?>">
			        <form action="/action.php?act=post" method="POST">
			        	<?php 
			        	  echo '<p>对' . $nickname . '进行回复</p>';
			        	  if (!$_SESSION['login']) { 
			        	?>
			        	    <p>昵称:<input type="text" name="nickname" value="<?php echo $_COOKIE['nickname']; ?>"></p>
			        	    <p>邮箱:<input type="text" name="email" value="<?php echo $_COOKIE['email']; ?>"></p>
			        	    <p>网址:<input type="text" name="url" value="<?php echo $_COOKIE['url']; ?>"></p>
			        	<?php 
			        	  }
			        	?>
			        	<textarea name="content" style="width:100%;"></textarea>
			        	<input type="hidden" name="reply_id" value="<?php echo $_GET['id']; ?>">
			        	    <input type="hidden" name="type" value="m">
			        	<input type="submit" value="回复">
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