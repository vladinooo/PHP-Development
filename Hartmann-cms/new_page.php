<?php require_once("includes/db_connection.php");?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/session.php");?>
<?php confirm_login(); ?>
<?php 
	// make sure the value that comes with url is always integer
	if (intval($_GET['subject'] == 0)) {
		redirect_to("content.php");
	}
	
	include("includes/form_functions.php");
		
	// Form validation (only if the form submitted by POST
	// with int value appened to url e.g. ?subject=1)
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
			$subject_id = mysql_string_prep($_GET['subject']);
			$menu_name = mysql_string_prep($_POST['menu_name']);
			$position = mysql_string_prep($_POST['position']);
			$visible = mysql_string_prep($_POST['visible']);
			$content = mysql_string_prep($_POST['content']);
			
			// insert into db
			$query = "INSERT INTO pages
			  		  (subject_id, menu_name, position, visible, content) VALUES
					  ({$subject_id}, '{$menu_name}', {$position}, '{$visible}', '{$content}')";
			$result = mysql_query($query);
			if ($result) {
				// Success
				// get the last id inserted into db over current db connection
				$new_page_id = mysql_insert_id();
				redirect_to("content.php?page={$new_page_id}");
			} else {
				// Failure
				$failure_message = "The page creation failed!";
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
			<a href="new_subject.php">+ Add new subject</a>
		</td>
		
		<td id="page">
			<h2>Add New Page</h2>
			<?php 
				// Output list of errors
				global $messages, $total_errors;
				display_messages($messages, $total_errors);
			?>
			<form action="new_page.php?subject=<?php echo $selected_subject['id']; ?>" method="POST">
			
				<?php $new_page = true; ?>
				<?php include("page_form.php"); ?>
	
				<input type="submit" value="Create Page" name="submit" />
			</form>
			<br />
			
			<a href="content.php">Cancel</a>
			
		</td>
		
	</tr>
</table>
<?php include("includes/footer.php"); ?>