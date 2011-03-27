<?php 
  header("content-type=text/html; charset=utf-8");
  require_once 'common.php'; 
  $act = $_GET['act'];
  switch ($act) {
    case 'login':
      $user = $_POST['user'];
      $password = $_POST['password'];
      setcookie('login_user',$user,time()+3600 * 24 * 30);
      setcookie('login_password',$password,time()+3600 * 24 * 30);
      if ($user !== '' && $password !== '' ) {
        $admin = sql_query("SELECT * FROM " . DB_PREFIX . "user WHERE username = '$user'" );
        $pass = mysql_fetch_object($admin);
        $pass = $pass -> password;
        $num_rows = mysql_num_rows($admin);
        if ($num_rows >= 1) {   
          if ($pass == md5($password)) {
            $_SESSION['login'] = TRUE;	
            if ($_POST['type'] == 'm') {
              go('/m/index.php');
            } else {
              go();	
            }
          } else {
          	echo "<script>alert('密码错了！好好想想呢！');location.href='index.php?page=login';</script>";
          	$_COOKIE['login_password'] = "";
          }  	
        } else {
          echo	"<script>alert('查无此号！请确认你的登录信息！');location.href='index.php?page=login';</script>";
          $_COOKIE['login_user'] = "";
          $_COOKIE['login_password'] = "";
        }
      } else {
  	    echo "<script>alert('请输入用户名和密码!');location.href='index.php?page=login';</script>";
  	    $_COOKIE['login_user'] = "";
        $_COOKIE['login_password'] = "";
    	}
    break;	
    
    case 'logout':
      $_SESSION['login'] = FALSE;
      if ($_GET['type'] == 'm') {
        go('/m/index.php');
      } else {
        go();	
      }
    break;
    
  	case 'save':
  	  $entry = strip_tags($_POST['entry']);
  	  $mp3 = $_POST['mp3'];
  	  $video = $_POST['video'];
  	  $admin = sql_query('SELECT * FROM ' . DB_PREFIX . 'user WHERE username = "' . $_COOKIE['login_user'] . '"');
  	  $admin = mysql_fetch_array($admin);
  	  $userid = $admin['administrator'];
  	  $weibo = array('0' => 'sina', '1' => 'tecent', '2' => 'wangyi');
  	  $oauth = array('0' => 'oauth_token', '1' => 'oauth_token_secret');
  	  foreach ($weibo as $item) {
  	  	foreach ($oauth as $o) {
  	  		$web = unserialize($admin[$item]);
  	  		$sync[$item][$o] = $web[$o];
  	  	}	
  	  }
  	  $time = time();
  	  $mblog = $_POST['sync'];
      $imagename=$_FILES['image']['name']; 
      $data = $_FILES['image']['tmp_name'];
      sql_query("INSERT INTO " . DB_PREFIX . "entry VALUES ('', '$userid', '', '', '', '$entry', '$time', '网页', '0', '$path', '$mp3', '$video')");
  	  if ($video != "") {
  	    $entry .= $video;
  	  } 
  	  if (is_array($mblog)) {
  	    foreach ($mblog as $key => $var) {
  	      if ($var == 'fanfou') {
  	      	sync_fanfou(strip_tags($entry));
  	      } elseif ($var == 'sina') {
  	      	  $c = new WeiboClient( WB_AKEY , WB_SKEY , $sync['sina']['oauth_token'] , $sync['sina']['oauth_token_secret'] );
  	      	  $c -> update($entry);
  	      } elseif ($var == 'digu') {
  	      	sync_digu(strip_tags($entry));
  	      } elseif ($var == 'qq') {
  	        $tecent = new MBApiClient( MB_AKEY , MB_SKEY , $sync['tecent']['oauth_token'] , $sync['tecent']['oauth_token_secret'] );
            $p =array('c' => $entry,'ip' => $_SERVER['REMOTE_ADDR'], 'j' => '','w' => '');
            $tecent->postOne($p);
          } elseif ($var == 'wangyi') {
          	$wangyi = new wy_WeiboClient( WY_AKEY, WY_SKEY, $sync['wangyi']['oauth_token'], $sync['wangyi']['oauth_token_secret']);
          	  $wangyi -> update( $entry );
  	      }
  	     }
  	  }
      if ($_GET['type'] == 'm') {
        go('/m/index.php');
      } else {
        go();	
      }
  	break;
  	
    case 'del':
      sql_query('DELETE FROM ' . DB_PREFIX . 'entry WHERE id=' . $_GET['id']);
      if($_GET['type'] == 'm') {
        go('/m/index.php');	
      } else {
        echo "<script>alert('删除成功');location.href='index.php';</script>";
      }
    break;
    
    case 'update':
      $nickname = $_POST['nickname'];
      $email = $_POST['email'];
      $userid = $_POST['userid'];
      $xiami = $_POST['xiami'];
      $douban = $_POST['douban'];
      $photo = $_POST['photo'];
			sql_query('UPDATE ' . DB_PREFIX . 'user SET nickname = "' . $nickname .'", mail = "' . $email .'", xiami = "' . $xiami . '", douban = "' . $douban . '", photo = "' . $photo . '" WHERE administrator ="' . $userid . '"');
			$psw['ever'] = $_POST['psw_ever'];
			$psw['new'] = $_POST['psw_new'];
			$psw['new_again'] = $_POST['psw_new_again'];
	  	if ($psw['ever'] != "" AND $psw['new'] != "" AND $psw['new_again'] !="") {
	  		$psw_ever = mysql_fetch_object(sql_query('SELECT * FROM ' . DB_PREFIX . 'user WHERE administrator = "' . $userid . '"')) -> password;
			  $psw['ever'] = md5($psw['ever']);
			  if ($psw['ever'] == $psw_ever ) {
			    if($psw['new'] == $psw['new_again']) {
			  	  sql_query('UPDATE ' . DB_PREFIX . 'user SET password = "' . md5($psw['new']) . '" WHERE administrator = "' . $userid . '"');
			  	  echo "<script>alert('密码修改成功');location.href='action.php?act=logout';</script>";
			    } else {
			  	  echo "<script>alert('两次输入的密码不相同');location.href='index.php?page=setting';</script>";
			  	}
			  } else {
			    echo "<script>alert('原密码错误');location.href='index.php?page=setting';</script>";
			  }
			} else {
				if($_POST['type'] == 'm') {
				  go('/m/setting.php');	
				} else {
          go('index.php?page=setting');	
			  }
			}
    break;
    
    case 'post':
      $reply_id = $_POST['reply_id'];
      $reply_entry = sql_query('SELECT * FROM ' . DB_PREFIX . 'entry WHERE id ="' . $reply_id . '"');
      $reply_entry = mysql_fetch_object($reply_entry);
      $reply_user_id = $reply_entry -> userid;
      if ($reply_user_id == 0) {
        $rename = $reply_entry -> nickname; 
      } else { 
        $admins = sql_query('SELECT * FROM ' . DB_PREFIX . 'user WHERE administrator="' . $reply_user_id . '"');
        $admins = mysql_fetch_object($admins);
        $rename = $admins -> nickname;
      }//获取评论消息的昵称
      if (!$_SESSION['login']) {
        $nickname = $_POST['nickname'];
        $email = $_POST['email'];
        $url = $_POST['url'];
        $userid = 0;
        setcookie('nickname', $nickname, time() + 3600 * 24 * 7);
        setcookie('email', $email, time() + 3600 * 24 * 7);
        setcookie('url', $url, time() + 3600 * 24 * 7);
      } else {
      	$nickanme = '';
      	$email = '';
      	$url = '';
  	    $admin = sql_query('SELECT * FROM ' . DB_PREFIX . 'user WHERE username = "' . $_COOKIE['login_user'] . '"');
  	    $admin = mysql_fetch_object($admin);
  	    $userid = $admin -> administrator;
      }
      $time = time();
      $entry = '@<a href="index.php?page=view&id=' . $reply_id . '" target="' . $rename . '">' . $rename . '</a>&nbsp;' . strip_tags($_POST['content']);
      sql_query("INSERT INTO " . DB_PREFIX . "entry VALUES ('', '$userid',  '$nickname', '$email', '$url', '$entry', '$time', '网页', '$reply_id','','','')");
      if ($_POST['type'] == 'm') {
        go('/m/index.php');
      } else {
        go();	
      }
    break;
      
    case 'sina_oauth':
      $sina_oa = new WeiboOAuth( WB_AKEY , WB_SKEY , $_SESSION['sina_keys']['oauth_token'] , $_SESSION['sina_keys']['oauth_token_secret']  );
      $sina_last_key = $sina_oa ->getAccessToken(  $_REQUEST['oauth_verifier'] ) ;
      $_SESSION['sina_last_key'] = $sina_last_key;
      $page = MF_URL.'action.php?act=insert_oauth&mb=sina';
      go($page);
    break;
    
    case 'qq_oauth':
      $tecent_oa = new MBOpenTOAuth( MB_AKEY , MB_SKEY , $_SESSION['tecent_keys']['oauth_token'] , $_SESSION['tecent_keys']['oauth_token_secret']  );
      $tecent_last_key = $tecent_oa ->getAccessToken( $_REQUEST['oauth_verifier'] ) ;
      $_SESSION['tecent_last_key'] = $tecent_last_key;
      $page = MF_URL.'action.php?act=insert_oauth&mb=qq';
      go($page);
    break;
    
    case '163_oauth':
      $wangyi_oa = new wy_WeiboOAuth( WY_AKEY , WY_SKEY , $_SESSION['wangyi_keys']['oauth_token'] , $_SESSION['wangyi_keys']['oauth_token_secret']  );
      $wangyi_last_key = $wangyi_oa->getAccessToken(  $_REQUEST['oauth_token'] );
      $_SESSION['wangyi_last_key'] = $wangyi_last_key;
      $page = MF_URL.'action.php?act=insert_oauth&mb=163';
      go($page);
    break;
    
    case 'insert_oauth':
      switch ($_GET['mb']) {
      	case 'sina':
      	  $sina = new WeiboClient( WB_AKEY , WB_SKEY , $_SESSION['sina_last_key']['oauth_token'] , $_SESSION['sina_last_key']['oauth_token_secret']  );
          $sina = $sina->verify_credentials();
          $sync['sina']['id'] = $sina['name'];
          $sync['sina']['oauth_token'] = $_SESSION['sina_last_key']['oauth_token'];
          $sync['sina']['oauth_token_secret'] = $_SESSION['sina_last_key']['oauth_token_secret'];
          sql_query('UPDATE ' . DB_PREFIX . 'user SET sina = "' . addslashes(serialize($sync['sina'])) . '" WHERE username = "' . $_COOKIE['login_user'] . '"');
        break;
        case 'qq':
          $sync['qq']['id'] = $_SESSION['tecent_last_key']['name'];
          $sync['qq']['oauth_token'] = $_SESSION['tecent_last_key']['oauth_token'];
          $sync['qq']['oauth_token_secret'] = $_SESSION['tecent_last_key']['oauth_token_secret'];
          sql_query('UPDATE ' . DB_PREFIX . 'user SET tecent = "' . addslashes(serialize($sync['qq'])) . '" WHERE username = "' . $_COOKIE['login_user'] . '"');
        break;
        case '163':
          $wangyi = new wy_WeiboClient( WY_AKEY , WY_SKEY , $_SESSION['wangyi_last_key']['oauth_token'] , $_SESSION['wangyi_last_key']['oauth_token_secret']  );
          $wangyi = $wangyi->verify_credentials();
          $sync['163']['id'] = $wangyi['name'];
          $sync['163']['oauth_token'] = $_SESSION['wangyi_last_key']['oauth_token'];
          $sync['163']['oauth_token_secret'] = $_SESSION['wangyi_last_key']['oauth_token_secret'];
          sql_query('UPDATE ' . DB_PREFIX . 'user SET wangyi = "' . addslashes(serialize($sync['163'])) . '" WHERE username = "' . $_COOKIE['login_user'] . '"');
        break;
      }
      go(MF_URL . 'index.php?page=setting');
    break;
    
    case 'del_oauth':
      $mb = $_GET['mb'];
      sql_query('UPDATE ' . DB_PREFIX . 'user SET ' . $mb . ' = "" WHERE username = "' . $_COOKIE['login_user'] . '"');
      echo "<script>alert('取消授权成功');location.href='index.php?page=setting';</script>";
    break;
    
  }