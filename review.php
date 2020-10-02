<?php 
  include('connect.php'); 
  $db->checkLogin();
  //print $_SESSION[SESS_PRE.'_USER_TOKEN'];
  if( !isset($_SESSION[SESS_PRE.'_TAX_APPLICATION_ID']) )
    $_SESSION[SESS_PRE.'_TAX_APPLICATION_ID'] = 9;  // 9, 12

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

    if( $httpcode <> 200 )
    {
        $_SESSION['MSG'] = 'Review_Info_Error';
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
                         <div class="row no-gutters no-revert">
                            <div class="col-md-12">
                                <div class="contact-img text-center px-md-5">
                                    <div class="title mb-3">
                                        <h3 class="text-left"><strong>REVIEW</strong><?php echo '<span class="ml-5 pl-5 text-info">80%</span>'; ?></h3>  
                                    </div>
                                </div>
                             </div>

                             <!-- START: Personal Information -->
                             <div class="col-md-6">
                                 <div class="contact-img text-center px-md-5">
                                      <h5 class="text-left mb-3"><strong>My Information</strong></h5>
                                     <div class="text-center conatc-review">
                                       <div class="d-flex align-items-center mb-2">
                                        <p class="mb-0"><strong>Name:</strong> <span><?php echo $res['firstName'] . ' ' . $res['middleName'] . ' ' . $res['lastName']; ?></span></p> <a href="<?php echo SITEURL.'personal-information/edit/'.$res['id'].'/'; ?>" class="d-block ml-auto">EDIT</a>
                                       </div>
                                       <div class="d-flex align-items-center mb-2">
                                        <p class="mb-0"><strong>SSN:</strong> <span><?php echo $res['ssn']; ?></span></p> 
                                       </div>
                                       <div class="d-flex align-items-center mb-2">
                                        <p class="mb-0"><strong>Date of Birth:</strong> <span><?php echo $db->date($res['dateOfBirth'], 'm/d/Y'); ?></span></p> 
                                       </div>
                                       <div class="d-flex align-items-center mb-2 flex-wrap">
                                            <p class="mb-0"><strong>Address:</strong> <span><?php echo $res['street1']; ?></span></p> <a href="<?php echo SITEURL . 'address/edit/'.$res['id'].'/'; ?>" class="d-block ml-auto">EDIT</a>
                                            <p class="col-12 text-left p-0">
                                              <?php
                                                if( !empty($res['street2']) && !is_null($res['street2']) )
                                                  echo $res['street2'] . '<br />';
                                                echo $res['city'] . ', ' . $res['state'] . ' ' . $res['zip'];
                                              ?>
                                            </p>
                                       </div>
                                       <div class="d-flex align-items-center mb-2">
                                        <p class="mb-0"><strong>ID:</strong> <span><?php echo $res['idType']; ?> (<?php echo $res['identificationNumber']; ?>) <?php echo $res['idState']; ?></span></p> <a href="<?php echo SITEURL . 'identification-information/edit/'.$res['id'].'/'; ?>" class="d-block ml-auto">EDIT</a>
                                       </div>
                                       <div class="d-flex align-items-center mb-2">
                                        <p class="mb-0"><strong>Occupation:</strong>  <strong><?php echo $res['occupation']; ?></strong></p> <a href="<?php echo SITEURL.'tax-application/edit/'.$res['id'].'/'; ?>" class="d-block ml-auto">EDIT</a> 
                                       </div>
                                       <div class="d-flex align-items-center mb-2">
                                        <p class="mb-0"><strong>PIN:</strong>  <strong><?php echo $res['pin'];//$res['identityTheftPin']; ?></strong></p>  <a href="<?php echo SITEURL.'tax-pin/edit/'.$res['id'].'/'; ?>" class="d-block ml-auto">EDIT</a>
                                       </div>
                                     </div>
                                 </div>
                             </div>
                             <!-- END: Personal Information -->

                             <!-- START: Spouse Information -->
                             <div class="col-md-6">
                                 <div class="contact-img text-center px-md-5">     
                                      <h5 class="text-left mb-3"><strong>Spouse Information</strong></h5>
                                     <div class="text-center conatc-review">
                                       <div class="d-flex align-items-center mb-2">
                                        <p class="mb-0"><strong>Name:</strong> <span><?php echo $res['spouse']['firstName'] . ' ' . $res['spouse']['middleName'] . ' ' . $res['spouse']['lastName']; ?></span></p> <a href="<?php echo SITEURL.'spouse-information/edit/'.$res['spouse']['spouseId'].'/'.$res['spouse']['taxApplicationId'].'/'; ?>" class="d-block ml-auto">EDIT</a>
                                       </div>
                                       <div class="d-flex align-items-center mb-2">
                                        <p class="mb-0"><strong>SSN:</strong> <span><?php echo $res['spouse']['ssn']; ?></span></p> 
                                       </div>
                                       <div class="d-flex align-items-center mb-2">
                                        <p class="mb-0"><strong>Date of Birth:</strong> <span><?php echo $db->date($res['spouse']['dateOfBirth'], 'm/d/Y'); ?></span></p> 
                                       </div>
                                       <div class="d-flex align-items-center mb-2 flex-wrap">
                                            <p class="mb-0"><strong>Address:</strong> <span><?php echo $res['spouse']['street1']; ?></span></p> <a href="<?php echo SITEURL.'spouse-address/edit/'.$res['spouse']['spouseId'].'/'.$res['spouse']['taxApplicationId'].'/'; ?>" class="d-block ml-auto">EDIT</a>
                                            <p class="col-12 text-left p-0">
                                              <?php
                                                if( !empty($res['spouse']['street2']) && !is_null($res['spouse']['street2']) )
                                                  echo $res['spouse']['street2'] . '<br />';
                                                echo $res['spouse']['city'] . ', ' . $res['spouse']['state'] . ' ' . $res['spouse']['zip'];
                                              ?>
                                            </p>
                                       </div>
                                       <div class="d-flex align-items-center mb-2">
                                        <p class="mb-0"><strong>ID:</strong> <span><?php echo $res['spouse']['idType']; ?> (<?php echo $res['spouse']['identificationNumber']; ?>) <?php echo $res['spouse']['idState']; ?></span></p> <a href="<?php echo SITEURL.'spouse-identification-information/edit/'.$res['spouse']['spouseId'].'/'.$res['spouse']['taxApplicationId'].'/'; ?>" class="d-block ml-auto">EDIT</a>
                                       </div>
                                       <div class="d-flex align-items-center mb-2">
                                        <p class="mb-0"><strong>Occupation:</strong>  <strong><?php echo $res['spouse']['occupation']; ?></strong></p> <a href="<?php echo SITEURL.'spouse-occupation/edit/'.$res['spouse']['spouseId'].'/'.$res['spouse']['taxApplicationId'].'/'; ?>" class="d-block ml-auto">EDIT</a> 
                                       </div>
                                       <div class="d-flex align-items-center mb-2">
                                        <p class="mb-0"><strong>PIN:</strong>  <strong><?php echo $res['spouse']['pin']; ?></strong></p> <a href="<?php echo SITEURL.'spouse-tax-pin/edit/'.$res['spouse']['spouseId'].'/'.$res['spouse']['taxApplicationId'].'/'; ?>" class="d-block ml-auto">EDIT</a>
                                       </div>
                                     </div>
                                 </div>
                             </div>
                             <!-- END: Spouse Information -->

                             <!-- START: Dependents -->
                             <div class="col-md-6 mt-5">
                                <div class="contact-img text-center px-md-5">                                    
                                  <h5 class="text-left mb-3"><strong>Dependents</strong></h5>
                                  <div class="text-center conatc-review">
                                    <?php
                                        if( count($res['dependents']) )
                                        {
                                    ?>
                                    <ul class="text-left list-of-document">
                                    <?php
                                        $n = count($res['dependents']);
                                        for($i=0; $i<$n; $i++ )
                                        {
                                    ?>
                                        <li class="d-flex align-items-center border-bottom py-3" id="dep<?php echo $res['dependents'][$i]['id']; ?>">
                                            <div class="text-main">
                                                <h6 class="mb-0"><strong><?php echo $res['dependents'][$i]['firstName'] . ' ' . $res['dependents'][$i]['lastName'] . ' (' . str_replace('_', ' ', $res['dependents'][$i]['dependentType']) . ')'; ?></strong></h6>
                                                <h6 class="mb-0"><strong> SSN: </strong> <?php echo $res['dependents'][$i]['ssn']; ?></h6>
                                            </div>
                                            <div class="buttons ml-auto d-flex">
                                              <a href="javascript:void(0);" class="d-block ml-auto mr-2" onclick="delete_dependent('<?php echo $res['dependents'][$i]['id']; ?>');">DEL</a>
                                              <a href="javascript:void(0);" class="d-block ml-auto" onclick="edit_dependent('<?php echo $res['dependents'][$i]['id']; ?>');">EDIT</a>
                                            </div>
                                        </li>
                                    <?php
                                        }
                                    ?>
                                    </ul>
                                    <?php
                                        }
                                        else
                                            echo 'No dependent found.';
                                    ?>
                                  </div>
                                </div>  
                             </div>
                             <!-- END: Dependents -->

                             <!-- START: Documents -->
                             <div class="col-md-6 mt-5">
                                <div class="contact-img text-center px-md-5">                                    
                                  <h5 class="text-left mb-3"><strong>Documents</strong></h5>
                                  <div class="text-center conatc-review">
                                    <?php
                                        if( count($res['documents']) )
                                        {
                                    ?>
                                     <ul class="text-left list-of-document">
                                    <?php
                                        $n = count($res['documents']);
                                        for($i=0; $i<$n; $i++ )
                                        {
                                    ?>
                                         <li class="d-flex align-items-center border-bottom py-3" id="doc<?php echo $res['documents'][$i]['id']; ?>">
                                            <div class="text-main">
                                                <h6 class="mb-0"><strong><?php echo str_replace('_', ' ', $res['documents'][$i]['documentType']) . ' - ' . $res['documents'][$i]['nameOfDocument']; ?></strong></h6>
                                                <h6 class="mb-0"><strong> Desc: </strong> <?php echo $res['documents'][$i]['description']; ?></h6>
                                            </div>
                                            <div class="buttons ml-auto">
                                              <a href="javascript:void(0);" class="d-block ml-auto" onclick="delete_document('<?php echo $res['documents'][$i]['id']; ?>');">DEL</a>
                                            </div>
                                         </li>
                                    <?php
                                        }
                                    ?>
                                     </ul>
                                    <?php
                                        }
                                        else
                                            echo 'No document found.';
                                    ?>
                                  </div>
                                </div>  
                             </div>
                             <!-- END: Documents -->
                            
                             <div class="col-md-6 mt-4">
                              <button type="button" class="btn btn-primary" id="btngood">LOOKS GOOD</button>   
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
        $('#btngood').click(function() {
            window.location.href = "<?php echo SITEURL; ?>sign-your-application/";
        });
    });

    function edit_dependent(id)
    {
        window.location.href = "<?php echo SITEURL; ?>dependents-information/"+id+"/review/";
    }

    function delete_dependent(id)
    {
        if( confirm('Are you sure you want to delete the dependent?') )
        {
            $.ajax({
                url:"<?php echo SITEURL; ?>process-dependent/", 
                type: "get", 
                data: "mode=delete&id="+id, 
                success: function(data) {
                    //console.log(data);
                    if( data == 1 )
                    {
                        $('#dep'+id).remove();
                        Swal.fire({
                          title: 'Success!',
                          html: 'The dependent has been removed successfully!',
                          icon: 'success',
                          confirmButtonText: 'Okay'
                        });
                    }
                    else
                    {
                        Swal.fire({
                          title: 'Error!',
                          html: 'Something went wrong, Please try again !',
                          icon: 'error',
                          confirmButtonText: 'Okay'
                        });
                    }
                }
            });
        }
    }

    function delete_document(id)
    {
        if( confirm('Are you sure you want to delete the document?') )
        {
            $.ajax({
              url:"<?php echo SITEURL; ?>process-tax-documents/", 
                type: "get", 
                data: "mode=delete&id="+id, 
                success: function(data) {
                    //console.log(data);
                    if( data == 1 )
                    {
                        $('#doc'+id).remove();
                        Swal.fire({
                          title: 'Success!',
                          html: 'The document has been removed successfully!',
                          icon: 'success',
                          confirmButtonText: 'Okay'
                        });
                    }
                    else
                    {
                        Swal.fire({
                          title: 'Error!',
                          html: 'Something went wrong, Please try again !',
                          icon: 'error',
                          confirmButtonText: 'Okay'
                        });
                    }
                }
            });
        }
    }
</script>
</body>
</html>