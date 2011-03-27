<div id="main">
	<!--显示日志-->
	<div id="entry">
		<ul class="entry">
			<!--按照时间读取最近消息-->
			<?php 
			  while ($entry = mysql_fetch_object($entries)) {
			?>
			    <li id="entry_id_<?php echo $entry -> id; ?>">
			    	<!--判断消息类型-->
			      <?php
			        $content = search_key($content); 
			        foreach ($keywords AS $keyword) {
			          $content = str_replace($keyword,'<span class="red">' . $keyword . '</span>' ,$entry -> content);	
			        }
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
			      ?>
			      <!--结束-->
			      <div id="entry_id_<?php echo $entry -> id; ?>" onmouseover="document.getElementById('entry_id_<?php echo $entry -> id; ?>').addClass('light');return false;" onmouseout="document.getElementById('entry_id_<?php echo $entry -> id; ?>').removeClass('light');return false;">
			      	<span class="avatar"><img src="<?php echo getavatar($email); ?>" alt="<?php echo $nickname; ?>"></span>
			      	<span class="top"></span>
			      	<span class="middle">
			      	  <span class="nickname"><a href="<?php echo http($url); ?>" alt="<?php echo $nickname; ?>"><?php echo $nickname; ?></a></span>
			      	  <span class="content"><?php echo formaturl(nl2br($content)); ?></span>
			      	</span>
			      	<span class="bottom" id="<?php echo $entry -> id; ?>">
			      		<span class="info">
			      		  <span class="time"><a href="index.php?page=view&id=<?php echo $entry -> id; ?>" target=""><?php echo time_past($entry -> time); ?></a></span>
			      		  <span class="from">通过<?php echo $entry -> from; ?></span>
			      		</span>
			      		<span class="todo">
			      			<span class="reply"><a href="#" onmouseover="$('#entry_id_<?php echo $entry -> id; ?>').addClass('solid_bottom');return false;" onmouseout="$('#entry_id_<?php echo $entry -> id; ?>').removeClass('solid_bottom');return false;" onclick="$('#reply_post_<?php echo $entry -> id; ?>').slideToggle();return false;">[回]</a></span>
			      			<?php if ($_SESSION['login']) { echo '<span class="del"><a href="action.php?act=del&id=' . $entry -> id . '" alt="">[删]</a></span>'; } ?>
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
			        	<textarea name="content" id="content" onkeydown="if(event.ctrlKey&&event.keyCode==13){document.getElementById('submit').click();return false};"></textarea>
			        	<input id="submit" type="submit" value="回复(Ctrl+Enter)">
			        </form>	
			      </div>
			    </li>
			<?php
			  $total++;
			  }
			function search_pages($total,$perpage) {
			$count = $total;
      if ($count%$perpage == 0) {
        $page['total'] = intval($count/$perpage);	
      } else {
        $page['total'] = intval($count/$perpage) + 1;	
      }//获取总页数
      if ($_GET['p'] == "") $_GET['p'] = 1;
      $page_class = 'page';
      $page['current'] = $_GET['p'];
      if ($page['current'] <= 4) {
      	$i = 1;
      } else {
      	$i = $page['current'] - 3;
      }
      $max = $page['current'] + 4;
      if ($max > $page['total']) {
        $max = $page['total'];	
      }
      if ($page['current'] != 1) {
        echo '<a href="index.php?page=search&q=' . $key . '&p=1">&laquo;</a>';		
      }
      for($i;$i <= $max;$i++) {
      	if ($i == $page['current']) {
      	  echo '<b>' . $i . '</b>';	
      	} else {
      	  echo '<a href="index.php?page=search&q=' . $key . '&p=' . $i . '">' . $i . '</a>';
        }
      }
      if ($page['current'] != $page['total'] ) {
        echo '<a href="index.php?page=search&q=' . $key . '&p=' . $page['total'] . '">&raquo;</a>';	
      }
      echo '<span class="total">共' . $page['total'] . '页</span>';
    }
			?>
			<!--结束-->
		</ul>
	</div>
	<div class="pages">
	<?php echo search_pages($total, $perpage); ?>
	<span class="pagesone"><input type="text" size="3" onkeydown="javascript: if(event.keyCode==13){var page=(this.value&gt;20) ? 20 : this.value;  location='index.php?page=search&q=<?php echo $key; ?>&p='+page+''; return false;}"><button onclick="javascript: var page=(this.previousSibling.value&gt;20) ? 20 : this.previousSibling.value;  location='index.php?page=search&q=<?php echo $key; ?>&p='+page+''; return false;">Go</button></span>
</div>
</div>

