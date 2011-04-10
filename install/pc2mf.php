<html>
<head>
<title>PageCookery转微饭程序 </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
    textarea {width:100%;height:200px;}
    form {width:400px;}
    button {float:right;}
    #footer {width:100%;text-align:center;position:fixed;bottom:0px;}
</style>
</head>
<body>
<?php 
    require_once 'config.php'; //连接数据库   
    function mysql_run($sqlcon){   
      $con=mysql_connect(DB_HOST, DB_USER,DB_PASSWD);
      mysql_select_db(DB_NAME);
      mysql_query("SET NAMES 'utf8'");
      $result = mysql_query($sqlcon);
      mysql_close($con);
      return $result;
    }

?>

<p>复制下列代码并在phpMyadmin中执行即可<a href="http://img1.dnschina.net/files/68/insert_into_sql.png" target="_blank" style="font-size:12px;">不懂请看图</a></p>
<textarea>

<?php

$content = mysql_run('SELECT * FROM entry');
while($entry=mysql_fetch_array($content)){
  $b['userid'] = $entry['userid'];
  $b['nickname'] = '';
  $b['email'] ='';
  $b['url'] = '';
  $b['content'] = $entry['content'];
  $b['time'] = $entry['time'];
  $b['from'] = $entry['from'];
  $b['reply_id'] = 0;
}
$reply = mysql_run('SELECT * FROM reply');
while($item = mysql_fetch_array($teply)) {
  $a['userid'] = $item['userid'];
  $a['nickname'] = $item['nickname'];
  $a['email'] =$item['email'];
  $a['url'] = $item['url'];
  $a['content'] = $item['message'];
  $a['time'] = $item['time'];
  $a['from'] = '网页';
  $a['reply_id'] = $item['entryid'];
}
$c = $a + $b;
foreach ($c as $data) {
  echo "INSERT INTO `entry` VALUES ";
  echo "(''," . $c['userid'] . ",'" . $c['nickname'] . "'," . $c['email'] . "'," . $c['url'] . "'," . htmlspecialchars( str_replace('\\','',$c['content']) , ENT_QUOTES ) . "'," . $c['time'] . ",'" . $c['from'] . "'," . $c['reply_id'] . "',);";
}
?>


<?php
$re = mysql_run('SELECT * FROM ' . DB_PREFIX . 'reply');
while($reply =mysql_fetch_object($re)){
        echo "INSERT INTO `reply` VALUES";
        echo "(''," . $reply -> tid .",'Great Fire Wall', '" . $reply -> ip . "','" . $reply -> content . "'," . $reply -> date . ",'0','" . $reply -> name . "');";
}
?>
</textarea>
<p style="margin-top:15px;color:#AAA;">
        友情提示：<br>
        1.请确定你是在PageCookery的表中执行代码，并确保PageCookery已经安装，即存在entry和reply两个表。<br>
        2.部分对数据库架构进行过变动的用户可能会导入失败，请修改相关代码后再进行导入。<br>
        3.导入前请将原数据库进行备份，以免发生意外损失。
</p>
<div id="footer">Powered By <a href="http://imnerd.org">怡红公子</a> | 欢迎报告 <a href="mailto:i@imnerd.org">BUG</a></div>
<body>
</html>