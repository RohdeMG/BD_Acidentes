	<?php
	session_start();
	$myPDO = pg_connect("host=localhost options=--client_encoding=UTF8 dbname=Dados_Civil user=postgres password=rohde1392")
	or die('Could not connect: ' . pg_last_error());
	$encoding = pg_client_encoding($myPDO);
	?>
