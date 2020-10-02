<?php 
    include('connect.php'); 
    $db->checkLogin();

    $querystring = '?taxApplicationId='.$_SESSION[SESS_PRE.'_TAX_APPLICATION_ID'];

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => API_URL."TaxApplication/GetTaxApplicationDownloadById".$querystring,
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
    //print_r($response); exit;
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE); // curl response code
    curl_close($curl);

    $res = json_decode($response, true);

    file_put_contents(SITE_ABSOLUTE_PATH.'upload/PDF/download.pdf', $response);
?>
<script type="text/javascript">
    window.location.href = "<?php echo SITEURL.'upload/PDF/download.pdf'; ?>";
</script>
