<?php
    function sql_query($sqlcon){   
      $con=mysql_connect(DB_HOST, DB_USER,DB_PASSWORD);
      mysql_select_db(DB_NAME);
      mysql_query("SET NAMES 'utf8'");
      $result = mysql_query($sqlcon);
      mysql_close($con);
      return $result;
    }  
    
    function time_past($time_post) {
      date_default_timezone_set('Asia/Shanghai');
      $past = time() - $time_post;
      if($past == 0) {
      	return '刚刚输入';
      } else if($past < 60) {
      	return intval($past).'秒前';
      } else if($past < 3600) { 
      	if ($past%60 > 0) {
      		$sec = intval($past%60) . '秒前';
      	} else {
      	  $sec = '前';	
      	}
      	return intval($past/60).'分' . $sec;
      } else if(($past < 86400) && ($time_past < time() - 86400)) {
      	$past_min = $past%3600;
      	if($past_min < 60) {
      	  $min = intval($past_min) . '秒前';	
      	} else if ($past_min < 3600){
      		if($past_min%60 > 0) {     	
      			$min = intval($past_min/60) . '分' . intval($past_min%60) . '秒前';
      		} else {
      		 	$min = intval($past_min/60) . '分前';
      		}
      	}
      	return intval($past/3600).'小时' . $min;
      } else if ($past>strtotime('2010-12-31 23:59:59')) {
      	return date("n月j日 H:i",$time_post);
      } else {
      	return date("Y年n月j日 H:i:s",$time_post);
      }
    }
    
    function getavatar($email) {
    	return "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( "http://www.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s=40") . "&s=40";
    }

    function user_agent($ua){
      //开始解析操作系统
      $os = null;
      if(preg_match('/Windows 95/i',$ua) || preg_match('/Win95/',$ua)) {
        $os = "Windows 95";
      } elseif (preg_match('/Windows NT 5.0/i',$ua) || preg_match('/Windows 2000/i', $ua)) {
        $os = "Windows 2000";
      } elseif (preg_match('/Win 9x 4.90/i',$ua) || preg_match('/Windows ME/i', $ua)) {
        $os = "Windows ME";
      } elseif (preg_match('/Windows.98/i',$ua) || preg_match('/Win98/i', $ua)) {
        $os = "Windows 98";
      } elseif (preg_match('/Windows NT 6.0/i',$ua)) {
        $os = "Windows Vista";
      } elseif (preg_match('/Windows NT 6.1/i',$ua)) {
        $os = "Windows 7";
      } elseif (preg_match('/Windows NT 5.1/i',$ua)) {
        $os = "Windows XP";
      } elseif (preg_match('/Windows NT 5.2/i',$ua) && preg_match('/Win64/i',$ua)) {
        $os = "Windows XP 64 bit";
      } elseif (preg_match('/Windows NT 5.2/i',$ua)){
        $os = "Windows Server 2003";
      } elseif (preg_match('/Mac_PowerPC/i',$ua)) {
        $os = "Mac OS";
      } elseif (preg_match('/Windows Phone/i',$ua)) {
        $os = "windows phone7";
      } elseif (preg_match('/Windows NT 4.0/i',$ua) || preg_match('/WinNT4.0/i',$ua)) {
        $os = "Windows NT 4.0";
      } elseif (preg_match('/Windows NT/i',$ua) || preg_match('/WinNT/i',$ua)) {
        $os = "Windows NT";
      } elseif (preg_match('/Windows CE/i',$ua)) {
        $os = "Windows CE";
      } elseif (preg_match('/ipad/i',$ua)) {
        $os = "iPad";
      } elseif (preg_match('/Touch/i',$ua)) {
        $os = "Touchw";
      } elseif (preg_match('/Symbian/i',$ua) || preg_match('/SymbOS/i',$ua)) {
        $os = "Symbian OS";
      } elseif (preg_match('/PalmOS/i',$ua)) {
        $os = "Palm OS";
      } elseif (preg_match('/QtEmbedded/i',$ua)) {
        $os = "Qtopia";
      } elseif (preg_match('/Ubuntu/i',$ua)) {
        $os = "Ubuntu Linux";
      } elseif (preg_match('/Gentoo/i',$ua)) {
        $os = "Gentoo Linux";
      } elseif (preg_match('/Fedora/i',$ua)) {
        $os = "Fedora Linux";
      } elseif (preg_match('/FreeBSD/i',$ua)) {
        $os = "FreeBSD";
      } elseif (preg_match('/NetBSD/i',$ua)) {
        $os = "NetBSD";
      } elseif (preg_match('/OpenBSD/i',$ua)) {
        $os = "OpenBSD";
      } elseif (preg_match('/SunOS/i',$ua)) {
        $os = "SunOS";
      } elseif (preg_match('/Linux/i',$ua)) {
        $os = "Linux";
      } elseif (preg_match('/Mac OS X/i',$ua)) {
        $os = "Mac OS X";
      } elseif (preg_match('/Macintosh/i',$ua)) {
        $os = "Mac OS";
      } elseif (preg_match('/Unix/i',$ua)) {
        $os = "Unix";
      } elseif (preg_match('#Nokia([a-zA-Z0-9.]+)#i',$ua,$matches)) {
        $os = "Nokia".$matches[1];
      } elseif (preg_match('/Mac OS X/i',$ua)) {
        $os = "Mac OS X";
      } else {
        $os = '未知的操作系统';
      }
      //开始解析浏览器
      if(preg_match('#(Camino|Chimera)[ /]([a-zA-Z0-9.]+)#i',$ua,$matches)){
        $browser = 'Camino '.$matches[2];
      }elseif(preg_match('#SE 2([a-zA-Z0-9.]+)#i',$ua,$matches)){
        $browser='搜狗浏览器 2'.$matches[1];
      }elseif(preg_match('#360([a-zA-Z0-9.]+)#i',$ua,$matches)){
        $browser='360浏览器 '.$matches[1];
      }elseif (preg_match('#Maxthon( |\/)([a-zA-Z0-9.]+)#i',$ua,$matches)){
        $browser='Maxthon '.$matches[2];
      }elseif (preg_match('#Chrome/([a-zA-Z0-9.]+)#i',$ua,$matches)){
        $browser='Chrome '.$matches[1];
      }elseif (preg_match('#Safari/([a-zA-Z0-9.]+)#i',$ua,$matches)){
        $browser='Safari '.$matches[1];
      }elseif(preg_match('#opera mini#i', $ua)) {
        preg_match('#Opera/([a-zA-Z0-9.]+)#i', $ua, $matches);
        $browser='Opera Mini '.$matches[1];
      }elseif(preg_match('#Opera.([a-zA-Z0-9.]+)#i',$ua,$matches)){
        $browser='Opera '.$matches[1];
      }elseif(preg_match('#(j2me|midp)#i', $ua)) {
        $browser="J2ME/MIDP Browser";
      }elseif(preg_match('/GreenBrowser/i', $ua)){
        $browser='GreenBrowser';
      }elseif (preg_match('#TencentTraveler ([a-zA-Z0-9.]+)#i',$ua,$matches)){
        $browser='腾讯TT浏览器 '.$matches[1];
      }elseif(preg_match('#UCWEB([a-zA-Z0-9.]+)#i',$ua,$matches)){
        $browser='UCWEB '.$matches[1];
      }elseif(preg_match('#MSIE ([a-zA-Z0-9.]+)#i',$ua,$matches)){
        $browser='Internet Explorer '.$matches[1];
      }elseif(preg_match('#avantbrowser.com#i',$ua)){
        $browser='Avant Browser';
      }elseif(preg_match('#PHP#', $ua, $matches)){
        $browser='PHP';
      }elseif(preg_match('#danger hiptop#i',$ua,$matches)){
        $browser='Danger HipTop';
      }elseif(preg_match('#Shiira[/]([a-zA-Z0-9.]+)#i',$ua,$matches)){
        $browser='Shiira '.$matches[1];
      }elseif(preg_match('#Dillo[ /]([a-zA-Z0-9.]+)#i',$ua,$matches)){
        $browser='Dillo '.$matches[1];
      }elseif(preg_match('#Epiphany/([a-zA-Z0-9.]+)#i',$ua,$matches)){
        $browser='Epiphany '.$matches[1];
      }elseif(preg_match('#UP.Browser/([a-zA-Z0-9.]+)#i',$ua,$matches)){
        $browser='Openwave UP.Browser '.$matches[1];
      }elseif(preg_match('#DoCoMo/([a-zA-Z0-9.]+)#i',$ua,$matches)){
        $browser='DoCoMo '.$matches[1];
      }elseif(preg_match('#(Firefox|Phoenix|Firebird|BonEcho|GranParadiso|Minefield|Iceweasel)/([a-zA-Z0-9.]+)#i',$ua,$matches)){
        $browser='Firefox '.$matches[2];
      }elseif(preg_match('#(SeaMonkey)/([a-zA-Z0-9.]+)#i',$ua,$matches)){
        $browser='Mozilla SeaMonkey '.$matches[2];
      }elseif(preg_match('#Kazehakase/([a-zA-Z0-9.]+)#i',$ua,$matches)){
        $browser='Kazehakase '.$matches[1];
      }else{
        $browser='未知浏览器';
      }
      return $os." | ".$browser;
    }

    function getip(){  
      if(!empty($_SERVER["HTTP_CLIENT_IP"]))  
        $cip = $_SERVER["HTTP_CLIENT_IP"];  
      else if(!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))  
        $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];  
      else if(!empty($_SERVER["REMOTE_ADDR"]))  
        $cip = $_SERVER["REMOTE_ADDR"];  
      else  
        $cip = "无法获取！";  
      return $cip;  
    }
    
    function user_ip($ip) {
      $f = new SaeFetchurl();
      $url2 = $f->fetch("http://www.ip.cn/getip.php?action=queryip&ip_url=".$ip);
      $file2=iconv("gb2312", "utf-8",$url2);
      preg_match_all("/来自：(.*)/",$file2,$user_ip);
      return $user_ip[1][0];
    }

    function go($url= "index.php") {
      return header('Location:' . $url);	
    }

    function ptfanfou($post) {
      $curl = curl_init();
      $post_data = 'status=' . urlencode($post) . '&source=fantang';
      curl_setopt($curl, CURLOPT_URL, 'http://api.fanfou.com/statuses/update.xml');
      if (!$_SESSION['login']) {
        curl_setopt($curl, CURLOPT_USERPWD, "yhgz:lizheming.com");
      } else {
        curl_setopt($curl, CURLOPT_USERPWD, "lizheming:8344907"); 
      }	
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
      $json = curl_exec($curl);
      curl_close($curl);
    }

    function pages($perpage) {
      $counts = sql_query("SELECT COUNT(id) AS total FROM " . DB_PREFIX . "entry");
      $counts = mysql_fetch_array($counts);
      $count = $counts['total']; //获取总条数
      if ($count%$perpage == 0) {
        $page['total'] = intval($count/$perpage);	
      } else {
        $page['total'] = intval($count/$perpage) + 1;	
      }//获取总页数
      if ($_GET['page'] == "") $_GET['page'] = 1;
      $page_class = 'page';
      $page['current'] = $_GET['page'];
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
        echo '<a href="index.php?page=1">&laquo;</a>';		
      }
      for($i;$i <= $max;$i++) {
      	if ($i == $page['current']) {
      	  echo '<b>' . $i . '</b>';	
      	} else {
      	  echo '<a href="index.php?page=' . $i . '">' . $i . '</a>';
        }
      }
      if ($page['current'] != $page['total'] ) {
        echo '<a href="index.php?page=' . $page['total'] . '">&raquo;</a>';	
      }
      echo '<span class="total">共' . $page['total'] . '页</span>';
    }

    function get_entry_by_page($perpage) {
      if ($_GET['page'] == "") {
        $_GET['page'] = 1;	
      } 
      $page = $_GET['page'];
      $start_entry = ($page - 1) * $perpage;
      $entrys = sql_query('SELECT * FROM ' . DB_PREFIX . 'entry ORDER BY time DESC LIMIT ' . $start_entry . ', ' . $perpage);
      return $entrys;	
    }
    
    function sync_fanfou($post,$name,$pass) {
      $curl = curl_init();
      $post_data = 'status=' . urlencode($post) . '&source=fantang';
      curl_setopt($curl, CURLOPT_URL, 'http://api.fanfou.com/statuses/update.xml');
      curl_setopt($curl, CURLOPT_USERPWD, $name . ':' . $pass);
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
      $json = curl_exec($curl);
      curl_close($curl);
    }

    function sync_digu($post,$name,$pass) {
      $curl = curl_init();
      $post_data = 'content=' . urlencode($post) . '&source=API';
      curl_setopt($curl, CURLOPT_URL, 'http://api.minicloud.com.cn/statuses/update.xml');
      curl_setopt($curl, CURLOPT_USERPWD, $name . ':' . $pass);
      curl_setopt($curl, CURLOPT_POST, true);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
      $json = curl_exec($curl);
      curl_close($curl);
    }
    
    
    function sync_sohu($post,$name,$pass) {
    	$post_data = 'status='.urlencode($post);
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt($curl, CURLOPT_USERPWD, $name . ':' . $pass);
    	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
     	curl_setopt($curl, CURLOPT_HEADER, 0);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
	    curl_setopt($curl, CURLOPT_URL, 'http://api.t.sohu.com/statuses/update.json');
	    $cdata = curl_exec($curl);
    }
    
    function sync_leihou($post,$name,$pass) {
    	$post_data = 'status='.urlencode($post);
	    $curl = curl_init();
	    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
      curl_setopt($curl, CURLOPT_USERPWD, $name . ':' . $pass);
    	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
     	curl_setopt($curl, CURLOPT_HEADER, 0);
      curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
	    curl_setopt($curl, CURLOPT_URL, 'http://leihou.com/statuses/update.json');
	    $cdata = curl_exec($curl);
    }
    
    function sync_tumblr($post,$name,$pass) {
			// Prepare POST request
				$request_data = http_build_query(
				    array(
				        'email'     => $name,
				        'password'  => $pass,
				        'type'      => 'quote',
				        'quote'    => $post,
				        'source'   => '<a href="' . MF_URL . '" alt="' . MF_NAME . '">' . MF_NAME . '</a>'
				    )
				);
			
			// Send the POST request (with cURL)
			$c = curl_init('http://www.tumblr.com/api/write');
			curl_setopt($c, CURLOPT_POST, true);
			curl_setopt($c, CURLOPT_POSTFIELDS, $request_data);
			curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($c);
			$status = curl_getinfo($c, CURLINFO_HTTP_CODE);
			curl_close($c);
    }
    
    function Douban($username, $subject, $apikey) {       
      if ($apikey == "") {
        $apikey='064e10081295144112ea301837bf3cc3';
      }
      $douban='http://api.douban.com/people/' . $username . '/collection?cat=' . $subject . '&apikey=' . $apikey ;
      $f = new SaeFetchurl();
      $content = $f->fetch($douban);
      $feed =  simplexml_load_file($content);
      $children =  $feed->children('http://www.w3.org/2005/Atom');
      $a = $children-> entry->children('http://www.w3.org/2005/Atom')->xpath('//db:subject');
      echo '<ul>';
      foreach ($a as $d) echo '<li>' . $d -> title . '</li>';
      echo '</ul>';
    }
    
    function get_nickname_by_userid($userid) {
    	
    }

    function http($url) {
    	if (substr($url, 0, 7) != 'http://') {
		    $url = 'http://' . $url;
	    }	
	    return $url;
    }
    
    function search_key($text) {
	    preg_match_all("/#(.*)#/U",$text,$key,PREG_PATTERN_ORDER);
	    $count = count($key[1]);
	    for($i=0;$i < $count;$i++) {
	     $keys = '|\#' . $key[1][$i] . '\#|';
	     $text = preg_replace($keys, '#<a href="index.php?page=search&q=' . $key[1][$i] . '">' . $key[1][$i] . '</a>#', $text);
	    }
    	return $text;
    }
    
    function video($url) {
    	preg_match_all("/http\:\/\/(.*)\.com/U",$url,$type,PREG_PATTERN_ORDER);
    	switch ($type[1][0]) {
    		case 'v.youku':
          preg_match_all("/id_(.*).html/U",$url,$youku,PREG_PATTERN_ORDER);
          return '<p><embed width="320" height="240" pluginspage="http://www.macromedia.com/go/getflashplayer" flashvars="isShowRelatedVideo=false&amp;VideoIDS=' . $youku[1][0] . '&amp;isAutoPlay=false&amp;isDebug=false&amp;UserID=0&amp;RecordCode=1001,1002,1003,1004,1005,1006,2001,3001,3002,3003,3004,3005,3007,3008,9999&amp;RecordResource=index&amp;isLoop=false&amp;winType=index&amp;playMovie=true&amp;MMControl=true&amp;MMout=true" wmode="transparent" quality="high" bgcolor="#FFFFFF" name="index_player_swf" id="index_player_swf" src="http://static.youku.com/v1.0.0141/v/swf/qplayer.swf" type="application/x-shockwave-flash"></p>';	
        break;
        
        case 'www.tudou':
          preg_match_all("/view\/(.*)\//U",$url,$tudou,PREG_PATTERN_ORDER);
          return '<p><embed src="http://www.tudou.com/v/' . $tudou[1][0] . '/v.swf" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" wmode="opaque" width="320" height="240"></embed></p>';
        break; 
        
        case 'v.ku6':
          preg_match_all("/show\/(.*)\.html/U",$url,$ku,PREG_PATTERN_ORDER);
          return '<p><embed width="320" height="240" name="plugin" src="http://player.ku6cdn.com/default/out/pv201102251335.swf?ver=108&amp;vid=' . $ku[1][0] . '&amp;type=v&amp;referer=" type="application/x-shockwave-flash"></p>';
        break;
        
        case 'www.56':
          preg_match_all("/v_(.*).html/U",$url,$wl,PREG_PATTERN_ORDER);
          return '<p><embed src="http://player.56.com/v_' . $wl[1][0] . '.swf"  type="application/x-shockwave-flash" width="320" height="240" allowNetworking="all" allowScriptAccess="always"></embed></p>';
        break;
      }
    }
    
    function formaturl($t) {
        $t = htmlspecialchars(preg_replace("/http:\/\/[\w-.?\/=&%:]*/i", "[+@] href=\"\$0\" target=\"_blank\"[@+]\$0[-@+]", $t), ENT_NOQUOTES);
        $t = str_replace(array('[+@]','[@+]','[-@+]'), array('<a','>','</a>'), $t);
        return $t;
    }
    
		function write($text,$file) {
			$handle = @fopen($file, 'w');
		
			if ( @flock($handle, LOCK_EX) )
			{
				@fwrite($handle, $text);
		
				@flock($handle, LOCK_UN);
			}
					
			@fclose($handle);	
		}

    function get_microblog() {
  	  $user = sql_query('SELECT * FROM ' . DB_PREFIX . 'user WHERE username ="' . $_COOKIE['login_user'] . '"');
      $user = mysql_fetch_array($user);
      $microblog = unserialize($user['microblog']);
      return $microblog;
    }
    
    function sync_option($type) {
    	$microblog = get_microblog();
    	if($type == 'sina' OR $type == 'qq' OR $type == '163') {
    	  if ($microblog[$type]['id'] != '') {
    	    return TRUE;	
    	  }	else {
    	    return FALSE;	
    	  }
    	} else {
	    	if ($microblog[$type]['name'] != '' AND $microblog[$type]['pass'] != '') {
	    	  return TRUE;	
	    	} else {
	    	  return FALSE;	
	    	}
	    }
    }
    
    function service_option($type) {
      $service = sql_query('SELECT * FROM ' . DB_PREFIX . 'user WHERE administrator ="1"');
      $service = mysql_fetch_array($service);
      if ($service[$type] != '') {
        return TRUE;	
      }	else {
        return FALSE;	
      }
    }
    
 
?>