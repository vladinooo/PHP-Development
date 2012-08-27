<?php require_once("includes/functions.php"); ?>
<?php 

	session_start();
	
	// return boolean Y/N
	function logged_in() {
		return isset($_SESSION['user_id']);
	}
	
	// can be extended with else statement to provide extra
	// functionality to logged-in users
	function confirm_login() {
		if (!logged_in()) {
			redirect_to("admin_login.php");
		}
	}

?>