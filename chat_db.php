<?php
	include('connect.php');
	$db->checkLogin();

	//print_r($_REQUEST);

	$mode = $_REQUEST['mode'];

	if( $mode == 'create' )
	{
		$toUserId = $_REQUEST['toUserId'];
		$messageThreadId = $_REQUEST['messageThreadId'];
		$severityLevel = $_REQUEST['severityLevel'];
		$body = $_REQUEST['txtmessage'];

		$arfields = array(
			'toUserId' => (int) $toUserId,
			'messageThreadId' => (int) $messageThreadId,
			'severityLevel' => (int) $severityLevel,
			'body' => $body
		);

		$data = json_encode($arfields);
		//print_r($data); exit;

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => API_URL."Communication/CreateMessage",
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

		$response = curl_exec($curl);
		//print_r($response);
		$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE); // curl response code
		curl_close($curl);

		$res = json_decode($response, true);
		// print $httpcode;
		// print '<pre>'; print_r($res); exit;

	    if( $httpcode == 200 )
	    {
	    	$_SESSION['MSG'] = 'Chat_Msg_Success';
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
	}

	if( $mode == 'read' )
	{
		$messageId = $_REQUEST['messageId'];
    	$querystring = '?messageId='.$messageId;

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => API_URL."Communication/MarkMessageAsRead".$querystring,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "PUT",
		  CURLOPT_HTTPHEADER => array(
		    "Authorization: Bearer ".$_SESSION[SESS_PRE.'_USER_TOKEN'], 
	        "Content-Length: 10"
		  ),
		));

		$response = curl_exec($curl);
		//print_r($response);
		$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE); // curl response code
		curl_close($curl);

		$res = json_decode($response, true);
		// print $httpcode;
		// print '<pre>'; print_r($res); exit;
	}
?>