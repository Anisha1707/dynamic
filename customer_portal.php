<?php 
  include('connect.php'); 
  $db->checkLogin();
  $page = 'Customer Portal';
  //print $_SESSION[SESS_PRE.'_USER_TOKEN'];

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => API_URL."User/GetUserDashboard",
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
  //print '<pre>'; print_r($res); exit;

  if( $httpcode <> 200 )
  {
    $_SESSION['MSG'] = 'Session_Expired';
    $db->location(SITEURL);
    exit;
  }

  $_SESSION['franchiseId'] = $res['franchiseId'];
  $_SESSION['preparerId'] = $res['preparerId'];
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
                 <div class="col-md-8">
                    <div class="row mb-3">
                      <?php
                        if( count($res['taxApplications']) )
                        {
                      ?>                      
                        <div class="col-md-6 mb-4">
                            <div class="contact-inner h-100">
                               <h4><strong>Tax Application</strong></h4>
                               <ul class="list-main p-0 mx-0 mt-3">
                                <?php
                                  $n = count($res['taxApplications']);
                                  for($i=0; $i<$n; $i++ )
                                  {
                                ?>
                                    <li class="d-flex text-left align-items-center mb-3">
                                      <p class="mr-3 mb-0"><a href="<?php echo SITEURL.$percentage_page[$res['taxApplications'][$i]['percentComplete']].$res['taxApplications'][$i]['taxApplicationId'].'/edit/'; ?>"><?php echo $res['taxApplications'][$i]['taxYear']; ?></a></p>
                                      <span class="text-right w-100">
                                      <?php 
                                        if($res['taxApplications'][$i]['isFiled'])
                                          echo '<span class="black" title="Filed"> <i class="fas fa-flag-checkered mr-2"></i></span> ';
                                        if($res['taxApplications'][$i]['isAssigned'])
                                          echo '<span class="black" title="Assigned"> <i class="fas fa-user-tie mr-2"></i></span> ';
                                        if($res['taxApplications'][$i]['isViewed'])
                                          echo '<span class="black" title="Viewed"> <i class="fas fa-eye mr-2"></i></span> ';
                                        //if(! $res['taxApplications'][$i]['isCompleted'])
                                        if(! $res['taxApplications'][$i]['isFiled'])
                                        {
                                          echo '<span class="ml-auto black" title="Upload" data-toggle="modal" data-target="#modal-upload" onclick="show_upload('.$res['taxApplications'][$i]['taxApplicationId'].');"> <i class="fas fa-file-upload mr-2"></i></span> ';
                                        }
                                      ?>
                                      </span>
                                    </li>
                                <?php
                                  }
                                ?>
                               </ul>

                               <button class="btn btn-primary" type="button" id="btnadd">Add Tax Application <i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                      <?php
                        }

                        if( count($res['userMessages']) )
                        {
                      ?>                                           
                        <div class="col-md-6 mb-4">
                            <div class="contact-inner h-100">
                               <h4><strong>Messages</strong></h4>
                               <ul class="list-main p-0 mx-0 mt-3">
                                <?php
                                  $n = count($res['userMessages']);
                                  for($i=0; $i<$n; $i++ )
                                  {
                                ?>
                                   <li class="d-flex text-left align-items-center chat-msg mb-3">
                                        <i class="fas fa-envelope"></i>
                                        <p class="ml-3 mb-0"><?php echo $res['userMessages'][$i]['threadTitle']; ?>
                                        </p> 
                                        <span class="black text-right w-80" title="Chat" data-toggle="modal" data-target="#modal-chat" onclick="show_chat('<?php echo $res['userMessages'][$i]['threadId']; ?>');"> <i class="fas fa-comments mr-2"></i></span>
                                   </li>
                                <?php
                                  }
                                ?>
                               </ul>
                            </div>
                        </div>
                      <?php
                        }
                      ?>
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
                    <?php
                      if( count($res['taxProfessionals']) )
                      {
                        $n = count($res['taxProfessionals']);
                        for($i=0; $i<$n; $i++ )
                        {
                    ?>
                      <div class="col-md-12 col-lg-6 mb-4">
                        <div class="contact-inner">
                          <!-- <a href="javasript:void(0)"> -->
                          <div class="team text-center">
                            <img src="<?php echo $res['taxProfessionals'][$i]['imageUrl']; ?>" class="img-fluid mb-3" alt="">
                            <h5 class="black"><?php echo str_replace(' ', '<br />', $res['taxProfessionals'][$i]['displayName']); ?></h5>
                            <small class="black"><?php echo $res['taxProfessionals'][$i]['title']; ?></small>
                          </div>
                          <!-- </a> -->
                        </div>
                      </div>
                    <?php
                        }
                      }
                    ?>
                    </div>
                 </div>
             </div>
         </div>
     </section>

      <div class="modal" id="modal-upload">
         <div class="modal-dialog  modal-dialog-centered"></div>
      </div>

      <div class="modal" id="modal-chat">
         <div class="modal-dialog  modal-dialog-centered chat-dialog"></div>
      </div>

    <?php include('front_include/footer.php'); ?>       
</div>
<?php include('front_include/js.php'); ?>
<script type="text/javascript">
    $(document).ready(function() {
      $('.loader').hide();
    });
  $('#btnadd').click(function() {
      window.location.href = "<?php echo SITEURL; ?>tax-application/";
  });

  function show_upload(taxID)
  {
     $.ajax({
        url: "<?php echo SITEURL; ?>tax-documents-upload-model/"+taxID+"/",
        type: 'post',
        data: {},
        beforeSend: function(){
             $(".loader").show();
        }, 
        success: function(data) {
           //alert(data);
           $('#modal-upload').html(data).modal('show');
           $(".loader").hide(); 
        }               
     });
  }

  function show_chat(threadID)
  {
     $.ajax({
        url: "<?php echo SITEURL; ?>chat/"+threadID+"/",
        type: 'post',
        data: {},
        beforeSend: function(){
             $(".loader").show();
        }, 
        success: function(data) {
           //alert(data);
           $('#modal-chat').html(data).modal('show');
           $(".loader").hide(); 
        }               
     });
  }
  
</script>
</body>
</html>