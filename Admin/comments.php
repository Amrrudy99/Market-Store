<?php

	/*
	==================================================
	==	Manage Comments Page 
	==	You Can Edit | Delete | Approve  Comments From Here
	==================================================
	*/

	session_start();

	$PageTitle = 'Comments';

	if (isset($_SESSION['Username'])) {

	  include 'init.php';

	  $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;

	  // Start Manage Page

	  if ($do == 'Manage') { // Manage Page 


	  		// Select All Comments

	  		$stmt = $con->prepare("SELECT 
	  									Comments.*, items.Name AS Item_Name , users.Username AS Member
	  								FROM
	  									comments
	  								INNER JOIN 
	  									items
	  								ON
	  									items.Item_ID = comments.item_id
	  								INNER JOIN
	  									users
	  								ON
	  									users.UserID = comments.user_id
	  								ORDER BY
	  									 c_id DESC");
	  		$stmt->execute();
	  		$comments = $stmt->fetchAll();

	  		if(! empty($comments)){
	  	?>

	  	<h1 class="text-center">Manage Comments</h1>
		  	<div class = "container"> 
		  		<div class="table-responsive">
		  			<table class="main-table text-center table table-bordered">
		  				<tr>
		  					<td>#ID</td>
		  					<td>Comment</td>
		  					<td>Item Name</td>
		  					<td>User Name</td>
		  					<td>Added Date</td>
		  					<td>Control</td>
		  				</tr>

		  				<?php

		  					foreach ($comments as $comment) {
			  					echo "<tr>";
			  						echo "<td>" . $comment['c_id'] . "</td>";
			  						echo "<td>" . $comment['comment'] . "</td>";
			  						echo "<td>" . $comment['Item_Name'] . "</td>";
			  						echo "<td>" . $comment['Member'] . "</td>";
			  						echo "<td>" . $comment['comment_date'] . "</td>";
			  					echo "<td>
			  							    <a href='comments.php?do=Edit&comid=" . $comment['c_id']. "' class='btn btn-success'><i class='fas fa-edit'></i> Edit</a>
			  								<a href='comments.php?do=Delete&comid=" . $comment['c_id']. "' class='btn btn-danger confirm'><i class='fas fa-trash'></i></i> Delete</a>";

			  								if($comment['status'] == 0){
			  									echo "<a href='comments.php?do=Approve&comid=" . $comment['c_id']. "' 
			  									class='btn btn-info activate '>
			  									<i class='fas fa-check'></i></i> Approve</a>";

			  								}

			  							echo  "</td>";
			  					echo "</tr>";
		  					}


		  				?>

		  				<tr>
		  					
		  			</table>
		  		</div>
		  	</div>

		  	<?php }
		 else{

				 echo '<div class="container">';
				 	echo '<div class="nice-message">There\'s NO Comments To Show</div>';
				 echo '</div>';
			}
		 ?>

	<?php  } 
 
	  elseif ($do == 'Edit') { // Edit Page

	  	 // Check If Get Request commid is Numeric $ Get The Integer Value of It

	  	$comid = isset($_GET['comid'] ) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

	    // Selsect All Data Depend On This ID

       $stmt = $con->prepare("SELECT * FROM comments WHERE c_id = ?");

       // Execute Quer

       $stmt->execute(array($comid));

       //Fetch The Data
       $row   = $stmt->fetch();
       $count = $stmt->rowCount();


       if ($count > 0) // ID = 1 Is only True
       {  ?>	

		  	<h1 class="text-center">Edit Comments</h1>
		  	<div class = "container"> 
		  		<form class="form-horizontal" action="?do=Update" method="POST">
		  			<input type="hidden" name="comid" value="<?php echo $comid; ?>">
		  			<!-- Start Comment Field -->
			  		<div class="form-group form-group-lg">
			  			<label class="col-sm-2 control-label">Comment</label>
				  		<div class="col-sm-10 col-sm-6">
				  			<textarea class="form-control" name="comment"><?php echo $row['comment']; ?></textarea>
				  		</div>	
			  		</div>
			  		<!-- End Comment Field -->
			  		<!-- Start Submit Field -->
			  		<div class="form-group form-group-lg">
				  		<div class="col-sm-offset-2 col-sm-10">
				  		<input type="submit" value="Sava" class="btn btn-primary btn-lg " />	
				  		</div>	
			  		</div>
			  		<!-- End Submit Field -->
		  		</form>
		  	</div>

	 <?php 

		}

		// If There's No Such ID Show Error Message
		else
		{	
			echo "<div class='container'>";

			$theMsg = '<div class="alert alert-danger">THERES NO SUCH ID</div>';

			redirectHome($theMsg);

			echo "</div>";
		}	

}
    elseif ($do == 'Update') {	// Update Page

			echo "<h1 class='text-center'>Update Comment</h1>";
			echo "<div class='container'>";

			if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				// Get Variables From The Form

				$comid 	    = $_POST['comid'];
				$comment 	= $_POST['comment'];


				// Update the Database With This Info

				 $stmt = $con->prepare("UPDATE comments SET comment = ? WHERE c_id = ?");

			     $stmt->execute(array($comment, $comid));

				 		// Echo Success Message

				 $theMsg = "<div class='alert alert-success text-center'>" . $stmt->rowCount() . ' Record Update </div>';

					 redirectHome($theMsg, 'back');

			}	

			else
			{
				$theMsg ='<div class="alert alert-danger">Sorry You Can Not Browse This Page Directly</div>';

				redirectHome($theMsg);

			}

			echo '</div>';
    }

	elseif ($do == 'Delete') // Delete Page
	{
			echo "<h1 class='text-center'>Delete Comment</h1>";
			echo "<div class='container'>";

		// Check If Get Request comid is Numeric $ Get The Integer Value of It

	  	$comid = isset($_GET['comid'] ) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

	    // Selsect All Data Depend On This ID

       $check = checkItem('c_id', 'comments' , $comid);
 
       if ($check > 0) // ID = 1 Is only True
       {  
       		$stmt = $con->prepare("DELETE FROM comments WHERE c_id = :zid");

			$stmt->bindParam(":zid", $comid);

			$stmt->execute();

			$theMsg = "<div class='alert text-center alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';

			redirectHome($theMsg , 'back');
       }

       else
       {
       	 	$theMsg = '<div class="alert alert-danger">This ID Is Not Exist</div>';

       	 	redirectHome($theMsg);
       }

       echo '</div>';

	} elseif ($do == 'Approve') {
		
			echo "<h1 class='text-center'>Approve Comment</h1>";
			echo "<div class='container'>";

		// Check If Get Request comid is Numeric $ Get The Integer Value of It

	  	$comid = isset($_GET['comid'] ) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

	    // Selsect All Data Depend On This ID

       $check = checkItem('c_id', 'comments' , $comid);
 
       if ($check > 0) // ID = 1 Is only True
       {  
       		$stmt = $con->prepare("UPDATE comments SET status = 1 WHERE c_id = ?");

			$stmt->execute(array($comid));

			$theMsg = "<div class='alert text-center alert-success'>" . $stmt->rowCount() . ' Record Approved</div>';

			redirectHome($theMsg , 'back');
       }

       else
       {
       	 	$theMsg = '<div class="alert alert-danger">This ID Is Not Exist</div>';

       	 	redirectHome($theMsg);
       }

       echo '</div>';

	}

	  include $tpl . '/Footer.php';

	} else {
		
		header('Location: Index.php');
		exit();

	}