<?php require_once("includes/db_connection.php");?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/session.php");?>
<?php confirm_login(); ?>
<?php find_selected_page();  ?>
<?php include("includes/header.php"); ?>
<table id="structure">
	<tr>
		<td id="navigation">
			<?php echo navigation($selected_subject, $selected_page); ?>
			<br />
			<a href="new_subject.php">+ Add new subject</a>
			<br /><br />
			<a href="staff.php" class="italic_link">Return to Menu</a>
		</td>
		
		<td id="page">
			<?php if (!is_null($selected_subject)) { ?>
					<h2><?php echo $selected_subject['menu_name']; ?></h2>
			<?php } elseif (!is_null($selected_page)) { ?>
					<h2><?php echo $selected_page['menu_name']; ?></h2>
					
					<div class="page-content">
						<?php echo $selected_page['content']; ?>
					</div>
					<br />
					<a href="edit_page.php?page=<?php echo urlencode($selected_page['id']); ?>">Edit page</a>
					
			<?php } else { ?>
					<h2>Select a subject or page to edit</h2>
			<?php } ?>
		</td>
	</tr>
</table>
<?php include("includes/footer.php"); ?>