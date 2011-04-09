<div id="main" class="douban">
	<ul>
		<?php
			$user = mysql_fetch_array(sql_query('SELECT * FROM ' . DB_PREFIX . 'user WHERE administrator = "1"'));
			$username = $user['douban'];
			$douban='http://api.douban.com/people/' . $username . '/collection?cat=movie&apikey=014105b54a6f531a03c3111fdf4df94e&max-results=48' ;
			$douban = file_get_contents($douban);
			preg_match_all("/\<db\:subject\>(.*?)<\/db\:subject>/s",$douban,$subject);
			foreach($subject[1] as $item) {
				preg_match_all("/<id>(.*?)\<\/id>/s",$item,$id);
				preg_match_all("/<title>(.*?)<\/title>/s",$item,$title);
				preg_match_all("/\<link href=\"(.*?)\"/s",$item,$image);
				$movie = array('id' => $id[1][0], 'title' => $title[1][0], 'image' => $image[1][2], 'link' => $image[1][1]);
				echo '<li><img src="' . $movie['image'] . '" alt="' . $movie['title'] . '"></li>';
			}
		?>
	</ul>
</div>