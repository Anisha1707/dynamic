<?php
	include('connect.php');

	$mode = $_REQUEST['mode'];

	if( $mode == 'send' )
	{
		$deliver = $_REQUEST['deliver'];
		$deliveryMode = 'Email';

		if( $deliver == 'sms' )
			$deliveryMode = 'SMS';
		else if( $deliver == 'email' ) 
			$deliveryMode = 'Email';

		$querystring = '?deliveryMode='.$deliveryMode;

		$curl = curl_init();

		// NOTE: deliveryMode must be passed as Querystring only and add Content-Length header too.
		curl_setopt_array($curl, array(
		  	CURLOPT_URL => API_URL."User/SendSecurityCode".$querystring,
		  	CURLOPT_RETURNTRANSFER => true,
		  	CURLINFO_HEADER_OUT => true,
		  	CURLOPT_ENCODING => "",
		  	CURLOPT_MAXREDIRS => 10,
		  	CURLOPT_TIMEOUT => 0,
		  	CURLOPT_FOLLOWLOCATION => true,
		  	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  	CURLOPT_CUSTOMREQUEST => "POST",
		  	CURLOPT_HTTPHEADER => array(
	            "Authorization: Bearer ".$_SESSION[SESS_PRE.'_USER_TOKEN'], 
	            "Content-Length: 1"
		  	),
		));

		$response = curl_exec($curl);
		$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE); // curl response code
		curl_close($curl);

		$res = json_decode($response, true);

		if( $httpcode == 200 )
			echo '1';
		else
			echo 'Something went wrong. Please try again!';
	}

	if( $mode == 'confirm' )
	{
		$code = '';
		for( $i=1; $i<=6; $i++ )
			$code .= $_REQUEST['letter_'.$i];

		$querystring = '?code='.$code;

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  	CURLOPT_URL => API_URL."User/ConfirmUserAccount".$querystring,
		  	CURLOPT_RETURNTRANSFER => true,
		  	CURLOPT_ENCODING => "",
		  	CURLOPT_MAXREDIRS => 10,
		  	CURLOPT_TIMEOUT => 0,
		  	CURLOPT_FOLLOWLOCATION => true,
		  	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  	CURLOPT_CUSTOMREQUEST => "POST",
		  	CURLOPT_HTTPHEADER => array(
	            "Authorization: Bearer ".$_SESSION[SESS_PRE.'_USER_TOKEN'], 
	            "Content-Length: 121"
		  	),
		));

		$response = curl_exec($curl);
		$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE); // curl response code
		curl_close($curl);

		$res = json_decode($response, true);

		if( $httpcode == 200 )
		{
			//$_SESSION['MSG'] = 'Code_verified';
			echo '1';
			exit;
		}
		else
		{
			//$_SESSION['MSG'] = $res['message'];
			echo $res['message'];
			exit;
		}
	}
?>