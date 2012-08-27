<?php require_once("includes/db_connection.php");?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/session.php");?>
<?php confirm_login(); ?>

<?php 
	// make sure the value that comes with url is always integer
	if (intval($_GET['page']) == 0) {
		redirect_to("content.php");
	}
	
	include_once("includes/form_functions.php");
		
	// Form validation (only if the form submitted by POST
	// with int value appended to url e.g. ?page=1)
	if (isset($_POST['submit'])) {
		
		$messages = Array();
		// check required fields
		$required_filed_errors = Array();
		$required_fileds = Array('menu_name', 'position', 'visible');
		$required_filed_errors = check_required_fields($required_fileds);
		
		// check max length
		$max_field_length_errors = Array();
		$field_lengths = Array('menu_name' => 30);
		$max_field_length_errors = check_max_field_length($field_lengths);
		
		$total_errors = array_merge($required_filed_errors, $max_field_length_errors);
		
		if (empty($total_errors)) {
			// clean and prepare input for mysql
			$id = mysql_string_prep($_GET['page']);
			$menu_name = mysql_string_prep($_POST['menu_name']);
			$position = mysql_string_prep($_POST['position']);
			$visible = mysql_string_prep($_POST['visible']);
			$content = mysql_string_prep($_POST['content']);
			
			$query = "UPDATE pages SET
					  menu_name = '{$menu_name}',
					  position = {$position},
					  visible = '{$visible}',
					  content = '{$content}'
					  WHERE id = {$id}";
			$result = mysql_query($query);
			if ($result) {
				// Success
				$success_message = "The page was successully updated.";
				$messages['success_msg'] = $success_message;
			} else {
				// Failure
				$failure_message = "The page update failed!";
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
			<?php echo navigation($selected_subject, $selected_page); ?>
			<br />
			<a href="new_subject.php">+ Add a new subject</a>
		</td>
		
		<td id="page">
			<h2>Edit Page: <?php echo $selected_page['menu_name']; ?></h2>
			<?php 
				// Output list of errors
				global $messages, $total_errors;
				display_messages($messages, $total_errors);
			?>
			<form action="edit_page.php?page=<?php echo $selected_page['id']; ?>" method="POST">
			
				<?php include("page_form.php"); ?>
				<input type="submit" name="submit" value="Update Page" />
				
				&nbsp;&nbsp;
				
				<a href="delete_page.php?page=<?php echo urlencode($selected_page['id']); ?>"
				onclick="return confirm('Are you sure?')">Delete page</a>
			</form>
			<br />
			
			<a href="content.php?page=<?php echo $selected_page['id']; ?>">Cancel</a>
			<br />
			
		</td>
		
	</tr>
</table>
<?php include("includes/footer.php"); ?>