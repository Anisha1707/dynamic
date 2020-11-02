<?php
	error_reporting(0);
	session_start();
	//date_default_timezone_set('America/Los_Angeles');
	date_default_timezone_set('Asia/Kolkata');
	ini_set('default_charset', 'UTF-8');
	ini_set('max_execution_time', 0);

	include("include/define.php");
	include("include/function.class.php");

	$db = new Functions();
	include("refresh_token.php");

	$percentage_page = array(
		'0' => 'tax-application/', 
		'10' => 'personal-information/', 
		'20' => 'address/', 
		'30' => 'identification-information/', 
		'40' => 'tax-pin/', 
		'50' => 'family-question/', /* 'spouse-information/'' */
		'52' => 'spouse-address/', 
		'54' => 'spouse-identification-information/', 
		'56' => 'spouse-occupation/', 
		'58' => 'spouse-tax-pin/', 
		'60' => 'family-question-dependent/', 
		'65' => 'dependent/',  	/* 'dependents-information/' */
		'70' => 'documents/', 
		'75' => 'tax-documents/',  	/* 'tax-documents-upload/' */ 
		'80' => 'review/', 
		'90' => 'sign-your-application/', 
		'100' => 'download/', 
	);
?>