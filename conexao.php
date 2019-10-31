	<?php
	session_start();
	$myPDO = pg_connect("host=localhost dbname=Acidentes user=postgres password=rohde1392")
	or die('Could not connect: ' . pg_last_error());
	$encoding = pg_client_encoding($myPDO);
	//"host=pcdev.pt dbname=admin_alexf user=admin_alex password=5t24*uVj"
	?>
