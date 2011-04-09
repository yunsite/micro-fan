<?php
  ob_start();
  session_start(); 
  error_reporting(E_ALL ^ E_NOTICE);
  require_once './lib/function.php';
  if (!file_exists('./config/config.php') OR !file_exists('./config/config.site.php')) {
  	go('./install');
  }
  require_once './config/config.php';
  require_once './config/config.site.php';
  require_once './lib/oauth.php';
  require_once './lib/163_client.php';
  require_once './lib/sina_client.php';
  require_once './lib/qq_client.php';
  $perpage = "20";
?>