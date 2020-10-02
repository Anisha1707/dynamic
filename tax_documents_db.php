<?php
	include('connect.php');
	$db->checkLogin();
	//print $_SESSION[SESS_PRE.'_USER_TOKEN'] . '<br /><br />';

	$mode = $_REQUEST['mode'];
	$id = $_REQUEST['id'];

	if( $mode == 'delete' )
	{
		$querystring = '?documentId='.$id;

		$curl = curl_init();

		// NOTE: deliveryMode must be passed as Querystring only and add Content-Length header too.
		curl_setopt_array($curl, array(
		  	CURLOPT_URL => API_URL."TaxApplication/DeleteTaxApplicationDocument".$querystring,
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
		//print '<pre>'; print_r($res);

		if( $httpcode == 200 )
			echo '1';
		else
			echo 'Something went wrong. Please try again!';

	}
?>