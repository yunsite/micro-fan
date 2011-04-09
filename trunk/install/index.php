<?php
  ob_start();
  error_reporting(E_ALL ^ E_NOTICE);
    function sql_query($sqlcon){   
      $con=mysql_connect(DB_HOST, DB_USER,DB_PASSWORD);
      mysql_select_db(DB_NAME);
      mysql_query("SET NAMES 'utf8'");
      $result = mysql_query($sqlcon);
      mysql_close($con);
      return $result;
    }  
?>
<html>
	<head>
		<title>微饭安装</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<style type="text/css">
		  label {display:block;}
		  body {width:400px;margin:50px auto;font-size:14px;text-align:right;}
		  h2 {text-align:center;}
		  input {border:1px solid #999;width:250px;height:22px;line-height:20px;padding:1px 0 2px;margin-bottom:10px;}
		  #submit {width:100px;margin-right:80px;margin-top:20px;border:0 none;}
		</style>
	</head>
  <body>
  	<h2>微饭微博安装程序</h2>
<?php
function cexit() {
if (file_exists('../config/config.php') AND file_exists('../config/config.site.php')) {
  echo "<script>alert('看起来你已经安装过微饭了哦，如果你确实没有安装过，请删除/config/config.php和/config/config.site.php两个文件后再执行安装程序.');location.href='../index.php';</script>";	
}	
}
$step = $_GET['step'];
if ($step == "" OR NULL) { $step == "1"; }
switch ($step) {
	case '1':
	  if (file_exists('../config/config.php')) {
	    echo '创建config.php成功>>><a href="index.php?step=2">下一步</a>';	
	    require_once('../config/config.php');
	    if(!mysql_connect(DB_HOST,DB_USER,DB_PASSWORD)) die("<p>友情提示——Mysql连接失败！请确认你的数据库登录信息</p>");
	  } else {
?>
      <form action="act.php?step=1" method="POST">
        <label>MySQL 主机:<input type="text" name="db_host" value="localhost"></label>
        <label>[一般为localhost,如不确定请勿更改]</label>
        <label>MySQL数据库用户名:<input type="text" name="db_user" value=""></label>
        <label>MySQL 数据库密码:<input type="text" name="db_password" value=""></label>
        <label>数据库名称:<input type="text" name="db_name" value=""></label>
        <label>数据库前缀:<input type="text" name="db_prefix" value="mf_"></label>
        <label>[注意要以'_'结尾]</label>
        <label><input id="submit" type="submit" value="确认"></label>
    </form>
<?php 
    }
  break;
  
  case '2':
		  if (file_exists('../config/config.site.php')) {
		    echo '创建config.site.php成功>>><a href="index.php?step=3">下一步</a>';	
		  } else {
	      $site_url = "http://".$_SERVER['HTTP_HOST'].str_replace("install/index.php","",$_SERVER["SCRIPT_NAME"]);
	?>
	      <form action="act.php?step=2" method="POST">
	      	<label>微博标题:<input type="text" name="site_title"></label>
	      	<label>微博地址:<input type="text" name="site_url" value="<?php echo $site_url; ?>"></label>
	      	<label>微博描述:<input type="text" name="site_introduction"></label>
	      	<label>每页微博:<input type="text" name="site_pageone" value="20"></label>
	        <label><input id="submit" type="submit" value="确认"></label>
	      </form>
	<?php
	    } 
  break;
  
  case '3':
    require_once '../config/config.php';
    $test = mysql_fetch_object(sql_query('SELECT * FROM ' . DB_PREFIX . 'user WHERE administrator = "1"'));
    if ($test) {
    	echo '微饭安装成功！O(∩_∩)O>>><a href="../index.php">返回首页</a>';
    } else {
?>
      <form action="act.php?step=3" method="POST">
      	<label>管理员账号:<input type="text" name="admin_user"></label>
      	<label>管理员昵称:<input type="text" name="admin_nickname"></label>
      	<label>管理员邮箱:<input type="text" name="admin_email"></label>
       	<label>管理员密码:<input type="text" name="admin_password"></label>
      	<label><input id="submit" type="submit" value="确认"></label>
      </form>
<?php 
    }
  break;
  
  default:
    header('Location:index.php?step=1');
  break;
}
?>
</body>
</html>