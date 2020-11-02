<?php
	include('../connect.php');
?>
<!DOCTYPE html>
<html lang="en" class="">
<head>
	<!-- Site Title -->
	<title>Thank you | Red Blue Page</title>
	<?php include('include/css.php'); ?>
</head>
<body>
	<section class="banner-area">
		<div class="container">
			<div class="logo-area">
				<img src="<?php echo SITEURL; ?>images/logo.png" class="img img-fluid img-logo">
			</div>
			<div class="row justify-content-center">
				<div class="col-md-10">
					<div class="banner-title-main banner-thankyou">
						<h3 class="heading"><?php echo CLIENT_HEADING; ?></h3>
						<h2 class="sub-heading">Thank You!</h2>
						<p class="sub-text">Please Watch this short video about our passion to serve</p>
						<div class="thankyou-video">
							<div class="embed-responsive embed-responsive-16by9">
								<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/YihV9CqxxJY?rel=0" allowfullscreen></iframe>
							</div>							 
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php include('../front_include/js.php'); ?>
</body>
</html>