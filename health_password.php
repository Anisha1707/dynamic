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
                                         <h3 class="text-left">HEALTH PASSWORD</h3>
                                     </div>
                                     <form name="frm" id="frm" method="post" action="<?php echo SITEURL; ?>process-health-password/">
                                        <!-- <div class="form-group"> 
                                            <label for="healthPassword">Health Password</label>
                                            <input type="password" name="healthPassword" id="healthPassword" maxlength="50" class="form-control" placeholder="Health Password"> 
                                        </div> -->
                                        <div class="form-group"> 
                                            <label for="currentPassword">Current Password</label>
                                            <input type="password" name="currentPassword" id="currentPassword" maxlength="50" class="form-control" placeholder="Current Password"> 
                                        </div>
                                        <div class="form-group"> 
                                            <label for="newPassword">New Password</label>
                                            <input type="password" name="newPassword" id="newPassword" maxlength="50" class="form-control" placeholder="New Password"> 
                                        </div>
                                        <div class="form-group"> 
                                            <label for="confirmPassword">Confirm Password</label>
                                            <input type="password" name="confirmPassword" id="confirmPassword" maxlength="50" class="form-control" placeholder="Confirm Password"> 
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
                //currentPassword:{required:true, minlength:8, pwcheck:true},
                currentPassword:{required:true},
                newPassword:{required:true, equalTo:"#confirmPassword", minlength:8, pwcheck:true},
                confirmPassword:{required:true, equalTo:"#newPassword", minlength:8, pwcheck:true},
            },
            messages: { 
                //currentPassword:{required:"Please enter current password.", minlength:"Password must be atleast 8 characters long.", pwcheck:"Password must have atleast one uppercase, one lowercase and one numeric character."},
                currentPassword:{required:"Please enter current password."},
                newPassword:{required:"Please enter new password.", minlength:"Password must be atleast 8 characters long.", pwcheck:"Password must have atleast one uppercase, one lowercase and one numeric character.", equalTo:"Your new passwords need to match."},
                confirmPassword:{required:"Please enter confirm password.", minlength:"Password must be atleast 8 characters long.", pwcheck:"Password must have atleast one uppercase, one lowercase and one numeric character.", equalTo:"Your new passwords need to match."},
            },
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            }
        });

        $.validator.addMethod("pwcheck", function(value) {
           return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // consists of only these
               && /[a-z]/.test(value) // has a lowercase letter
               && /\d/.test(value) // has a digit
        });
    });
</script>
</body>
</html>
