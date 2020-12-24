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
                                         <h3 class="text-left"><strong>FORGOT PASSWORD</strong></h3>
                                         <p class="text-left">Please select the option and enter the details to look up for your account:</p>
                                         <div class="row">
                                             <div class="col-md-4">
                                                <button type="button" id="btnusername" class="btn btn-primary">Username</button>
                                             </div>
                                             <div class="col-md-4">
                                                <button type="button" id="btnemail" class="btn btn-primary">Email</button>
                                             </div>
                                             <div class="col-md-4">
                                                <button type="button" id="btnphone" class="btn btn-primary">Phone</button>
                                             </div>
                                         </div>
                                     </div>
                                     <div id="show_code" style="display:none">
                                     <form name="frm" id="frm" method="post" action="<?php echo SITEURL; ?>process-forgot-password/">
                                        <input type="hidden" name="mode" id="mode" value="confirm">
                                        <input type="hidden" name="tokenType" id="tokenType" value="">
                                         <div class="row no-revert">
                                             <div class="col">
                                                 <div class="form-group"> 
                                                    <label id="lbllookup"></label>
                                                     <input type="text" name="accountLookup" id="accountLookup" value="" maxlength="100" class="form-control inputs"> 
                                                 </div>
                                             </div>
                                         </div>
                                        <button type="button" id="confirm" class="btn btn-primary">CONFIRM</button>
                                        <div id="show_confirm" style="display:none">
                                        <div class="text-left mt-3">
                                         <p class="text-left">We are going to send you a confirmation code to either your registered phone number or email address to confirm your account. How would you like us to send your code?</p>
                                         <div class="row">
                                             <div class="col-md-6">
                                                <button type="button" id="send_sms" class="btn btn-primary">SMS/Text Message </button>
                                             </div>
                                             <div class="col-md-6">
                                                <button type="button" id="send_email" class="btn btn-primary">Email</button>
                                             </div>
                                         </div>
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
<script type="text/javascript">
    $(document).ready(function() {
        $('.loader').hide();
        $('#btnusername').click(function() {
            $('#tokenType').val('Username');
            $('#lbllookup').text('Username: ');
            $('#show_code').show();
        });

        $('#btnemail').click(function() {
            $('#tokenType').val('Email');
            $('#lbllookup').text('Email Address: ');
            $('#show_code').show();
        });

        $('#btnphone').click(function() {
            $('#tokenType').val('PhoneNumber');
            $('#lbllookup').text('Phone Number: ');
            $('#show_code').show();
        });

        $('#send_sms').click(function() {
            send_confirmation('sms');
        });

        $('#send_email').click(function() {
            send_confirmation('email');
        });

        function send_confirmation(mode)
        {
            $.ajax({
                url: '<?php echo SITEURL; ?>process-forgot-password/', 
                type: 'GET', 
                data: 'mode=send&deliver='+mode, 
                beforeSend: function() {
                    $('.loader').show();
                    $('.wrapper').css('pointer-events', 'none');
                },
                success: function(res) {
                    //alert(res);
                    if( res == 1)
                    {
                        Swal.fire({
                          title: 'Success!',
                          text: 'Verification code has been sent.',
                          icon: 'success',
                          confirmButtonText: 'Okay'
                        });
                        window.location.href = '<?php echo SITEURL; ?>reset-password/';
                    }
                    else
                    {
                        Swal.fire({
                          title: 'Error!',
                          text: res,
                          icon: 'error',
                          confirmButtonText: 'Okay'
                        });
                        $('#show_code').hide();
                    }
                    $('.loader').hide();
                    $('.wrapper').css('pointer-events', 'auto');
                }
            });
        }
    });

    $(function(){
        $("#frm").validate({
            ignore: "",
            rules: {
                accountLookup:{required:true},
            },
            messages: { 
                accountLookup:{required:"Required"},
            },
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            }
        });

        $('#confirm').click(function() {
            if( $("#frm").valid() )
            {
                $.ajax({
                    url: '<?php echo SITEURL; ?>process-forgot-password/', 
                    type: 'GET', 
                    data: $('#frm').serialize(), 
                    beforeSend: function() {
                        $('.loader').show();
                        $('.wrapper').css('pointer-events', 'none');
                    },
                    success: function(res) {
                        //alert(res);
                        if( res == 1)
                        {
                            $('#show_confirm').show();
                        }
                        else
                        {
                            Swal.fire({
                              title: 'Error!',
                              text: res,
                              icon: 'error',
                              confirmButtonText: 'Okay'
                            });
                            $('#show_confirm').hide();
                        }
                        $('.loader').hide();
                        $('.wrapper').css('pointer-events', 'auto');
                    }
                });
            }
        });
    });
</script>
</body>
</html>
