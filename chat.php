<?php 
    include('connect.php'); 
    $db->checkLogin();

    $threadID = 0;

    if( isset($_REQUEST['threadID']) && !is_null($_REQUEST['threadID']) && !empty($_REQUEST['threadID']) )
      $threadID = $_REQUEST['threadID'];

    /* START: Get Tax Professionals */
    $arprofessional = array();
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
    else
    {
      if( count($res['taxProfessionals']) )
      {
        $n = count($res['taxProfessionals']);
        for($i=0; $i<$n; $i++ )
        {
          array_push($arprofessional, array('id' => $res['taxProfessionals'][$i]['userId'], 'name' => $res['taxProfessionals'][$i]['displayName']));
        }
      }
    }
    /* END: Get Tax Professionals */


    /* START: Get all the messages from the thread */
    $querystring = '?threadId='.$threadID;

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => API_URL."Communication/GetMessagesByThreadId".$querystring,
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
    /* END: Get all the messages from the thread */
?>

<div class="modal-dialog modal-dialog-centered">
  <div class="modal-content">
    <!-- Modal Header -->
    <div class="modal-header">
      <h4 class="modal-title">CHAT</h4>
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    
    <!-- Modal body -->
    <div class="modal-body">
      <?php //print '<pre>'; print_r($res); //exit; ?>
      <div class="chat-body">
      <?php
        foreach ($res as $msg) 
        {
          $dt = '';
          //echo date('m/d/Y');
          if( $db->date($msg['dateInserted'], 'm/d/Y') == date('m/d/Y') )
            $dt = $db->date($msg['dateInserted'], 'h:i A');
          else
            $dt = $db->date($msg['dateInserted'], 'm/d/Y h:i A');

          if( $msg['isTPB'] == 1 )
          {
      ?>
        <div class="chat-container <?php echo ($msg['unread'])?' unread':''; ?>">
          <img src="<?php echo SITEURL; ?>images/tpb-avatar.png" alt="<?php echo $msg['displayName']; ?>" title="<?php echo $msg['displayName']; ?>" style="width:100%;">
          <?php echo $msg['body']; ?>
          <span class="time-right"><?php echo $dt; ?></span>
        </div>
      <?php
          }
          else
          {
      ?>
        <div class="chat-container darker <?php echo ($msg['unread'])?' unread':''; ?>">
          <img src="<?php echo SITEURL; ?>images/client-avatar.png" alt="<?php echo $msg['displayName']; ?>" title="<?php echo $msg['displayName']; ?>" class="right" style="width:100%;">
          <?php echo $msg['body']; ?>
          <span class="time-left"><?php echo $dt; ?></span>
        </div>
      <?php
          }
        }
      ?>
      </div>

      <br /><hr style="border-top: 2px solid #000;" />
      <form name="frmchat" id="frmchat" method="post" action="<?php echo SITEURL; ?>process-chat/" class="frm-chat">
        <input type="hidden" name="messageThreadId" id="messageThreadId" value="<?php echo $threadID; ?>">
        <input type="hidden" name="severityLevel" id="severityLevel" value="1">
        <input type="hidden" name="mode" id="mode" value="create">
        <div class="form-group">
          <label>Tax Professional</label>
          <select name="toUserId" id="toUserId" class="form-control">
          <?php
            if( count($arprofessional) )
            {
              $n = count($arprofessional);
              for($i=0; $i<$n; $i++ )
              {
                echo '<option value="'.$arprofessional[$i]['id'].'">'.$arprofessional[$i]['name'].'</option>';  
              }
            }
          ?>            
          </select>
        </div>
        <div class="form-group">
          <label>Message</label>
          <textarea name="txtmessage" id="txtmessage" rows="3" placeholder="Type your message"></textarea>
          <div id="desc_err"></div>
        </div>
        <button type="submit" class="btn btn-primary">SUBMIT</button>
      </form>
    </div>
  </div>
</div>
<?php include('front_include/js.php'); ?>
<script type="text/javascript" src="<?php echo SITEURL; ?>js/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        CKEDITOR.replace('txtmessage', {toolbar:'Basic'});
        $('.loader').hide();

        setTimeout(function() {
        <?php
          foreach ($res as $msg) 
          {
            if( $msg['unread'] )
              echo 'mark_read("'.$msg['id'].'");';
          }
        ?>
        }, 1000);
    });

    $(function(){
        $("#frmchat").validate({
            ignore: "",
            rules: {
                txtmessage:{required : function() { CKEDITOR.instances.txtmessage.updateElement(); } },
            },
            messages: { 
                txtmessage:{required:"Please enter message."},
            },
            errorPlacement: function(error, element) {
              if( element.attr("name") == 'txtmessage' )
                error.insertAfter("#desc_err");
              else
                error.insertAfter(element);
            }
        });
    });

    function mark_read(id)
    {
      $.ajax({
        url: "<?php echo SITEURL; ?>process-chat/",
        type: 'post',
        data: {messageId:id, mode:'read'},
        success: function(data) {
          //console.log(data);
        }               
      });
    }
</script>
</body>
</html>