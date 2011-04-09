<div id="main">
	<!--判断是否登录显示消息输入框-->
	<?php 
	  if ($_SESSION['login']) {
	?>
	    <div id="post">
	      <form name="post" action="action.php?act=save" method="POST" enctype="multipart/form-data">
	    	  <span id="tip">你还可以输入<span id="input_count">140</span>个字</span>
	    	  <span id="sync" style="float:right;margin-top:-30px;">
            <?php 
              if (sync_option('ff')) { 
            ?>
                <label><input type="checkbox" name="sync[]" value="fanfou" checked="checked">饭否</label>
            <?php 
              } 
            ?>
            <?php 
              if (sync_option('dg')) { 
            ?>
                <label><input type="checkbox" name="sync[]" value="digu" checked="checked">嘀咕</label>
            <?php 
              } 
            ?>
            <?php 
              if (sync_option('sh')) { 
            ?>
                <label><input type="checkbox" name="sync[]" value="sohu" checked="checked">搜狐</label>
            <?php 
              } 
            ?>
            <?php 
              if (sync_option('lh')) { 
            ?>
                <label><input type="checkbox" name="sync[]" value="leihou" checked="checked">雷猴</label>
            <?php 
              } 
            ?>
            <?php 
              if (sync_option('tumblr')) { 
            ?>
                <label><input type="checkbox" name="sync[]" value="tumblr" checked="checked">TumBlr</label>
            <?php 
              } 
            ?>
            <?php 
              if (sync_option('sina')) { 
            ?>
                <label><input type="checkbox" name="sync[]" value="sina" checked="checked">新浪</label>
            <?php 
              } 
            ?>
            <?php 
              if (sync_option('qq')) { 
            ?>
                <label><input type="checkbox" name="sync[]" value="qq" checked="checked">腾讯</label>
            <?php 
              } 
            ?>
            <?php 
              if (sync_option('163')) { 
            ?>
                <label><input type="checkbox" name="sync[]" value="163" checked="checked">网易</label>
            <?php 
              } 
            ?>
	        </span>
	        <textarea name="entry" id="entry" rows="3" onkeydown="if(event.ctrlKey&&event.keyCode==13){document.getElementById('submit').click();return false};" onkeyup="cState()"></textarea>

	        <div  id="add_photo" onclick="$('#upload').slideToggle();">上传图片</div>
	        <label>
	        	<input type="hidden" name="MAX_FILE_SIZE" value="102400000">
	          <div id="upload" style="display:none;"><input type="file" name="image"></div>
	        </label>
	        <div id="add_music" onclick="$('#mp3').slideToggle();">添加音乐</div>
	        <div id="mp3" style="display:none;">
	        	<div>可添加歌曲名称或mp3地址,为确保歌曲的准确性，建议添加音乐URL</div>
	        	<input type="text" name="mp3" style="width:400px;">
	        </div>
	        <div id="add_video" onclick="$('#video').slideToggle();">添加视频</div>
	        <div id="video" style="display:none;">
	        	<div>请直接输入视频网站播放页链接地址<br>目前已支持<a href="http://youku.com" target="_blank">优酷网</a>,<a href="http://tudou.com" target="_blank">土豆网</a>,<a href="http://ku6.com" target="_blank">酷6网</a>,<a href="http://56.com" target="_blank">56网</a>等网站</div>
	        	<input type="text" name="video" style="width:400px;">
	        </div>
	        <input id="submit" class="formbutton" type="submit" value="发表">
	      </form>
	    </div>
	<?php
	  }
	?>
	<!--结束-->
	
	<!--显示日志-->
	<div id="entry">
		<ul class="entry">
			<!--按照时间读取最近消息-->
			<?php 
			  $entries = get_entry_by_page($perpage);
			  while ($entry = mysql_fetch_object($entries)) {
			?>
			    <li id="entry_id_<?php echo $entry -> id; ?>">
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
			        	$url = MF_URL;
			        }
			        $content = search_key($entry -> content);
			        $img = $entry -> img;
			        $mp3 = $entry -> mp3;
			        $video = $entry -> video;
			      ?>
			      <!--结束-->
			      <div id="entry_id_<?php echo $entry -> id; ?>" onmouseover="document.getElementById('entry_id_<?php echo $entry -> id; ?>').addClass('light');return false;" onmouseout="document.getElementById('entry_id_<?php echo $entry -> id; ?>').removeClass('light');return false;">
			      	<span class="avatar"><img src="<?php echo getavatar($email); ?>" alt="<?php echo $nickname; ?>"></span>
			      	<span class="top"></span>
			      	<span class="middle">
			      	  <span class="nickname"><a href="<?php echo http($url); ?>" alt="<?php echo $nickname; ?>"><?php echo $nickname; ?></a></span>
			      	  <span class="content">
			      	  	<?php echo nl2br($content); 
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
			      	  	<?php } 
			      	  	      if ($video !="") { 
			      	  	      	echo video($video);
			      	  	      }
			      	  	?>      	
			      	  </span>
			      	</span>
			      	<span class="bottom" id="<?php echo $entry -> id; ?>">
			      		<span class="info">
			      		  <span class="time"><a href="index.php?page=view&id=<?php echo $entry -> id; ?>" target=""><?php echo time_past($entry -> time); ?></a></span>
			      		  <span class="from">通过<?php echo $entry -> from; ?></span>
			      		</span>
			      		<span class="todo">
			      			<span class="reply"><a href="#" onmouseover="$('#entry_id_<?php echo $entry -> id; ?>').addClass('solid_bottom');return false;" onmouseout="$('#entry_id_<?php echo $entry -> id; ?>').removeClass('solid_bottom');return false;" onclick="$('#reply_post_<?php echo $entry -> id; ?>').slideToggle();return false;">[回]</a></span>
			      			<?php if ($_SESSION['login'] AND $authorid == $entry -> userid) { echo '<span class="del"><a href="action.php?act=del&id=' . $entry -> id . '" alt="">[删]</a></span>'; } ?>
			      		</span>
			      	</span>
			      </div>
			      <div class="reply_post" id="reply_post_<?php echo $entry -> id; ?>" style="display:none;">
			        <form name="reply_post_<?php echo $entry -> id; ?>" action="action.php?act=post" method="POST">
			        	<input type="hidden" name="reply_id" value="<?php echo $entry -> id; ?>">
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
			        	<textarea name="content" id="content" onkeydown="if(event.ctrlKey&&event.keyCode==13){document.getElementById('reply_submit_<?php echo $entry -> id; ?>').click();return false};"></textarea>
			        	<input id="reply_submit_<?php echo $entry -> id; ?>" class="reply_submit" type="submit" value="回复(Ctrl+Enter)">
			        </form>	
			      </div>
			    </li>
			<?php
			  }
			?>
			<!--结束-->
		</ul>
	</div>
	<div class="pages">
	  <?php pages($perpage); ?>
	  <span class="pagesone"><input type="text" size="3" onkeydown="javascript: if(event.keyCode==13){var page=(this.value&gt;20) ? 20 : this.value;  location='index.php?page='+page+''; return false;}"><button onclick="javascript: var page=(this.previousSibling.value&gt;20) ? 20 : this.previousSibling.value;  location='index.php?page='+page+''; return false;">Go</button></span>
	</div>
</div>