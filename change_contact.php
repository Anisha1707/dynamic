<?php include('connect.php');?>
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
                                         <h3 class="text-left">UPDATE CONTACT INFORMATION</h3>
                                     </div>
                                     <form name="frm" id="frm" method="post" action="<?php echo SITEURL; ?>process-change-contact/">
                                        <div class="form-group"> 
                                            <label for="newEmail">Email</label>
                                            <input type="email" name="newEmail" id="newEmail" maxlength="100" class="form-control" placeholder="Email Address"> 
                                        </div>
                                        <div class="form-group"> 
                                            <label for="newPhoneNumber">Phone Number</label>
                                            <input type="text" name="newPhoneNumber" id="newPhoneNumber" maxlength="20" class="form-control" placeholder="Phone Number"> 
                                        </div>
                                        <button type="submit" class="btn btn-primary">SUBMIT</button>
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
        $("#frm").validate({
            ignore: "",
            rules: {
                newEmail:{required:true, email:true},
                newPhoneNumber:{required:true},
            },
            messages: { 
                newEmail:{required:"Please enter email address.", email:"Please enter valid email address."},
                newPhoneNumber:{required:"Please enter phone number."},
            },
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            }
        });
    });
</script>
</body>
</html>