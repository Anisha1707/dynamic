<?php
	include('connect.php');
	$db->checkLogin();
	
	print $_SESSION[SESS_PRE.'_USER_TOKEN'];
	//$_SESSION[SESS_PRE.'_TAX_APPLICATION_ID'] = 9;
	//print_r($_REQUEST);

	$mode = $_REQUEST['mode'];

	$firstName = $_REQUEST['firstName'];
	$middleName = $_REQUEST['middleName'];
	$lastName = $_REQUEST['lastName'];
	$ssn = $_REQUEST['ssn'];
	$dateOfBirth = $_REQUEST['dateOfBirth'];
	$spouseID = $_REQUEST['spouseID'];
	$taxApplicationID = $_REQUEST['taxApplicationID'];

	if( empty($taxApplicationID) || is_null($taxApplicationID) || $taxApplicationID <= 0 )
		$taxApplicationID = $_SESSION[SESS_PRE.'_TAX_APPLICATION_ID'];

	$ardateOfBirth = explode('/', $dateOfBirth);
	$dateOfBirth = $ardateOfBirth[2] . '-' . $ardateOfBirth[0] . '-' . $ardateOfBirth[1];
	$arfields = array(
		'taxApplicationId' => (int) $taxApplicationID,
		'firstName' => $firstName,
		'middleName' => $middleName,
		'lastName' => $lastName,
		'ssn' => $ssn,
		'dateOfBirth' => $dateOfBirth, 
		'isITIN' => false
	);

	if( $mode == 'edit' )
	{
		//$arfields['spouseID'] = (int) $_SESSION[SESS_PRE.'_SPOUSE_ID'];
		$arfields['spouseId'] = (int) $spouseID;
	}

	$data = json_encode($arfields);
	//print_r($data); //exit;

	$curl = curl_init();

	if( $mode == 'edit' )
	{
		curl_setopt_array($curl, array(
		  CURLOPT_URL => API_URL."TaxApplication/SaveTaxApplicationSpouseInformation",
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
	else
	{
		curl_setopt_array($curl, array(
		  CURLOPT_URL => API_URL."TaxApplication/CreateTaxApplicationSpouseInformation",
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
    	$_SESSION['MSG'] = 'Spouse_Info_Success';
    	if( $mode == 'add' )
    	{
    		$_SESSION[SESS_PRE.'_SPOUSE_ID'] = $res['spouseId'];
			$db->location(SITEURL.'spouse-address/');
    	}
		else
			$db->location(SITEURL.'review/');
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
			$db->location(SITEURL.'spouse-information/');
		else
			$db->location(SITEURL.'spouse-information/'.$taxApplicationID.'/'.$spouseID.'/edit/');
		exit;
	}
?>