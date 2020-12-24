<?php 
    include('connect.php'); 
    $db->checkLogin();

    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => API_URL."Communication/GetAllTickets",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
          "Authorization: Bearer ".$_SESSION[SESS_PRE.'_USER_TOKEN']
        ),
    ));

    $response = curl_exec($curl);
    //print_r($response);
    $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE); // curl response code
    curl_close($curl);

    $res = json_decode($response, true);
    //print '<pre>'; print_r($res); //exit;

    if( $httpcode <> 200 )
    {
      $_SESSION['MSG'] = 'Session_Expired';
      $db->location(SITEURL);
      exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo SITENAME; ?></title>
    <?php include('front_include/css.php'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo SITEURL; ?>css/chat.css">
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
                                         <h3 class="text-left text-uppercase"><strong>Tickets</strong></h3>  
                                     </div>
                                    <?php
                                        $n = count($res);
                                        if( $n > 0 )
                                        {
                                    ?>
                                    <ul class="text-left list-of-document">
                                    <?php
                                        for( $i=0; $i<$n; $i++ )
                                        {
                                    ?>
                                        <li class="d-flex align-items-center border-bottom py-3">
                                            <div class="text-main">
                                                <h6 class="mb-0"><?php echo $res[$i]['issue']; ?></h6>
                                                <?php
                                                    if( $res[$i]['isClosed'] )
                                                        echo '<small class="text-warning">(Closed) - '.$db->rpdate($res[$i]['closedDate'], 'm/d/Y').'</small>';
                                                ?>
                                            </div>
                                            <div class="buttons ml-auto d-flex">
                                                <button type="button" class="btn btn-primary py-1 px-2 ml-2" data-toggle="modal" data-target="#modal-ticket" onclick="view_ticket('<?php echo $res[$i]['id']; ?>');">View</button>
                                            </div>
                                        </li>
                                    <?php
                                        }
                                    ?>
                                    </ul>
                                    <?php
                                        }
                                        else
                                        {
                                            echo '<div class="row col-md-12 text-center"><p>No record found</p></div>';
                                        }
                                    ?>
                                    <div class="step active mt-3">
                                        <h4><strong>Do you have any issue?</strong></h4>
                                        <div class="row my-3 justify-content-center no-revert">
                                            <div class="col-md-6">
                                                <button type="button" class="btn btn-primary" id="btncreate">Create Ticket</button>
                                            </div>
                                        </div>
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

    <div class="modal" id="modal-ticket">
        <div class="modal-dialog  modal-dialog-centered chat-dialog"></div>
    </div>

    <?php include('front_include/footer.php'); ?>
</div>
<?php include('front_include/js.php'); ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('.loader').hide();
    });

    $('#btncreate').click(function() {
        window.location.href = "<?php echo SITEURL; ?>create-ticket/";
    });

    function view_ticket(id)
    {
        //window.location.href = "<?php echo SITEURL; ?>ticket-information/"+id+"/";
        $.ajax({
            url: "<?php echo SITEURL; ?>ticket-information/"+id+"/",
            type: 'post',
            data: {},
            beforeSend: function(){
                 $(".loader").show();
            }, 
            success: function(data) {
               //alert(data);
               $('#modal-ticket').html(data).modal('show');
               $(".loader").hide(); 
            }               
        });
    }
</script>
</body>
</html>