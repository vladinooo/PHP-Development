		</div>
		<div id="footer">Copyright <?php date_default_timezone_set('Europe/London'); echo date('Y'); ?>, Vlad Hartmann</div>
	</body>
</html>
<?php 
	// Close connection
	if (isset($connection)) {
		mysql_close($connection);
	}
?>