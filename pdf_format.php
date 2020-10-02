<?php 
  include('connect.php'); 
/*
  if( !isset($_SESSION[SESS_PRE.'_TAX_APPLICATION_ID']) )
    $_SESSION[SESS_PRE.'_TAX_APPLICATION_ID'] = 12;  // 9, 12

    $querystring = '?taxApplicationId='.$_SESSION[SESS_PRE.'_TAX_APPLICATION_ID'];

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => API_URL."TaxApplication/GetTaxApplicationById".$querystring,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer ".$_SESSION[SESS_PRE.'_USER_TOKEN']
      ),
    ));

    $response = curl_exec($curl);
    //print_r($response);
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE); // curl response code
    curl_close($curl);

    $res = json_decode($response, true);
    //print '<pre>'; print_r($res); exit;
*/
    /*if( $httpcode <> 200 )
    {
        $_SESSION['MSG'] = 'Review_Info_Error';
        $db->location(SITEURL.'customer-portal/');
        exit;
    }*/
?>

<!DOCTYPE html>
   <html lang="en-US" prefix="og: http://ogp.me/ns#">
      <head>
	   <style type="text/css">
	         body {
	            font-family: sans-serif;
	            font-size: 16px;
	            line-height: 1.5;
	         }
	    </style>
      </head>
      <body style="">
         <table border="0" style="padding:0 100px;width:600px">
            <tr>
               <td>
                  <table border="0" style="width:600px">
                     <tr>
                        <td style="text-align:center;padding-bottom: 20px;">
                           <img src="<?php echo SITEURL; ?>images/logo.png" style="width:200px;"> 
                        </td>
                     </tr>
                  </table>
               </td>
            </tr>
            <tr><td style="height: 20px;"></td></tr>
            <tr>
              <td>
                  <table border="0" style="width:300px">
                  	<thead>
                  		<tr>
                  			<th>Personal Information</th>
                  		</tr>
                  	</thead>
                  	<tbody>
                  		<tr>
                  			<td><strong>Name:</strong> <span><?php echo $res['firstName'] . ' ' . $res['middleName'] . ' ' . $res['lastName']; ?></span></td>
                  		</tr>
                  		<tr>
                  			<td><strong>SSN:</strong> <span><?php echo $res['ssn']; ?></span></td>
                  		</tr>
                  		<tr>
                  			<td><strong>Date of Birth:</strong> <span><?php echo $db->date($res['dateOfBirth'], 'm/d/Y'); ?></span></td>
                  		</tr>
                  		<tr>
                  			<td><strong>Address:</strong> <span><?php echo $res['street1']; ?></span>
                                <p>
                                  <?php
                                    if( !empty($res['street2']) && !is_null($res['street2']) )
                                      echo $res['street2'] . '<br />';
                                    echo $res['city'] . ', ' . $res['state'] . ' ' . $res['zip'];
                                  ?>
                                </p>

                  			</td>
                  		</tr>
                  		<tr>
                  			<td><strong>ID:</strong> <span><?php echo $res['idType']; ?> (<?php echo $res['identificationNumber']; ?>) <?php echo $res['idState']; ?></span></td>
                  		</tr>
                  		<tr>
                  			<td><strong>Occupation:</strong>  <strong><?php echo $res['occupation']; ?></strong></td>
                  		</tr>
                  		<tr>
                  			<td><strong>PIN:</strong>  <strong><?php echo $res['pin']; ?></strong></td>
                  		</tr>
                  	</tbody>
                  </table>
              </td>
              <td>
                  <table border="0" style="width:300px">
                  	<thead>
                  		<tr>
                  			<th>Spouse Information</th>
                  		</tr>
                  	</thead>
                  	<tbody>
                  		<tr>
                  			<td><strong>Name:</strong> <span><?php echo $res['spouse']['firstName'] . ' ' . $res['spouse']['middleName'] . ' ' . $res['spouse']['lastName']; ?></span></td>
                  		</tr>
                  		<tr>
                  			<td><strong>SSN:</strong> <span><?php echo $res['spouse']['ssn']; ?></span></td>
                  		</tr>
                  		<tr>
                  			<td><strong>Date of Birth:</strong> <span><?php echo $db->date($res['spouse']['dateOfBirth'], 'm/d/Y'); ?></span></td>
                  		</tr>
                  		<tr>
                  			<td><strong>Address:</strong> <span><?php echo $res['spouse']['street1']; ?></span>
                                <p>
                                  <?php
                                    if( !empty($res['spouse']['street2']) && !is_null($res['spouse']['street2']) )
                                      echo $res['spouse']['street2'] . '<br />';
                                    echo $res['spouse']['city'] . ', ' . $res['spouse']['state'] . ' ' . $res['spouse']['zip'];
                                  ?>
                                </p>

                  			</td>
                  		</tr>
                  		<tr>
                  			<td><strong>ID:</strong> <span><?php echo $res['spouse']['idType']; ?> (<?php echo $res['spouse']['identificationNumber']; ?>) <?php echo $res['spouse']['idState']; ?></span></td>
                  		</tr>
                  		<tr>
                  			<td><strong>Occupation:</strong>  <strong><?php echo $res['spouse']['occupation']; ?></strong></td>
                  		</tr>
                  		<tr>
                  			<td><strong>PIN:</strong>  <strong><?php echo $res['spouse']['pin']; ?></strong></td>
                  		</tr>
                  	</tbody>
                  </table>
              </td>
            </tr>
         </table>
      </body>
  </html>
