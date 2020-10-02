<?php
	error_reporting(0);
	session_start();
	date_default_timezone_set('America/Los_Angeles');
	ini_set('default_charset', 'UTF-8');
	ini_set('max_execution_time', 0);

	include("include/define.php");
	include("include/function.class.php");

	$db = new Functions();
	include("refresh_token.php");
?>