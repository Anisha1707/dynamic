<?php
class Functions 
{	
	public function checkLogin($url=""){
		$time = $_SERVER['REQUEST_TIME'];
		if( $time > $_SESSION[SESS_PRE.'_EXPIRED'] || $time > $_SESSION[SESS_PRE.'_REFRESH_EXPIRED']  )
		{
			unset($_SESSION[SESS_PRE.'_USER_TOKEN']);
			unset($_SESSION[SESS_PRE.'_REFRESH_TOKEN']);
			unset($_SESSION[SESS_PRE.'_EXPIRED']);
			unset($_SESSION[SESS_PRE.'_REFRESH_EXPIRED']);

			$_SESSION['MSG'] = 'Session_Expired';
			$this->location(SITEURL);
		}
	}

	public function setSessionExpiration()
	{
		$time = $_SERVER['REQUEST_TIME'] + 300;  /* for 1 hours = 3600 seconds */
		$_SESSION[SESS_PRE.'_EXPIRED'] = $time;
		$time_refresh = $_SERVER['REQUEST_TIME'] + 3600;  /* for 1 hours = 3600 seconds */
		$_SESSION[SESS_PRE.'_REFRESH_EXPIRED'] = $time_refresh;
	}

	public function unsetSession()
	{
		unset($_SESSION[SESS_PRE.'_USER_TOKEN']);
		unset($_SESSION[SESS_PRE.'_REFRESH_TOKEN']);
		unset($_SESSION[SESS_PRE.'_TAX_APPLICATION_ID']);
		unset($_SESSION[SESS_PRE.'_SPOUSE_ID']);

		unset($_SESSION[SESS_PRE.'_EXPIRED']);
		unset($_SESSION[SESS_PRE.'_REFRESH_EXPIRED']);

		unset($_SESSION['franchiseCode']);
		unset($_SESSION['preparerCode']);
	}

	public function location($redirectPageName=null) // Location
	{
		if($redirectPageName==null){
			header("Location:".SITEURL);
			exit;
		}else{
			header("Location:".$redirectPageName);
			exit;
		}
	}

	public function date($date, $format="m/d/Y H:i A"){
		return date_format(date_create($date),$format);
	}
}	
?>