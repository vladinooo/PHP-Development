<?php require_once("includes/session.php");?>
<?php confirm_login(); ?>
<?php
	// this page is included by new_page.php and edit_page.php
	if (!isset($new_page)) {
		$new_page = false;
	}
?>
	<p>Page name: <input type="text" name="menu_name"
	value="<?php echo $selected_page['menu_name']; ?>" id="menu_name" />
	</p>
	
	<p>Position:
		<select name="position">
		<?php
			if (!$new_page) {
				// edit existing page
				$page_set = get_all_pages_under_subject($selected_page['id']);
				$page_count = mysql_num_rows($page_set);
			}
			else {
				// add new page
				$page_set = get_all_pages_under_subject($selected_subject['id']);
				$page_count = mysql_num_rows($page_set) + 1;
			}
			
			// output number of pages
			for($count = 1; $count <= $page_count +1; $count++) {
				echo "<option value=\"$count\"";
				if ($selected_page['position'] == $count) {
					echo " selected";
				}
				echo ">{$count}</option>";
			}
		?>
		</select>
	</p>
	<p>Visible: 
		<input type="radio" name="visible" value="yes"
		<?php if ($selected_page['visible'] == "yes") { echo " checked"; } ?> /> Yes
		&nbsp;
		<input type="radio" name="visible" value="no"
		<?php if ($selected_page['visible'] == "no") { echo " checked"; } ?> /> No
	</p>
	<p>Content:
		<br />
		<textarea name="content" rows="20" cols="80"><?php echo $selected_page['content']; ?></textarea>
	</p>
