<?php 
    include('connect.php'); 
    $db->checkLogin();
    //$_SESSION[SESS_PRE.'_TAX_APPLICATION_ID'] = 9;

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

    if( $httpcode <> 200 )
    {
        $_SESSION['MSG'] = 'Dependent_Info_Error';
        $db->location(SITEURL.'family-question-dependent/');
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
                      <?php 
                        {
                          $progress = 65;
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
                                         <h3 class="text-left text-uppercase"><strong>Your Dependents</strong></h3>  
                                     </div>
                                    <?php
                                        if( count($res) )
                                        {
                                    ?>
                                    <ul class="text-left list-of-document">
                                    <?php
                                        $n = count($res);
                                        for($i=0; $i<$n; $i++ )
                                        {
                                    ?>
                                        <li class="d-flex align-items-center border-bottom py-3" id="dep<?php echo $res[$i]['id']; ?>">
                                            <div class="text-main">
                                                <h6 class="mb-0"><strong><?php echo $res[$i]['firstName'] . ' ' . $res[$i]['lastName'] . ' (' . str_replace('_', ' ', $res[$i]['dependentType']) . ')'; ?></strong></h6>
                                                <h6 class="mb-0"><strong> SSN: </strong> <?php echo $res[$i]['ssn']; ?></h6>
                                            </div>
                                            <div class="buttons ml-auto d-flex">
                                                <button type="button" class="btn btn-primary py-1 px-2" onclick="delete_dependent('<?php echo $res[$i]['id']; ?>');">Del</button>
                                                <button type="button" class="btn btn-primary py-1 px-2 ml-2" onclick="edit_dependent('<?php echo $res[$i]['id']; ?>');">Edit</button>
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
                                     <div class="step active mt-3">
                                        <h4><strong>Do you have any other dependents?</strong></h4>
                                        <div class="row my-3 justify-content-center no-revert">
                                            <div class="col-md-4">
                                                <button type="button" class="btn btn-primary next-step" id="btnanother">Yes</button>
                                            </div>
                                            <div class="col-md-4">
                                                <button type="button" class="btn btn-primary" id="btndocument">No</button>
                                            </div>
                                        </div>
                                    </div>
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

    $('#btnanother').click(function() {
        window.location.href = "<?php echo SITEURL; ?>dependents-information/";
    });

    $('#btndocument').click(function() {
        window.location.href = "<?php echo SITEURL; ?>documents/";
    });

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

    function edit_dependent(id)
    {
        window.location.href = "<?php echo SITEURL; ?>dependents-information/"+id+"/";
    }
</script>
</body>
</html>