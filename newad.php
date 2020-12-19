<?php 
	session_start();
  	$PageTitle = 'Create New Item';
  	include 'init.php';
  	if (isset($_SESSION['user'])) {

  		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  			$formErrors = array();

  			$name		= filter_var($_POST['name'], FILTER_SANITIZE_STRING);
  			$desc 		= filter_var($_POST['description'], FILTER_SANITIZE_STRING);
  			$price 		= filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
  			$country 	= filter_var($_POST['country'], FILTER_SANITIZE_STRING);
  			$status 	= filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
  			$category 	= filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
  			$tags 	    = filter_var($_POST['tags'], FILTER_SANITIZE_STRING);

  			if (strlen($name) < 3) {

  				$formErrors[] = 'Item Title Must Be At Least 3 Characters';
  			}

  			if (strlen($desc) < 10) {

  				$formErrors[] = 'Item Description Must Be At Least 10 Characters';
  			}

  			if (empty($price)) {

  				$formErrors[] = 'Item Price Must Be Not Empty';
  			}

  			if (strlen($country) < 2) {

  				$formErrors[] = 'Item Country Must Be At Least 2 Characters';
  			}

  			if (empty($status)) {

  				$formErrors[] = 'Item Status Must Be Not Empty';
  			}

  			if (empty($category)) {

  				$formErrors[] = 'Item Category Must Be Not Empty';
  			}


				// Check IF There's No Error Proceed The Update Operation 

				if (empty($formErrors))
				{

					// Insert User Info In Data Base

								$stmt = $con->prepare("INSERT INTO
														 	items(Name,Description,Price,Country_Made,Status,Add_Date,Cat_ID,Member_ID,tags)
														 	VALUES(:zname, :zdesc, :zprice, :zcountry, :zstatus, now(),:zcat,:zmember,:ztags)");
								$stmt->execute(array(

									'zname'    => $name,
									'zdesc'    => $desc,
									'zprice'   => $price,
									'zcountry' => $country,
									'zstatus'  => $status,
									'zcat'     => $category,
									'zmember'  => $_SESSION['UID'],
									'ztags'    => $tags
									
								));


							 // Echo Success Message

							if ($stmt) {

								$succesMsg = 'ITEM ADD DONE';
								
							}				
			    }
  		}

?>

<h1 class="text-center"><?php echo $PageTitle;?></h1>
	<div class="create-ad block">
		<div class="container">
			<div class="panel panel-primary">
				<div class="panel-heading"><?php echo $PageTitle;?></div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-8">	
								<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
			  			<!-- Start Name Field -->
				  		<div class="form-group form-group-lg">
				  			<label class="col-sm-3 control-label">Name</label>
					  		<div class="col-sm-10 col-sm-9">
					  		<input 	
					  				pattern=".{4,}"
					  				title="This Field Required At Least 4 Char" 
					  				type="text" 
					  				name="name" 
					  				class="form-control live" 
					  				required="required" 
					  			    placeholder="Name Of Item"
					  			    data-class=".live-title" />	
					  		</div>	
				  		</div>
				  		<!-- End Name Field -->
				  		<!-- Start Description Field -->
				  		<div class="form-group form-group-lg">
				  			<label class="col-sm-3 control-label">Description</label>
					  		<div class="col-sm-10 col-sm-9">
					  		<input 
					  			   pattern=".{10,}"
					  			   title="This Field Required At Least 10 Char"
					  			   type="text"
					  			   name="description" 
					  			   class="form-control live" 
					  			   required="required" 
					  			   placeholder="Details Of Item"
					  			   data-class=".live-desc" />	
					  		</div>	
				  		</div>
				  		<!-- End Description Field -->
				  		<!-- Start Price Field -->
				  		<div class="form-group form-group-lg">
				  			<label class="col-sm-3 control-label">Price</label>
					  		<div class="col-sm-10 col-sm-9">
					  		<input 
					  			   type="text"
					  			   name="price" 
					  			   class="form-control live" 
					  			   required="required" 
					  			   placeholder="Price Of Item"
					  			   data-class=".live-price" />	
					  		</div>	
				  		</div>
				  		<!-- End Price Field -->
				  		<!-- Start Country_Made Field -->
				  		<div class="form-group form-group-lg">
				  			<label class="col-sm-3 control-label">Country</label>
					  		<div class="col-sm-10 col-sm-9">
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
				  			<label class="col-sm-3 control-label">Status</label>
					  		<div class="col-sm-10 col-sm-9">
					  				<select name="status">
					  					<option value="0">...</option>
					  					<option value="1">New</option>
					  					<option value="2">Like New</option>
					  					<option value="3">Semi New</option>
					  				</select>	
					  		</div>	
				  		</div>
				  		<!-- End Status Field -->
				  		<!-- Start Categories Field -->
				  		<div class="form-group form-group-lg">
				  			<label class="col-sm-3 control-label">Category</label>
					  		<div class="col-sm-10 col-sm-9">
					  				<select name="category">
					  					<option value="0">...</option>
					  					<?php
					  						$cats = getAllFrom('*','categories', '', '', 'ID');
					  						foreach ($cats as $cat) {
					  							echo "<option value='" .$cat['ID'] . "'>" .$cat['Name'] . "</option>";
					  						}
					  					?>
					  				</select>	
					  		</div>	
				  		</div>
				  		<!-- End Categories Field -->
				  		<!-- Start Tags Field -->
				  		<div class="form-group form-group-lg">
				  			<label class="col-sm-3 control-label">Tags</label>
					  		<div class="col-sm-10 col-sm-9">
					  		<input 
					  			   type="text"
					  			   name="tags" 
					  			   class="form-control" 
					  			   placeholder="Separate Tags With Comma (,)"  />	
					  		</div>	
				  		</div>
				  		<!-- End Tags Field -->
				  		<!-- Start Submit Field -->
				  		<div class="form-group form-group-lg">
					  		<div class="col-sm-offset-3 col-sm-9">
					  		<input type="submit" value="Add Item" class="btn btn-primary btn-sm" />	
					  		</div>	
				  		</div>
				  		<!-- End Submit Field -->
			  		</form>
							</div>
							<div class="col-md-4">	
								<div class="thumbnail item-box live-preview">
									<span class="price-tag ">
										$<span class="live-price">0</span>
									</span>
									<img class="img-responsive" src="" alt="" />
									<div class="caption">
										<h3 class="live-title">Title</h3>
										<p class="live-desc">Description</p>
									</div>
								</div>
							</div>
						</div>
						<!-- Start Looping Through Errors -->
						<?php

							if (! empty($formErrors)) {

								foreach ($formErrors as $error) {
									echo '<div class="alert alert-danger">' . $error . '</div>';
								}
							}

							if (isset($succesMsg)) {

								echo '<div class="alert alert-success">' . $succesMsg . '</div>';
							}




						?>
						<!-- End Looping Through Errors -->
				</div>
			</div>
		</div>
	</div>


<?php 
	} else {
		header('Location: login.php ');
		exit();
	}
  	include $tpl . '/Footer.php';
?>