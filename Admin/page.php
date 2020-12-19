<?php 

	/*
		Categories => [ Manange | Edit | Update | Add | Insert | Delete | Stats ]

		Condition ? True : False ;
	*/

 $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;



 //If The Page is main Page

 if ($do == 'Manage')
 {
 	echo 'Welcome You are in MANAGE Category Page';
 	echo '<a href = "?do=Insert"> Add New Category + </a>';
 }
 elseif ($do == 'Add')
 {
 	echo 'Welcome You are in ADD Category Page';
 }
 elseif ($do == 'Edit')
 {
 	echo 'Welcome You are in EDIT Category Page';
 }
 else
{
	echo 'Error There\'s No Page With This Name ';
}