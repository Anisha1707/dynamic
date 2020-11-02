<script src="<?php echo SITEURL; ?>js/jquery-3.2.1.min.js"></script>
<script src="<?php echo SITEURL; ?>js/jquery.validate.js"></script>
<script src="<?php echo SITEURL; ?>js/popper.min.js"></script>
<script src="<?php echo SITEURL; ?>js/bootstrap.min.js"></script>
<!-- <script src="<?php echo SITEURL; ?>js/bootstrap-notify.js"></script> -->
<script src="<?php echo SITEURL; ?>js/jquery.mask.min.js"></script>
<script src="<?php echo SITEURL; ?>js/sweetalert2/dist/sweetalert2.all.min.js"></script>
<!-- Optional: include a polyfill for ES6 Promises for IE11 -->
<!-- <script src="https://cdn.jsdelivr.net/npm/promise-polyfill"></script> -->
<script src="<?php echo SITEURL; ?>js/script.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		//alert("<?php echo addslashes($_SESSION['MSG']); ?>");
		setTimeout(function(){
			<?php if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Something_Wrong') { ?>
				Swal.fire({
				  title: 'Error!',
				  html: 'Something went wrong, Please try again !',
				  icon: 'error',
				  confirmButtonText: 'Okay'
				});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Session_Expired') { ?>
				Swal.fire({
				  title: 'Error!',
				  html: 'Session expired. Please login!',
				  icon: 'error',
				  confirmButtonText: 'Okay'
				});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Invalid_Email_Password') { ?>
				Swal.fire({
				  title: 'Error!',
				  html: 'Invalid email or password.',
				  icon: 'error',
				  confirmButtonText: 'Okay'
				});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Success_Login') { ?>
				Swal.fire({
				  title: 'Success!',
				  html: 'You have successfully logged in to the site.',
				  icon: 'success',
				  confirmButtonText: 'Okay'
				});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Success_Confirm') { ?>
				Swal.fire({
				  title: 'Success!',
				  html: 'The confirmation process has been completed successfully.',
				  icon: 'success',
				  confirmButtonText: 'Okay'
				});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Code_verified') { ?>
				Swal.fire({
				  title: 'Success!',
				  html: 'Code verified successfully.',
				  icon: 'success',
				  confirmButtonText: 'Okay'
				});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Tax_Application_Success') { ?>
				Swal.fire({
				  title: 'Success!',
				  html: 'Tax application has been submitted successfully.',
				  icon: 'success',
				  confirmButtonText: 'Okay'
				});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Personal_Info_Success') { ?>
				Swal.fire({
				  title: 'Success!',
				  html: 'Personal information has been submitted successfully.',
				  icon: 'success',
				  confirmButtonText: 'Okay'
				});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Address_Success') { ?>
				Swal.fire({
				  title: 'Success!',
				  html: 'Address information has been submitted successfully.',
				  icon: 'success',
				  confirmButtonText: 'Okay'
				});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Identification_Success') { ?>
				Swal.fire({
				  title: 'Success!',
				  html: 'Identification information has been submitted successfully.',
				  icon: 'success',
				  confirmButtonText: 'Okay'
				});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Pin_Success') { ?>
				Swal.fire({
				  title: 'Success!',
				  html: 'PIN information has been submitted successfully.',
				  icon: 'success',
				  confirmButtonText: 'Okay'
				});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Spouse_Info_Success') { ?>
				Swal.fire({
				  title: 'Success!',
				  html: 'Spouse information has been submitted successfully.',
				  icon: 'success',
				  confirmButtonText: 'Okay'
				});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Spouse_Address_Success') { ?>
				Swal.fire({
				  title: 'Success!',
				  html: 'Spouse address information has been submitted successfully.',
				  icon: 'success',
				  confirmButtonText: 'Okay'
				});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Spouse_Identification_Success') { ?>
				Swal.fire({
				  title: 'Success!',
				  html: 'Spouse identification information has been submitted successfully.',
				  icon: 'success',
				  confirmButtonText: 'Okay'
				});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Spouse_Occupation_Success') { ?>
				Swal.fire({
				  title: 'Success!',
				  html: 'Spouse occupation information has been submitted successfully.',
				  icon: 'success',
				  confirmButtonText: 'Okay'
				});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Spouse_Pin_Success') { ?>
				Swal.fire({
				  title: 'Success!',
				  html: 'Spouse PIN information has been submitted successfully.',
				  icon: 'success',
				  confirmButtonText: 'Okay'
				});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Dependent_Info_Success') { ?>
				Swal.fire({
				  title: 'Success!',
				  html: 'Dependent information has been submitted successfully.',
				  icon: 'success',
				  confirmButtonText: 'Okay'
				});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Dependent_Info_Error') { ?>
				Swal.fire({
				  title: 'Error!',
				  html: 'There is some issue with getting dependent(s) information. Please try again later!',
				  icon: 'error',
				  confirmButtonText: 'Okay'
				});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Document_Upload_Success') { ?>
				Swal.fire({
				  title: 'Success!',
				  html: 'Document uploaded successfully.',
				  icon: 'success',
				  confirmButtonText: 'Okay'
				});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Document_Info_Error') { ?>
				Swal.fire({
				  title: 'Error!',
				  html: 'There is some issue with getting document(s) information. Please try again later!',
				  icon: 'error',
				  confirmButtonText: 'Okay'
				});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Review_Info_Error') { ?>
				Swal.fire({
				  title: 'Error!',
				  html: 'There is some issue with getting tax application information. Please try again later!',
				  icon: 'error',
				  confirmButtonText: 'Okay'
				});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Signature_Success') { ?>
				Swal.fire({
				  title: 'Success!',
				  html: 'Signatures uploaded successfully.',
				  icon: 'success',
				  confirmButtonText: 'Okay'
				});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Update_Username_Success') { ?>
				Swal.fire({
				  title: 'Success!',
				  html: 'Username updated successfully.',
				  icon: 'success',
				  confirmButtonText: 'Okay'
				});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Update_Password_Success') { ?>
				Swal.fire({
				  title: 'Success!',
				  html: 'Password updated successfully.',
				  icon: 'success',
				  confirmButtonText: 'Okay'
				});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Update_Profile_Success') { ?>
				Swal.fire({
				  title: 'Success!',
				  html: 'Profile information updated successfully.',
				  icon: 'success',
				  confirmButtonText: 'Okay'
				});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Update_Contact_Success') { ?>
				Swal.fire({
				  title: 'Success!',
				  html: 'Contact information updated successfully.',
				  icon: 'success',
				  confirmButtonText: 'Okay'
				});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Duplicate_Email_Error') { ?>
				Swal.fire({
				  title: 'Error!',
				  html: 'The email address is already registered with us. Please use another!',
				  icon: 'error',
				  confirmButtonText: 'Okay'
				});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Duplicate_Phone_Error') { ?>
				Swal.fire({
				  title: 'Error!',
				  html: 'The phone number is already registered with us. Please use another!',
				  icon: 'error',
				  confirmButtonText: 'Okay'
				});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Duplicate_User_Error') { ?>
				Swal.fire({
				  title: 'Error!',
				  html: 'The username is already registered with us. Please use another!',
				  icon: 'error',
				  confirmButtonText: 'Okay'
				});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Chat_Msg_Success') { ?>
				Swal.fire({
				  title: 'Success!',
				  html: 'Your message has been sent successfully.',
				  icon: 'success',
				  confirmButtonText: 'Okay'
				});
			<?php unset($_SESSION['MSG']); } else if( isset($_SESSION['MSG']) && !empty($_SESSION['MSG']) ) { ?>
				//$.notify({message: "<?php echo addslashes($_SESSION['MSG']); ?>"},{type: 'danger'});
				Swal.fire({
				  title: 'Error!',
				  html: "<?php echo addslashes($_SESSION['MSG']); ?>",
				  icon: 'error',
				  confirmButtonText: 'Okay'
				});
			<?php 
				/*if( $db->endsWith($_SERVER['REQUEST_URI'], 'confirmation/') ) 
				{
					echo "alert('hiii');";
					echo '$("#show_code").show();'; 
				}*/
				unset($_SESSION['MSG']); 
			} 
			?>
		},1000);
   	});

</script>
