<?php 
    include('connect.php'); 
    $db->checkLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo SITENAME; ?></title>
    <?php include('front_include/css.php'); ?>
    <style type="text/css">
        canvas#signature {
          border: 2px solid black;
        }

        form>* {
          margin: 10px;
        }       
    </style>
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
                          $progress = 90;
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
                                        <h3 class="text-left"><strong>SIGN YOUR APPLICATION</strong></h3>
                                        <p class="text-left">Please sign in the box below so your signature can be applied to the application. Also, We need a copy of your initials to apply as well.</p>                                      
                                    </div>
                                    <form name="frm" id="frm" method="post" action="<?php echo SITEURL; ?>process-sign-your-application/" enctype="multipart/form-data" class="text-left">
                                        <label for="">Signature</label>
                                        <canvas id="cnvSignature" width="450" height="150" style="border: 1px solid #ddd;"></canvas> 
                                        <input type="hidden" name="Signature" id="Signature" value="" />
                                        <label for="">Initials</label>
                                        <canvas id="cnvInitials" width="450" height="150" style="border: 1px solid #ddd;"></canvas> 
                                        <input type="hidden" name="Initials" id="Initials" value="" />
                                        <div class="row my-3">
                                            <div class="col-md-4">
                                                <button type="button" class="btn btn-primary next-step" id="clear-signature">Clear</button>
                                            </div>
                                            <div class="col-md-4">
                                                <button type="submit" name="submit" id="submit" class="btn btn-primary">Save</button>
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
<script src="<?php echo SITEURL; ?>js/signature_pad.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.loader').hide();
    });

    $(function(){
        $("#frm").validate({
            ignore: "",
            rules: {
                Signature:{required:true},
                Initials:{required:true},
            },
            messages: { 
                Signature:{required:"Please enter signature."},
                Initials:{required:"Please enter initials."},
            },
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            }
        });
    });
    jQuery(document).ready(function($){
        $('#clear-signature').on('click', function(){
            signaturePad.clear();
            signaturePad1.clear();
            $('#Signature').val();
            $('#Initials').val();
        });
    });

    var canvas = document.getElementById('cnvSignature');
    var canvas1 = document.getElementById('cnvInitials');
    var signaturePad = new SignaturePad(canvas);
    var signaturePad1 = new SignaturePad(canvas1);
    var signature = document.getElementsByName('Signature')[0];
    var initials = document.getElementsByName('Initials')[0];
    canvas.addEventListener("mouseup", function() {
      signature.value = canvas.toDataURL();
    });

    canvas1.addEventListener("mouseup", function() {
      initials.value = canvas1.toDataURL();
    });
</script>
</body>
</html>