<?php 
    include('connect.php'); 
    $db->checkLogin();

  $identificationNumber = '';
  $idType = '';
  $state = '';
  $dateIssued = '';
  $dateExpired = '';

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
    CURLOPT_URL => API_URL."TaxApplication/GetTaxApplicationIdentification".$querystring,
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
    $identificationNumber = $res['identificationNumber'];
    $idType = $res['idType'];
    $state = $res['state'];
    $dateIssued = $res['dateIssued'];
    $dateExpired = $res['dateExpired'];
  }

  /* START: Get list of Identification Types */
  $curl = curl_init();

  curl_setopt_array($curl, array(
      CURLOPT_URL => API_URL."TaxApplication/GetListOfIdTypes",
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
  /* END: Get list of Identification Types */

  foreach ($artype as $type) {
      if( str_replace(' ', '_', $type['text']) == $idType )
      {
          $idType = $type['value'];
          break;
      }
  }

  if( $dateIssued == '0001-01-01' )
    $dateIssued = '';
  else
    $dateIssued = $db->date($dateIssued, 'm/d/Y');

  if( $dateExpired == '0001-01-01' )
    $dateExpired = '';
  else
    $dateExpired = $db->date($dateExpired, 'm/d/Y');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo SITENAME; ?></title>
    <?php include('front_include/css.php'); ?>
    <link href="<?php echo SITEURL; ?>css/bootstrap-datepicker.css" rel="stylesheet">
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
                          $progress = 30;
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
                                     <div class="title mb-3">
                                         <h3 class="text-left text-uppercase "><strong>Identification Information</strong></h3>  
                                     </div>
                                     <form name="frm" id="frm" method="post" action="<?php echo SITEURL; ?>process-identification-information/">
                                        <input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>">
                                        <input type="hidden" name="taxApplicationID" id="taxApplicationID" value="<?php echo $taxApplicationID; ?>">
                                        <div class="row no-revert">
                                           <div class="col-md-6">
                                               <div class="form-group"> 
                                                  <label for="idType">Identification Type</label>
                                                  <select name="idType" id="idType" class="form-control">
                                                      <option value=""></option>
                                                      <?php
                                                          foreach ($artype as $type) {
                                                              echo '<option value="'.$type['value'].'"';
                                                              if( $type['value'] == $idType )
                                                                  echo ' selected';
                                                              echo '>'.$type['text'].'</option>';
                                                          }
                                                      ?>
                                                  </select>
                                             </div>
                                           </div>
                                           <div class="col-md-6">
                                               <div class="form-group"> 
                                                  <label for="identificationNumber">Identification No</label>
                                                  <input type="text" name="identificationNumber" id="identificationNumber" value="<?php echo $identificationNumber; ?>" maxlength="12" class="form-control" placeholder="Identification No"> 
                                             </div>
                                           </div> 
                                           <div class="col-md-6">
                                               <div class="form-group"> 
                                                  <label for="state">State</label>
                                                  <input type="text" name="state" id="state" value="<?php echo $state; ?>" maxlength="2" class="form-control" placeholder="State"> 
                                             </div>
                                           </div> 
                                           <div class="col-md-6">
                                               <div class="form-group"> 
                                                  <label for="dateIssued">Date Issued</label>
                                                  <input type="text" autocomplete="off" name="dateIssued" id="dateIssued" data-date-format="mm/dd/yyyy" class="form-control datepicker" value="<?php echo $dateIssued; ?>" maxlength="10" placeholder="MM/DD/YYYY">
                                             </div>
                                           </div>
                                           <div class="col-md-6">
                                               <div class="form-group"> 
                                                  <label for="dateExpired">Date Expired</label>
                                                  <input type="text" autocomplete="off" name="dateExpired" id="dateExpired" data-date-format="mm/dd/yyyy" class="form-control datepicker" value="<?php echo $dateExpired; ?>" maxlength="10" placeholder="MM/DD/YYYY">
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
<script src="<?php echo SITEURL; ?>js/bootstrap-datepicker.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.loader').hide();
  
        $('.datepicker').datepicker({
          //startDate: 'today',
          todayHighlight: true,
          autoClose: true,
          orientation: "bottom left",
          templates: {
            leftArrow: '<i class="fa fa fa-arrow-circle-left"></i>',
            rightArrow: '<i class="fa fa fa-arrow-circle-right"></i>'
          },
        });
    });

    $(function(){
        $("#frm").validate({
            ignore: "",
            rules: {
                idType:{required:true},
                identificationNumber:{required:true},
                state:{required:true},
                dateIssued:{required:true},
                dateExpired:{required:true},
            },
            messages: { 
                idType:{required:"Please select identification type."},
                identificationNumber:{required:"Please enter identification number."},
                state:{required:"Please enter state."},
                dateIssued:{required:"Please enter issued date."},
                dateExpired:{required:"Please enter expiration date."},
            },
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            }
        });
    });
</script>
</body>
</html>