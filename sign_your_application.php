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
                                        <h3 class="text-left"><strong>TPB's TAX PREPARATION, FILING, AND FEES AUTHORIZATION</strong></h3>
                                        <p class="note">I hereby authorize <?php echo SITETITLE; ?>, LLC to prepare and file on my behalf, federal and/or state income
                                          taxes. I understand by signing and submitting the application, I am submitting to the process of tax
                                          preparation by <?php echo SITETITLE; ?> and its terms and conditions for providing such services. I agree to
                                          pay a $50 E-file fee, and any additional tax preparation fees associated with the preparation and filing of
                                          additional forms, should such forms be required. I authorize <?php echo SITETITLE; ?> to deduct all fees from
                                          my tax refund as payment for services rendered, or agree to pay <?php echo SITETITLE; ?> invoiced amount
                                          should my returns show a balance due.</p>
                                        <p class="note">By signing this Authorization, I acknowledge that the information provided is true and factual and I bear
                                          the sole responsibility to provide all supporting documentation as in, but not limited to the following: </p>
                                        <ul class="note text-left">
                                          <li>Taxpayer's Driver's License/State ID (paper form from DMV is acceptable)</li>
                                          <li>Taxpayer's Social Security Card (paper form from SSA is acceptable)</li>
                                        </ul>
                                        <p class="note">If applicable:</p>
                                        <ul class="note text-left">
                                          <li>Spouse's Driver's License/State ID (paper form from DMV is acceptable)</li>
                                          <li>Spouse's Social Security Card (paper form from SSA is acceptable)</li>
                                          <li>Dependents being claimed Social Security Cards (paper form from SSA is acceptable)</li>
                                          <li>Form W-2</li>
                                          <li>Form 1099</li>
                                          <li>Schedule C Declaration (Request Form from TPB Preparer)</li>
                                          <li>Proof of Head of Household (Request Form from TPB Preparer)</li>
                                        </ul>
                                        <h6 class="text-left"><strong>Electronic Signature Agreement</strong></h6>
                                        <div class="row">
                                          <div class="col-md-3">
                                            <div class="form-group">
                                              <input type="checkbox" name="agree" id="agree" class="d-inline">  
                                              <label class="d-inline">I Accept</label>
                                            </div>
                                          </div>
                                          <div class="col-md-9" style="text-align: left; line-height: 1.2;">
                                            <small class="agree">By checking the "I Accept" box, you are signing this Authorization electronically. You
                                              agree your electronic signature is the legal equivalent of your manual signature on
                                              this Authorization. By selecting "I Accept" you consent to be legally bound by this
                                              Authorization's terms and conditions. You further agree that no certification
                                              authority or other third party verification is necessary to validate your E-Signature
                                              and that the lack of such certification or third party verification will not in any way
                                              affect the enforceability of your E-Signature.</small>
                                          </div>
                                        </div>
                                    </div>
                                    <div id="showform" style="display: none;">
                                      <hr>
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

    $('#agree').on('change', function() {
      if( $(this).prop('checked') )
        $('#showform').show();
      else
        $('#showform').hide();
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