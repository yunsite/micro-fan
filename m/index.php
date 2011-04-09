<?php require_once 'common.php'; ?>
<html>
	<head>
		<title><?php echo MF_NAME; ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	</head>
	<body>
		<div id="main">
	    <!--判断是否登录显示消息输入框-->
	    <?php 
	      if ($_SESSION['login']) {
	    ?>
	        <div id="post">
	          <form name="post" action="/action.php?act=save&type=m" method="POST">
	    	      <span id="tip">你在做什么？</span>
	            <p><input name="entry" id="entry" style="width:100%;"></p>	        
	            <label><input type="checkbox" name="sync[]" value="fanfou" checked="checked">饭</label>
	            <label><input type="checkbox" name="sync[]" value="sina" checked="checked">新</label>
	            <label><input type="checkbox" name="sync[]" value="digu" checked="checked">嘀</label>
	            <label><input type="checkbox" name="sync[]" value="qq">腾</label>
	            <label><input type="checkbox" name="sync[]" value="wangyi" checked="checked">易</label>
	            <input type="hidden" name="MAX_FILE_SIZE" value="102400000"><input type="file" name="image">
	            <p><input class="formbutton"type="submit" value="发表"></p>
	            <input type="hidden" name="type" value="m">
	          </form>
	        </div>
	    <?php
	      }
	    ?>
	    <!--结束-->
	    <h2><strong>最新消息</strong>(<a href="/m/index.php">刷新</a>)</h2>
	    <!--显示日志-->
	    <div id="entry">
			  <!--按照时间读取最近消息-->
			  <?php 
			    $entries = get_entry_by_page($perpage);
			    while ($entry = mysql_fetch_object($entries)) {
			  ?>
			      <p class="entry_id_<?php echo $entry -> id; ?>">
			    	  <!--判断消息类型-->
			        <?php 
			          if ($entry -> userid == 0) { 
			          	$nickname = $entry -> nickname;
			          	$email = $entry -> email;
			           	$url = $entry -> url;
			          } else {
			          	$userid = sql_query('SELECT * FROM ' . DB_PREFIX . 'entry WHERE id ="' . $entry -> id . '"');
			          	$userid = mysql_fetch_object($userid);
			           	$userid = $userid -> userid;
			          	$user = sql_query('SELECT * FROM ' . DB_PREFIX . 'user WHERE administrator ="' . $userid . '"');
			          	$user = mysql_fetch_object($user);
			          	$nickname = $user -> nickname;
			          	$email = $user -> mail;
			          	$url = $fan_url;
			          }
			        ?>
			        <!--结束-->
			        <span id="entry_id_<?php echo $entry -> id; ?>">
			      	  <span class="nickname"><a href="index.php?page=author&name=<?php echo $nickname; ?>" alt="<?php echo $nickname; ?>"><?php echo $nickname; ?></a></span>
			      	  <span class="content"><?php echo nl2br(search_key($entry -> content)); ?></span>
			      		<span class="info">
			      		  <span class="time"><?php echo time_past($entry -> time); ?></span>
			      		  <span class="from">通过<?php echo $entry -> from; ?></span>
			      		</span>
			      		<span class="todo">
			      			<span class="reply"><a href="reply.php?id=<?php echo $entry -> id; ?>">回复</a></span>
			      			<?php if ($_SESSION['login']) { echo '<span class="del"><a href="/action.php?act=del&type=m&id=' . $entry -> id . '" alt="">删除</a></span>'; } ?>
			      		</span>
			        </span>
			      </p>
			  <?php
			    }
			  ?>
			  <!--结束-->
    	</div>
	    <div id="page navi">
	      <?php pages($perpage); ?>
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