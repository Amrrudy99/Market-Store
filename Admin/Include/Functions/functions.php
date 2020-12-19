<?php

	/*
	**	Get All Function v2.0
	**	Function To Get All Records From Any Database Table 
	*/

	function getAllFrom($field, $table, $where = NULL, $and = NULL, $orderfield, $ordering = "DESC"){

		global $con;

		$getAll = $con->prepare("SELECT $field FROM $table $where $and ORDER BY $orderfield $ordering");

		$getAll->execute();

		$all = $getAll->fetchAll();

		return $all;

	}


 	/*
 	** Title Function V1.0
 	** That Echo The Page Title In Case The Page
 	** Has The Variable $PageTitle And Echo Defult Title For Other Pages 
 	*/

 	Function GetTitle() 
 	{
 		global $PageTitle;
 		if (isset($PageTitle)) { echo $PageTitle; }
 		else { echo 'Defult'; }
 	}

 	/*
 	** Home Redirect function v2.0
 	** This Function Accept Parameters 
 	** $theMsg = Echo The Message [	Error | Success | Warning ]
 	** $url = The Link You Want To Redirect TO 
 	** $seconds  = Seconds Before Redirecting 
 	*/	


 	function redirectHome($theMsg , $url=null, $seconds = 3) {

 		if ($url === null)
 		{
 			$url  = 'index.php';	
 			$link = 'HomePage';
 		}
 		else 
 		{

 			if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '' )
 			{
 				$url  = $_SERVER['HTTP_REFERER'];
 				$link =	'Previous Page';
 			}
 			else
 			{
 				$url  = 'index.php';
 				$link = 'HomePage';
 			}
 			
 		}

 		echo $theMsg;

 		echo "<div class='alert alert alert-info'>You Will Redirected To $link  After $seconds Seconds.</div>";

 		header("refresh:$seconds;url=$url");

 		exit();




 	}



	 /*
	 ** Check Items Function v1.0
	 ** Function To Check Item In DataBase [ Function Accept Parameters ]
	 **	$select = The Item To Select [ Example: user, Item, Category ]
	 **	$form 	= The Table To Select From [ Example: users, Items, Categories ]
	 ** $value  = The Value Of Select [ Example: Amr, Box, Electronics ]
	 */	

	 function checkItem($select, $from, $value){

	 	global $con;

	 	$statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");

	 	$statement->execute(array($value));

	 	$count = $statement->rowCount();

	 	return $count;
	 }

	 /*
	 ** Count Number Of Items Function v1.0 
	 ** Function To Count Number Of Items Rows
	 **	$item = The Item To Count
	 **	$table = The Table To Choose From 
	 */

	 function countItems($item,$table){

	 	global $con;

	 	$stmt2 = $con->prepare("SELECT COUNT($item) FROM $table");

	  	$stmt2->execute();

	  	return $stmt2->fetchColumn();
	 }

	/*
	**	Get Latest Records Function v1.0
	**	Function To Get Latest Items From Database [User,Items,Comments]
	**	$select = Field To Select 
	** 	$table = The Table To Choose From
	**	$order = The Desc Ordering
	**	$limit = Number Of Record To Get  
	*/

	function getlatest($select, $table , $order ,$limit = 5 ){

		global $con;

		$getstmt = $con->prepare("SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit");

		$getstmt->execute();

		$rows = $getstmt->fetchAll();

		return $rows;

	}