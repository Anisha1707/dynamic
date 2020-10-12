<header class="py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
             <div class="logo d-flex align-items-center">
                 <a href="<?php echo SITEURL; ?>customer-portal/"><img src="<?php echo SITEURL; ?>images/logo.png" class="img-fluid" width="150" alt=""></a>
                 <h1><strong><?php echo SITENAME; ?></strong></h1>
             </div>
            </div>
        </div>
    </div>
</header>
<div class="navbar">
<?php
    if( $page == 'Customer Portal' && isset($_SESSION[SESS_PRE.'_USER_TOKEN']) && !empty($_SESSION[SESS_PRE.'_USER_TOKEN']) ) {
?>    
  <div class="dropdown">
    <button class="dropbtn btn btn-primary">
        <i class="fa fa-user-circle mr-0"></i>
        <span class="nav-profile-name"><?php echo 'Welcome '. $res['displayName'];?></span>
        <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="<?php echo SITEURL; ?>change-username/">Update Username</a>
      <a href="<?php echo SITEURL; ?>change-password/">Update Password</a>
      <a href="<?php echo SITEURL; ?>change-profile/">Update Profile</a>
      <a href="<?php echo SITEURL; ?>change-contact/">Update Contact Information</a>
      <a href="<?php echo SITEURL; ?>logout/">Logout</a>
    </div>
  </div>
<?php
    }
?>
</div>
