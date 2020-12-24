<?php
	include('connect.php');

	$mode = $_REQUEST['mode'];

	if( $mode == 'confirm' )
	{
		$code = '';
		for( $i=1; $i<=6; $i++ )
			$code .= $_REQUEST['letter_'.$i];

		$querystring = '?userToken='.$_SESSION[SESS_PRE.'_FORGOT_TOKEN'].'&securityCode='.$code;

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  	CURLOPT_URL => API_URL."Authentication/ForgotPasswordConfirmationCode".$querystring,
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

		if( $httpcode == 200 )
		{
			echo '1';
			exit;
		}
		else
		{
			echo $res['message'];
			exit;
		}
	}

	if( $mode == 'change' )
	{
		$code = '';
		for( $i=1; $i<=6; $i++ )
			$code .= $_REQUEST['letter_'.$i];

		$password = $_REQUEST['password'];

		$querystring = '?userToken='.$_SESSION[SESS_PRE.'_FORGOT_TOKEN'].'&securityCode='.$code.'&newPassword='.$password;

		$curl = curl_init();

		// NOTE: deliveryMode must be passed as Querystring only and add Content-Length header too.
		curl_setopt_array($curl, array(
		  	CURLOPT_URL => API_URL."Authentication/UpdatePassword".$querystring,
		  	CURLOPT_RETURNTRANSFER => true,
		  	CURLINFO_HEADER_OUT => true,
		  	CURLOPT_ENCODING => "",
		  	CURLOPT_MAXREDIRS => 10,
		  	CURLOPT_TIMEOUT => 0,
		  	CURLOPT_FOLLOWLOCATION => true,
		  	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  	CURLOPT_CUSTOMREQUEST => "PUT",
		  	CURLOPT_HTTPHEADER => array(
	            "Content-Length: 121"
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
?>