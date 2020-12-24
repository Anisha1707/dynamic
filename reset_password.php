<?php 
    include('connect.php'); 
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
                                         <h3 class="text-left"><strong>RESET PASSWORD</strong></h3>
                                     </div>
                                     <form name="frm" id="frm" method="post" action="<?php echo SITEURL; ?>process-reset-password/">
                                        <input type="hidden" name="mode" id="mode" value="confirm">
                                         <div class="row no-revert">
                                             <div class="col">
                                                 <div class="form-group"> 
                                                     <input type="tel" name="letter_1" id="letter_1" value="" maxlength="1" class="form-control inputs"> 
                                                 </div>
                                             </div>
                                             <div class="col">
                                                 <div class="form-group"> 
                                                     <input type="tel" name="letter_2" id="letter_2" value="" maxlength="1" class="form-control inputs"> 
                                                 </div>
                                             </div>
                                             <div class="col">
                                                 <div class="form-group"> 
                                                     <input type="tel" name="letter_3" id="letter_3" value="" maxlength="1" class="form-control inputs"> 
                                                 </div>
                                             </div>
                                             <div class="col">
                                                 <div class="form-group"> 
                                                     <input type="tel" name="letter_4" id="letter_4" value="" maxlength="1" class="form-control inputs"> 
                                                 </div>
                                             </div>
                                             <div class="col"> 
                                                 <div class="form-group"> 
                                                     <input type="tel" name="letter_5" id="letter_5" value="" maxlength="1" class="form-control inputs"> 
                                                 </div>
                                             </div>
                                             <div class="col"> 
                                                 <div class="form-group"> 
                                                     <input type="tel" name="letter_6" id="letter_6" value="" maxlength="1" class="form-control inputs"> 
                                                 </div>
                                             </div>
                                         </div>
                                        <button type="button" id="confirm" class="btn btn-primary">CONFIRM</button>
                                        <div id="show_reset" style="display:none">
                                        <div class="text-left mt-3">
                                            <p>Now that you have confirmed your account, <br>
                                                please enter the new password.</p>
                                            <div class="form-group"> 
                                                <input type="password" name="password" id="password" value="" maxlength="20" class="form-control inputs"> 
                                            </div>
                                            <button type="button" id="btnreset" class="btn btn-primary">Submit</button>
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
<script type="text/javascript">
    $(document).ready(function() {
        $('.loader').hide();
    });

    $(function(){
        $("#frm").validate({
            ignore: "",
            rules: {
                letter_1:{required:true},
                letter_2:{required:true},
                letter_3:{required:true},
                letter_4:{required:true},
                letter_5:{required:true},
                letter_6:{required:true},
            },
            messages: { 
                letter_1:{required:"Required"},
                letter_2:{required:"Required"},
                letter_3:{required:"Required"},
                letter_4:{required:"Required"},
                letter_5:{required:"Required"},
                letter_6:{required:"Required"},
            },
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            }
        });

        $(".inputs").keyup(function () {
            if (this.value.length == this.maxLength) {
                if($(this).attr('name') == 'letter_1')
                    $('#letter_2').focus();
                if($(this).attr('name') == 'letter_2')
                    $('#letter_3').focus();
                if($(this).attr('name') == 'letter_3')
                    $('#letter_4').focus();
                if($(this).attr('name') == 'letter_4')
                    $('#letter_5').focus();
                if($(this).attr('name') == 'letter_5')
                    $('#letter_6').focus();
                if($(this).attr('name') == 'letter_6')
                    $('#confirm').focus();
            }
        });

        $('#confirm').click(function() {
            if( $("#frm").valid() )
            {
                $.ajax({
                    url: '<?php echo SITEURL; ?>process-reset-password/', 
                    type: 'GET', 
                    data: $('#frm').serialize(), 
                    beforeSend: function() {
                        $('.loader').show();
                        $('.wrapper').css('pointer-events', 'none');
                    },
                    success: function(res) {
                        if( res == 1)
                        {
                            $('#show_reset').show();
                        }
                        else
                        {
                            Swal.fire({
                              title: 'Error!',
                              text: res,
                              icon: 'error',
                              confirmButtonText: 'Okay'
                            });
                            $('#show_reset').hide();
                        }
                        $('.loader').hide();
                        $('.wrapper').css('pointer-events', 'auto');
                    }
                });
            }
        });

        $('#btnreset').click(function() {
            $('#mode').val('change');
            $.ajax({
                url: '<?php echo SITEURL; ?>process-reset-password/', 
                type: 'POST', 
                data: $('#frm').serialize(), 
                beforeSend: function() {
                    $('.loader').show();
                    $('.wrapper').css('pointer-events', 'none');
                },
                success: function(res) {
                    if( res == 1)
                    {
                        window.location.href = "<?php echo SITEURL; ?>";
                    }
                    else
                    {
                        Swal.fire({
                          title: 'Error!',
                          text: res,
                          icon: 'error',
                          confirmButtonText: 'Okay'
                        });
                    }
                    $('.loader').hide();
                    $('.wrapper').css('pointer-events', 'auto');
                }
            });
            
        });
    });
</script>
</body>
</html>
