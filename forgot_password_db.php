<?php
	include('connect.php');

	$mode = $_REQUEST['mode'];

	if( $mode == 'confirm' )
	{
		$accountLookup = $_REQUEST['accountLookup'];
		$tokenType = $_REQUEST['tokenType'];

		$querystring = '?accountLookup='.$accountLookup.'&tokenType='.$tokenType;

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  	CURLOPT_URL => API_URL."Authentication/ForgotPassword".$querystring,
		  	CURLOPT_RETURNTRANSFER => true,
		  	CURLOPT_ENCODING => "",
		  	CURLOPT_MAXREDIRS => 10,
		  	CURLOPT_TIMEOUT => 0,
		  	CURLOPT_FOLLOWLOCATION => true,
		  	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  	CURLOPT_CUSTOMREQUEST => "POST",
		  	CURLOPT_HTTPHEADER => array(
	            "Content-Length: 121"
		  	),
		));

		$response = curl_exec($curl);
		$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE); // curl response code
		curl_close($curl);

		$res = json_decode($response, true);
		//print $httpcode; print_r($res); exit;

		if( $httpcode == 200 )
		{
			$_SESSION[SESS_PRE.'_FORGOT_TOKEN'] = $res['userToken'];
			echo '1';
			exit;
		}
		else
		{
			echo $res['message'];
			exit;
		}
	}

	if( $mode == 'send' )
	{
		$deliver = $_REQUEST['deliver'];
		$deliveryMode = 'Email';

		if( $deliver == 'sms' )
			$deliveryMode = 'SMS';
		else if( $deliver == 'email' ) 
			$deliveryMode = 'Email';

		$querystring = '?userToken='.$_SESSION[SESS_PRE.'_FORGOT_TOKEN'].'&deliveryMode='.$deliveryMode;

		$curl = curl_init();

		// NOTE: deliveryMode must be passed as Querystring only and add Content-Length header too.
		curl_setopt_array($curl, array(
		  	CURLOPT_URL => API_URL."Authentication/ForgotPasswordSendToken".$querystring,
		  	CURLOPT_RETURNTRANSFER => true,
		  	CURLINFO_HEADER_OUT => true,
		  	CURLOPT_ENCODING => "",
		  	CURLOPT_MAXREDIRS => 10,
		  	CURLOPT_TIMEOUT => 0,
		  	CURLOPT_FOLLOWLOCATION => true,
		  	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  	CURLOPT_CUSTOMREQUEST => "POST",
		  	CURLOPT_HTTPHEADER => array(
	            "Content-Length: 121"
		  	),
		));

		$response = curl_exec($curl);
		$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE); // curl response code
		curl_close($curl);

		$res = json_decode($response, true);
		//print $httpcode; print_r($res); exit;

		if( $httpcode == 200 )
			echo '1';
		else
			echo 'Something went wrong. Please try again!';
	}
?>