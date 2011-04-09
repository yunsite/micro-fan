<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once '../lib/function.php';
if (file_exists('../config/config.php')) {
  require_once '../config/config.php';	
}
if (file_exists('../config/config.site.php')) {
	require_once '../config/config.site.php';
}

switch ($_GET['step']) {
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

	  $config_str .= "\n\n";
	  
	  $config_str .= "/*新浪账号*/";
	  
	  $config_str .= "\n\n";
	  
	  $config_str .= "define('WB_AKEY', '2546437393');";
	  
	  $config_str .= "\n\n";
	  
    $config_str .= "define('WB_SKEY', '5abfaae87a665fc316361a8fe72e59ce');";
	  
	  $config_str .= "\n\n";
	  
	  $config_str .= "/*网易账号*/";
	  
	  $config_str .= "\n\n";
	  
    $config_str .= "define('WY_AKEY', '1DwF5Hicfzwz3geI');";
	  
	  $config_str .= "\n\n";
	  
	  $config_str .= "define('WY_SKEY', 'IRqSfMwPE8didR8llwuHAL8w5WDkw78g');";
	  
	  $config_str .= "\n\n";
	  
    $config_str .= "/*腾讯账号*/";
	  
	  $config_str .= "\n\n";
	  
    $config_str .= "define('MB_AKEY', '064a2f5a7fac499f82a17a50fc63800d');";
	  
	  $config_str .= "\n\n";
	  
    $config_str .= "define('MB_SKEY', '3823b0d39378374770908ab5de28fce6');";
	  
	  $config_str .= "\n\n";
 
	  $config_str .= '?>';
	
	  /*写入到config文件中*/
	  $file = '../config/config.php';
	  write($config_str,$file);
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
							  PRIMARY KEY (`id`),
							  KEY `time` (`time`)) 
                ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci	");
	  sql_query("CREATE TABLE IF NOT EXISTS `mf_user` (
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
							  `skin` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
							  PRIMARY KEY (`id`)) 
							  ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
		$time = time();
    sql_query("INSERT INTO `" . DB_PREFIX . "entry` VALUES ('', 1, '', '', '', 'Hello,World!', '$time', '网页', 0, '', '', '')");
	  header('location:index.php?step=1');
	break;
	
	case '2':
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
	  $user = $_POST['admin_user'];
	  $password = md5($_POST['admin_password']);
	  $nickname = $_POST['admin_nickname'];
	  $email = $_POST['admin_email'];   
    sql_query("INSERT INTO `" . DB_PREFIX . "user` VALUES ('','$user', '$nickname', '$email', '$password', '1','','','','','','','')");
    header('location:index.php?step=3');
break;
}
?>