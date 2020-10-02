<?php 
    include('connect.php'); 
    $db->checkLogin();
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
                                         <h3 class="text-left text-uppercase "><strong>Documents</strong><?php echo '<span class="ml-5 pl-5 text-info">70%</span>'; ?></h3>  
                                         <p class="text-left">Now that we have the basic information and have verified the family information, we now need any documents you have right now to attah to the application. these documents include but are not limited to copies of your identification, SSN cards for you nd family members/dependents and official tax documents. if you don't have all of them right now, you can always come back and attach them later.</p>
                                     </div>
                                     <form name="frm" id="frm" method="post" action="">
                                        <div class="step active">
                                            <h4><strong>Do you have any Tax Documents you would like to upload?</strong></h4>
                                            <div class="row my-3 justify-content-center">
                                                <div class="col-md-4">
                                                    <button type="button" class="btn btn-primary" id="btnupload">Yes</button>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="button" class="btn btn-primary" id="btnreview">No</button>
                                                </div>
                                            </div>
                                        </div>
                                         
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
        $('#btnupload').click(function() {
            window.location.href = "<?php echo SITEURL; ?>tax-documents-upload/";
        });

        $('#btnreview').click(function() {
            window.location.href = "<?php echo SITEURL; ?>review/";
        });
    });
</script>
</body>
</html>