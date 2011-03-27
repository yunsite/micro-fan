<?php
  require_once 'common.php';
  require_once './template/header.php';
  $single_page = $_GET['page'];
  switch ($single_page) 
  {
  	case 'comment':
  	  require_once './template/comment.php';
  	break;
  	
  	case 'music':
      $xiami['id'] = mysql_fetch_object(sql_query('SELECT * FROM ' . DB_PREFIX . 'user WHERE administrator = "1"')) -> xiami;
      $data = 'http://www.xiami.com/widget/xml-dynamic/uid/' . $xiami['id'] . '/id/' . $xiami['id'] . '/width/235/height/346/mainColor/FF8719/backColor/494949/type/shuffle';
      $xml = file_get_contents($data);
      preg_match_all( "/\<track\>(.*?)\<\/track\>/s",$xml, $track );  
  	  require_once './template/xiami.php';
  	break;
  	
  	case 'photo':
      $user = sql_query('SELECT * FROM ' . DB_PREFIX . 'user WHERE administrator = "1"');
      $user = mysql_fetch_array($user);
      $photoid = $user['photo'];
      $flickr = file_get_contents("http://api.flickr.com/services/rest/?method=flickr.people.getPublicPhotos&api_key=3df15beb1f581eda361ca6806fce63b5&user_id=" . $photoid . "&per_page=32");
      $flickr = str_replace("photos","",$flickr);
      preg_match_all("/<photo(.*?)\/>/s",$flickr,$photos);
      $photo = $photos[1];
      $count = count($photo);
  	  require_once './template/flickr.php';
  	break;
  	
  	case 'movie':
      $douban = mysql_fetch_object(sql_query('SELECT * FROM ' . DB_PREFIX . 'user WHERE administrator = "1"')) -> douban;
      $douban = file_get_contents('http://api.douban.com/people/' . $douban . '/collection?cat=movie&max-results=48');
      preg_match_all("/\<db\:subject\>(.*?)<\/db\:subject>/s",$douban,$subject);
  	  require_once './template/douban.php';
  	break;
  	
  	case 'setting':
  	  $user = sql_query('SELECT * FROM ' . DB_PREFIX . 'user WHERE username ="' . $_COOKIE['login_user'] . '"');
      $user = mysql_fetch_array($user);
      $userid = $user['administrator'];
      $nickname = $user['nickname'];
      $email = $user['mail'];
      $sina = unserialize($user['sina']);
      $tecent = unserialize($user['tecent']);
      $wangyi = unserialize($user['wangyi']);
      $xiami = $user['xiami'];
      $douban = $user['douban'];
      $photo = $user['photo'];
      //sina weibo
      $sina_o = new WeiboOAuth( WB_AKEY , WB_SKEY  );
      $sina_keys = $sina_o->getRequestToken();
      $sina_callback = MF_URL . 'action.php?act=sina_oauth';
      $sina_aurl = $sina_o -> getAuthorizeURL( $sina_keys['oauth_token'] ,false , $sina_callback );
      $_SESSION['sina_keys'] = $sina_keys;
      //qq weibo
      echo '<span style="display:none;">';
      $tecent_o = new MBOpenTOAuth( MB_AKEY , MB_SKEY  );
      $tecent_keys = $tecent_o->getRequestToken(MF_URL . 'action.php?act=qq_oauth');
      $tecent_aurl = $tecent_o->getAuthorizeURL( $tecent_keys['oauth_token'] ,false,'');
      $_SESSION['tecent_keys'] = $tecent_keys;
      echo '</span>';
      //163 weibo
      echo '<span style="display:none;">';
      $wangyi_o = new wy_WeiboOAuth( WY_AKEY , WY_SKEY  );
      $wangyi_keys = $wangyi_o->getRequestToken();
      $wangyi_callback = MF_URL . 'action.php?act=163_oauth';
      $wangyi_aurl = $wangyi_o->getAuthorizeURL( $wangyi_keys['oauth_token'] ,true ,  $wangyi_callback);
      $_SESSION['wangyi_keys'] = $wangyi_keys;	
      echo '</span>';
      //
  	  require_once './template/setting.php';
  	break;
  	
  	case 'login':
  	  require_once './template/login.php';
  	break;
  	
  	case 'view':
  	  $entry = sql_query('SELECT * FROM ' . DB_PREFIX . 'entry WHERE id ="' . $_GET['id'] . '"');
  	  $entry = mysql_fetch_object($entry);
			$userid = $entry -> userid;
			if ($userid == 0) { 
			  $nickname = $entry -> nickname;
			  $email = $entry -> email;
			  $url = $entry -> url;
			} else {
			  $user = sql_query('SELECT * FROM ' . DB_PREFIX . 'user WHERE administrator ="' . $userid . '"');
			  $user = mysql_fetch_object($user);
			  $nickname = $user -> nickname;
			  $email = $user -> mail;
			  $url = MF_URL;
			}
			$content = search_key($entry -> content);
			$img = $entry -> img;
			$mp3 = $entry -> mp3;
  	  require_once './template/view.php';
  	break;
  	
  	case 'widget':
  	  require_once './template/widget.php';
  	break;
  	
  	case 'register':
  	  require_once './template/register.php';
  	break;
  	
  	case 'search':
			if ($_GET['q']) {
	    	$key = $_GET['q'];
		    $keywords = explode(' ', trim(urldecode($_GET['q'])));
		      foreach($keywords AS $keyword) {
			      if (!$search_query) {
			        $search_query .= " WHERE `content` LIKE '%" . $keyword ."%'";
			      } else {
			        $search_query .= " OR `content` LIKE '%" . $keyword ."%'";
		        }
			    }
		  }
      if ($_GET['p'] == "") {
        $_GET['p'] = 1;	
      } 
      $page = $_GET['p'];
      $start_entry = ($page - 1) * $perpage;
	    $entries = sql_query("SELECT * FROM " . DB_PREFIX . "entry" . $search_query . " ORDER BY time DESC LIMIT " . $start_entry . ", " . $perpage);
			$total = 0;
  	  require_once './template/search.php';
  	break;
  	
  	default:
  	  $login = sql_query('SELECT * FROM ' . DB_PREFIX . 'user WHERE username = "' . $_COOKIE['login_user'] . '"');
  	  $login = mysql_fetch_array($login);
  	  $authorid = $login['administrator'];
  	  require_once './template/blog.php';
  	break;
  }
  require_once './template/footer.php';
?>