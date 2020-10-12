<?php 
    include('connect.php'); 
    $db->checkLogin();

    $id = 0;
    if( isset($_REQUEST['id']) && $_REQUEST['id'] > 0 )
        $id = $_REQUEST['id'];

    $description = '';
    $documentFile = '';
    $documentType = '';
    $nameOfDocument = '';

    /* START: Get list of all the dependents and find the matching record */
    $querystring = '?taxApplicationId='.$_SESSION[SESS_PRE.'_TAX_APPLICATION_ID'];

    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => API_URL."TaxApplication/GetListOfDocumentsByTaxApplicationId".$querystring,
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
    if( count($res) )
    {
        foreach ($res as $document) 
        {
            if( $document['id'] == $id )
            {
                //print '<pre>'; print_r($document);
                $description = $document['description'];
                $fileLocation = $document['fileLocation'];
                $documentType = $document['documentType'];
                $nameOfDocument = $document['nameOfDocument'];
            }
        }
    }
    /* END: Get list of all the dependents and find the matching record */

    /* START: Get list of Document Types */
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => API_URL."TaxApplication/GetListOfDocumentTypes",
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
    // print $httpcode;
    // print '<pre>'; print_r($res); //exit;

    $artype = array();
    if( $httpcode == 200 )
    {
        $artype = $res;
    }
    /* END: Get list of Document Types */

    foreach ($artype as $type) {
        if( str_replace(' ', '_', $type['text']) == $documentType )
        {
            $documentType = $type['value'];
            break;
        }
    }
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
                      <?php 
                        if($mode=='add')
                        {
                          $progress = 75;
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
                                         <h3 class="text-left"><strong>Tax Documents upload</strong></h3>  
                                     </div>
                                     <form name="frm" id="frm" method="post" action="<?php echo SITEURL; ?>process-tax-documents-upload/" enctype="multipart/form-data">
                                    <!-- <form name="frm" id="frm" method="post" action="<?php echo SITEURL; ?>test_upload.php" enctype="multipart/form-data"> -->
                                         <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
                                         <input type="hidden" name="mode" id="mode" value="<?php echo ($id>0)?'edit':'add'; ?>">
                                       <div class="row no-revert">
                                           <div class="col-md-12">
                                                <div class="form-group"> 
                                                    <label for="documentType">Document Type</label>
                                                    <select name="documentType" id="documentType" class="form-control">
                                                        <option value=""></option>
                                                        <?php
                                                            foreach ($artype as $type) {
                                                                echo '<option value="'.$type['value'].'"';
                                                                if( $type['value'] == $documentType )
                                                                    echo ' selected';
                                                                echo '>'.$type['text'].'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                           </div>
                                           <div class="col-md-12">
                                                <div class="form-group"> 
                                                    <label for="nameOfDocument">Name of Document</label>
                                                    <input type="text" name="nameOfDocument" id="nameOfDocument" value="<?php echo $nameOfDocument; ?>" maxlength="150" class="form-control" placeholder="Name of Documents"> 
                                                </div>
                                           </div>
                                           <div class="col-md-12">
                                                <div class="form-group"> 
                                                    <label for="documentFile">Document File</label>
                                                    <input type="file" name="documentFile" id="documentFile" class="form-control"> 
                                                    <input type="hidden" name="old_documentFile" id="old_documentFile" value="<?php echo $documentFile; ?>">
                                                </div>
                                           </div>
                                           <div class="col-md-12">
                                                <div class="form-group"> 
                                                    <label for="description">Description</label>
                                                    <input type="text" name="description" id="description" value="<?php echo $description; ?>" maxlength="400" class="form-control" placeholder="Description"> 
                                                </div>
                                           </div>
                                            
                                       </div>
                                        <button type="submit" name="submit" id="submit" class="btn btn-primary">NEXT</button>   
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
                documentType:{required:true},
                nameOfDocument:{required:true},
                documentFile:{required:function() {if($('#mode').val() == 'add') return true; else return false;} },
                description:{required:true},
            },
            messages: { 
                documentType:{required:"Please select document type."},
                nameOfDocument:{required:"Please enter name of the document."},
                documentFile:{required:"Please select document file."},
                description:{required:"Please enter description."},
            },
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            }
        });
    });
</script>
</body>
</html>