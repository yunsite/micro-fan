<div id="main">
	<?php 
	  if ($_SESSION['login']) {
	?>
	    <form action="action.php?act=addlink" method="POST">
	      <h2>添加友情链接</h2>
	      <label>名称:<input type="text" name="name">链接:<input type="text" name="url"></label>
	      <label>描述:<input type="text" name="description"></label>
	      <input type="submit" id="submit" value="更新">
	    </form>
	<?php
    }
    $link = sql_query('SELECT * FROM ' . DB_PREFIX . 'link ORDER BY id');
    While($item = mysql_fetch_array($link)) {
  ?>
      <img src="http://www.google.com/s2/favicons?domain=<?php $item['url']; ?>" alt="<?php echo $item['name']; ?>"><a href="<?php echo $item['url']; ?>" alt="<?php echo $item['description']; ?>"><?php echo $item['name']; ?></a>
  <?php	
    }
  ?>