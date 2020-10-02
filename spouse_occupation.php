<?php 
  include('connect.php'); 
  $db->checkLogin();

  // $_SESSION[SESS_PRE.'_TAX_APPLICATION_ID'] = 23;
  // $_SESSION[SESS_PRE.'_SPOUSE_ID'] = 12;

  $carrier = '';
  $email = '';
  $occupation = '';
  $phoneNumber = '';
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
    CURLOPT_URL => API_URL."TaxApplication/GetTaxApplicationSpouseOccupationAndContact".$querystring,
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
    $carrier = $res['carrier'];
    $email = $res['email'];
    $occupation = $res['occupation'];
    $phoneNumber = $res['phoneNumber'];
    $spouseID = $res['spouseId'];
  }


    /* START: Get list of Carrier Types */
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => API_URL."TaxApplication/GetListOfCarrierTypes",
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
    // print $httpcode;
    // print '<pre>'; print_r($res); //exit;

    $artype = array();
    if( $httpcode == 200 )
    {
        $artype = $res;
    }
    /* END: Get list of Carrier Types */

    foreach ($artype as $type) {
        if( str_replace(' ', '_', $type['text']) == $carrier )
        {
            $carrier = $type['value'];
            break;
        }
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
                                         <h3 class="text-left text-uppercase"><strong>SPOUSE'S Occupation and Contact</strong><?php echo ($mode=='add')?'<span class="ml-5 pl-5 text-info">56%</span>':''; ?></h3>  
                                     </div>
                                     <form name="frm" id="frm" method="post" action="<?php echo SITEURL; ?>process-spouse-occupation/">
                                       <input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>">
                                       <input type="hidden" name="spouseID" id="spouseID" value="<?php echo $spouseID; ?>">
                                       <input type="hidden" name="taxApplicationID" id="taxApplicationID" value="<?php echo $taxApplicationID; ?>">
                                       <div class="row">
                                           <div class="col-md-6">
                                               <div class="form-group"> 
                                                  <label for="occupation">Occupation</label>
                                                  <input type="text" name="occupation" id="occupation" value="<?php echo $occupation; ?>" maxlength="75" class="form-control" placeholder="Occupation"> 
                                             </div>
                                           </div>
                                           <div class="col-md-6">
                                               <div class="form-group"> 
                                                  <label for="email">Email</label>
                                                  <input type="email" name="email" id="email" value="<?php echo $email; ?>" maxlength="100" class="form-control" placeholder="Email"> 
                                             </div>
                                           </div>
                                           <div class="col-md-6">
                                               <div class="form-group"> 
                                                  <label for="phoneNumber">Phone Number</label>
                                                  <input type="number" name="phoneNumber" id="phoneNumber" value="<?php echo $phoneNumber; ?>" maxlength="20" class="form-control" placeholder="Phone Number"> 
                                             </div>
                                           </div>
                                           <div class="col-md-6">
                                               <div class="form-group"> 
                                                  <label for="carrier">Carrier</label>
                                                  <!-- <input type="text" name="carrier" id="carrier" value="<?php //echo $carrier; ?>" maxlength="30" class="form-control" placeholder="Carrier">  -->
                                                  <select name="carrier" id="carrier" class="form-control">
                                                      <option value=""></option>
                                                      <?php
                                                          foreach ($artype as $type) {
                                                              echo '<option value="'.$type['value'].'"';
                                                              if( $type['value'] == $carrier )
                                                                  echo ' selected';
                                                              echo '>'.$type['text'].'</option>';
                                                          }
                                                      ?>
                                                  </select>
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
                occupation:{required:true},
                email:{required:true, email:true},
                phoneNumber:{required:true},
                carrier:{required:true},
            },
            messages: { 
                occupation:{required:"Please enter occupation."},
                email:{required:"Please enter email address.", email:"Please enter valid email address."},
                phoneNumber:{required:"Please enter phone number."},
                carrier:{required:"Please enter carrier."},
            },
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            }
        });
    });
</script>
</body>
</html>