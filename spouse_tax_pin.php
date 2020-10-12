<?php 
    include('connect.php'); 
    $db->checkLogin();

    $pin = '';
    $spouseID = '';

    $mode = 'add';
    $spouseID = 0;
    $taxApplicationID = $_SESSION[SESS_PRE.'_TAX_APPLICATION_ID'];

    if( isset($_REQUEST['mode']) && !is_null($_REQUEST['mode']) && !empty($_REQUEST['mode']) )
        $mode = $_REQUEST['mode'];
    if( isset($_REQUEST['spouseID']) && !is_null($_REQUEST['spouseID']) && !empty($_REQUEST['spouseID']) )
        $spouseID = $_REQUEST['spouseID'];
    if( isset($_REQUEST['taxApplicationID']) && !is_null($_REQUEST['taxApplicationID']) && !empty($_REQUEST['taxApplicationID']) )
        $taxApplicationID = $_REQUEST['taxApplicationID'];

    //$querystring = '?taxApplicationId='.$_SESSION[SESS_PRE.'_TAX_APPLICATION_ID'];
    $querystring = '?taxApplicationId='.$taxApplicationID;

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => API_URL."TaxApplication/GetTaxApplicationSpousePin".$querystring,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
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
    //print '<pre>'; print_r($res); //exit;

    if( $httpcode == 200 )
    {
        $pin = $res['pin'];
        $spouseID = $res['spouseId'];
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo SITENAME; ?></title>
    <?php include('front_include/css.php'); ?>
</head>
<body>
<div class="loader"></div>
<div class="main home">
    <?php include('front_include/header.php'); ?>      
     <section class="login-banner">         
         <div class="container p-0 mt-4">
             <div class="row">
                 <div class="col-md-12">
                     <div class="contact-inner">
                      <?php 
                        if($mode=='add')
                        {
                          $progress = 58;
                      ?>
                        <div class="row mb-5">
                          <div class="col-md-12">
                            <div class="progress" style="height:2vw;">
                              <div class="progress-bar" role="progressbar" style="width: <?php echo $progress; ?>%;" aria-valuenow="<?php echo $progress; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $progress; ?>%</div>
                            </div>
                          </div>
                        </div>
                      <?php
                        }
                      ?>                      
                         <div class="row no-gutters">
                             <div class="col-md-7">
                                 <div class="contact-img text-center px-md-5">
                                     <div class="title mb-5">
                                         <h3 class="text-left"><strong>SPOUSE'S TAX PIN</strong></h3>
                                         <p class="text-left mb-5">If your spouse was a victim of Identity Theft or received a letter from the IRS titled "Notice CP01A", please enter their PIN assigned for the tax year. If neither applies to them, you can leave this blank.</p>
                                     </div>
                                     <form name="frm" id="frm" method="post" action="<?php echo SITEURL; ?>process-spouse-tax-pin/">
                                        <input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>">
                                        <input type="hidden" name="spouseID" id="spouseID" value="<?php echo $spouseID; ?>">
                                        <input type="hidden" name="taxApplicationID" id="taxApplicationID" value="<?php echo $taxApplicationID; ?>">
                                        <div class="form-group"> 
                                            <label for="pin">Six Digital Pin</label>
                                            <input type="text" name="pin" id="pin" value="<?php echo $pin; ?>" class="form-control" placeholder="PIN" maxlength="6"> 
                                        </div>
                                        <button type="submit" name="submit" id="submit" class="btn btn-primary">NEXT</button>
                                         
                                     </form>
                                 </div>
                             </div>
                             <div class="col-md-5">
                                 <div class="contact-img text-center">
                                     <img src="<?php echo SITEURL; ?>images/bg.svg" class="img-fluid" alt="">
                                 </div>
                             </div>
                              
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </section>
    <?php include('front_include/footer.php'); ?>     
</div>
<?php include('front_include/js.php'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('.loader').hide();
    });

    $(function(){
        $("#frm").validate({
            ignore: "",
            rules: {
                pin:{minlength:6},
            },
            messages: { 
                pin:{minlength:"Please enter 6 digits of PIN."},
            },
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            }
        });
    });
</script>
</body>
</html>