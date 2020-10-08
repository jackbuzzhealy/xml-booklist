<?php
	//ends login session and redirects user to home
	session_start();
	session_destroy();
	header("location: index.php");
?>