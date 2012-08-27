<?php

	// mysql string cleaning
	function mysql_string_prep($value) {
		$magic_quotes_active = get_magic_quotes_gpc();
		// PHP v4.3.0 or higher
		$new_enough_php = function_exists("mysql_real_escape_string");
		if ($new_enough_php) {
			// PHP v4.3.0 or higher
			// undo any magic quote effects so mysql_real_string_escape can do the work
			if ($magic_quotes_active) {
				$value = stripslashes($value);
			}
			$value = mysql_real_escape_string($value);
		}
		else {
			// PHP older than v4.3.0
			// if magic quotes not on add slashes manually
			if (!$magic_quotes_active) {
				$value = addslashes($value);
			}
		}
		return $value;
	}

	// check if retrieved results not null
	function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed: " . mysql_error());
		}
	}
	
	// get all subjects (will show as default only subjects with visible = 'yes')
	function get_all_subjects($public = true) {
		global $connection;
		$query = "SELECT * FROM subjects ";
		if ($public) {
			$query .= "WHERE visible = 'yes' ";
		}
		$query .= "ORDER BY position ASC";
		$subject_set = mysql_query($query, $connection);
		confirm_query($subject_set);
		return $subject_set;
	}
	
	// get all pages related to the subject (will show as default only pages with visible = 'yes')
	function get_all_pages_under_subject($id, $public = true) {
		global $connection;
		$query = "SELECT * FROM pages
				  WHERE subject_id = {$id} ";
		if ($public) {
			$query .= "AND visible = 'yes' ";
		}
		$query .= "ORDER BY position ASC";
		$page_set = mysql_query($query, $connection);
		confirm_query($page_set);
		return $page_set;
	}
	
	// get subject
	function get_subject_by_id($id) {
		global $connection;
		$query = "SELECT * FROM subjects
				  WHERE id = {$id}
				  LIMIT 1";
		$result_set = mysql_query($query, $connection);
		confirm_query($result_set);
		if ($row = mysql_fetch_array($result_set)) {
			return $row;
		}
		else {
			return NULL;
		}
	}
	
	// get page
	function get_page_by_id($id) {
		global $connection;
		$query = "SELECT * FROM pages
				  WHERE id = {$id}
				  LIMIT 1";
		$result_set = mysql_query($query, $connection);
		confirm_query($result_set);
		if ($row = mysql_fetch_array($result_set)) {
		return $row;
		}
		else {
			return NULL;
		}
	}
	
	
	// get default page when selecting the subject
	function get_default_page($subject_id) {
		$page_set = get_all_pages_under_subject($subject_id, $public = true);
		// get the first row from $page_set
		if ($first_page = mysql_fetch_array($page_set)) {
			return $first_page;
		} else {
			return NULL;
		}
	}
	
	
	// Capture values submitted by url
	// and uses them for navigation and page subjects
	function find_selected_page() {
		global $selected_subject;
		global $selected_page;
		if (isset($_GET['subject'])) {
			$selected_subject = get_subject_by_id($_GET['subject']);
			$selected_page = get_default_page($selected_subject['id']);
		}
		elseif (isset($_GET['page'])) {
			$selected_subject = NULL;
			$selected_page = get_page_by_id($_GET['page']);
		}
		else {
			$selected_subject = NULL;
			$selected_page = NULL;
		}
	}
	
	// build staff navigation
	function navigation($selected_subject, $selected_page, $public = false) {
		$output = "<ul class=\"subjects\">";

		// get all subjects
		$subject_set = get_all_subjects($public);
			
		// print subjects
		while ($subject = mysql_fetch_array($subject_set)) {
		
			// make link bold if selected
			$output .= "<li";
			if ($subject["id"] == $selected_subject["id"]) {
				$output .= " class=\"selected\"";
			}
			$output .= "><a href=\"edit_subject.php?subject=" . urlencode($subject["id"]) . "\">{$subject["menu_name"]}</a></li>";
		
			// get pages related to subjects
			$page_set = get_all_pages_under_subject($subject["id"], $public);
		
			// print pages
			$output .= "<ul class=\"pages\">";
			while ($page = mysql_fetch_array($page_set)) {
					
				// make link bold if selected
				$output .= "<li";
				if ($page["id"] == $selected_page["id"]) {
					$output .= " class=\"selected\"";
				}
				$output .= "><a href=\"content.php?page=" . urlencode($page["id"]) . "\">{$page["menu_name"]}</li>";
			}
			$output .= "</ul>";
		}
	
		$output .= "</ul>";
		return $output;
	}
	
	// build public navigation
	function public_navigation($selected_subject, $selected_page, $public = true) {
		$output = "<ul class=\"subjects\">";
	
		// get all subjects
		$subject_set = get_all_subjects($public);
			
		// print subjects
		while ($subject = mysql_fetch_array($subject_set)) {
	
			// make link bold if selected
			$output .= "<li";
			if ($subject["id"] == $selected_subject["id"]) {
				$output .= " class=\"selected\"";
			}
			$output .= "><a href=\"index.php?subject=" . urlencode($subject["id"]) . "\">{$subject["menu_name"]}</a></li>";
	
			// get pages related to subjects
			$page_set = get_all_pages_under_subject($subject["id"], $public);
	
			// print pages
			$output .= "<ul class=\"pages\">";
			while ($page = mysql_fetch_array($page_set)) {
					
				// make link bold if selected
				$output .= "<li";
				if ($page["id"] == $selected_page["id"]) {
					$output .= " class=\"selected\"";
				}
				$output .= "><a href=\"index.php?page=" . urlencode($page["id"]) . "\">{$page["menu_name"]}</li>";
			}
			$output .= "</ul>";
		}
	
		$output .= "</ul>";
		return $output;
	}

	// redirect function
	function redirect_to($location = NULL) {
		if ($location != NULL) {
			header("Location: {$location}");
			Exit;
		}
	}
	
?>