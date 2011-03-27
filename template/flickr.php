<div id="main" class="flickr">
	<ul>
		<?php 
      for($i=0;$i < $count;$i++) {
        preg_match_all("/farm=\"(.*?)\"/s",$photo[$i],$farm);
        preg_match_all("/server=\"(.*?)\"/s",$photo[$i],$server);
        preg_match_all("/id\=\"(.*?)\"/",$photo[$i],$id);
        preg_match_all("/secret\=\"(.*?)\"/",$photo[$i],$secret);
        $photo_m = 'http://farm' . $farm[1][0] . '.static.flickr.com/'	. $server[1][0] . '/' . $id[1][0] . '_' . $secret[1][0] . '_m.jpg';
        $photo_b = 'http://farm' . $farm[1][0] . '.static.flickr.com/'	. $server[1][0] . '/' . $id[1][0] . '_' . $secret[1][0] . '_b.jpg';	
        echo '<li><a href="' . $photo_b . '" class="lightbox"><img src="' . $photo_m . '" alt="" /></a></li>';
      }
    ?>
  </ul>
</div>