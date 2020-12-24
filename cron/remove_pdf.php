<?php
	/*
	Execute this file once a day to remove temporary generated PDF files from the server.
	It will remove all the files created prior half an hour (1800 seconds).
	*/

	//$dir = "D:/xampp/htdocs/torrence/";	// path local
	//$dir = "/home/finityco/public_html/works/tax_payers_bureau_customer_portal/";	// path stagging
	$dir = "/home/tax_payers_bureau_customer_portal/public_html/";	// path live

	include($dir . 'connect.php');

  	function delete_older_than($dir, $max_age) {
	    $list = array();  
	    $limit = time() - $max_age;
	    $dir = realpath($dir);
	    
	    echo $dir . '<br />';
	    if (!is_dir($dir)) {
	      echo 'dir not found';
	      return;
	    }
	    
	    $dh = opendir($dir);
	    if ($dh === false) {
	      return;
	    }
	    
	    while (($file = readdir($dh)) !== false) {
	      $file = $dir . '/' . $file;
	      if (!is_file($file)) {
	        continue;
	      }
	      
	      if (filemtime($file) < $limit) {
	        $list[] = $file;
	        unlink($file);
	      } 
	    }
	    closedir($dh);
	    return $list;
  	}

	//$date = date('Y-m-d h:i:s', strtotime('-30 minutes'));
	//echo $date;
	$deleted = delete_older_than($dir.'upload/PDF', 1800);
  	$txt = "Deleted " . count($deleted) . " Old PDF(s):<br />" . implode("<br />", $deleted);

	$deleted = delete_older_than($dir.'upload/initials', 1800);
  	$txt .= "<br /><br />Deleted " . count($deleted) . " Old Initial(s):<br />" . implode("<br />", $deleted);

	$deleted = delete_older_than($dir.'upload/signature', 1800);
  	$txt .= "<br /><br />Deleted " . count($deleted) . " Old Signature(s):<br />" . implode("<br />", $deleted);

  	echo $txt . '<br /><br />';
?>