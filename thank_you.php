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
                         <div class="row no-gutters no-revert">
                            <div class="col-md-12">
                                <div class="contact-img text-center px-md-5">
                                    <div class="title mb-3">
                                        <h3 class="text-center"><strong>THANK YOU</strong></h3> 
                                        <p>You can download a copy of your application here: Also you can always log into this portal to review your application, check any communications, and review updates for your application(s) and returns.</p> 
                                    </div>
                                </div>
                             </div>
                             <div class="col-md-6 mt-5 mx-auto">
                                 <div class="row no-revert">
                                     <div class="col-md-6">
                                        <button type="button" class="btn btn-primary" id="btndownload">Download</button>
                                     </div>
                                     <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary" id="btnclose">Close</button>
                                     </div>
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

    $('#btndownload').click(function() {
        window.open('<?php echo SITEURL; ?>download/', '_blank');
    });
    $('#btnclose').click(function() {
        window.location.href = "<?php echo SITEURL; ?>customer-portal/";
    });
</script>
</body>
</html>