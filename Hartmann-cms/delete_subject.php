<?php require_once("includes/db_connection.php");?>
<?php require_once("includes/functions.php"); ?>
<?php 
	// make sure the value that comes with url is always integer
	if (intval($_GET['subject'] == 0)) {
		redirect_to("content.php");
	}
	
	// clean and prepare input for mysql
	$id = mysql_string_prep($_GET['subject']);
	
	// check if subject exists in db
	if ($subject = get_subject_by_id($id)) {
		$query = "DELETE FROM subjects
				  WHERE id = {$id}";
		$results = mysql_query($query, $connection);
		if (mysql_affected_rows() == 1) {
			// Success
			redirect_to("content.php");
		} else {
			// Failure
			echo "Subject deletion failed!";
			echo "<br />" . mysql_error();
			echo "<a href=\"content.php\">Return to main page</a>";
		}
	} else {
		// subject doesn't exist in db
		redirect_to("content.php");
	}
?>
<?php 
	// close db connection
	mysql_close($connection);
?>