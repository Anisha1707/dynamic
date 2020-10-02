<?php
    include('connect.php'); 
    $db->checkLogin();

	//print $_SESSION[SESS_PRE.'_USER_TOKEN'];
	//print_r($_REQUEST);

	$mode = $_REQUEST['mode'];

	$idType = $_REQUEST['idType'];
	$identificationNumber = $_REQUEST['identificationNumber'];
	$state = $_REQUEST['state'];
	$dateIssued = $_REQUEST['dateIssued'];
	$dateExpired = $_REQUEST['dateExpired'];

	$ardateIssued = explode('/', $dateIssued);
	$dateIssued = $ardateIssued[2] . '-' . $ardateIssued[0] . '-' . $ardateIssued[1];

	$ardateExpired = explode('/', $dateExpired);
	$dateExpired = $ardateExpired[2] . '-' . $ardateExpired[0] . '-' . $ardateExpired[1];
	$taxApplicationID = $_REQUEST['taxApplicationID'];

	if( empty($taxApplicationID) || is_null($taxApplicationID) || $taxApplicationID <= 0 )
		$taxApplicationID = $_SESSION[SESS_PRE.'_TAX_APPLICATION_ID'];

	$arfields = array(
		'taxApplicationId' => (int) $taxApplicationID,
		'idType' => $idType,
		'identificationNumber' => $identificationNumber,
		'state' => $state,
		'dateIssued' => $dateIssued,
		'dateExpired' => $dateExpired
	);

	$data = json_encode($arfields);
	//print_r($data); exit;

	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => API_URL."TaxApplication/SaveTaxApplicationIdentification",
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
	//print $httpcode;
	//print '<pre>'; print_r($res); exit;

    if( $httpcode == 200 )
    //if( strtolower($res['status']) == 'success' )
    {
    	$_SESSION['MSG'] = 'Identification_Success';
		//$db->location(SITEURL.'family-question/');
		if( $mode == 'add' )
			$db->location(SITEURL.'tax-pin/');
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
			$db->location(SITEURL.'identification-information/');
		else
			$db->location(SITEURL.'identification-information/edit/'.$taxApplicationID.'/');
		exit;
	}
?>