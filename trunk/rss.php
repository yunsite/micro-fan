<?php
header('Content-type: text/xml');
require_once 'lib/function.php';
require_once 'config/config.php';
require_once 'config/config.site.php';
$entry = sql_query('SELECT * FROM ' . DB_PREFIX . 'entry ORDER BY time DESC LIMIT 0,20');
echo '<?xml version="1.0" encoding="utf-8"?><rss version="2.0">';
echo '<channel>';
echo '<title><![CDATA[' . stripslashes(MF_NAME) . ']]></title>';
echo '<link>' . MF_URL . '</link>';
echo '<description><![CDATA[' . $site['introduction'] . ']]></description>';
echo '<language>zh</language>';
echo "<copyright>Copyright 2011 Powerd By MicroFan</copyright>";
while ($item = mysql_fetch_object($entry)) {
  echo '<item>';
  echo '<title><![CDATA[' . strip_tags(str_replace('&nbsp;', ' ',$item -> content)) . ']]></title>';
  echo '<link>' . MF_URL . 'index.php?page=view' . stripslashes('&amp;') .'id=' . $item -> id. '</link>';
  echo '<description><![CDATA[]]></description>';
  echo '<pubDate>' . date('r', $item -> time) . '</pubDate>';
  echo '</item>';
}
echo '</channel>';
echo '</rss>';
?>