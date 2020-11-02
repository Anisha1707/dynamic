<?php
	include('connect.php');
	$db->checkLogin();
	//print $_SESSION[SESS_PRE.'_USER_TOKEN'];
	//print_r($_REQUEST); die();

	$franchiseCode = $_REQUEST['fran'];
	$preparerCode = $_REQUEST['prep'];

	$year = $_REQUEST['year'];
	$occupation = $_REQUEST['occupation'];

	$arfields = array(
		'year' => (int) $year,
		'occupation' => $occupation,
		'franchiseId' => (int) 0,
		'prepareId' => (int) 0,
		'franchiseCode' => $franchiseCode,
		'preparerCode' => $preparerCode,
	);

	$data = json_encode($arfields);
	//print_r($data); exit;

	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => API_URL."TaxApplication/CreateTaxApplication",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS =>$data,
	  CURLOPT_HTTPHEADER => array(
	    "Content-Type: application/json", 
        "Authorization: Bearer ".$_SESSION[SESS_PRE.'_USER_TOKEN']
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
		$_SESSION[SESS_PRE.'_TAX_APPLICATION_ID'] = $res['taxApplicationId'];
    	$_SESSION['MSG'] = 'Tax_Application_Success';
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
		$_SESSION['MSG'] = $res['errorList'][0];
		$db->location(SITEURL.'tax-application-client/');
		exit;
	}
?>