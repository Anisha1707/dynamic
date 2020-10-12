<?php
	include('connect.php');

	$newEmail = $_REQUEST['newEmail'];
	$newPhoneNumber = $_REQUEST['newPhoneNumber'];

	$flgemail = $flgphone = 0;

	/* START: check for email exists */ 
	$querystring = '?emailAddress='.$newEmail;

	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => API_URL."User/EmailExist".$querystring,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => '',
	  CURLOPT_HTTPHEADER => array(
	    "Authorization: Bearer ".$_SESSION[SESS_PRE.'_USER_TOKEN']
	  ),
	));

	$response = curl_exec($curl);
	$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE); // curl response code
	curl_close($curl);

	$res = json_decode($response, true);
	//print '<pre>'; print_r($res); exit;

    if( $httpcode == 200 )
    {
    	if( !$res['value'] )
    		$flgemail = 1;
    	else
    	{
			$_SESSION['MSG'] = 'Duplicate_Email_Error';
			$db->location(SITEURL);
			exit;
    	}
	}
	else if( $httpcode == 401 )
	{
		$_SESSION['MSG'] = 'Session_Expired';
		$db->location(SITEURL);
		exit;
	}
	else
	{
		$_SESSION['MSG'] = $res['message'];
	}
	/* END: check for email exists */

	/* START: check for phone number exists */ 
	$querystring = '?phoneNumber='.$newPhoneNumber;

	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => API_URL."User/PhoneNumberExist".$querystring,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => '',
	  CURLOPT_HTTPHEADER => array(
		"Authorization: Bearer ".$_SESSION[SESS_PRE.'_USER_TOKEN']
	  ),
	));

	$response = curl_exec($curl);
	$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE); // curl response code
	curl_close($curl);

	$res = json_decode($response, true);
	//print '<pre>'; print_r($res); exit;

    if( $httpcode == 200 )
    {
    	if( !$res['value'] )
    		$flgphone = 1;
    	else
    	{
			$_SESSION['MSG'] = 'Duplicate_Phone_Error';
			$db->location(SITEURL);
			exit;
    	}
	}
	else if( $httpcode == 401 )
	{
		$_SESSION['MSG'] = 'Session_Expired';
		$db->location(SITEURL);
		exit;
	}
	else
	{
		$_SESSION['MSG'] = $res['message'];
	}
	/* END: check for phone number exists */


	if( $flgemail && $flgphone )
	{
		$querystring = '?newEmail='.$newEmail.'&newPhoneNumber='.$newPhoneNumber;

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => API_URL."User/UpdateContactInformation".$querystring,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "PUT",
	  	  CURLOPT_POSTFIELDS => '',
		  CURLOPT_HTTPHEADER => array(
		    "Authorization: Bearer ".$_SESSION[SESS_PRE.'_USER_TOKEN']
		  ),
		));

		$response = curl_exec($curl);
		$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE); // curl response code
		curl_close($curl);

		$res = json_decode($response, true);
		//print $httpcode . '<pre>'; print_r($res); exit;

	    if( $httpcode == 200 )
	    {
	    	$_SESSION['MSG'] = 'Update_Contact_Success';
			$db->location(SITEURL.'customer-portal/');
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
			$_SESSION['MSG'] = $res['message'];
			$db->location(SITEURL.'change-contact/');
			exit;
		}
	}

?>