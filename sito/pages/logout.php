<?php
  require "library.php";
	// distruzione sessione corrente
	session_start();
	session_unset();
	session_destroy();
	$_SESSION = array();
  header("location: login.php");

?>