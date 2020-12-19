<?php 
	
	session_start();	// Start The Session
	
	session_unset();   // Unset the Data

	session_destroy();  // Destroy the Session

	header('Location: index.php');

	exit();
