<?php
error_reporting(E_ALL ^ E_NOTICE);
function write($text,$file) {
	$handle = @fopen($file, 'w');

	if ( @flock($handle, LOCK_EX) )
	{
		@fwrite($handle, $text);

		@flock($handle, LOCK_UN);
	}
			
	@fclose($handle);	
}

$step = $_GET['step'];
switch ($step) {
	case '1':
	  if(isset($_POST['db_host'],$_POST['db_user'],$_POST['db_password'],$_POST['db_name'],$_POST['db_prefix'])) {
	    $db = array( host => strtolower(trim($_POST['db_host'])), user => strtolower(trim($_POST['db_user'])), password => $_POST['db_password'], name => strtolower(trim($_POST['db_name'])), prefix => strtolower(trim($_POST['db_prefix'])));	
	  }
	  /*检查数据库资料完整性*/
    if( empty($db['host']) )
	  {
	  	die("<script>alert('Mysql 地址不能为空');</script>");
    }

  	if( empty($db['name']) )
  	{
  		die("<script>alert('Mysql 库名称不能为空');</script>");
  	}

	  if( empty($db['user']) )
	  {
	  	die("<script>alert('Mysql 用户不能为空');</script>");
  	}

	  if( empty($db['prefix']) )
   	{
	  	die("<script>alert('Mysql 表前缀不能为空');</script>");
  	}

  	if( substr($db['prefix'],-1) != "_" )
	  {
	  	die("<script>alert('Mysql 表前缀必须是以下划线结束');</script>");
	  }
	
	  /*确定config文件内容*/
    $config_str = "<?php";

	  $config_str .= "\n\n";
	
	  $config_str .= "// ** MySQL 设置 - 具体信息来自您正在使用的主机 ** //";
	
	  $config_str .= "\n";
	
	  $config_str .= "/** 数据库的名称 */";
	
	  $config_str .= "\n\n";

	  $config_str .= "define('DB_NAME', '" . $db['name'] . "');";
	
	  $config_str .= "\n\n";
	
	  $config_str .= "/**数据库前缀*/";

	  $config_str .= "\n\n";

	  $config_str .= "define('DB_PREFIX', '" . $db['prefix'] . "');";

	  $config_str .= "\n\n";
	
	  $config_str .= "/** MySQL 数据库用户名 */";
	
	  $config_str .= "\n\n";

	  $config_str .= "define('DB_USER', '" . $db['user'] . "');";

	  $config_str .= "\n\n";
	
	  $config_str .= "/** MySQL 数据库密码 */";
	
	  $config_str .= "\n\n";

	  $config_str .= "define('DB_PASSWORD', '" . $db['password'] . "');";

	  $config_str .= "\n\n";
	
	  $config_str .= "/** MySQL 主机 */";
	
	  $config_str .= "\n\n";

	  $config_str .= "define('DB_HOST', '" . $db['host'] . "');";

	  $config_str .= "\n";
 
	  $config_str .= '?>';
	
	  /*写入到config文件中*/
	  $file = '../config/config.php';
	  write($config_str,$file);
	  header('location:index.php?step=1');
	break;
	
	case '2':
	  require_once '../config/config.php';
	  require_once '../lib/function.php';
    sql_query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "entry` (
  		`id` int(10) NOT NULL AUTO_INCREMENT,
  		`userid` int(1) NOT NULL,
  		`nickname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  		`email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  		`url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  		`content` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  		`time` int(10) NOT NULL,
 		  `from` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
 		  `reply_id` int(10) NOT NULL,
 		  `img` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		  `mp3` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		  `video` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
		  PRIMARY KEY (`id`),KEY `time` (`time`)) 
		  ENGINE=MyISAM DEFAULT CHARSET=utf8");
    sql_query("INSERT INTO `" . DB_PREFIX . "entry` (`id`, `userid`, `nickname`, `email`, `url`, `content`, `time`, `from`, `reply_id`) VALUES ('', 1, '', '', '', 'Hello,World!', '$time', '网页', 0)");
    sql_query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "user` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nickname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mail` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `administrator` int(1) NOT NULL,
  `sina` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `tecent` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `wangyi` mediumtext COLLATE utf8_unicode_ci NOT NULL,
  `xiami` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `douban` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
	  if (isset($_POST['site_title'],$_POST['site_url'],$_POST['site_introduction'],$_POST['site_pageone'])) {
	    $site = array( title => $_POST['site_title'], url => $_POST['site_url'], introdunction => $_POST['site_introduction'], pageone => $_POST['site_pageone']);	
	  }
	  
	  $site_config = '<?php';
	  
	  $site_config .= "\n\n";
	  
	  $site_config .= 'define(MF_NAME, "' . $site['title'] . '");';
	  
	  $site_config .= "\n\n";
	  
	  $site_config .= 'define(MF_URL, "' . $site['url'] . '");';
	  
	  $site_config .= "\n\n";
	  
	  $site_config .= '$site = array (';
	  
	  $site_config .= "\n";
	  
	  $site_config .= 'introduction =>"' . $site['introduction'] . '",'; 
	  
	  $site_config .= "\n";
	  
	  $site_config .= 'pageone =>"' . $site['pageone'] . '",';
	  
	  $site_config .= "\n";
	  
	  $site_config .= 'tongji =>"");';
	  
	  $site_config .= "\n\n";
	  
	  $site_config .= '?>';
	  
	  $file = '../config/config.site.php';
	  
	  write($site_config,$file);
	  
    header('location:index.php?step=2');
	break;
	
	case '3':
	  require_once '../config/config.php';
	  require_once '../config/config.site.php';
	  require_once '../lib/function.php';
	  $user = $_POST['admin_user'];
	  $password = md5($_POST['admin_password']);
	  $nickname = $_POST['admin_nickname'];
	  $email = $_POST['admin_email'];
    sql_query("INSERT INTO `" . DB_PREFIX . "user` VALUES ('', '$user', '$nickname', '$email', '$password', '1', '', '', '', '', '', '')");
    header('location:index.php?step=3');
break;
}
?>