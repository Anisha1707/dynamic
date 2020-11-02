<?php 
    include('connect.php'); 

    $_SESSION['franchiseCode'] = '';
    $_SESSION['preparerCode'] = '';

    if( isset($_REQUEST['fran']) && !is_null($_REQUEST['fran']) && !empty($_REQUEST['fran']) )
        $_SESSION['franchiseCode'] = $_REQUEST['fran'];
    if( isset($_REQUEST['prep']) && !is_null($_REQUEST['prep']) && !empty($_REQUEST['prep']) )
        $_SESSION['preparerCode'] = $_REQUEST['prep'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo SITENAME; ?></title>
    <?php include('front_include/css.php'); ?>
</head>
<body>
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
                                         <h3 class="text-left">CREATE AN ACCOUNT</h3>
                                     </div>
                                     <form name="frm" id="frm" method="POST" action="<?php echo SITEURL; ?>process-signup/">
                                         <div class="row no-revert">
                                             <div class="col-md-6">
                                                 <div class="form-group"> 
                                                     <label for="">First Name</label>
                                                     <input type="text" name="first_name" id="first_name" value="" maxlength="50" class="form-control" placeholder="First Name"> 
                                                 </div>
                                             </div>
                                             <div class="col-md-6">
                                                 <div class="form-group"> 
                                                     <label for="">Last Name</label>
                                                     <input type="text" name="last_name" id="last_name" value="" maxlength="50" class="form-control" placeholder="Last Name"> 
                                                 </div>
                                             </div>
                                             <div class="col-md-6">
                                                 <div class="form-group">
                                                     <label for="">Phone Number</label> 
                                                     <input type="number" name="phone" id="phone" value="" maxlength="20" class="form-control" placeholder="Phone Number"> 
                                                 </div>
                                             </div>
                                             <div class="col-md-6">
                                                 <div class="form-group"> 
                                                     <label for="">Email</label>
                                                     <input type="email" name="email" id="email" value="" maxlength="100" class="form-control" placeholder="Email"> 
                                                 </div>
                                             </div>
                                             <div class="col-md-6"> 
                                                 <div class="form-group"> 
                                                     <label for="">User Name</label>
                                                     <input type="text" name="username" id="username" value="" maxlength="50" class="form-control" placeholder="User Name"> 
                                                 </div>
                                             </div>
                                             <div class="col-md-6"> 
                                                 <div class="form-group"> 
                                                     <label for="">Password</label>
                                                     <input type="password" name="password" id="password" value="" maxlength="30" class="form-control" placeholder="Password"> 
                                                 </div>
                                             </div>
                                         </div>
                                        <button type="submit" name="submit" id="submit" class="btn btn-primary">CREATE ACCOUNT</button>
                                        <div class="text-center account pt-3">
                                            <p><small>By creating an account you agree to our <br>
                                                <a href="<?php echo SITEURL; ?>privacy-policy/"> terms of Service and Privacy Policy</a></small></p>
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
    $(function(){
        $("#frm").validate({
            ignore: "",
            rules: {
                first_name:{required:true},
                last_name:{required:true},
                email:{required:true, email:true},
                phone:{required:true},
                username:{required:true},
                password:{required:true},
            },
            messages: { 
                first_name:{required:"Please enter first name."},
                last_name:{required:"Please enter last name."},
                email:{required:"Please enter email address.", email:"Please enter valid email address."},
                phone:{required:"Please enter phone number."},
                username:{required:"Please enter user name."},
                password:{required:"Please enter password."},
            },
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            }
        });
    });
</script>
</body>
</html>