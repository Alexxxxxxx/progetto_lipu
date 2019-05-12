<?php

	require "library.php";

	session_start();
	if (!isset($_SESSION["start_time"])){
		header('Location:login.php');
		die();
	}
    else {
		$now = time();
		$start = $_SESSION["start_time"];
		$time = $now - $start;
		if ($time > (3600*24)) // 3600s * 24 => 1d
		{
			header('Location:logout.php');
			die();
		}
	}
?>