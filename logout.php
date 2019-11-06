		<?php
		session_start();
		session_destroy();
		session_unset();
		// Redirect to the login page:
		header('Location: index.php');
		?>