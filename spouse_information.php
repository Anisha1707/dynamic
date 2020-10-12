<?php 
  include('connect.php'); 
  $db->checkLogin();

  $firstName = '';
  $middleName = '';
  $lastName = '';
  $ssn = '';
  $dateOfBirth = '';

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
    CURLOPT_URL => API_URL."TaxApplication/GetTaxApplicationSpousePersonalInformation".$querystring,
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
    $firstName = $res['firstName'];
    $middleName = $res['middleName'];
    $lastName = $res['lastName'];
    $ssn = $res['ssn'];
    $dateOfBirth = $res['dateOfBirth'];
  }

  if( $dateOfBirth == '0001-01-01' )
    $dateOfBirth = '';
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
                          $progress = 50;
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
                                         <h3 class="text-left"><strong>SPOUSE'S PERSONAL INFORMATION</strong></h3>  
                                     </div>
                                     <form name="frm" id="frm" method="post" action="<?php echo SITEURL; ?>process-spouse-information/">
                                       <input type="hidden" name="mode" id="mode" value="<?php echo $mode; ?>">
                                       <input type="hidden" name="spouseID" id="spouseID" value="<?php echo $spouseID; ?>">
                                       <input type="hidden" name="taxApplicationID" id="taxApplicationID" value="<?php echo $taxApplicationID; ?>">
                                       <div class="row">
                                           <div class="col-md-6">
                                               <div class="form-group"> 
                                                  <label for="firstName">First Name</label>
                                                  <input type="text" name="firstName" id="firstName" maxlength="50" value="<?php echo $firstName; ?>" class="form-control" placeholder="First Name"> 
                                             </div>
                                           </div>
                                           <div class="col-md-6">
                                               <div class="form-group"> 
                                                  <label for="middleName">Middle Name</label>
                                                  <input type="text" name="middleName" id="middleName" maxlength="50" value="<?php echo $middleName; ?>" class="form-control" placeholder="Middle Name"> 
                                             </div>
                                           </div>
                                           <div class="col-md-6">
                                               <div class="form-group"> 
                                                  <label for="lastName">Last Name</label>
                                                  <input type="text" name="lastName" id="lastName" maxlength="50" value="<?php echo $lastName; ?>" class="form-control" placeholder="Last Name"> 
                                             </div>
                                           </div>
                                           <div class="col-md-6">
                                               <div class="form-group"> 
                                                  <label for="ssn">SSN</label>
                                                  <input type="text" name="ssn" id="ssn" maxlength="12" value="<?php echo $ssn; ?>" class="form-control" placeholder="XXX-XX-XXXX"> 
                                             </div>
                                           </div> 
                                           <div class="col-md-6">
                                               <div class="form-group"> 
                                                  <label for="">Date of Birth</label>
                                                  <input type="text" name="dateOfBirth" id="dateOfBirth" maxlength="10" value="<?php echo $db->date($dateOfBirth, 'm/d/Y'); ?>" autocomplete="off" class="form-control datepicker" data-date-format="mm/dd/yyyy" placeholder="MM/DD/YYYY"> 
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
                firstName:{required:true},
                //middleName:{required:true},
                lastName:{required:true},
                ssn:{required:true},
                dateOfBirth:{required:true},
            },
            messages: { 
                firstName:{required:"Please enter first name."},
                //middleName:{required:"Please enter middle name."},
                lastName:{required:"Please enter last name."},
                ssn:{required:"Please enter SSN."},
                dateOfBirth:{required:"Please enter date of birth."},
            },
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            }
        });
    });
</script>
</body>
</html>