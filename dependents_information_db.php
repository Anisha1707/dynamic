<?php
	include('connect.php');
	$db->checkLogin();
	//print $_SESSION[SESS_PRE.'_USER_TOKEN'];
	//$_SESSION[SESS_PRE.'_TAX_APPLICATION_ID'] = 9;
	//print_r($_REQUEST);

	$mode = $_REQUEST['mode'];
	$back = $_REQUEST['back'];

	$firstName = $_REQUEST['firstName'];
	$lastName = $_REQUEST['lastName'];
	$dependentType = $_REQUEST['dependentType'];
	$ssn = $_REQUEST['ssn'];
	$dateOfBirth = $_REQUEST['dateOfBirth'];
	$id = (int) $_REQUEST['id'];

	$ardateOfBirth = explode('/', $dateOfBirth);
	$dateOfBirth = $ardateOfBirth[2] . '-' . $ardateOfBirth[0] . '-' . $ardateOfBirth[1];

	$arfields = array(
		'taxApplicationId' => $_SESSION[SESS_PRE.'_TAX_APPLICATION_ID'],
		'id' => $id,
		'firstName' => $firstName,
		'lastName' => $lastName,
		'dependentType' => $dependentType,
		'ssn' => $ssn,
		'dateOfBirth' => $dateOfBirth
	);

	$data = json_encode($arfields);
	//print_r($data); exit;

	$curl = curl_init();

	if( $mode == 'add' )
	{
		curl_setopt_array($curl, array(
		  CURLOPT_URL => API_URL."TaxApplication/CreateTaxApplicationDependent",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS =>$data,
		  CURLOPT_HTTPHEADER => array(
		    "Authorization: Bearer ".$_SESSION[SESS_PRE.'_USER_TOKEN'],
		    "Content-Type: application/json"
		  ),
		));
	}
	else if( $mode == 'edit' )
	{
		curl_setopt_array($curl, array(
		  CURLOPT_URL => API_URL."TaxApplication/SaveTaxApplicationDependent",
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
	}

	$response = curl_exec($curl);
	//print_r($response);
	$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE); // curl response code
	curl_close($curl);

	$res = json_decode($response, true);
	// print $httpcode;
	// print '<pre>'; print_r($res); exit;

    if( $httpcode == 200 )
    //if( strtolower($res['status']) == 'success' )
    {
    	$_SESSION['MSG'] = 'Dependent_Info_Success';
		if( $back == 'review' )
			$db->location(SITEURL.'review/');
		else
			$db->location(SITEURL.'dependent/');
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
			$db->location(SITEURL.'dependents-information/');
		else
		{
			if( $back == 'review' )
				$db->location(SITEURL.'dependents-information/'.$id.'/review/');
			else
				$db->location(SITEURL.'dependents-information/'.$id.'/');
		}
		exit;
	}
?>