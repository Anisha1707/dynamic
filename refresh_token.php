<?php
    //print '<pre>'; print_r($_SESSION);
    if( isset($_SESSION[SESS_PRE.'_REFRESH_TOKEN']) && !empty($_SESSION[SESS_PRE.'_REFRESH_TOKEN']) )
    {
        $arfields = array(
            'token' => $_SESSION[SESS_PRE.'_USER_TOKEN'],
            'refreshToken' => $_SESSION[SESS_PRE.'_REFRESH_TOKEN']
        );

        $data = json_encode($arfields);
        //print_r($data);

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => API_URL."Authentication/Refresh",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => $data,
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
        {
            $_SESSION[SESS_PRE.'_USER_TOKEN'] =  $res['token'];
            $_SESSION[SESS_PRE.'_REFRESH_TOKEN'] =  $res['refreshToken'];
            $db->setSessionExpiration();
        }
        else if( $httpcode == 400 )
        {
            $db->unsetSession();
            $_SESSION['MSG'] = $res['message'];
            $db->location(SITEURL);
            exit;
        }
        else
        {
            $db->unsetSession();
            $_SESSION['MSG'] = 'Session_Expired';
            $db->location(SITEURL);
            exit;
        }
    }

?>