<?php
	include('connect.php');
	$db->checkLogin();
	//print $_SESSION[SESS_PRE.'_USER_TOKEN'];
	//print_r($_REQUEST);

	$mode = $_REQUEST['mode'];

	$firstName = $_REQUEST['firstName'];
	$middleName = $_REQUEST['middleName'];
	$lastName = $_REQUEST['lastName'];
	$ssn = $_REQUEST['ssn'];
	$dateOfBirth = $_REQUEST['dateOfBirth'];

	$ardateOfBirth = explode('/', $dateOfBirth);
	$dateOfBirth = $ardateOfBirth[2] . '-' . $ardateOfBirth[0] . '-' . $ardateOfBirth[1];

	$arfields = array(
		'firstName' => $firstName,
		'middleName' => $middleName,
		'lastName' => $lastName,
		'ssn' => $ssn,
		'dateOfBirth' => $dateOfBirth
	);

	$data = json_encode($arfields);
	//print_r($data); exit;

	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => API_URL."Profile/SaveProfileInformation",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "PUT",
	  CURLOPT_POSTFIELDS =>$data,
	  CURLOPT_HTTPHEADER => array(
	    "Authorization: Bearer ".$_SESSION[SESS_PRE.'_USER_TOKEN'],
	    "Content-Type: application/json"
	  ),
	));

	$response = curl_exec($curl);
	//print_r($response); exit;
	$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE); // curl response code
	curl_close($curl);

	$res = json_decode($response, true);
	//print '<pre>'; print_r($res); exit;

    if( $httpcode == 200 )
    {
    	//$_SESSION['MSG'] = 'Personal_Info_Success';
    	if( $mode == 'add' )
			$db->location(SITEURL.'address/');
		else
			$db->location(SITEURL.'review/');
		exit;
	}
	else if( $httpcode == 400 )
	{
		if( count($res['errorList']) > 1 )
		{
			$msg = 'Following errors occured:<br />';
			foreach ($res['errorList'] as $err) {
				$msg .= $err . '<br />';
			}
			$_SESSION['MSG'] = $msg;
		}
		else
			$_SESSION['MSG'] = $res['errorList'][0];
		$db->location(SITEURL.'personal-information/');
		exit;
	}
	else if( $httpcode == 401 )
	{
		$_SESSION['MSG'] = 'Session_Expired';
		$db->location(SITEURL);
		exit;
	}
	else
	{
		$_SESSION['MSG'] = 'Something_Wrong';
		if( $mode == 'add' )
			$db->location(SITEURL.'personal-information/');
		else
			$db->location(SITEURL.'personal-information/'.$taxApplicationID.'/edit/');
		exit;
	}
?>