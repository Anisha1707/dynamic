<?php
	include('../connect.php');
	$franchiseCode = '';
	$preparerCode = '';

	if( isset($_REQUEST['fran']) && !is_null($_REQUEST['fran']) && !empty($_REQUEST['fran']) )
		$franchiseCode = $_REQUEST['fran'];
	if( isset($_REQUEST['prep']) && !is_null($_REQUEST['prep']) && !empty($_REQUEST['prep']) )
		$preparerCode = $_REQUEST['prep'];
?>
<!DOCTYPE html>
<html lang="en" class="">
<head>
	<!-- Site Title -->
	<title>Register | Red Blue Page</title>
	<?php include('include/css.php'); ?>
</head>
<body>
	<section class="banner-area banner-reg-area">
		<div class="container">
			<div class="logo-area">
				<img src="<?php echo SITEURL; ?>images/logo.png" class="img img-fluid img-logo">
			</div>
			<div class="row justify-content-center">
				<div class="col-md-10">
					<div class="banner-title-main banner-registration">
						<h3 class="heading"><?php echo CLIENT_HEADING; ?></h3>

						<h2 class="sub-heading">Let Us Get a Little Information From You So We Can Send You the Information!</h2>

						<form name="frm" id="frm" method="POST" class="reg-form" action="<?php echo CLIENTURL; ?>thank-you/">
							<input type="hidden" name="fran" id="fran" value="<?php echo $franchiseCode; ?>">
							<input type="hidden" name="prep" id="prep" value="<?php echo $preparerCode; ?>">
							<div class="form-row">
							    <div class="form-group col-md-6">
							      <label for="first_name">First Name</label>
							      <input type="text" name="first_name" id="first_name" value="" maxlength="50" class="form-control" placeholder="First Name"> 
							    </div>
							    <div class="form-group col-md-6">
							      <label for="last_name">Last Name </label>
							      <input type="text" name="last_name" id="last_name" value="" maxlength="50" class="form-control" placeholder="Last Name"> 
							    </div>
							  </div>
							   <div class="form-row">
							    <div class="form-group col-md-6">
							      <label for="email">Email</label>
							      <input type="email" name="email" id="email" value="" maxlength="100" class="form-control" placeholder="Email"> 
							    </div>
							    <div class="form-group col-md-6">
							      <label for="phone">Phone Number</label>
							      <input type="number" name="phone" id="phone" value="" maxlength="20" class="form-control" placeholder="Phone Number"> 
							    </div>
							</div>
							
							<button type="submit" class="btn a-link ">Give Me More Information</button>
						</form>
						
					</div>
				</div>
			</div>
			
		</div>
	</section>
	<?php include('../front_include/js.php'); ?>
	<script type="text/javascript">
	    $(function(){
	        $("#frm").validate({
	            ignore: "",
	            rules: {
	                first_name:{required:true},
	                last_name:{required:true},
	                email:{required:true, email:true},
	                phone:{required:true},
	            },
	            messages: { 
	                first_name:{required:"Please enter first name."},
	                last_name:{required:"Please enter last name."},
	                email:{required:"Please enter email address.", email:"Please enter valid email address."},
	                phone:{required:"Please enter phone number."},
	            },
	            errorPlacement: function(error, element) {
	                error.insertAfter(element);
	            }
	        });
	    });
	</script>
</body>
</html>