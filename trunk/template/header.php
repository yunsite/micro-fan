<html>
	<head>
		<title><?php echo MF_NAME; ?></title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="rss.php">
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="javascript/global.js"></script>
    <script type="text/javascript" src="javascript/jquery.lightbox.js"></script>
    <script type="text/javascript">
    $(function() {
        $('a.lightbox').lightBox();
    });
    </script>
		<link rel="stylesheet" type="text/css" href="skin/style.css">
		<style type="text/css">
	    @import 'skin/jquery.lightbox.css';
	    <?php 
	      $bgurl = mysql_fetch_array(sql_query('SELECT * FROM ' . DB_PREFIX . 'user WHERE administrator ="1"')); 
	      if ($bgurl['skin'] == "") {
	        $bgurl['skin'] = 'http://microfan.sinaapp.com//skin/images/bg.jpg';	
	      }
	    ?>
	    html {
			  background:url(<?php echo $bgurl['skin']; ?>) no-repeat fixed 0 50% transparent;
			}
    </style>
	</head>
	<body>
		<div id="header">
			<div id="title">
				<h3><a href="<?php echo MF_URL; ?>" target="<?php echo MF_NAME; ?>"><?php echo MF_NAME;?></a></h3>
		  </div>
			
      <ul>
				<li><a href="index.php">首页</a></li>
				<li><a href="index.php?page=widget">微博秀</a></li>
				<?php 
				  if (service_option('xiami')) {
				?>
				    <li><a href="index.php?page=music">音乐墙</a></li>
				<?php
			    }
			   ?>
				<?php 
				  if (service_option('photo')) {
				?>
				    <li><a href="index.php?page=photo">照片墙</a></li>
				<?php
			    }
			   ?>
				<?php 
				  if (service_option('douban')) {
				?>
				    <li><a href="index.php?page=movie">电影墙</a></li>
				<?php
			    }
			   ?>
				<?php 
				  if($_SESSION['login']) {
				?>
			      <li><a href="index.php?page=setting">管理</a></li>
			      <li><a href="action.php?act=logout">退出</a></li> 
			  <?php 
			    } else { 
			  ?>
			      <li><a href="index.php?page=login">登录</a></li>
			  <?php 
			    } 
			  ?>
		  </ul>
		  <span class="search"><input type="text" size="3" onkeydown="javascript: if(event.keyCode==13){var key=(this.value&gt;20) ? 20 : this.value;  location='index.php?page=search&q='+key+''; return false;}"><button onclick="javascript: var key=(this.previousSibling.value&gt;20) ? 20 : this.previousSibling.value;  location='index.php?page=search&?q='+key+''; return false;">搜索</button></span>
		</div>
					