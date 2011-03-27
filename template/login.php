<div id="main">
	<form action="action.php?act=login" method="POST" id="login">
	  <label>用户名:<input type="text" name="user" value="<?php echo $_COOKIE['login_user']; ?>"></label>
	  <label>密&nbsp;&nbsp;码:<input type="password" name="password" value="<?php echo $_COOKIE['login_password']; ?>"><label>
	  <input id="submit" type="submit" value="提交">
  </form>
</div>