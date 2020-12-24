<?php 
    include('connect.php');

    $signingId = '';
    $disclaimerId = '';
    $title = '';
    $disclaimer = '';

    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => API_URL."User/GetUserDisclaimer",
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
    //print '<pre>'; print_r($res); exit;

    if( $httpcode == 200 )
    {
        $signingId = $res['signingId'];
        $disclaimerId = $res['disclaimerId'];
        $title = $res['title'];
        $disclaimer = $res['disclaimer'];
    }

    if( (int)$signingId <= 0 )
    {
        unset($_SESSION[SESS_PRE.'_HEALTH_DISCLAIMER']);
        $db->location(SITEURL.'customer-portal/');
        exit;
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
                         <div class="row no-gutters">
                             <div class="col-md-7">
                                 <div class="contact-img text-center px-md-5">
                                     <div class="title mb-3">
                                         <h3 class="text-left">HEALTH DISCLAIMER</h3>
                                     </div>
                                     <form name="frm" id="frm" method="post" action="<?php echo SITEURL; ?>process-health-disclaimer/">
                                        <input type="hidden" name="signingId" id="signingId" value="<?php echo $signingId; ?>">
                                        <div class="title mb-3">
                                            <h5 class="text-left"><?php echo $title; ?></h5>
                                            <div class="note"><?php echo $disclaimer; ?></div>
                                            <div class="row">
                                              <div class="col-md-3">
                                                <div class="form-group">
                                                  <input type="checkbox" name="agree" id="agree" class="d-inline">  
                                                  <label class="d-inline">I Accept</label>
                                                </div>
                                              </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary">SUBMIT</button>
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
        $("#frm").on('submit', function() {
            if( $("#agree:checked").length <= 0 ) 
            { 
                alert("Please tick the checkbox."); 
                return false;
            }
            return true; 
        });
    });
</script>
</body>
</html>