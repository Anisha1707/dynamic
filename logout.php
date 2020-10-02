<?php
	include("connect.php");

	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => API_URL."Authentication/Logout",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_HTTPHEADER => array(
	    "Authorization: Bearer ".$_SESSION[SESS_PRE.'_USER_TOKEN']
	  ),
	));

	$response = curl_exec($curl);
	$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE); // curl response code
	curl_close($curl);

	$res = json_decode($response, true);
	//print '<pre>'; print_r($res); exit;

	//if( $httpcode == 200 )
	{
		$db->unsetSession();
		$db->location(SITEURL);
		exit;
	}
?>