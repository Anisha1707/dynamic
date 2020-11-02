<?php
	if($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == 'localhost:8080' || $_SERVER['HTTP_HOST'] == 'pc-11' || $_SERVER['HTTP_HOST'] == '192.168.0.129'){
	    $Protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']!=='off' || $_SERVER['SERVER_PORT']==443) ? "https://" : "http://";
		$SITEURL = $Protocol.$_SERVER['HTTP_HOST']."/torrence/";
	    $ADMINURL = $Protocol.$_SERVER['HTTP_HOST']."/torrence/apanel/";

	    $SITE_ABSOLUTE_PATH = $_SERVER['DOCUMENT_ROOT'].'/torrence/';
	}
	else 
	{
	    $Protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']!=='off' || $_SERVER['SERVER_PORT']==443) ? "https://" : "http://";
	    $SITEURL = $Protocol.$_SERVER['HTTP_HOST']."/works/tax_payers_bureau_customer_portal/";
	    $ADMINURL = $Protocol.$_SERVER['HTTP_HOST']."/works/tax_payers_bureau_customer_portal/apanel/";

	    $SITE_ABSOLUTE_PATH = $_SERVER['DOCUMENT_ROOT'].'/works/tax_payers_bureau_customer_portal/';
	}       
		
	define('SITEURL', $SITEURL);
	define('ADMINURL', $ADMINURL);
	define('SITE_ABSOLUTE_PATH', $SITE_ABSOLUTE_PATH);
	define('CLIENTURL', SITEURL.'client/');
	define('SITENAME','TAX PAYERS BUREAU CUSTOMER PORTAL');
	//define('SITETITLE','TAX PAYERS BUREAU');
	define('SITETITLE','Tax Payers Bureau');
	define('CLIENT_HEADING', "Welcome to Tax Payers Bureau's Customer Portal");
	//define('ADMINTITLE','TAX PAYERS BUREAU Apanel');
	//define('CURR','&dollar;');				

	// define("SITEMAIL", "info@finitycodes.com");
	// define("SITEPHONE", "(123) 456-7890");
	define("SESS_PRE", "TPB");
	//define("CUR", "$");
	//define("ISMAIL", true);

	define("API_URL", "https://api.tpbmobile.com/v1/api/");

	//define("DOCS","upload/docs/");

?>