<?php
	header('Content-Type: text/plain');
	require "includes/config.inc.php";	
	echo $config['version'];
?>