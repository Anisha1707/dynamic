<?php 
    include('connect.php'); 
    $db->checkLogin();
    //$_SESSION[SESS_PRE.'_TAX_APPLICATION_ID'] = 9;

    $querystring = '?taxApplicationId='.$_SESSION[SESS_PRE.'_TAX_APPLICATION_ID'];

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => API_URL."TaxApplication/GetListOfDocumentsByTaxApplicationId".$querystring,
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
        $_SESSION['MSG'] = 'Document_Info_Error';
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
                                         <h3 class="text-left"><strong>Tax Documents</strong><?php echo '<span class="ml-5 pl-5 text-info">75%</span>'; ?></h3>  
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
                                         <li class="d-flex align-items-center border-bottom py-3" id="doc<?php echo $res[$i]['id']; ?>">
                                            <div class="text-main">
                                                <h6 class="mb-0"><strong><?php echo str_replace('_', ' ', $res[$i]['documentType']) . ' - ' . $res[$i]['nameOfDocument']; ?></strong></h6>
                                                <h6 class="mb-0"><strong> Desc: </strong> <?php echo $res[$i]['description']; ?></h6>
                                            </div>
                                            <div class="buttons ml-auto">
                                                <button type="submit" class="btn btn-primary py-1 px-2" onclick="delete_document('<?php echo $res[$i]['id']; ?>');">Delete</button>
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
                                     <div class="step active mt-3">
                                        <h4><strong>Do you have any other documents?</strong></h4>
                                        <div class="row my-3 justify-content-center">
                                            <div class="col-md-4">
                                                <button type="button" class="btn btn-primary next-step" id="btnupload">Yes</button>
                                            </div>
                                            <div class="col-md-4">
                                                <button type="button" class="btn btn-primary" id="btnreview">No</button>
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

    $(function(){
        $('#btnupload').click(function() {
            window.location.href = "<?php echo SITEURL; ?>tax-documents-upload/";
        });

        $('#btnreview').click(function() {
            window.location.href = "<?php echo SITEURL; ?>review/";
        });
    });

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