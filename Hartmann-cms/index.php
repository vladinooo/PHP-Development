<?php require_once("includes/session.php");?>
<?php require_once("includes/db_connection.php");?>
<?php require_once("includes/functions.php"); ?>
<?php find_selected_page();  ?>
<?php include("includes/header.php"); ?>
<table id="structure">
	<tr>
		<td id="navigation">
			<?php echo public_navigation($selected_subject, $selected_page); ?>
			<br />
			<?php
				// if logged in replace login link
				if (logged_in()) {
					echo "<a href=\"staff.php\" class=\"italic_link\">Return to Menu</a>";
				}
				else {
					echo "<img src=\"images/login-icon.png\" width=\"16\" height=\"16\" />";
					echo "<a href=\"admin_login.php\" class=\"italic_link\">Log in</a>";
				}
			?>
			<br /><br />
			<p style="font-size: 10px; font-style: italic;">un: admin <br /> pw: admin1</p>
			
		</td>
		
		<td id="page">
			<?php if ($selected_page) { ?>
				<h2><?php echo $selected_page['menu_name']; ?></h2>
				<div class="page-content">
					<?php echo htmlentities($selected_page['content']); ?>
				</div>
			<?php }
				  else { ?>
				 		<h2>Welcome</h2>
				 <?php } ?>
		</td>
		
	</tr>
</table>
<?php include("includes/footer.php"); ?>