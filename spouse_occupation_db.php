<?php
	include('connect.php');
	$db->checkLogin();
	//print $_SESSION[SESS_PRE.'_USER_TOKEN'];
	//print_r($_REQUEST);

	$mode = $_REQUEST['mode'];

	$occupation = $_REQUEST['occupation'];
	$email = $_REQUEST['email'];
	$phoneNumber = $_REQUEST['phoneNumber'];
	$carrier = $_REQUEST['carrier'];
	$spouseID = $_REQUEST['spouseID'];
	$taxApplicationID = $_REQUEST['taxApplicationID'];

	if( empty($spouseID) || is_null($spouseID) || $spouseID <= 0 )
		$spouseID = $_SESSION[SESS_PRE.'_SPOUSE_ID'];

	if( empty($taxApplicationID) || is_null($taxApplicationID) || $taxApplicationID <= 0 )
		$taxApplicationID = $_SESSION[SESS_PRE.'_TAX_APPLICATION_ID'];

	$arfields = array(
		'taxApplicationId' => (int) $taxApplicationID,
		//'spouseId' => (int) $_SESSION[SESS_PRE.'_SPOUSE_ID'],
		'spouseId' => (int) $spouseID,
		'occupation' => $occupation,
		'email' => $email,
		'phoneNumber' => $phoneNumber,
		'carrier' => $carrier
	);

	$data = json_encode($arfields);
	//print_r($data); exit;

	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => API_URL."TaxApplication/SaveTaxApplicationSpouseOccupationAndContact",
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
	//print_r($response);
	$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE); // curl response code
	curl_close($curl);

	$res = json_decode($response, true);
	// print $httpcode;
	// print '<pre>'; print_r($res); exit;

    if( $httpcode == 200 )
    //if( strtolower($res['status']) == 'success' )
    {
    	//$_SESSION['MSG'] = 'Spouse_Occupation_Success';
		//$db->location(SITEURL.'family-question-dependent/');
		if( $mode == 'add' )
			$db->location(SITEURL.'spouse-tax-pin/');
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
		$_SESSION['MSG'] = $response;
		if( $mode == 'add' )
			$db->location(SITEURL.'spouse-occupation/');
		else
			$db->location(SITEURL.'spouse-occupation/'.$taxApplicationID.'/'.$spouseID.'/edit/');
		exit;
	}
?>