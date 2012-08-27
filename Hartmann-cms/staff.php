<?php require_once("includes/session.php");?>
<?php confirm_login(); ?>
<?php include("includes/header.php"); ?>
<table id="structure">
	<tr>
		<td id="navigation">
			<img src="images/login-icon.png" width="16" height="16" />
			<a href="logout.php" class="italic_link">Log out</a>
		</td>
		<td id="page">
			<h2>Staff Menu</h2>
			<p>Welcome to the staff area, <?php echo $_SESSION['username']; ?></p>
			<ul>
				<li><a href="content.php">Manage Website Content</a></li>
				<li><a href="create_user.php">Add Admin User</a></li>
				<li><a href="index.php">Public website</a></li>
			</ul>
		</td>
	</tr>
</table>
<?php include("includes/footer.php"); ?>