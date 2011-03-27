<div id="main" class="view">		     
			      <div id="entry_id_<?php echo $_GET['id']; ?>">
			      	<span class="avatar"><img src="<?php echo getavatar($email); ?>" alt="<?php echo $nickname; ?>"></span>
			      	<span class="top"></span>
			      	<span class="middle">
			      	  <span class="nickname"><a href="<?php echo http($url); ?>" alt="<?php echo $nickname; ?>"><?php echo $nickname; ?></a></span>
			      	  	<?php echo formaturl(nl2br($content)); 
			      	  	      if ($mp3 !="") { ?>
			      	  	      	<object type="application/x-shockwave-flash" data="http://public.1g1g.com/miniplayer/miniPlayer.swf" width="200" height="24" id="1gMiniPlayer">
                            <param name="movie" value="miniPlayer.swf" />
                            <param name="allowScriptAccess" value="always" />
                            <param name="FlashVars" value="play=<?php echo urlencode($mp3); ?>&isAutoPlay=false" />
                            <param name="wmode" value ="transparent" />
                          </object>
                  <?php }
			      	  	      if ($img != "") { ?>
			      	  	        <div class="picture">
			      	  		        <a href="<?php echo $img; ?>" alt="" class="lightbox"><img src="<?php echo $img; ?>" alt="" width="40%" /></a>
			      	  	        </div>
			      	  	<?php } ?>
			      	  </span>
			      	<span class="bottom">
			      		<span class="info">
			      		  <span class="time"><a href="index.php?page=view&id=<?php echo $entry -> id; ?>" target=""><?php echo time_past($entry -> time); ?></a></span>
			      		  <span class="from"><?php echo $entry -> from; ?></span>
			      		</span>
			      		<span class="todo">
			      			<span class="reply"><a href="#" onclick="$('#reply_post_<?php echo $entry -> id; ?>').slideToggle();return false;">[回]</a></span>
			      			<?php if ($_SESSION['login']) { echo '<span class="del"><a href="action.php?act=del" alt="">[删]</a></span>'; } ?>
			      		</span>
			      		<span class="enjoy">
 <a href="javascript:void(0)" onclick="postToWb();" style="height:16px;font-size:12px;line-height:16px;"><img src="http://v.t.qq.com/share/images/s/weiboicon16.png" alt="转播到腾讯微博" align="absmiddle"/></a>
<script type="text/javascript">
	function postToWb(){
		var _t = encodeURI($('#content').text());
		var _url = encodeURIComponent(document.location);
		var _appkey = encodeURI("064a2f5a7fac499f82a17a50fc63800d");//你从腾讯获得的appkey
		var _pic = encodeURI('');//（例如：var _pic='图片url1|图片url2|图片url3....）
		var _site = 'http://microfan.sinaapp.com';//你的网站地址
		var _u = 'http://v.t.qq.com/share/share.php?url='+_url+'&appkey='+_appkey+'&site='+_site+'&pic='+_pic+'&title='+_t;
		window.open( _u,'', 'width=700, height=680, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, location=yes, resizable=no, status=no' );
	}
</script>


			      		</span>
			      	</span>
			      </div>
			      <div id="reply_post_<?php echo $entry -> id; ?>" class="reply_post" style="display:none;">
			        <form action="action.php?act=post" method="POST">
			        	<?php 
			        	  echo '<span>对' . $nickname . '进行回复</span>';
			        	  if (!$_SESSION['login']) { 
			        	?>
			        	    <label>昵称:<input type="text" name="nickname" value="<?php echo $_COOKIE['nickname']; ?>"></label>
			        	    <label>邮箱:<input type="text" name="email" value="<?php echo $_COOKIE['email']; ?>"></label>
			        	    <label>网址:<input type="text" name="url" value="<?php echo $_COOKIE['url']; ?>"></label>
			        	<?php 
			        	  }
			        	?>
			        	<textarea name="content" id="content" onkeydown="if(event.ctrlKey&&event.keyCode==13){document.getElementById('submit').click();return false};"></textarea>
			        	<input type="hidden" name="reid" value="<?php echo $entry -> id; ?>">
			        	<input id="submit" type="submit" value="回复(Ctrl+Enter)">
			        </form>	
			      </div>
</div>
<style type="text/css">
	#footer {display:none;}
</style>