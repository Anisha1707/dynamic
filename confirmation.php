<?php 
    include('connect.php'); 

    if( !isset($_SESSION[SESS_PRE.'_USER_TOKEN']) || empty($_SESSION[SESS_PRE.'_USER_TOKEN']) || is_null($_SESSION[SESS_PRE.'_USER_TOKEN']) )
    {
        $_SESSION['MSG'] = 'Something_Wrong';
        $db->location(SITEURL.'signup/');
        exit;
    }
    //print 'Token: ' . $_SESSION[SESS_PRE.'_USER_TOKEN'];
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
                                         <h3 class="text-left"><strong>CONFIRM ACCOUNT</strong></h3>
                                         <p class="text-left">We are going to send you a confirmation code to either your phone number or email address you just created to confirm your account. How would you like us to send your code?</p>
                                         <div class="row">
                                             <div class="col-md-6">
                                                <button type="submit" id="send_sms" class="btn btn-primary">SMS/Text Message </button>
                                             </div>
                                             <div class="col-md-6">
                                                <button type="submit" id="send_email" class="btn btn-primary">Email</button>
                                             </div>
                                         </div>
                                     </div>
                                     <div id="show_code" style="<?php echo ( $_SESSION['MSG'] != 'Code_verified' )?'display:none;':''; ?>">
                                     <form name="frm" id="frm" method="post" action="<?php echo SITEURL; ?>process-confirmation/">
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
                                        <div id="show_confirm" style="<?php echo ( $_SESSION['MSG'] != 'Code_verified' )?'display:none;':''; ?>">
                                        <div class="text-left mt-3">
                                            <p>Now that you have confirmed your account, <br>
                                                let's fill out your tax application. Press okay below continue.</p>
                                            <button type="button" id="btnverified" class="btn btn-primary">Okay</button>
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
        $('#send_sms').click(function() {
            send_confirmation('sms');
        });

        $('#send_email').click(function() {
            send_confirmation('email');
        });

        function send_confirmation(mode)
        {
            $.ajax({
                url: '<?php echo SITEURL; ?>process-confirmation/', 
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
                        //$.notify({message:"Verification code has been sent."}, {type:"success"});
                        Swal.fire({
                          title: 'Success!',
                          text: 'Verification code has been sent.',
                          icon: 'success',
                          confirmButtonText: 'Okay'
                        });
                        $('#show_code').show();
                        $('#letter_1').focus();
                    }
                    else
                    {
                        //$.notify({message:res}, {type:"danger"});
                        Swal.fire({
                          title: 'Error!',
                          text: res,
                          icon: 'error',
                          confirmButtonText: 'Okay'
                        });
                        console.log(res);
                        $('#show_code').hide();
                        //$('#show_code').show();
                        //$('#letter_1').focus();
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
                    url: '<?php echo SITEURL; ?>process-confirmation/', 
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
                            Swal.fire({
                              title: 'Success!',
                              text: 'Account successfully confirmed.',
                              icon: 'success',
                              confirmButtonText: 'Okay'
                            });
                            $('#show_confirm').show();
                        }
                        else
                        {
                            //$.notify({message:res}, {type:"danger"});
                            Swal.fire({
                              title: 'Error!',
                              text: res,
                              icon: 'error',
                              confirmButtonText: 'Okay'
                            });
                            console.log(res);
                            $('#show_confirm').hide();
                            //$('#show_confirm').show();
                        }
                        $('.loader').hide();
                        $('.wrapper').css('pointer-events', 'auto');
                    }
                });
            }
        });

        $('#btnverified').click(function() {
            window.location.href = "<?php echo SITEURL; ?>tax-application/";
        });
    });
</script>
</body>
</html>
