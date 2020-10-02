<?php
	include('connect.php');

	$first_name = $_REQUEST['first_name'];
	$last_name = $_REQUEST['last_name'];
	$email = $_REQUEST['email'];
	$phone = $_REQUEST['phone'];
	$username = $_REQUEST['username'];
	$password = $_REQUEST['password'];

	$arfields = array(
		'firstName' => $first_name,
		'lastName' => $last_name,
		'email' => $email,
		'phoneNumber' => $phone,
		'username' => $username,
		'password' => $password,
	);

	$data = json_encode($arfields);
	//print_r($data); exit;

	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => API_URL."User/CreateUser",
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
	//if( isset($res['token']) && !empty($res['token']) )
	{
		$_SESSION[SESS_PRE.'_USER_TOKEN'] =  $res['token'];
		$_SESSION[SESS_PRE.'_REFRESH_TOKEN'] =  $res['refreshToken'];
		$db->setSessionExpiration();
		$db->location(SITEURL.'confirmation/');
		exit;
	}
	else
	{
		$_SESSION['MSG'] = $response;
		$db->location(SITEURL.'signup/');
		exit;
	}
?>