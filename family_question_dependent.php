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
                      <?php 
                        {
                          $progress = 60;
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
                                         <h3 class="text-left text-uppercase "><strong>Family Question</strong></h3>  
                                         <p class="text-left">Now that we have the basic information on you, we need to get information on the family that will be apart of your application.</p>
                                     </div>
                                     <form name="frm" id="frm" method="post" action="">
                                        <div class="step active">
                                            <h4><strong>Do you have any dependents?</strong></h4>
                                            <div class="row my-3 justify-content-center no-revert">
                                                <div class="col-md-4">
                                                    <button type="button" class="btn btn-primary" id="btndependent">Yes</button>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="button" class="btn btn-primary" id="btndocument">No</button>
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
        $('#btndependent').click(function() {
            window.location.href = "<?php echo SITEURL; ?>dependents-information/";
        });

        $('#btndocument').click(function() {
            window.location.href = "<?php echo SITEURL; ?>documents/";
        });
    });
</script>
</body>
</html>