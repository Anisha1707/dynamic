<?php 
  include('connect.php'); 
  $db->checkLogin();

  $street1 = '';
  $street2 = '';
  $city = '';
  $state = '';
  $zip = '';

  $mode = 'add';
  $taxApplicationID = $_SESSION[SESS_PRE.'_TAX_APPLICATION_ID'];

  if( isset($_REQUEST['mode']) && !is_null($_REQUEST['mode']) && !empty($_REQUEST['mode']) )
    $mode = $_REQUEST['mode'];
  if( isset($_REQUEST['taxApplicationID']) && !is_null($_REQUEST['taxApplicationID']) && !empty($_REQUEST['taxApplicationID']) )
    $taxApplicationID = $_REQUEST['taxApplicationID'];

  //$querystring = '?taxApplicationId='.$_SESSION[SESS_PRE.'_TAX_APPLICATION_ID'];
  $querystring = '?taxApplicationId='.$taxApplicationID;

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => API_URL."TaxApplication/GetTaxApplicationAddress".$querystring,
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
    $street1 = $res['street1'];
    $street2 = $res['street2'];
    $city = $res['city'];
    $state = $res['state'];
    $zip = $res['zip'];
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo SITENAME; ?></title>
    <?php include('front_include/css.php'); ?>
</head>
<body>
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
                                         <h3 class="text-left"><strong>ADDRESS</strong><?php echo ($mode=='add')?'<span class="ml-5 pl-5 text-info">20%</span>':''; ?></h3>  
                                     </div>
                                     <form name="frm" id="frm" method="post" action="<?php echo SITEURL; ?>process-address/">
                                        <input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>">
                                        <input type="hidden" name="taxApplicationID" id="taxApplicationID" value="<?php echo $taxApplicationID; ?>">
                                        <div class="row">
                                           <div class="col-md-6">
                                               <div class="form-group"> 
                                                   <label for="street1">Street 1</label>
                                                 <input type="text" name="street1" id="street1" value="<?php echo $street1; ?>" maxlength="100" class="form-control" placeholder="Street 1"> 
                                             </div>
                                           </div>
                                           <div class="col-md-6">
                                               <div class="form-group"> 
                                                   <label for="street2">Street 2</label>
                                                 <input type="text" name="street2" id="street2" value="<?php echo $street2; ?>" maxlength="100" class="form-control" placeholder="Street 2"> 
                                             </div>
                                           </div>
                                           <div class="col-md-6">
                                               <div class="form-group"> 
                                                   <label for="city">City</label>
                                                 <input type="text" name="city" id="city" value="<?php echo $city; ?>" maxlength="100" class="form-control" placeholder="City"> 
                                             </div>
                                           </div>
                                           <div class="col-md-6">
                                               <div class="form-group"> 
                                                   <label for="state">State</label>
                                                 <input type="text" name="state" id="state" value="<?php echo $state; ?>" maxlength="2" class="form-control" placeholder="State Code"> 
                                             </div>
                                           </div> 
                                           <div class="col-md-6">
                                               <div class="form-group"> 
                                                   <label for="zip">Zip</label>
                                                 <input type="text" name="zip" id="zip" value="<?php echo $zip; ?>" maxlength="100" class="form-control" placeholder="Zip"> 
                                             </div>
                                           </div>
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
                street1:{required:true},
                //street2:{required:true},
                city:{required:true},
                state:{required:true},
                zip:{required:true},
            },
            messages: { 
                street1:{required:"Please enter street 1."},
                //street2:{required:"Please enter street 2."},
                city:{required:"Please enter city."},
                state:{required:"Please enter state."},
                zip:{required:"Please enter zip code."},
            },
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            }
        });
    });
</script>
</body>
</html>