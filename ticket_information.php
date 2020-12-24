<?php 
    include('connect.php'); 
    $db->checkLogin();

    $ticketID = 0;

    if( isset($_REQUEST['ticketID']) && !is_null($_REQUEST['ticketID']) && !empty($_REQUEST['ticketID']) )
      $ticketID = $_REQUEST['ticketID'];

    /* START: Get all the messages from the thread */
    $querystring = '?ticketId='.$ticketID;
    //print $querystring;

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => API_URL."Communication/GetTicketMessagesByTicketId".$querystring,
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
    /* END: Get all the messages from the thread */
?>
<div class="modal-dialog modal-dialog-centered chat-dialog">
  <div class="modal-content">
    <!-- Modal Header -->
    <div class="modal-header">
      <h4 class="modal-title">TICKET MESSAGES</h4>
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

          $flg = 1;
          if( substr($msg['body'], 0, 3) == '<p>' )
            $flg = 0;

          if( $msg['isTPB'] == 1 )
          {
      ?>
        <div class="chat-container <?php echo ($msg['unread'])?' unread':''; ?>">
          <img src="<?php echo SITEURL; ?>images/tpb-avatar.png" alt="<?php echo $msg['displayName']; ?>" title="<?php echo $msg['displayName']; ?>" style="width:100%;">
          <?php echo ($flg)?'<p>':''; echo $msg['body']; echo ($flg)?'</p>':''; ?>
          <span class="time-left">From <?php echo $msg['displayName']; ?></span>
          <span class="time-right"><?php echo $dt; ?></span>
        </div>
      <?php
          }
          else
          {
      ?>
        <div class="chat-container darker <?php echo ($msg['unread'])?' unread':''; ?>">
          <img src="<?php echo SITEURL; ?>images/client-avatar.png" alt="<?php echo $msg['displayName']; ?>" title="<?php echo $msg['displayName']; ?>" class="right" style="width:100%;">
          <?php echo ($flg)?'<p>':''; echo $msg['body']; echo ($flg)?'</p>':''; ?>
          <span class="time-left"><?php echo $dt; ?></span>
          <span class="time-right">From <?php echo $msg['displayName']; ?></span>
        </div>
      <?php
          }
        }
      ?>
      </div>

      <br /><hr style="border-top: 2px solid #000;" />
      <form name="frmticket" id="frmticket" method="post" action="<?php echo SITEURL; ?>process-ticket-information/" class="frm-chat">
        <input type="hidden" name="ticketId" id="ticketId" value="<?php echo $ticketID; ?>">
        <input type="hidden" name="mode" id="mode" value="create">
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
        $("#frmticket").validate({
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
        url: "<?php echo SITEURL; ?>process-ticket-information/",
        type: 'post',
        data: {ticketMessageId:id, mode:'read'},
        success: function(data) {
          console.log(data);
        }               
      });
    }
</script>
</body>
</html>