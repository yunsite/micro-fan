<div id="main" class="flickr">
	<?php 
    $user = sql_query('SELECT * FROM ' . DB_PREFIX . 'user WHERE administrator = "1"');
    $user = mysql_fetch_array($user);
    $photoid = $user['photo'];
		$data = file_get_contents("http://api.flickr.com/services/rest/?method=flickr.people.getPublicPhotos&api_key=3df15beb1f581eda361ca6806fce63b5&user_id=" . $user['photo'] . "&per_page=32");
	  $object = simpleXML_load_string($data);
	  $photo = $object -> photos -> photo;
	  echo '<ul class="photos">';
	  foreach ($photo as $each) {
	    $photo_m = 'http://farm' . $each['farm'] . '.static.flickr.com/'	. $each['server'] . '/' . $each['id'] . '_' . $each['secret'] . '_m.jpg';
		  $photo_b = 'http://farm' . $each['farm'] . '.static.flickr.com/'	. $each['server'] . '/' . $each['id'] . '_' . $each['secret'] . '_b.jpg';
	 	  echo '<li>';
		  echo '<a href="' . $photo_b . '" class="lightbox"><img src="' . $photo_m . '" /></a>'; 
		  echo '</li>';
	  }
	  echo '</ul>';
 ?>
</div>