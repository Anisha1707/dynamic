<?php
	include('connect.php');
	$db->checkLogin();
	//print $_SESSION[SESS_PRE.'_USER_TOKEN'] . '<br /><br />';
	//$_SESSION[SESS_PRE.'_TAX_APPLICATION_ID'] = 9;
	//print_r($_REQUEST); exit;

	$Sign = $_POST['Signature'];
	$Init = $_POST['Initials'];

	$Signature = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $Sign));
	$sign_file = time()."_".rand(1,9999999)."sign.png";
	file_put_contents(SITE_ABSOLUTE_PATH.'upload/signature/'.$sign_file, $Signature);

	$Initials = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $Init));
	$init_file = time()."_".rand(1,9999999)."init.png";
	file_put_contents(SITE_ABSOLUTE_PATH.'upload/initials/'.$init_file, $Initials);

	$SignatureFile = '';
	$InitialFile = '';

    //If the function curl_file_create exists
    if(function_exists('curl_file_create')){
        $SignatureFile = new CURLFile(SITE_ABSOLUTE_PATH.'upload/signature/'.$sign_file, 'image/png', 'signature.png');
        $InitialFile = new CURLFile(SITE_ABSOLUTE_PATH.'upload/initials/'.$init_file, 'image/png', 'initials.png');
    } else{
        $SignatureFile = '@' . realpath(SITEURL.'upload/signature/'.$sign_file);
        $InitialFile = '@' . realpath(SITEURL.'upload/initials/'.$init_file);
    }
	$arfields = array(
		'TaxApplicationId' => $_SESSION[SESS_PRE.'_TAX_APPLICATION_ID'],
		'Signature' => $SignatureFile,
		'Initials' => $InitialFile
	);

	//$data = json_encode($arfields);
	$data = $arfields;
	//print_r($data); //exit;

	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => API_URL."Profile/SaveProfileSignature",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 0,
	  CURLOPT_FOLLOWLOCATION => true,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  //CURLOPT_SAFE_UPLOAD => false,
	  CURLOPT_CUSTOMREQUEST => "PUT",
	  CURLOPT_POSTFIELDS =>$data,
	  CURLOPT_HTTPHEADER => array(
	    "Authorization: Bearer ".$_SESSION[SESS_PRE.'_USER_TOKEN'],
	    "Content-type: multipart/form-data"
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
    	$_SESSION['MSG'] = 'Signature_Success';
		$db->location(SITEURL.'thank-you/');
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
		$db->location(SITEURL.'sign-your-application/');
		exit;
	}
?>