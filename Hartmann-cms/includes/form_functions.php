<?php 
	
	// check required fields
	function check_required_fields($required_fields_array) {
		$field_errors = Array();
		foreach ($required_fields_array as $fieldname) {
			if (!isset($_POST[$fieldname]) || empty($_POST[$fieldname])) {
				$field_errors[] = $fieldname;
			}
		}
		return $field_errors;
	}
	
	// check max field length
	function check_max_field_length($fields_array) {
		$field_errors = Array();
		foreach ($fields_array as $fieldname => $maxlength) {
			if (strlen(trim(mysql_string_prep($_POST[$fieldname]))) > $maxlength) {
				$field_errors[] = $fieldname;
			}
		}
		return $field_errors;
	}
	
	// display messages and errors
	function display_messages($messages_array, $errors_array) {
		if (!empty($messages_array)) {
			// display success message
			if (array_key_exists('success_msg', $messages_array)) {
				echo "<p class=\"success_msg\">" . $messages_array['success_msg'] . "</p>";
			}
			// display failure message and list errors
			if (array_key_exists('failure_msg', $messages_array)) {
				echo "<p class=\"error_msg\">" . $messages_array['failure_msg'] . " Please review the following: <br />";
				foreach ($errors_array as $error) {
					echo "- " . $error . "<br />";
				}
				echo "</p>";
			}
			
		}
	}
?>