<div id="main" class="setting">
<form action="action.php?act=update" method="POST" enctype="multipart/form-data">
	<h2>资料管理</h2>
	<span class="avatar"><img src="<?php echo getavatar($email); ?>"></span>
	<label>昵称:<input type="text" name="nickname" value="<?php echo $nickname; ?>"></label>
	<label>邮箱:<input type="text" name="email" value="<?php echo $email; ?>">(头像使用Gravatar服务，详情见:<a href="http://www.iplaysoft.com/gravatar.html" target="_blank">Gravatar</a>)</label>
	<input type="hidden" name="userid" value="<?php echo $userid; ?>">
	<input id="submit" type="submit" value="更新">
	<h2>模板设置</h2>
	<input type="hidden" name="MAX_FILE_SIZE" value="102400000">
	<label>更换背景:<input type="file" name="background"></label>
	<input id="submit" type="submit" value="更新">
	<h2>Web服务管理</h2>
	<label>虾米 ID:<input type="text" name="xiami" value="<?php echo $xiami; ?>"></label>
	<label>豆瓣账号:<input type="text" name="douban" value="<?php echo $douban; ?>"></label>
  <label>Flickr ID:<input type="text" name="photo" value="<?php echo $photo; ?>">(请到<a href="http://idgettr.com/" alt="" target="_blank">IDGettr</a>查找你账号的对应ID)</label>
	<input id="submit" type="submit" value="更新">
	<h2>密码修改</h2>
	<label>原密码:<input type="password" name="psw_ever"></label>
	<label>新密码:<input type="password" name="psw_new"></label>
	<label>再输入:<input type="password" name="psw_new_again"></label>
	<input id="submit" type="submit" value="更新">
	<h2>微博账号管理</h2>
	<label>饭否账号:<input type="text" name="f_name" value="<?php echo $microblog['ff']['name']; ?>">密码:<input type="password" name="f_pass" value="<?php echo $microblog['ff']['pass']; ?>"></label>
	<label>嘀咕账号:<input type="text" name="d_name" value="<?php echo $microblog['dg']['name']; ?>">密码:<input type="password" name="d_pass" value="<?php echo $microblog['dg']['pass']; ?>"></label>
	<label>搜狐账号:<input type="text" name="sh_name" value="<?php echo $microblog['sh']['name']; ?>">密码:<input type="password" name="sh_pass" value="<?php echo $microblog['sh']['pass']; ?>"></label>
	<label>雷猴账号:<input type="text" name="lh_name" value="<?php echo $microblog['lh']['name']; ?>">密码:<input type="password" name="lh_pass" value="<?php echo $microblog['lh']['pass']; ?>"></label>
	<label>tumblr账号:<input type="text" name="tumblr_name" value="<?php echo $microblog['tumblr']['name']; ?>">密码:<input type="password" name="tumblr_pass" value="<?php echo $microblog['tumblr']['pass']; ?>"></label>
	<input id="submit" type="submit" value="更新">
	<p>(由于以上微博的认证方式有所不同，程序会记录您的用户名和密码。如果不放心，请不要绑定。)</p>
	<label>
  <?php 
	  if ($microblog['sina']['id'] != "") {
	?>
	    已经绑定新浪微博账号: &nbsp; <a href="http://t.sina.com.cn/" target="_blank"><?php echo $microblog['sina']['id']; ?></a> | <a href="action.php?act=del_oauth&mb=sina">取消授权</a>
  <?php } else { ?>
	    <a href="<?php echo $sina_aurl; ?>"><div id="mb" class="sina">授权新浪微博</div></a>
  <?php } ?></label>
  <label><?php 
	  if ($microblog['qq']['id'] != "") {
	?>
	    已经绑定腾讯微博账号: &nbsp; <a href="http://t.qq.com/" target="_blank"><?php echo $microblog['qq']['id']; ?></a> | <a href="action.php?act=del_oauth&mb=qq">取消授权</a>
  <?php } else { ?>
	    <a href="<?php echo $tecent_aurl; ?>"><div id="mb" class="qq">授权腾讯微博</div></a>
  <?php } ?></label>
  <label>
  <?php
	  if ($microblog['163']['id'] != "") {
	?>
	    已经绑定网易微博账号: &nbsp; <a href="http://t.163.com/" target="_blank"><?php echo $microblog['163']['id']; ?></a> | <a href="action.php?act=del_oauth&mb=163">取消授权</a>
  <?php } else { ?>
	    <a href="<?php echo $wangyi_aurl; ?>"><div id="mb" class="wangyi">授权网易微博</div></a>
  <?php } ?></label>
</form>
</div>