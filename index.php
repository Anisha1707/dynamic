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
         <div class="container">
             <div class="row">
                 <div class="col-md-12">
                     <div class="title">
                         <h2 class="welcome">WELCOME</h2>
                     </div>
                 </div>
             </div>
         </div>
         <div class="container p-0 mt-4">
             <div class="row">
                 <div class="col-md-12">
                     <div class="contact-inner">
                         <div class="row no-gutters">
                             <div class="col-md-7">
                                 <div class="contact-img text-center px-md-5">
                                     <div class="title mb-3">
                                         <h3 class="text-left">Login</h3>
                                     </div>
                                     <form name="frm" id="frm" method="post" action="<?php echo SITEURL; ?>process-login/">
                                        <div class="form-group"> 
                                            <label for="username">User Name</label>
                                            <input type="text" name="username" id="username" maxlength="50" class="form-control" placeholder="User Name"> 
                                        </div>
                                        <div class="form-group"> 
                                            <label for="password">Password</label>
                                            <input type="password" name="password" id="password" maxlength="" class="form-control" placeholder="Password"> 
                                        </div>
                                        <button type="submit" class="btn btn-primary">LOGIN</button>
                                        <div class="text-center pt-3">
                                            <a href="javascript:void(0)">Forgot Password?</a>
                                            <div class="signup mt-3">
                                                <h3><strong>Don't have an account?</strong></h3>
                                                <a href="<?php echo SITEURL; ?>signup/">Create your account</a>
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
                         <div class="row no-revert">
                            <div class="col-md-12">
                                <hr>
                                 <div class="login-text mt-4">
                                     <h4><strong>Latest New Filler</strong></h4>
                                     <p><small> Lorem ipsum dolor sit amet consectetur adipisicing elit. Suscipit beatae quo consequatur ratione iusto ipsa tempora? Reiciendis officia quibusdam sed dolores amet error doloribus perferendis tenetur quia totam, repellendus dolor.</small></p>
                                     <p><small> Lorem ipsum dolor sit amet consectetur adipisicing elit. Suscipit beatae quo consequatur ratione iusto ipsa tempora.</small></p>
                                     <p><small> Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ad ratione vitae repellat magni neque, porro obcaecati tempora soluta libero voluptate itaque eaque quasi id ex ut ullam quam cumque nihil.</small></p>
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
                username:{required:true},
                password:{required:true},
            },
            messages: { 
                username:{required:"Please enter username."},
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