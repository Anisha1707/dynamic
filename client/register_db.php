<?php
	include('connect.php');

	$first_name = $_REQUEST['first_name'];
	$last_name = $_REQUEST['last_name'];
	$email = $_REQUEST['email'];
	$phone = $_REQUEST['phone'];
	$franchiseCode = $_REQUEST['fran'];
	$preparerCode = $_REQUEST['prep'];

	$arfields = array(
		'franchiseCode' => $franchiseCode,
		'preparerCode' => $preparerCode,
		'firstName' => $first_name,
		'lastName' => $last_name,
		'email' => $email,
		'phone' => $phone,
	);

	$data = json_encode($arfields);
	//print_r($data); exit;

	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => API_URL."User/CreateLeadCapture",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS =>$data,
	  CURLOPT_HTTPHEADER => array(
	    "Content-Type: application/json"
	  ),
	));

	$response = curl_exec($curl);
	$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE); // curl response code
	curl_close($curl);
	//echo $response;	

	$res = json_decode($response, true);
	//print '<pre>'; print_r($res); exit;

	if( $httpcode == 200 )
	{
		$db->location(CLIENTURL.'thank-you/');
		exit;
	}
	else
	{
		$_SESSION['MSG'] = $response;
		$db->location(CLIENTURL.'register/'.$franchiseCode . '/' . $preparerCode . '/');
		exit;
	}
?>