<?php
header('Content-Type:application/javascript;charset=utf-8');
require_once("../config/config.php");
require_once("../lib/function.php");
if (!isset($_GET['mount'])){
        $_GET['mount']='10';
}
if (!isset($_GET['userid'])){
        $_GET['userid']='1';
}
?>
document.getElementById('microfan').innerHTML='<?php
if(preg_match("/^[0-9]*$/",$_GET['mount'])){
$entry = sql_query('SELECT * FROM ' . DB_PREFIX . 'entry WHERE userid = "' . $_GET['userid'] . '"ORDER BY time DESC LIMIT '.$_GET['mount']);
echo '<style type="text/css">#microfan img {display:none;}</style><ul>';
while($item = mysql_fetch_object($entry)){
echo '<li>';
echo nl2br($item -> content);
echo '<a href="' . $fan_url .'?page=view&id=' . $item -> id . '" target="_blank"><span class="time">' . time_past($item -> time) . '</span></a>';
echo '</li>';
}
echo '</ul>';
}else{
echo '这里没有你要的东西呢';
}
?>';