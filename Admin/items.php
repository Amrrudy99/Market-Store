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


		if ($do == 'Manage'){ // Manage Page 


	  		$stmt = $con->prepare("SELECT items.*, 
	  										categories.Name AS Category_Name,
	  										users.Username 
	  								FROM 
	  									items

									INNER JOIN categories ON categories.ID = items.Cat_ID

									INNER JOIN users ON users.UserID = items.Member_ID

									ORDER BY 
										Item_ID DESC");
	  		$stmt->execute();
	  		$items = $stmt->fetchAll();

	  		if(! empty($items)){
	  	?>

	  	<h1 class="text-center">Manage Items</h1>
		  	<div class = "container"> 
		  		<div class="table-responsive">
		  			<table class="main-table text-center table table-bordered">
		  				<tr>
		  					<td>#ID</td>
		  					<td>Name</td>
		  					<td>Description</td>
		  					<td>Price</td>
		  					<td>Adding Date</td>
		  					<td>Catrgory</td>
		  					<td>Username</td>
		  					<td>Control</td>
		  				</tr>

		  				<?php

		  					foreach ($items as $item) {
			  					echo "<tr>";
			  						echo "<td>" . $item['Item_ID'] . "</td>";
			  						echo "<td>" . $item['Name'] . "</td>";
			  						echo "<td>" . $item['Description'] . "</td>";
			  						echo "<td>" . $item['Price'] . "</td>";
			  						echo "<td>" . $item['Add_Date'] . "</td>";
			  						echo "<td>" . $item['Category_Name'] . "</td>";
			  						echo "<td>" . $item['Username'] . "</td>";
			  					echo "<td>
			  						<a href='items.php?do=Edit&itemid=" . $item['Item_ID']. "' class='btn btn-success'><i class='fas fa-edit'></i> Edit</a>
			  						<a href='items.php?do=Delete&itemid=" . $item['Item_ID']. "' class='btn btn-danger confirm'><i class='fas fa-trash'></i></i> Delete</a>";
			  						if($item['Approve'] == 0){
			  									echo "<a href='items.php?do=Approve&itemid=" . $item['Item_ID']. "'
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
		  	 	<a href = "items.php?do=Add" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i> New Item</a>
		  	</div>

		<?php }
		 else{

				 echo '<div class="container">';
				 	echo '<div class="nice-message">There\'s NO Items To Show</div>';
				 	echo '<a href = "items.php?do=Add" class="btn btn-sm btn-primary">
				 			<i class="fa fa-plus"></i> New Item
				 		  </a>';
				 echo '</div>';
			}
		 ?>


		  	<?php }

		elseif ($do == 'Add') { ?>
			
			<h1 class="text-center">Add New Item</h1>
		  	<div class = "container"> 
		  		<form class="form-horizontal" action="?do=Insert" method="POST">
		  			<!-- Start Name Field -->
			  		<div class="form-group form-group-lg">
			  			<label class="col-sm-2 control-label">Name</label>
				  		<div class="col-sm-10 col-sm-6">
				  		<input 
				  				type="text" 
				  				name="name" 
				  				class="form-control" 
				  				required="required"	
				  			    placeholder="Name Of Item" />	
				  		</div>	
			  		</div>
			  		<!-- End Name Field -->
			  		<!-- Start Description Field -->
			  		<div class="form-group form-group-lg">
			  			<label class="col-sm-2 control-label">Description</label>
				  		<div class="col-sm-10 col-sm-6">
				  		<input 
				  			   type="text"
				  			   name="description" 
				  			   class="form-control" 
				  			   required="required"
				  			   placeholder="Details Of Item" />	
				  		</div>	
			  		</div>
			  		<!-- End Description Field -->
			  		<!-- Start Price Field -->
			  		<div class="form-group form-group-lg">
			  			<label class="col-sm-2 control-label">Price</label>
				  		<div class="col-sm-10 col-sm-6">
				  		<input 
				  			   type="text"
				  			   name="price" 
				  			   class="form-control" 
				  			   required="required" 
				  			   placeholder="Price Of Item" />	
				  		</div>	
			  		</div>
			  		<!-- End Price Field -->
			  		<!-- Start Country_Made Field -->
			  		<div class="form-group form-group-lg">
			  			<label class="col-sm-2 control-label">Country</label>
				  		<div class="col-sm-10 col-sm-6">
				  		<input 
				  			   type="text"
				  			   name="country" 
				  			   class="form-control" 
				  			   required="required"
				  			   placeholder="Country Of Made" />	
				  		</div>	
			  		</div>
			  		<!-- End Country_Made Field -->
			  		<!-- Start Status Field -->
			  		<div class="form-group form-group-lg">
			  			<label class="col-sm-2 control-label">Status</label>
				  		<div class="col-sm-10 col-sm-6">
				  				<select name="status">
				  					<option value="0">...</option>
				  					<option value="1">New</option>
				  					<option value="2">Like New</option>
				  					<option value="3">Semi New</option>
				  				</select>	
				  		</div>	
			  		</div>
			  		<!-- End Status Field -->
			  		<!-- Start Members Field -->
			  		<div class="form-group form-group-lg">
			  			<label class="col-sm-2 control-label">Member</label>
				  		<div class="col-sm-10 col-sm-6">
				  				<select name="member">
				  					<option value="0">...</option>
				  					<?php
				  						$allMembers = getAllFrom("*", "users", "", "", "UserID");
				  						foreach ($allMembers as $user) {
				  							echo "<option value='" .$user['UserID'] . "'>" .$user['Username'] . "</option>";
				  						}
				  					?>
				  				</select>	
				  		</div>	
			  		</div>
			  		<!-- End Members Field -->
			  		<!-- Start Categories Field -->
			  		<div class="form-group form-group-lg">
			  			<label class="col-sm-2 control-label">Category</label>
				  		<div class="col-sm-10 col-sm-6">
				  				<select name="category">
				  					<option value="0">...</option>
				  					<?php
				  						$allCats = getAllFrom("*", "categories", " where Parent = 0", "", "ID");
				  						foreach ($allCats as $cat) {
				  							echo "<option value='" . $cat['ID'] . "'>" .$cat['Name'] . "</option>";
				  							$childCats = getAllFrom("*", "categories", " where Parent = {$cat['ID']}", "", "ID");
				  							foreach ($childCats as $child) {
				  								echo "<option value='" . $child['ID'] . "'>--- " .$child['Name'] . "</option>";
				  							}
				  						}
				  					?>
				  				</select>	
				  		</div>	
			  		</div>
			  		<!-- End Categories Field -->
			  		<!-- Start Tags Field -->
			  		<div class="form-group form-group-lg">
			  			<label class="col-sm-2 control-label">Tags</label>
				  		<div class="col-sm-10 col-sm-6">
				  		<input 
				  			   type="text"
				  			   name="tags" 
				  			   class="form-control" 
				  			   placeholder="Separate Tags With Comma (,)" />	
				  		</div>	
			  		</div>
			  		<!-- End Tags Field -->
			  		<!-- Start Submit Field -->
			  		<div class="form-group form-group-lg">
				  		<div class="col-sm-offset-2 col-sm-10">
				  		<input type="submit" value="Add Item" class="btn btn-primary btn-sm" />	
				  		</div>	
			  		</div>
			  		<!-- End Submit Field -->
		  		</form>
		  	</div>

			<?php
		}

		elseif ($do == 'Insert') { // Insert Item Page 

			if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{	

				echo "<h1 class='text-center'>Insert Item</h1>";
				echo "<div class='container'>";


				// Get Variables From The Form

				$name 	 = $_POST['name'];
				$desc 	 = $_POST['description'];
				$price 	 = $_POST['price'];	
				$country = $_POST['country'];
				$status  = $_POST['status'];
				$member  = $_POST['member'];
				$cat  	 = $_POST['category'];
				$tags  	 = $_POST['tags'];

				// Validate The Form

				$formErrors = array();

				if (empty($name))
				{
					$formErrors[] = 'Name Can\'t be <strong>Empty</strong>';
				}
				if (empty($desc))
				{
					$formErrors[] = 'Description Can\'t be <strong>Empty</strong>';
				}
				if (empty($price))
				{
					$formErrors[] = 'Price Can\'t be <strong>Empty</strong>';
				}
				if (empty($country))
				{
					$formErrors[] = 'Country Can\'t be <strong>Empty</strong>';
				}
				if ($status == 0)
				{
					$formErrors[] = 'You Must Choose the <strong>Status</strong>';
				}
				if ($member == 0)
				{
					$formErrors[] = 'You Must Choose the <strong>Member</strong>';
				}
				if ($cat == 0)
				{
					$formErrors[] = 'You Must Choose the <strong>Category</strong>';
				}
				
				foreach ($formErrors as $Error)
				{
					echo '<div class="alert alert-danger">' . $Error . '</div>';
				}

				// Check IF There's No Error Proceed The Update Operation 

				if (empty($formErrors))
				{

					// Insert User Info In Data Base

								$stmt = $con->prepare("INSERT INTO
														 	items(Name,Description,Price,Country_Made,Status,Add_Date,Member_ID,Cat_ID, tags)
														 	VALUES(:zname, :zdesc, :zprice, :zcountry, :zstatus, now(),:zmember, :zcat, :ztags) ");
								$stmt->execute(array(

									'zname'    => $name,
									'zdesc'    => $desc,
									'zprice'   => $price,
									'zcountry' => $country,
									'zstatus'  => $status,
									'zmember'  => $member,
									'zcat'     => $cat,
									'ztags'     => $tags
								));


							 // Echo Success Message

							 $theMsg = "<div class='alert alert-success text-center'>" . $stmt->rowCount() . ' Record Inserted </div>';

							 redirectHome($theMsg, 'back');		

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
		
		elseif ($do == 'Edit') {

			// Check If Get Request itemid is Numeric $ Get The Integer Value of It

		  	$itemid = isset($_GET['itemid'] ) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

		    // Selsect All Data Depend On This ID

	       $stmt = $con->prepare("SELECT * FROM items WHERE Item_ID = ? ");
	       // Execute Query
	       $stmt->execute(array($itemid));
	       //Fetch The Data
	       $item   = $stmt->fetch();
	       $count = $stmt->rowCount();


	       if ($count > 0) // ID = 1 Is only True
	       {  ?>	

				  	<h1 class="text-center">Edit Item</h1>
		  	<div class = "container"> 
		  		<form class="form-horizontal" action="?do=Update" method="POST">
		  			<input type="hidden" name="itemid" value="<?php echo $itemid; ?>">

		  			<!-- Start Name Field -->
			  		<div class="form-group form-group-lg">
			  			<label class="col-sm-2 control-label">Name</label>
				  		<div class="col-sm-10 col-sm-6">
				  		<input 
				  				type="text" 
				  				name="name" 
				  				class="form-control" 
				  				required="required" 
				  			    placeholder="Name Of Item" 
				  			    value="<?php echo $item['Name']?>" />	
				  		</div>	
			  		</div>
			  		<!-- End Name Field -->
			  		<!-- Start Description Field -->
			  		<div class="form-group form-group-lg">
			  			<label class="col-sm-2 control-label">Description</label>
				  		<div class="col-sm-10 col-sm-6">
				  		<input 
				  			   type="text"
				  			   name="description" 
				  			   class="form-control" 
				  			   required="required"
				  			   placeholder="Details Of Item" 
				  			   value="<?php echo $item['Description']?>" />	
				  		</div>	
			  		</div>
			  		<!-- End Description Field -->
			  		<!-- Start Price Field -->
			  		<div class="form-group form-group-lg">
			  			<label class="col-sm-2 control-label">Price</label>
				  		<div class="col-sm-10 col-sm-6">
				  		<input 
				  			   type="text"
				  			   name="price" 
				  			   class="form-control" 
				  			   required="required"
				  			   placeholder="Price Of Item" 
				  			   value="<?php echo $item['Price']?>" />	
				  		</div>	
			  		</div>
			  		<!-- End Price Field -->
			  		<!-- Start Country_Made Field -->
			  		<div class="form-group form-group-lg">
			  			<label class="col-sm-2 control-label">Country</label>
				  		<div class="col-sm-10 col-sm-6">
				  		<input 
				  			   type="text"
				  			   name="country" 
				  			   class="form-control" 
				  			   required="required"
				  			   placeholder="Country Of Made" 
				  			   value="<?php echo $item['Country_Made']?>"/>	
				  		</div>	
			  		</div>
			  		<!-- End Country_Made Field -->
			  		<!-- Start Status Field -->
			  		<div class="form-group form-group-lg">
			  			<label class="col-sm-2 control-label">Status</label>
				  		<div class="col-sm-10 col-sm-6">
				  				<select name="status">
				  					<option value="0">...</option>
				  					<option value="1" <?php if ($item['Status']==1){echo 'selected';} ?>>New</option>
				  					<option value="2" <?php if ($item['Status']==2){echo 'selected';} ?>>Like New</option>
				  					<option value="3" <?php if ($item['Status']==3){echo 'selected';} ?>>Semi New</option>
				  				</select>	
				  		</div>	
			  		</div>
			  		<!-- End Status Field -->
			  		<!-- Start Members Field -->
			  		<div class="form-group form-group-lg">
			  			<label class="col-sm-2 control-label">Member</label>
				  		<div class="col-sm-10 col-sm-6">
				  				<select name="member">
				  					<option value="0">...</option>
				  					<?php
				  						$stmt = $con->prepare("SELECT * FROM users");
				  						$stmt->execute();
				  						$users = $stmt->fetchAll();
				  						foreach ($users as $user) {
				  							echo "<option value='" . $user['UserID'] . "'";
				  						     if ($item['Member_ID']== $user['UserID']){echo 'selected';} 
				  						    echo" >" . $user['Username'] . "</option>";
				  						}
				  					?>
				  				</select>	
				  		</div>	
			  		</div>
			  		<!-- End Members Field -->
			  		<!-- Start Categories Field -->
			  		<div class="form-group form-group-lg">
			  			<label class="col-sm-2 control-label">Category</label>
				  		<div class="col-sm-10 col-sm-6">
				  				<select name="category">
				  					<option value="0">...</option>
				  					<?php
				  						$stmt2 = $con->prepare("SELECT * FROM categories");
				  						$stmt2->execute();
				  						$cats = $stmt2->fetchAll();
				  						foreach ($cats as $cat) {
				  							echo "<option value='" . $cat['ID'] . "'";
				  							if ($item['Cat_ID']== $cat['ID']) {echo 'selected';}
				  							echo">" .$cat['Name'] . "</option>";
				  						}
				  					?>
				  				</select>	
				  		</div>	
			  		</div>
			  		<!-- End Categories Field -->
			  		<!-- Start Tags Field -->
			  		<div class="form-group form-group-lg">
			  			<label class="col-sm-2 control-label">Tags</label>
				  		<div class="col-sm-10 col-sm-6">
				  		<input 
				  			   type="text"
				  			   name="tags" 
				  			   class="form-control" 
				  			   placeholder="Separate Tags With Comma (,)" 
				  			   value="<?php echo $item['tags'] ?>" />	
				  		</div>	
			  		</div>
			  		<!-- End Tags Field -->
			  		<!-- Start Submit Field -->
			  		<div class="form-group form-group-lg">
				  		<div class="col-sm-offset-2 col-sm-10">
				  		<input type="submit" value="Sava Item" class="btn btn-primary btn-sm" />	
				  		</div>	
			  		</div>
			  		<!-- End Submit Field -->
		  		</form>

		<!---------------------------------------                         COMMENT         ------------------------------------------>    
				<?php
		  			// Select All Comments

	  		$stmt = $con->prepare("SELECT 
	  									Comments.* , users.Username AS Member
	  								FROM
	  									comments
	  								INNER JOIN
	  									users
	  								ON
	  									users.UserID = comments.user_id
	  								WHERE item_id = ?");
	  		$stmt->execute(array($itemid));
	  		$rows = $stmt->fetchAll();

	  		if (!empty($rows))
	  		{
				?>
			  	<h1 class="text-center">Manage [<?php echo $item['Name']?>] Comments</h1>
				  		<div class="table-responsive">
				  			<table class="main-table text-center table table-bordered">
				  				<tr>
				  					<td>Comment</td>
				  					<td>User Name</td>
				  					<td>Added Date</td>
				  					<td>Control</td>
				  				</tr>

				  				<?php

				  					foreach ($rows as $row) {
					  					echo "<tr>";
					  						echo "<td>" . $row['comment'] . "</td>";
					  						echo "<td>" . $row['Member'] . "</td>";
					  						echo "<td>" . $row['comment_date'] . "</td>";
					  					echo "<td>
					  							    <a href='comments.php?do=Edit&comid=" . $row['c_id']. "' class='btn btn-success'><i class='fas fa-edit'></i> Edit</a>
					  								<a href='comments.php?do=Delete&comid=" . $row['c_id']. "' class='btn btn-danger confirm'><i class='fas fa-trash'></i></i> Delete</a>";

					  								if($row['status'] == 0){
					  									echo "<a href='comments.php?do=Approve&comid=" . $row['c_id']. "' 
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
				<?php }?>
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
		
		elseif ($do == 'Update') { //Update Page
					
			echo "<h1 class='text-center'>Update Item</h1>";
			echo "<div class='container'>";

			if ($_SERVER['REQUEST_METHOD'] == 'POST')
			{
				// Get Variables From The Form

				$id 		= $_POST['itemid'];
				$name 		= $_POST['name'];
				$desc 		= $_POST['description'];	
				$price 		= $_POST['price'];
				$country 	= $_POST['country'];
				$status 	= $_POST['status'];
				$cat		= $_POST['category'];
				$member 	= $_POST['member'];
				$tags 	    = $_POST['tags'];

				// Validate The Form

				$formErrors = array();

				if (empty($name))
				{
					$formErrors[] = 'Name Can\'t be <strong>Empty</strong>';
				}
				if (empty($desc))
				{
					$formErrors[] = 'Description Can\'t be <strong>Empty</strong>';
				}
				if (empty($price))
				{
					$formErrors[] = 'Price Can\'t be <strong>Empty</strong>';
				}
				if (empty($country))
				{
					$formErrors[] = 'Country Can\'t be <strong>Empty</strong>';
				}
				if ($status == 0)
				{
					$formErrors[] = 'You Must Choose the <strong>Status</strong>';
				}
				if ($member == 0)
				{
					$formErrors[] = 'You Must Choose the <strong>Member</strong>';
				}
				if ($cat == 0)
				{
					$formErrors[] = 'You Must Choose the <strong>Category</strong>';
				}
				
				foreach ($formErrors as $Error)
				{
					echo '<div class="alert alert-danger">' . $Error . '</div>';
				}

				// Check IF There's No Error Proceed The Update Operation 

				if (empty($formErrors))
				{
					// Update the Database With This Info

				 $stmt = $con ->prepare("UPDATE items SET
				 						 Name = ?,
				 						 Description = ?,
				 						 Price = ?,
				 						 Country_Made = ?,
				 						 Status = ?,
				 						 Cat_ID = ?,
				 						 Member_ID = ?,
				 						 tags = ?
				 						 WHERE Item_ID = ?");

			     $stmt->execute(array($name, $desc, $price, $country, $status, $cat, $member, $tags, $id ));

				 // Echo Success Message

					 $theMsg = "<div class='alert alert-success text-center'>" . $stmt->rowCount() . ' Record Update </div>';

					 	redirectHome($theMsg, 'back');

				}

			}	else
				{
					$theMsg ='<div class="alert alert-danger">Sorry You Can Not Browse This Page Directly</div>';

					redirectHome($theMsg);
				}

			echo '</div>';

		}
		
		elseif ($do == 'Delete') { // Delete Page

				echo "<h1 class='text-center'>Delete Item</h1>";
				echo "<div class='container'>";

			// Check If Get Request Item ID is Numeric $ Get The Integer Value of It

		  	$itemid = isset($_GET['itemid'] ) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

		    // Selsect All Data Depend On This ID

	       $check = checkItem('Item_ID', 'items' , $itemid);
	 
	       if ($check > 0) // ID = 1 Is only True
	       {  
	       		$stmt = $con->prepare("DELETE FROM items WHERE Item_ID = :zid");

				$stmt->bindParam(":zid", $itemid);

				$stmt->execute();

				$theMsg = "<div class='alert text-center alert-success'>" . $stmt->rowCount() . ' Record Deleted</div>';

				redirectHome($theMsg,'back');
	       }

	       else
	       {
	       	 	$theMsg = '<div class="alert alert-danger">This ID Is Not Exist</div>';

	       	 	redirectHome($theMsg);
	       }

	       echo '</div>';

		}
		
		elseif ($do == 'Approve') {

				echo "<h1 class='text-center'>Approve Item</h1>";
				echo "<div class='container'>";

			// Check If Get Request Item ID is Numeric $ Get The Integer Value of It

		  	$itemid = isset($_GET['itemid'] ) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

		    // Selsect All Data Depend On This ID

	       $check = checkItem('Item_ID', 'items' , $itemid);
	 
	       if ($check > 0) // ID = 1 Is only True
	       {  
	       		$stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE Item_ID = ?");

				$stmt->execute(array($itemid));

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
	

		include $tpl . 'Footer.php';

	}
		else
		{
			header('Location: index.php');

			exit();
		}

		ob_end_flush(); // Release The Output

?>