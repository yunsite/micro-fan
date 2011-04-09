<?php
  header("Content-type: image/png");
  error_reporting(E_ALL ^ E_NOTICE);
  require_once '../../config/config.php';
  require_once '../../config/config.site.php';
  require_once '../../lib/function.php';
	function cut($content,$length) {
		preg_match_all("/(?x) (?: [\w-]+  | [\x80-\xff]{3} )/i",$content,$words);
		$word = $words[0];
		$count = count($word);
		$i = 0;
		$dan = 0;
		$b = 0;
		$begin[0] = 0;
		for($a=1;$a < $count;$a++) {
			$chang = 0;
		  for	($b=$i;$b < $count;$b++) {
		  	if ($chang > $length) {
		  	  $begin[$a] = $i;
		  	  break;	
		  	} else {
		  	  $i++;	
		  	}
		  	$chang += strlen($word[$b]);
		  }
		}
		for($m=1;$m<count($begin);$m++) {
			$con[$m] = "";
			$start = $m - 1;
			for($n=$begin[$start];$n<=$begin[$m];$n++) {
			  $con[$m] .= $word[$n];	
			}
		}
		return $con;
	}
  if ($_GET['userid'] != "") {
    $user = sql_query('SELECT * FROM ' . DB_PREFIX . 'user WHERE administrator = "' . $_GET['userid'] . '"');	
    $user = mysql_fetch_array($user);
    $email = $user['mail'];
  }
  if ($_GET['id'] !="") {
  	$entry = sql_query('SELECT * FROM ' . DB_PREFIX . 'entry WHERE id = "' . $_GET['id'] . '"');
  	$entry = mysql_fetch_array($entry);
  	$userid = $entry['userid'];
  	if ($userid != 0) {
  	  $user = sql_query('SELECT * FROM ' . DB_PREFIX . 'user WHERE administrator = "' . $userid . '"');	
		  $user = mysql_fetch_array($user);
		  $email = $user['mail'];
  	} else {
  	  $email = $entry['email'];	
  	}
  } else {
    $entry = sql_query('SELECT * FROM ' . DB_PREFIX . 'entry ORDER BY time DESC LIMIT 0,1');
    $entry = mysql_fetch_array($entry);
    $user = sql_query('SELECT * FROM ' . DB_PREFIX . 'user WHERE administrator = "1"');
	  $user = mysql_fetch_array($user);
	  $email = $user['mail'];
  }
  $content = strip_tags($entry['content']);
  $im = imagecreatefrompng("s.png");
  $white = imagecolorallocate($im, 255,255,255);
  $grey = imagecolorallocate($im, 150,150,150);
  $black = imagecolorallocate($im, 0,0,0);
  $blue = imagecolorallocate($im, 51,153,204);
  $content = cut($content,40);
  $hang = count($content);
  switch($hang) {
  	case '1':
  	  $size=13;
  	break;
  	case '2':
  	  $size=11;
  	break;
  	case '3':
  	  $size=9;
  	break;
  	default:
  	  $size=0;
  	break;
  }
  $hei = intval(40 / $hang); 
  for ($i=1;$i <= $hang;$i++) {
    $height = 20 + $i * $hei;
    imagettftext($im, $size, 0, 120, $height, $black, "../../lib/MicrosoftYaHeiGB.ttf", $content[$i]);
  }
  imagettftext($im, 10, 0, 120, 20, $black, "../../lib/MicrosoftYaHeiGB.ttf", MF_URL);
  imagettftext($im, 10, 0, 120, 80, $grey, "../../lib/MicrosoftYaHeiGB.ttf", time_past($entry['time']));
  imagettftext($im, 14, 0, 170, 100, $blue, "../../lib/MicrosoftYaHeiGB.ttf", MF_NAME);
  imagettftext($im, 10, 0, 170, 114, $blue, "../../lib/MicrosoftYaHeiGB.ttf", MF_URL);
  $src = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( "http://www.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s=40") . "&s=98";
  $src_im = imagecreatefromjpeg($src);
  $src_info = getimagesize($src);
  imagecopy ( $im, $src_im ,12, 12,0,0,$src_info[0] ,$src_info[1]);
  imagepng($im);
  imagedestroy($im);
  imagedestroy($src);
?>