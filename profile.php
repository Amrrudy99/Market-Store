<?php 
	session_start();
  	$PageTitle = 'Profile';
  	include 'init.php';
  	if (isset($_SESSION['user'])) {
  	$getUser = $con->prepare("SELECT * FROM users WHERE Username = ?");
  	$getUser->execute(array($sessionUser));
  	$info = $getUser->fetch();
  	$userid = $info['UserID'];
?>

<h1 class="text-center">My Profile</h1>
<div class="information block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">MY Information</div>
				<div class="panel-body">
					<ul class="list-unstyled">
						<li>
							<i class="fas fa-unlock-alt"></i>
							<span>Login Name</span> : 		     	<?php echo $info['Username'] ?> 
						</li>
						<li>
							<i class="far fa-envelope"></i>
							<span>Email</span> :          	<?php echo $info['Email'] ?> 
						</li>
						<li>
							<i class="fas fa-user"></i>
							<span>Full Name</span> : 		 	<?php echo $info['FullName'] ?> 
						</li>
						<li>
							<i class="far fa-calendar-alt"></i>
							<span>Register Date</span> :   	<?php echo $info['Date'] ?> 
						</li>
						<li>
							<i class="fas fa-tags"></i>
							<span>Fav Category</span> : <?php echo $info['UserID'] ?> 
						</li>
					</ul>
					<a href="#" class="btn btn-default">Edit Information</a>
				</div>
		</div>
	</div>
</div>
<div id="my-ads" class="my-Ads block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">My Items</div>
				<div class="panel-body">
							<?php
								$myItems = getAllFrom("*", "items", "where Member_ID = $userid", "", "Item_ID");
								if(! empty($myItems)) {
									echo '<div class="row">';
								foreach ($myItems as $item) {
									echo '<div class="col-sm-6 col-md-3">';
										echo '<div class="thumbnail item-box">';
											if ($item['Approve'] == 0){
											 echo '<span class="approve-status">Waiting Approvel</span>'; 
											}
											echo '<span class="price-tag">' . $item['Price'] .'</span>';
											echo '<img class="img-responsive" src="" alt="" />';
											echo '<div class="caption">';
												echo '<h3><a href="items.php?itemid='.$item['Item_ID'].'">' .$item['Name']. '</a></h3>';
												echo '<p>' .$item['Description'] .'</p>';
												echo '<div class="date">' .$item['Add_Date'] .'</div>';
											echo '</div>';
										echo '</div>';
									echo '</div>';

								}
								echo '</div>';
							} else{
								echo 'Sorry There\' No Ads To Show, Create <a href="newad.php">New Ad</a>';
							}
							?>
				</div>
		</div>
	</div>
</div>	
<div class="my-comments block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading">My Comments</div>
				<div class="panel-body">
					<?php 	
						$myComments = getAllFrom("comment", "comments", "where user_id = $userid", "", "c_id");
						if (! empty($myComments)){
							foreach ($myComments as $comment) {
								echo '<p>' . $comment['comment'] . '</p>';  
							}
						} else {
							echo ' There\'s No Comments To Show' ;
						}
					?>
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