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
                                         <h3 class="text-left w-100"><strong>TICKET APPLICATION</strong></h3>
                                         <p class="text-left">If you have any issue with the agent, system, or anything else, we are here to help you out.</p>
                                         <p class="text-left">Please fill in the details below to reach out to us.</p> 
                                     </div>
                                     <form name="frm" id="frm" method="post" action="<?php echo SITEURL; ?>process-create-ticket/">
                                        <div class="form-group"> 
                                            <textarea name="issue" id="issue" class="form-control" rows="5" placeholder="Describe your issue"></textarea>
                                        </div>
                                        <button type="submit" name="submit" id="submit" class="btn btn-primary">SUBMIT</button>
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
        $('#other_text').hide();
        $('.loader').hide();
    });

    $(function(){
        $("#frm").validate({
            ignore: "",
            rules: {
                //subject:{required:true},
                issue:{required:true},
            },
            messages: { 
                //subject:{required:"Please enter subject."},
                issue:{required:"Please describe your issue."},
            },
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            }
        });
    });

    /*$('#issue_with').on('change', function() {
        if( $(this).val() == 'other' )
            $('#other_text').show();
        else
            $('#other_text').hide();
    });*/
</script>
</body>
</html>