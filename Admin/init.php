<?php
     
 	include 'Connect.php';

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

    // Include Navbar On All Pages Expect The One With $NoNavbar Variable

    If (!isset($NoNavbar)) { include $tpl . 'Navbar.php' ; }


   