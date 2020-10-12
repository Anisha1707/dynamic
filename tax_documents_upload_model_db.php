<?php
	include('connect.php');
	$db->checkLogin();

	$mode = $_REQUEST['mode'];

	$nameOfDocument = $_REQUEST['nameOfDocument'];
	$description = $_REQUEST['description'];
	$documentType = $_REQUEST['documentType'];
	$id = (int) $_REQUEST['id'];
	$taxApplicationID = (int) $_REQUEST['taxApplicationID'];

    //If the function curl_file_create exists
    if(function_exists('curl_file_create')){
        //$filePath = curl_file_create($_FILES['documentFile']['tmp_name']);
        $DocumentFile = new CURLFile($_FILES['documentFile']['tmp_name'], $_FILES['documentFile']['type'], $_FILES['documentFile']['name']);
    } else{
        $DocumentFile = '@' . realpath($_FILES['documentFile']['tmp_name']);
    }

/*	$arfields = array(
		'taxApplicationId' => $_SESSION[SESS_PRE.'_TAX_APPLICATION_ID'],
		'id' => $id,
		'nameOfDocument' => $nameOfDocument,
		'description' => $description,
		'documentType' => $documentType,
		'documentFile' => $documentFile
	);*/
	$arfields = array(
		'TaxApplicationId' => $taxApplicationID,
		'Id' => $id,
		'NameOfDocument' => $nameOfDocument,
		'Description' => $description,
		'DocumentType' => $documentType,
		'DocumentFile' => $DocumentFile
	);

	//$data = json_encode($arfields);
	$data = $arfields;
	//print_r($data); //exit;

	$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => API_URL."TaxApplication/CreateTaxApplicationDocument",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  //CURLOPT_SAFE_UPLOAD => false,
		  CURLOPT_CUSTOMREQUEST => "POST",
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
    	$_SESSION['MSG'] = 'Document_Upload_Success';
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
		$_SESSION['MSG'] = 'Something_Wrong';
		$db->location(SITEURL.'customer-portal/');
		exit;
	}
?>