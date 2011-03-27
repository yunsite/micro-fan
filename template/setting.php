<div id="main" class="setting">
<form action="action.php?act=update" method="POST">
	<h2>资料管理</h2>
	<span class="avatar"><img src="<?php echo getavatar($email); ?>"></span>
	<label>昵称:<input type="text" name="nickname" value="<?php echo $nickname; ?>"></label>
	<label>邮箱:<input type="text" name="email" value="<?php echo $email; ?>">(头像使用Gravatar服务，详情见:<a href="http://www.iplaysoft.com/gravatar.html" target="_blank">Gravatar</a>)</label>
	<input type="hidden" name="userid" value="<?php echo $userid; ?>">
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
	<label>
  <?php 
	  if ($sina['id'] != "") {
	?>
	    已经绑定新浪微博账号: &nbsp; <a href="http://t.sina.com.cn/" target="_blank"><?php echo $sina['id']; ?></a> | <a href="action.php?act=del_oauth&mb=sina">取消授权</a>
  <?php } else { ?>
	    <a href="<?php echo $sina_aurl; ?>"><div id="mb" class="sina">授权新浪微博</div></a>
  <?php } ?></label>
  <label><?php 
	  if ($tecent['id'] != "") {
	?>
	    已经绑定腾讯微博账号: &nbsp; <a href="http://t.qq.com/" target="_blank"><?php echo $tecent['id']; ?></a> | <a href="action.php?act=del_oauth&mb=tecent">取消授权</a>
  <?php } else { ?>
	    <a href="<?php echo $tecent_aurl; ?>"><div id="mb" class="qq">授权腾讯微博</div></a>
  <?php } ?></label>
  <label>
  <?php
	  if ($wangyi['id'] != "") {
	?>
	    已经绑定网易微博账号: &nbsp; <a href="http://t.163.com/" target="_blank"><?php echo $wangyi['id']; ?></a> | <a href="action.php?act=del_oauth&mb=wangyi">取消授权</a>
  <?php } else { ?>
	    <a href="<?php echo $wangyi_aurl; ?>"><div id="mb" class="wangyi">授权网易微博</div></a>
  <?php } ?></label>
</form>
</div>