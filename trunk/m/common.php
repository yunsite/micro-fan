<?php
  session_start(); 
  require_once '../config/config.php';
  require_once '../config/config.site.php';
  require_once '../config/config.micro.php';
  require_once '../lib/function.php';
  require_once '../lib/oauth.php';
  require_once '../lib/163_client.php';
  require_once '../lib/sina_client.php';
  require_once '../lib/qq_client.php';
  $perpage = "20";
?>