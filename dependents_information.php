<?php 
    include('connect.php'); 
    $db->checkLogin();

    $id = 0;
    if( isset($_REQUEST['id']) && $_REQUEST['id'] > 0 )
        $id = $_REQUEST['id'];

    $back = '';
    if( isset($_REQUEST['back']) && !is_null($_REQUEST['back']) && !empty($_REQUEST['back']) )
      $back = $_REQUEST['back'];

    $firstName = '';
    $lastName = '';
    $dependentType = '';
    $ssn = '';
    $dateOfBirth = '';

    /* START: Get list of all the dependents and find the matching record */
    $querystring = '?taxApplicationId='.$_SESSION[SESS_PRE.'_TAX_APPLICATION_ID'];

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => API_URL."TaxApplication/GetListOfDependentsByTaxApplicationId".$querystring,
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
    if( count($res) )
    {
        foreach ($res as $dependent) 
        {
            if( $dependent['id'] == $id )
            {
                //print '<pre>'; print_r($dependent);
                $firstName = $dependent['firstName'];
                $lastName = $dependent['lastName'];
                $dependentType = $dependent['dependentType'];
                $ssn = $dependent['ssn'];
                $dateOfBirth = $dependent['dateOfBirth'];           

                $ardateOfBirth = explode('-', $dateOfBirth);
                $dateOfBirth = $ardateOfBirth[1] . '/' . $ardateOfBirth[2] . '/' . $ardateOfBirth[0];
            }
        }
    }
    /* END: Get list of all the dependents and find the matching record */

    /* START: Get list of Dependent Types */
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => API_URL."TaxApplication/GetListOfDependentTypes",
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
    /* END: Get list of Dependent Types */

    foreach ($artype as $type) {
        if( str_replace(' ', '_', $type['text']) == $dependentType )
        {
            $dependentType = $type['value'];
            break;
        }
    }
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
                         <div class="row no-gutters">
                             <div class="col-md-7">
                                 <div class="contact-img text-center px-md-5">
                                     <div class="title mb-3">
                                         <h3 class="text-left text-uppercase"><strong>Dependent's Information</strong><?php echo ($id<=0)?'<span class="ml-5 pl-5 text-info">65%</span>':''; ?></h3>
                                     </div>
                                     <form name="frm" id="frm" method="post" action="<?php echo SITEURL; ?>process-dependents-information/">
                                         <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
                                         <input type="hidden" name="mode" id="mode" value="<?php echo ($id>0)?'edit':'add'; ?>">
                                         <input type="hidden" name="back" id="back" value="<?php echo $back; ?>">
                                         <div class="row no-revert">
                                            <div class="col-md-6">
                                               <div class="form-group"> 
                                                    <label for="firstName">First Name</label>
                                                    <input type="text" name="firstName" id="firstName" maxlength="50" value="<?php echo $firstName; ?>" class="form-control" placeholder="First Name"> 
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
                                                    <label for="dependentType">Dependent Type</label>
                                                    <select name="dependentType" id="dependentType" class="form-control">
                                                        <option value=""></option>
                                                        <?php
                                                            foreach ($artype as $type) {
                                                                echo '<option value="'.$type['value'].'"';
                                                                if( $type['value'] == $dependentType )
                                                                    echo ' selected';
                                                                echo '>'.$type['text'].'</option>';
                                                            }
                                                        ?>
                                                    </select>
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
                                                    <input type="text" name="dateOfBirth" id="dateOfBirth" maxlength="10" value="<?php echo $dateOfBirth; ?>" autocomplete="off" class="form-control datepicker" data-date-format="mm/dd/yyyy" placeholder="MM/DD/YYYY"> 
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
                lastName:{required:true},
                dependentType:{required:true},
                ssn:{required:true},
                dateOfBirth:{required:true},
            },
            messages: { 
                firstName:{required:"Please enter first name."},
                lastName:{required:"Please enter last name."},
                dependentType:{required:"Please select dependent type."},
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