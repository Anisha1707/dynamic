<?php
	include('connect.php');

	$username = $_REQUEST['username'];
	$password = $_REQUEST['password'];

	$arfields = array(
		'username' => $username,
		'password' => $password,
	);

	$data = json_encode($arfields);
	//print_r($data); exit;

	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => API_URL."Authentication/Authenticate",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS =>$data,
	  CURLOPT_HTTPHEADER => array(
	    "Content-Type: application/json", 
	  ),
	));

	$response = curl_exec($curl);
	$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE); // curl response code
	curl_close($curl);

	$res = json_decode($response, true);
	//print '<pre>'; print_r($res); exit;

    if( $httpcode == 200 )
    {
		$_SESSION[SESS_PRE.'_USER_TOKEN'] =  $res['token']['token'];
		$_SESSION[SESS_PRE.'_REFRESH_TOKEN'] =  $res['token']['refreshToken'];
		$db->setSessionExpiration();
    }

	if( isset($res['healthCheck']) && !empty($res['healthCheck']) && !is_null($res['healthCheck']) )
	{
		if( !$res['healthCheck']['passwordHealthGood'] )
			$_SESSION[SESS_PRE.'_HEALTH_PASSWORD'] = 1;
		if( !$res['healthCheck']['disclaimerHealthGood'] )
			$_SESSION[SESS_PRE.'_HEALTH_DISCLAIMER'] = 1;

		if( !$res['healthCheck']['usernameHealthGood'] )
		{
			$_SESSION[SESS_PRE.'_HEALTH_USERNAME'] = 1;
			$db->location(SITEURL.'health-username/');
			exit;
		}
		else if( !$res['healthCheck']['passwordHealthGood'] )
		{
			$db->location(SITEURL.'health-password/');
			exit;
		}
		else if( !$res['healthCheck']['disclaimerHealthGood'] )
		{
			$db->location(SITEURL.'health-disclaimer/');
			exit;
		}
		else
		{
			$db->location(SITEURL.'customer-portal/');
			exit;
		}

	}

	if( isset($res['token']) && !empty($res['token']) )
	{
		$db->location(SITEURL.'customer-portal/');
		exit;
	}
	else
	{
		$_SESSION['MSG'] = $res['message'];
		$db->location(SITEURL);
		exit;
	}
?>