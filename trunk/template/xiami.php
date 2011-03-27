<div id="main" class="xiami">
<div style="width:580px;height:70px;margin:5px auto 0;overflow:hidden;-webkit-box-shadow:#999 1px 1px 3px;-moz-box-shadow:#999 1px 1px 3px;box-shadow:#999 1px 1px 3px;">
<iframe src="http://www.xiami.com/song/play?ids=/song/playlist/id/2382481/type/3" width="755" height="555" allowtransparency="true" scrolling="no" style="margin:-43px 0 0 -30px;border:none 0;" id="player"></iframe>
</div>
<ul class="music">
<?php 
  foreach($track[1] as $item){
  	preg_match_all( "/\<song_id\>(.*?)\<\/song_id\>/",$item, $song_id ); 
  	preg_match_all( "/\<album_cover\><!\[CDATA\[(.*?)\]\]>\<\/album_cover\>/",$item, $song_album );
  	preg_match_all( "/\<song_name\><!\[CDATA\[(.*?)\]\]>\<\/song_name\>/", $item, $song_name );
  	preg_match_all( "/\<artist_name\><!\[CDATA\[(.*?)\]\]>\<\/artist_name\>/", $item, $song_artist);
  	$song = array ('id' => $song_id[1][0], 'album' => $song_album[1][0], 'name' => $song_name[1][0], 'artist' => $song_artist[1][0]);
    echo '<li id="song_' . $song['id'] . '" onclick="xiami(this.id);"><img class="l" src="' . $song['album'] . '"><p><b>' . $song['name'] . '</b><span>' . $song['artist'] . '</span></p></li>';
  }
?>
</ul>
<script type="text/javascript"> 
 function $(id){return document.getElementById(id);}
 if(location.hash.substring(1,2)=='!'){$('song_'+location.hash.substring(2)).onclick();}else{$('player').src='http://www.xiami.com/res/player/xiamiMusicPlayer_ld.swf?dataUrl=/song/playlist/id/2382481/type/3';}
 function xiami(id){$('player').src='http://www.xiami.com/res/player/xiamiMusicPlayer_ld.swf?dataUrl=http://www.xiami.com/song/playlist/id/'+id.substring(5)+'/object_name/default/object_id/0';self.location.href='#!'+id.substring(5);}
</script>
</div>