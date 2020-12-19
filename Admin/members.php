<?php

	/*
	==================================================
	==	Manage Members Page 
	==	You Can Add | Edit | Delete Members From Here
	==================================================
	*/

	session_start();

	$PageTitle = 'Members';

	if (isset($_SESSION['Username'])) {

	  include 'init.php';

	  $do = isset($_GET['do']) ? $_GET['do'] : 'Manage' ;

	  // Start Manage Page

	  if ($do == 'Manage') { // Manage Page 

	  		$query = '';

	  		if (isset($_GET['page']) && $_GET['page'] == 'Pending'){

	  			$query = 'AND RegStatus = 0';
	  		}

	  		// Select All Users Except Admin

	  		$stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query ORDER BY UserID DESC");
	  		$stmt->execute();
	  		$rows = $stmt->fetchAll();

	  		if(! empty($rows)){

	  	?>

	  	<h1 class="text-center">Manage Member</h1>
		  	<div class = "container"> 
		  		<div class="table-responsive">
		  			<table class="main-table manage-members text-center table table-bordered">
		  				<tr>
		  					<td>#ID</td>
		  					<td>Avatar</td>
		  					<td>Username</td>
		  					<td>Email</td>
		  					<td>Full Name</td>
		  					<td>Registerd Date</td>
		  					<td>Control</td>
		  				</tr>

		  				<?php

		  					foreach ($rows as $row) {
			  					echo "<tr>";
			  						echo "<td>" . $row['UserID'] . "</td>";
			  						echo "<td>";
			  						if (empty($row['avatar'])) {
			  							echo 'No Image';
			  						}
			  						else {
			  							echo "<img src='uploads/avatar/" . $row['avatar'] . "' alt='' />";
			  						}			  							
			  						echo  "</td>";
			  						echo "<td>" . $row['Username'] . "</td>";
			  						echo "<td>" . $row['Email'] . "</td>";
			  						echo "<td>" . $row['FullName'] . "</td>";
			  						echo "<td>" . $row['Date'] . "</td>";
			  					echo "<td>
			  							    <a href='members.php?do=Edit&ID=" . $row['UserID']. "' class='btn btn-success'><i class='fas fa-edit'></i> Edit</a>
			  								<a href='members.php?do=Delete&ID=" . $row['UserID']. "' class='btn btn-danger confirm'><i class='fas fa-trash'></i></i> Delete</a>";

			  								if($row['RegStatus'] == 0){
			  									echo "<a href='members.php?do=Activate&ID=" . $row['UserID']. "' 
			  									class='btn btn-info activate '>
			  									<i class='fas fa-check'></i></i> Activate</a>";

			  								}

			  							echo  "</td>";
			  					echo "</tr>";
		  					}


		  				?>

		  				<tr>
		  					
		  			</table>
		  		</div>
		  	 	<a href = "members.php?do=Add" class="btn btn-primary"><i class="fa fa-plus"></i> New Member</a>
		  	</div>

		<?php }

			else{

				 echo '<div class="container">';
				 	echo '<div class="nice-message">There\'s NO Members To Show</div>';
				 	echo '<a href = "members.php?do=Add" class="btn btn-primary">
				 			<i class="fa fa-plus"></i> New Member
				 		 </a>';
				 echo '</div>';
			}
		 ?>
	

	<?php  } 
	  
	  elseif ($do == 'Add'){	// Add Members Page	?> 

	  	<h1 class="text-center">Add New Member</h1>
		  	<div class = "container"> 
		  		<form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
		  			<!-- Start Username Field -->
			  		<div class="form-group form-group-lg">
			  			<label class="col-sm-2 control-label">Username</label>
				  		<div class="col-sm-10 col-sm-6">
				  		<input type="text" name="username" class="form-control" autocomplete="off" required="required" placeholder="Username To Login" />	
				  		</div>	
			  		</div>
			  		<!-- End Username Field -->
			  		<!-- Start Password Field -->
			  		<div class="form-group form-group-lg">
			  			<label class="col-sm-2 control-label">Password</label>
				  		<div class="col-sm-10 col-sm-6">
				  		<input type="password" name="password" class="password form-control" autocomplete="new-passeord" required="required" placeholder="Password Must Be Hard & Complex " />	
				  		<i class="show-pass fas fa-eye"></i>	
				  		</div>	
			  		</div>
			  		<!-- End Password Field -->
			  		<!-- Start Email Field -->
			  		<div class="form-group form-group-lg">
			  			<label class="col-sm-2 control-label">Email</label>
				  		<div class="col-sm-10 col-sm-6">
				  		<input type="email" name="email" class="form-control" required="required" placeholder="Email Must Be Valid" />	
				  		</div>	
			  		</div>
			  		<!-- End Email Field -->
			  		<!-- Start Full Name Field -->
			  		<div class="form-group form-group-lg">
			  			<label class="col-sm-2 control-label">Full Name</label>
				  		<div class="col-sm-10 col-sm-6">
				  		<input type="text" name="full" class="form-control" required="required" placeholder="Full Name Appear In Your Profile Page" />	
				  		</div>	
			  		</div>
			  		<!-- End Full Name Field -->
			  		<!-- Start Avatar Field -->
			  		<div class="form-group form-group-lg">
			  			<label class="col-sm-2 control-label">User Avatar</label>
				  		<div class="col-sm-10 col-sm-6">
				  		<input type="file" name="avatar" class="form-control" required="required" />	
				  		</div>	
			  		</div>
			  		<!-- End Avatar Field -->
			  		<!-- Start Submit Field -->
			  		<div class="form-group form-group-lg">
				  		<div class="col-sm-offset-2 col-sm-10">
				  		<input type="submit" value="Add Member" class="btn btn-primary btn-lg " />	
				  		</div>	
			  		</div>
			  		<!-- End Submit Field -->
		  		</form>
		  	</div>


<?php	}

		elseif($do == 'Insert')
	    {  // Insert Member Page 

			

			if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{	

				echo "<h1 class='text-center'>Update Member</h1>";
				echo "<div class='container'>";

				// Upload Variables

				$avatarName = $_FILES['avatar']['name'];
				$avatarSize = $_FILES['avatar']['size'];
				$avatarTmp = $_FILES['avatar']['tmp_name'];
				$avatarType = $_FILES['avatar']['type'];

				// List Of Allowed File Typed To Upload

				$avatarAllowedExtension = array("jpeg","jpg","png","gif");

				// Get Avatar Extension

				$avatarExtension = strtolower(end(explode('.', $avatarName)));

				// Get Variables From The Form

				$User 	= $_POST['username'];
				$Pass 	= $_POST['password'];
				$Email 	= $_POST['email'];	
				$Name 	= $_POST['full'];

				$hashPass = sha1($_POST['password']); 

				// Validate The Form

				$formErrors = array();

				if (strlen($User) <= 4 )
				{
					$formErrors[] = 'Username Less Than <strong>4 Characters</strong>';
				}

				if (strlen($User) > 20 )
				{
					$formErrors[] = 'Username More Than <strong>20 Characters</strong>';
				}

				if (empty($User))
				{
					$formErrors[] = 'Username Can Not Be <strong>Empty</strong>';
				}

				if (empty($Pass))
				{
					$formErrors[] = 'Password Can Not Be <strong>Empty</strong>';
				}

				if (empty($Name))
				{
					$formErrors[] = 'Full Name Can Not Be <strong>Empty</strong>';
				}

				if (empty($Email))
				{
					$formErrors[] = 'Email Can Not Be <strong>Empty</strong>';
				}

				if (! empty($avatarName) && ! in_array($avatarExtension, $avatarAllowedExtension)) {
					$formErrors[] = 'This Extension Is Not <strong>Allowed</strong>';
				}

				if (empty($avatarName)) {
					$formErrors[] = 'The Avatar Is <strong>Required</strong>';
				}

				if ($avatarSize > 4194304) {
					$formErrors[] = 'Avatar Can Not Be Larger Than <strong>4MB</strong>';
				}
				
				foreach ($formErrors as $Error)
				{
					echo '<div class="alert alert-danger">' . $Error . '</div>';
				}

				// Check IF There's No Error Proceed The Update Operation 

				if (empty($formErrors))
				{

					$avatar = rand(0,100000000) . '_' . $avatarName;

					move_uploaded_file($avatarTmp, "uploads\avatar\\". $avatar);

				// Check If User Exist In DataBase

					$check = checkItem("Username", "users" , $User);

					if ($check == 1)
					{

						$theMsg = '<div class="alert alert-danger">Sorry This User Is Exist</div>';

						redirectHome($theMsg,'back');

					}
					else
					{

						// Insert User Info In Data Base

							$stmt = $con->prepare("INSERT INTO
													 	users(Username,Password,Email,FullName, RegStatus, Date, avatar) 
													 	VALUES(:zuser, :zpass, :zmail, :Zname, 1 , now(), :zavatar) ");
							$stmt->execute(array(

								'zuser'   	=> $User,
								'zpass'  	=> $hashPass,
								'zmail'   	=> $Email,
								'Zname'   	=> $Name,
								'zavatar' 	=> $avatarName
							));


						 // Echo Success Message

						 $theMsg = "<div class='alert alert-success text-center'>" . $stmt->rowCount() . ' Record Inserted </div>';

						 redirectHome($theMsg, 'back');
				    }

			    }

			}	else
				{
					echo "<div class='container'>";

					$theMsg = '<div class="alert alert-danger">Sorry You Can Not Browse This Page Directly</div>';

					redirectHome($theMsg);

					echo "</div>";
				}

			echo '</div>';
			
		}
		

 
	  elseif ($do == 'Edit') { // Edit Page

	  	 // Check If Get Request userid is Numeric $ Get The Integer Value of It

	  	$userid = isset($_GET['ID'] ) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0;

	    // Selsect All Data Depend On This ID

       $stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? lIMIT 1");
       // Execute Query
       $stmt->execute(array($userid));
       //Fetch The Data
       $row   = $stmt->fetch();
       $count = $stmt->rowCount();


       if ($count > 0) // ID = 1 Is only True
       {  ?>	

		  	<h1 class="text-center">Edit Member</h1>
		  	<div class = "container"> 
		  		<form class="form-horizontal" action="?do=Update" method="POST">
		  			<input type="hidden" name="userid" value="<?php echo $userid; ?>">
		  			<!-- Start Username Field -->
			  		<div class="form-group form-group-lg">
			  			<label class="col-sm-2 control-label">Username</label>
				  		<div class="col-sm-10 col-sm-6">
				  		<input type="text" name="username" class="form-control" value="<?php echo $row['Username'];?>" autocomplete="off" required="required"/>	
				  		</div>	
			  		</div>
			  		<!-- End Username Field -->
			  		<!-- Start Password Field -->
			  		<div class="form-group form-group-lg">
			  			<label class="col-sm-2 control-label">Password</label>
				  		<div class="col-sm-10 col-sm-6">
				  		<input type="hidden" name="oldpassword" value="<?php echo $row['Password'];?>" />	
				  		<input type="password" name="newpassword" class="form-control" autocomplete="new-passeord"  placeholder="Fill It If You Need!!!" />
				  		</div>	
			  		</div>
			  		<!-- End Password Field -->
			  		<!-- Start Email Field -->
			  		<div class="form-group form-group-lg">
			  			<label class="col-sm-2 control-label">Email</label>
				  		<div class="col-sm-10 col-sm-6">
				  		<input type="email" name="email" value="<?php echo $row['Email'];?>" class="form-control" required="required"/>	
				  		</div>	
			  		</div>
			  		<!-- End Email Field -->
			  		<!-- Start Full Name Field -->
			  		<div class="form-group form-group-lg">
			  			<label class="col-sm-2 control-label">Full Name</label>
				  		<div class="col-sm-10 col-sm-6">
				  		<input type="text" name="full" value="<?php echo $row['FullName'];?>" class="form-control" required="required"/>	
				  		</div>	
			  		</div>
			  		<!-- End Full Name Field -->
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

	} elseif ($do == 'Update') {	// Update Page

	echo "<h1 class='text-center'>Update Member</h1>";
	echo "<div class='container'>";

	if ($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		// Get Variables From The Form

		$ID 	= $_POST['userid'];
		$User 	= $_POST['username'];
		$Email 	= $_POST['email'];	
		$Name 	= $_POST['full'];

		$Pass = '';

		// Password Trick 

		$Pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);

		// Validate The Form

		$formErrors = array();

				if (strlen($User) <= 5 )
				{
					$formErrors[] = 'Username Less Than <strong>5 Characters</strong>j';
				}
				if (strlen($User) > 20 )
				{
					$formErrors[] = 'Username More Than <strong>20 Characters</strong>';
				}
				if (empty($User))
				{
					$formErrors[] = 'Username Can Not Be <strong>Empty</strong>';
				}
				if (empty($Name))
				{
					$formErrors[] = 'Full Name Can Not Be <strong>Empty</strong>';
				}
				if (empty($Email))
				{
					$formErrors[] = 'Email Can Not Be <strong>Empty</strong>';
				}
				
				foreach ($formErrors as $Error)
				{
					echo '<div class="alert alert-danger">' . $Error . '</div>';
				}

		// Check IF There's No Error Proceed The Update Operation 

		if (empty($formErrors))
		{
			$stmt2 = $con->prepare("SELECT
										*
								    FROM
								    	users
								    WHERE
								    	Username = ?
								    AND 
								    	UserID != ?");

			$stmt2->execute(array($User , $ID));

			$count = $stmt2->rowCount();

			if ($count == 1 ) {

				$theMsg = '<div class="alert alert-danger">Sorry This User Is Exist</div>';

					redirectHome($theMsg, 'back');

			}else {

					// Update the Database With This Info

				 		$stmt = $con ->prepare("UPDATE users SET Username = ?, Email = ? , FullName = ? , Password = ?  WHERE UserID = ?");
			     		$stmt->execute(array($User,$Email,$Name, $Pass , $ID ));

					 // Echo Success Message

					 	$theMsg = "<div class='alert alert-success text-center'>" . $stmt->rowCount() . ' Record Update </div>';

					 	redirectHome($theMsg, 'back');
			}
		}

	}	else
		{
			$theMsg ='<div class="alert alert-danger">Sorry You Can Not Browse This Page Directly</div>';

			redirectHome($theMsg);
		}

	echo '</div>';
}

	elseif ($do == 'Delete') // Delet Member Page
	{
			echo "<h1 class='text-center'>Delete Member</h1>";
			echo "<div class='container'>";

		// Check If Get Request userid is Numeric $ Get The Integer Value of It

	  	$userid = isset($_GET['ID'] ) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0;

	    // Selsect All Data Depend On This ID

       $check = checkItem('userid', 'users' , $userid);
 
       if ($check > 0) // ID = 1 Is only True
       {  
       		$stmt = $con->prepare("DELETE FROM users WHERE UserID = :zuser");

			$stmt->bindParam(":zuser", $userid);

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

	} elseif ($do == 'Activate') {
		
			echo "<h1 class='text-center'>Activate Member</h1>";
			echo "<div class='container'>";

		// Check If Get Request userid is Numeric $ Get The Integer Value of It

	  	$userid = isset($_GET['ID'] ) && is_numeric($_GET['ID']) ? intval($_GET['ID']) : 0;

	    // Selsect All Data Depend On This ID

       $check = checkItem('userid', 'users' , $userid);
 
       if ($check > 0) // ID = 1 Is only True
       {  
       		$stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserID = ?");

			$stmt->execute(array($userid));

			$theMsg = "<div class='alert text-center alert-success'>" . $stmt->rowCount() . ' Record Update</div>';

			redirectHome($theMsg);
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