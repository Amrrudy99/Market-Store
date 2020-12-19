<?php
	
	// Error Reporting

	ini_set('display_errors','On');
	error_reporting(E_ALL);
     
 	include 'admin/Connect.php';

 	$sessionUser = '';

 	if (isset($_SESSION['user'])) {

 		$sessionUser = $_SESSION['user'];
 	}

 	//Routs   //More Dynamic

	$tpl 	= 'Include/Templates/';      //Template Directory
	$lang 	= 'Include/Languages/' ;    //Language Directory
	$fun    = 'Include/Functions/';	   //Function Directory
	$css 	= 'Layout/CSS/';		  //CSS Directory
    $js  	= 'Layout/JS/';		     //JS Directory
    

    // Include The Important Files

    include $fun . 'functions.php';
    include $lang .	'English.php';
    include $tpl  . 'Header.php' ; 




   