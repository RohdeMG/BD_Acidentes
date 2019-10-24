	<?php
	session_start();
	$myPDO = pg_connect("host=localhost dbname=Dados_Civil user=postgres password=rohde1392")
	or die('Could not connect: ' . pg_last_error());
	?>
