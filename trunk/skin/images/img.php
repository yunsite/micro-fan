<?php
  header("Content-type: image/png");
  error_reporting(E_ALL ^ E_NOTICE);
  require_once '../../config/config.php';
  require_once '../../config/config.site.php';
  require_once '../../lib/function.php';
  function strlength($str) {
    $i = 0;
    $count = 0;
    $len = strlen ($str);
    while ($i < $len) {
      $chr = ord ($str[$i]);
      $count++;
      $i++;
      if($i >= $len) break;
      if($chr & 0x80) {
        $chr <<= 1;
        while ($chr & 0x80) {
          $i++;
          $chr <<= 1;
        }
      }
    }
    return $count;
  }
  if ($_GET['userid'] == "") { $_GET['userid'] = 1; }
  $im = imagecreatefrompng("s.png");
  $white = imagecolorallocate($im, 255,255,255);
  $grey = imagecolorallocate($im, 150,150,150);
  $black = imagecolorallocate($im, 0,0,0);
  $blue = imagecolorallocate($im, 51,153,204);
  $entry = sql_query('SELECT * FROM ' . DB_PREFIX . 'entry ORDER BY time DESC LIMIT 0,1');
  $last_entry = mysql_fetch_object($entry);
  $content = strip_tags($last_entry -> content);
  $hang = round(strlength($content) / 13);
  $size = 14 - ($hang - 1) * 2;
  $heigh = intval(60 / $hang); 
  for ($i=0;$i < $hang;$i++) {
    $height = 20 + ($i + 1) * $heigh;
    if ($height < 80) {
      imagettftext($im, $size, 0, 120, $height, $black, "../../lib/SofiaSans.ttf", substr($content,$i*51,51));
    }	
  }
  imagettftext($im, 10, 0, 120, 20, $black, "../../lib/SofiaSans.ttf", MF_URL);
  imagettftext($im, 10, 0, 120, 80, $grey, "../../lib/SofiaSans.ttf", time_past($last_entry -> time));
  imagettftext($im, 14, 0, 190, 100, $blue, "../../lib/SofiaSans.ttf", MF_NAME);
  imagettftext($im, 10, 0, 190, 114, $blue, "../../lib/SofiaSans.ttf", MF_URL);
  //$user = sql_query('SELECT * FROM ' . DB_PREFIX . 'user WHERE administrator =' . $_GET['userid']);
  //$email = mysql_fetch_object($user) -> email;
  $src = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( 'i@imnerd.org' ) ) ) . "?d=" . urlencode( "http://www.gravatar.com/avatar/ad516503a11cd5ca435acc9bb6523536?s=40") . "&s=98";
  $src_im = imagecreatefromjpeg($src);
  $src_info = getimagesize($src);
  imagecopy ( $im, $src_im ,12, 12,0,0,$src_info[0] ,$src_info[1]);
  imagepng($im);
  imagedestroy($im);
  imagedestroy($src);
?>