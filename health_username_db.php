<?php
	include('connect.php');

	$username = $_REQUEST['username'];

	$querystring = '?username='.$username;

	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => API_URL."User/UsernameExist".$querystring,
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
	//print $httpcode . '<pre>'; print_r($res); exit;

    if( $httpcode == 200 )
    {
    	if( strtolower($res['status']) == 'success' || (int)$res['status'] == 1 )
    	{
			$querystring = '?newUsername='.$username;

			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => API_URL."User/UpdateUsername".$querystring,
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
		    	unset($_SESSION[SESS_PRE.'_HEALTH_USERNAME']);
		    	if( isset($_SESSION[SESS_PRE.'_HEALTH_PASSWORD']) && $_SESSION[SESS_PRE.'_HEALTH_PASSWORD'] == 1 )
		    	{
					$db->location(SITEURL.'health-password/');
					exit;
		    	}
		    	else if( isset($_SESSION[SESS_PRE.'_HEALTH_DISCLAIMER']) && $_SESSION[SESS_PRE.'_HEALTH_DISCLAIMER'] == 1 )
		    	{
					$db->location(SITEURL.'health-disclaimer/');
					exit;
		    	}
		    	else
		    	{
			    	$_SESSION['MSG'] = 'Update_Username_Success';
					$db->location(SITEURL.'customer-portal/');
					exit;
		    	}
			}
			else
			{
				$_SESSION['MSG'] = $res['message'];
				$db->location(SITEURL.'health-username/');
				exit;
			}
    	}
    	else
    	{
			$_SESSION['MSG'] = 'Duplicate_User_Error';
			$db->location(SITEURL.'health-username/');
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
		$_SESSION['MSG'] = 'Something_Wrong';
		$db->location(SITEURL.'health-username/');
		exit;
    }


?>