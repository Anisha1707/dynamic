<?php 
  include('connect.php'); 
  $db->checkLogin();
  //print $_SESSION[SESS_PRE.'_USER_TOKEN'];
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
                 <div class="col-md-8">
                    <div class="row mb-3">
                        <div class="col-md-6 mb-4">
                            <div class="contact-inner h-100">
                               <h4><strong>Text Application</strong></h4>
                               <ul class="list-main p-0 mx-0 mt-3">
                                   <li class="d-flex text-left align-items-center mb-3">
                                        <p class="mr-3 mb-0">2020</p>
                                        <a class="ml-auto black" href="javscript:void(0)"> <i class="fas fa-paste mr-2"></i></a> 
                                   </li>
                                   <li class="d-flex text-left align-items-center mb-3">
                                        <p class="mr-3 mb-0">2019</p>
                                        <a href="javscript:void(0)" class="ml-auto black"> <i class="fas fa-paste mr-2"></i></a> 
                                        <a href="javscript:void(0)" class="black"> <i class="fas fa-eye mr-2"></i></a> 
                                        <a href="javscript:void(0)" class="black"> <i class="fas fa-user-plus mr-2"></i></a> 
                                    </li>
                                    <li class="d-flex text-left align-items-center mb-3">
                                        <p class="mr-3 mb-0">2018</p>
                                        <a href="javscript:void(0)" class="ml-auto black"> <i class="fas fa-paste mr-2"></i></a> 
                                        <a href="javscript:void(0)" class="black"> <i class="fas fa-eye mr-2"></i></a> 
                                        <a href="javscript:void(0)" class="black"> <i class="fas fa-user-plus mr-2"></i></a> 
                                        <a href="javscript:void(0)" class="black"> <i class="fas fa-flag-checkered mr-2"></i></a> 
                                   </li>
                               </ul>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="contact-inner h-100">
                               <h4><strong>Messages</strong></h4>
                               <ul class="list-main p-0 mx-0 mt-3">
                                   <li class="d-flex text-left align-items-center mb-3">
                                        <i class="fas fa-envelope"></i>
                                        <p class="ml-3 mb-0">Tax App 2019</p> 
                                   </li>
                                   <li class="d-flex text-left align-items-center mb-3">
                                        <i class="fas fa-envelope"></i>
                                        <p class="ml-3 mb-0">Tax App 2019</p> 
                                   </li>
                                   <li class="d-flex text-left align-items-center mb-3">
                                        <i class="fas fa-envelope"></i>
                                        <p class="ml-3 mb-0">Tax App 2019</p> 
                                   </li>
                                   <li class="d-flex text-left align-items-center mb-3">
                                        <i class="fas fa-envelope"></i>
                                        <p class="ml-3 mb-0">Tax App 2019</p> 
                                   </li>
                                  
                               </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="contact-inner">
                                <h4><strong>Resources from TPB</strong></h4>
                                <div class="links">
                                    <a href="javascript:void(0)" class="d-block">How to get a home?</a>
                                    <a href="javascript:void(0)" class="d-block">Why is everything not tax deductible</a>
                                    <a href="javascript:void(0)" class="d-block">PPP loan 101</a> 
                                </div>
                            </div>
                        </div>
                    </div>
                 </div>
                 <div class="col-md-4">
                     <div class="row">
                        <div class="col-md-12 col-lg-6 mb-4">
                            <div class="contact-inner">
                               <a href="javasript:void(0)">
                                    <div class="team text-center">
                                        <img src="<?php echo SITEURL; ?>images/team1.png" class="img-fluid mb-3" alt="">
                                        <h5 class="black">Janet <br> Jackson</h5>
                                        <small class="black">Tax Preparer</small>
                                    </div>
                               </a>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6 mb-4">
                            <div class="contact-inner">
                               <a href="javasript:void(0)">
                                    <div class="team text-center">
                                        <img src="<?php echo SITEURL; ?>images/team2.png" class="img-fluid mb-3" alt="">
                                        <h5 class="black">Brenee <br> Brown</h5>
                                        <small class="black">Manager</small>
                                    </div>
                               </a>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6 mb-4">
                            <div class="contact-inner">
                               <a href="javasript:void(0)">
                                    <div class="team text-center">
                                        <img src="<?php echo SITEURL; ?>images/team3.png" class="img-fluid mb-3" alt="">
                                        <h5 class="black">Tim <br> Cook</h5>
                                        <small class="black">Senior Manager</small>
                                    </div>
                               </a>
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
</body>
</html>