<?php require_once("includes/db_connection.php");?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/session.php");?>
<?php confirm_login(); ?>
<?php 
	
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
			$query = "INSERT INTO users
			  		  (username, password) VALUES
					  ('{$username}', '{$password}')";
			$result = mysql_query($query);
			if ($result) {
				// Success
				$success_message = "The user was successully created.";
				$messages['success_msg'] = $success_message;
			} else {
				// Failure
				$failure_message = "The user creation failed!";
				$failure_message .= "<br />" . mysql_error();
				$messages['failure_msg'] = $failure_message;
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

?>

<?php find_selected_page();  ?>
<?php include("includes/header.php"); ?>
<table id="structure">
	<tr>
		<td id="navigation">
			<a href="staff.php" class="italic_link">Return to Menu</a>
		</td>
		
		<td id="page">
			<h2>Create Admin User</h2>
			<?php 
				// Output list of errors
				global $messages, $total_errors;
				display_messages($messages, $total_errors);
			?>
			<form action="create_user.php" method="POST">
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
						<td align="left"><a href="staff.php">Cancel</a></td>
						<td align="right">
							<input type="submit" value="Create" name="submit" />
						</td>
					</tr>
				</table>
			</form>
			
		</td>
		
	</tr>
</table>
<?php include("includes/footer.php"); ?>