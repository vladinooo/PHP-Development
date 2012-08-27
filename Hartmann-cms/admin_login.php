<?php require_once("includes/session.php");?>
<?php require_once("includes/db_connection.php");?>
<?php require_once("includes/functions.php"); ?>
<?php 

	// send admin user directly to staff.php if already logged in
	if (logged_in()) {
		redirect_to("staff.php");
	}
	
	include("includes/form_functions.php");
		
	// Form validation (only if the form submitted by POST
	// with int value appened to url e.g. ?subject=1)
	if (isset($_POST['submit'])) {
		
		$messages = Array();
		// check required fields
		$required_filed_errors = Array();
		$required_fileds = Array('username', 'password');
		$required_filed_errors = check_required_fields($required_fileds);
		
		// check max length
		$max_field_length_errors = Array();
		$field_lengths = Array('username' => 20, 'password' => 20);
		$max_field_length_errors = check_max_field_length($field_lengths);
		
		$total_errors = array_merge($required_filed_errors, $max_field_length_errors);
		
		if (empty($total_errors)) {
			// clean and prepare input for mysql
			$username = mysql_string_prep($_POST['username']);
			$password = mysql_string_prep($_POST['password']);
			
			// encrypt the password
			$password = sha1($password);
			
			// insert into db
			$query = "SELECT id, username FROM users
					  WHERE username = '{$username}'
					  AND password = '{$password}'
					  LIMIT 1";
			$result = mysql_query($query);
			confirm_query($result);
			if (mysql_num_rows($result) == 1) {
				// Username and password authenticated
				$found_user = mysql_fetch_array($result);
				
				// set the session
				$_SESSION['user_id'] = $found_user['id'];
				$_SESSION['username'] = $found_user['username'];
				
				redirect_to("staff.php");
			} else {
				// Username and password combination not found in db
				$failure_message = "Username or password incorect!";
				$messages['failure_msg'] = $failure_message;
				$total_errors[] = "username";
				$total_errors[] = "password";
			}
		} else {
			// Errors in the form
			if (count($total_errors) == 1) {
				$failure_message = "There was 1 error in the form!";
				$messages['failure_msg'] = $failure_message;
			}
			else {
				$failure_message = "There were " . count($total_errors) . " errors in the form!";
				$messages['failure_msg'] = $failure_message;
			}
		}
	}
	else {
		// Form has not been submitted
		if (isset($_GET['logout']) && $_GET['logout'] == 1) {
			// Success
			$success_message = "Successfully logged out. Goodbye!";
			$messages['success_msg'] = $success_message;
		}
		$username = "";
		$password = "";
	}

?>

<?php find_selected_page();  ?>
<?php include("includes/header.php"); ?>
<table id="structure">
	<tr>
		<td id="navigation">
			<a href="index.php">Return to public site</a>
		</td>
		
		<td id="page">
			<h2>Admin Login</h2>
			<?php 
				// Output list of errors
				global $messages, $total_errors;
				display_messages($messages, $total_errors);
			?>
			<form action="admin_login.php" method="POST">
				<table>
					<tr>
						<td><p>Username:</p></td>
						<td><input type="text" name="username" /></td>
					</tr>
					<tr>
						<td><p>Password:</p></td>
						<td><input type="password" name="password" /></td>
					</tr>
					<tr>
						<td><br /></td>
					</tr>
					<tr>
						<td align="right" colspan="2">
							<input type="submit" value="Log in" name="submit" />
						</td>
					</tr>
				</table>
			</form>
		</td>
		
	</tr>
</table>
<?php include("includes/footer.php"); ?>