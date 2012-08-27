<?php require_once("includes/functions.php"); ?>
<?php 
		
	// Four steps to closing a session i.e. logging out
	
	// 1. Find the session
	session_start();
	
	// 2. Unset all the session variables
	$_SESSION = Array();
	
	// 3. Destroy the session cookie on user's browser
	if(isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time()-1000, '/');
	}
	
	// 4. Destroy the session
	session_destroy();
	redirect_to("admin_login.php?logout=1");
?>