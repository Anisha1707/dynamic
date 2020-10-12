<?php
    include('connect.php'); 
    $db->checkLogin();

	//print $_SESSION[SESS_PRE.'_USER_TOKEN'];
	//print_r($_REQUEST);

	$mode = $_REQUEST['mode'];

	$pin = $_REQUEST['pin'];
	$taxApplicationID = $_REQUEST['taxApplicationID'];

	if( empty($taxApplicationID) || is_null($taxApplicationID) || $taxApplicationID <= 0 )
		$taxApplicationID = $_SESSION[SESS_PRE.'_TAX_APPLICATION_ID'];

	if( !empty($pin) )
	{
		$arfields = array(
			'taxApplicationId' => (int) $taxApplicationID,
			'pin' => $pin
		);

		$data = json_encode($arfields);
		//print_r($data); exit;

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => API_URL."TaxApplication/SaveTaxApplicationPin",
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
	    	$_SESSION['MSG'] = 'Pin_Success';
			if( $mode == 'add' )
				$db->location(SITEURL.'family-question/');
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
				$db->location(SITEURL.'tax-pin/');
			else
				$db->location(SITEURL.'tax-pin/'.$taxApplicationID.'/edit/');
			exit;
		}		
	}
	else
	{
		$db->location(SITEURL.'family-question/');
		exit;
	}

?>