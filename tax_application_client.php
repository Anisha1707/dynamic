<?php 
    include('connect.php'); 
    $db->checkLogin();

    $franchiseCode = '';
    $preparerCode = '';

    if( isset($_REQUEST['fran']) && !is_null($_REQUEST['fran']) && !empty($_REQUEST['fran']) )
        $franchiseCode = $_REQUEST['fran'];
    if( isset($_REQUEST['prep']) && !is_null($_REQUEST['prep']) && !empty($_REQUEST['prep']) )
        $preparerCode = $_REQUEST['prep'];
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
                          $progress = 0;
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
                                         <h3 class="text-left w-100"><strong>TAX APPLICATION</strong></h3>
                                         <p class="text-left">We are going to ask you a series of questions to gather information regarding the information of yourself, spouse/dependents if applicable and any information needed for your occupation/job</p>
                                         <p class="text-left">this information will be used by our tax professionals in preparing your taxes and take security very seriously.</p>
                                         <p class="text-left">Let's get started!</p> 
                                     </div>
                                     <form name="frm" id="frm" method="post" action="<?php echo SITEURL; ?>process-tax-application-client/">
                                        <input type="hidden" name="fran" id="fran" value="<?php echo $franchiseCode; ?>">
                                        <input type="hidden" name="prep" id="prep" value="<?php echo $preparerCode; ?>">
                                        <div class="form-group"> 
                                            <label for="year">Tax Year</label>
                                            <select name="year" id="year" class="form-control">
                                              <option value="">Tax Year</option>
                                              <?php
                                                $year = date('Y');
                                                $year_end = $year-3;

                                                // If current date between December 21st and December 31st, the next year needs to be added to the list.
                                                if( date('m') == 12 )
                                                {
                                                    $dt = date('d');
                                                    if( $dt >= 21 && $dt <= 31 )
                                                        $year++;
                                                }
                                                for( $i=$year; $i>=$year_end; $i-- )
                                                {
                                                    echo '<option value="'.$i.'"';
                                                    if( $i == $taxYear )
                                                        echo ' selected';
                                                    echo '>'.$i.'</option>';
                                                }
                                              ?>
                                            </select>
                                        </div>
                                        <div class="form-group"> 
                                            <label for="occupation">Occupation/Job</label>
                                            <input type="text" name="occupation" id="occupation" value="<?php echo $occupation; ?>" class="form-control" placeholder="Occupation/Job" maxlength="100"> 
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
                year:{required:true},
                occupation:{required:true},
            },
            messages: { 
                year:{required:"Please select year."},
                occupation:{required:"Please enter occupation/job."},
            },
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            }
        });
    });
</script>
</body>
</html>