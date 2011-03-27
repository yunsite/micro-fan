<div id="main" class="douban">
<ul>
<?php
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