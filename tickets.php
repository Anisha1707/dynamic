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
                                         <h3 class="text-left text-uppercase"><strong>Tickets</strong></h3>  
                                     </div>
                                    <ul class="text-left list-of-document">
                                        <li class="d-flex align-items-center border-bottom py-3">
                                            <div class="text-main">
                                                <h6 class="mb-0"><strong>Installation issue</strong> <small class="text-warning">(Closed)</small></h6>
                                                <h6 class="mb-0">I am not able to install windows on my system...</h6>
                                            </div>
                                            <div class="buttons ml-auto d-flex">
                                                <button type="button" class="btn btn-primary py-1 px-2" onclick="delete_ticket();">Del</button>
                                                <button type="button" class="btn btn-primary py-1 px-2 ml-2" onclick="edit_ticket();">Edit</button>
                                            </div>
                                        </li>
                                        <li class="d-flex align-items-center border-bottom py-3">
                                            <div class="text-main">
                                                <h6 class="mb-0"><strong>Installation issue</strong></h6>
                                                <h6 class="mb-0">I am not able to install windows on my system...</h6>
                                            </div>
                                            <div class="buttons ml-auto d-flex">
                                                <button type="button" class="btn btn-primary py-1 px-2" onclick="delete_ticket();">Del</button>
                                                <button type="button" class="btn btn-primary py-1 px-2 ml-2" onclick="edit_ticket();">Edit</button>
                                            </div>
                                        </li>
                                        <li class="d-flex align-items-center border-bottom py-3">
                                            <div class="text-main">
                                                <h6 class="mb-0"><strong>Installation issue</strong> <small class="text-warning">(Closed)</small></h6>
                                                <h6 class="mb-0">I am not able to install windows on my system...</h6>
                                            </div>
                                            <div class="buttons ml-auto d-flex">
                                                <button type="button" class="btn btn-primary py-1 px-2" onclick="delete_ticket();">Del</button>
                                                <button type="button" class="btn btn-primary py-1 px-2 ml-2" onclick="edit_ticket();">Edit</button>
                                            </div>
                                        </li>
                                        <li class="d-flex align-items-center border-bottom py-3">
                                            <div class="text-main">
                                                <h6 class="mb-0"><strong>Installation issue</strong></h6>
                                                <h6 class="mb-0">I am not able to install windows on my system...</h6>
                                            </div>
                                            <div class="buttons ml-auto d-flex">
                                                <button type="button" class="btn btn-primary py-1 px-2" onclick="delete_ticket();">Del</button>
                                                <button type="button" class="btn btn-primary py-1 px-2 ml-2" onclick="edit_ticket();">Edit</button>
                                            </div>
                                        </li>
                                    </ul>
                                    <div class="step active mt-3">
                                        <h4><strong>Do you have any issue?</strong></h4>
                                        <div class="row my-3 justify-content-center no-revert">
                                            <div class="col-md-6">
                                                <button type="button" class="btn btn-primary" id="btncreate">Create Ticket</button>
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

    $('#btncreate').click(function() {
        window.location.href = "<?php echo SITEURL; ?>ticket-information/";
    });
</script>
</body>
</html>