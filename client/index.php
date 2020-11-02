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
	<title>Home | Red Blue Page</title>
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
					<div class="banner-title-main banner-index">
						<h3 class="heading"><?php echo CLIENT_HEADING; ?></h3>
						<h2 class="sub-heading">Join Us to Maximize Your Tax Return Refund By True Professionals</h2>
						<p class="sub-text">We have studied the tax code to best serve our clients!</p>
						<a href="<?php echo SITEURL; ?>signup/<?php echo $franchiseCode . '/' . $preparerCode . '/'; ?>" class="btn a-link">Let's Get Started</a>
						<a href="<?php echo CLIENTURL; ?>register/<?php echo $franchiseCode . '/' . $preparerCode . '/'; ?>" class="btn a-link ml-3">Give Me More Information </a>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php include('../front_include/js.php'); ?>
</body>
</html>