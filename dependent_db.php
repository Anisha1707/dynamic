<?php
	include('connect.php');
	$db->checkLogin();

	$mode = $_REQUEST['mode'];
	$id = $_REQUEST['id'];

	if( $mode == 'delete' )
	{
		$querystring = '?dependentId='.$id;

		$curl = curl_init();

		// NOTE: deliveryMode must be passed as Querystring only and add Content-Length header too.
		curl_setopt_array($curl, array(
		  	CURLOPT_URL => API_URL."TaxApplication/DeleteTaxApplicationDependent".$querystring,
		  	CURLOPT_RETURNTRANSFER => true,
		  	CURLINFO_HEADER_OUT => true,
		  	CURLOPT_ENCODING => "",
		  	CURLOPT_MAXREDIRS => 10,
		  	CURLOPT_TIMEOUT => 0,
		  	CURLOPT_FOLLOWLOCATION => true,
		  	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  	CURLOPT_CUSTOMREQUEST => "DELETE",
		  	CURLOPT_HTTPHEADER => array(
	            "Authorization: Bearer ".$_SESSION[SESS_PRE.'_USER_TOKEN'], 
	            "Content-Length: 10"
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