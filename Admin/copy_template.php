<?php
	
	
	/*
	**
	** Items Page
	**
	*/

	ob_start();

	session_start();

	$pageTitle = 'Items';

	if (isset($_SESSION['Username']))
	{
		include 'init.php';	

		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

		if ($do == 'Manage'){

			echo 'Welcome Item';

		}

		elseif ($do == 'Add') {
			# code...
		}

		elseif ($do == 'Insert') {
			# code...
		}
		
		elseif ($do == 'Edit') {
			# code...
		}
		
		elseif ($do == 'Update') {
			# code...
		}
		
		elseif ($do == 'Delete') {
			# code...
		}
		
		elseif ($do == 'Approve') {
			# code...
		}

		include $tpl . 'Footer.php';

	}
		else
		{
			header('Location: index.php');

			exit();
		}

		ob_end_flush(); // Release The Output

?>