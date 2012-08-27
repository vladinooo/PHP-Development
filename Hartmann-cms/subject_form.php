<?php require_once("includes/session.php");?>
<?php confirm_login(); ?>
<?php
	// this page is included by new_subject.php and edit_subject.php
	
	// if the $new_subject is not set edit the existing one
	if (!isset($new_subject)) {
		$new_subject = false;
	}
?>
	<p>Subject name: <input type="text" name="menu_name"
	value="<?php echo $selected_subject['menu_name']; ?>" id="menu_name" />
	</p>
	
	<p>Position:
		<select name="position">
		<?php
			if (!$new_subject) {
				// edit existing subject
				$subject_set = get_all_subjects();
				$subject_count = mysql_num_rows($subject_set);
			}
			else {
				// add new subject
				$subject_set = get_all_subjects();
				$subject_count = mysql_num_rows($subject_set) + 1;
			}
			
			// output number of subjects
			for($count = 1; $count <= $subject_count +1; $count++) {
			 	echo "<option value=\"$count\"";
			 		if ($selected_subject['position'] == $count) {
			 			echo " selected";
			 		}
			 	echo ">{$count}</option>";
			 }
		?>
		</select>
	</p>
		
	<p>Visible: 
		<input type="radio" name="visible" value="yes"
		<?php if ($selected_subject['visible'] == "yes") { echo " checked"; } ?> /> Yes
		&nbsp;
		<input type="radio" name="visible" value="no"
		<?php if ($selected_subject['visible'] == "no") { echo " checked"; } ?> /> No
	</p>
	
