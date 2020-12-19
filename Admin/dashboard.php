<?php 
	
	ob_start(); // Output Buffering Start

	session_start();

	if (isset($_SESSION['Username'])) {

	  $PageTitle = 'Dashboard';

	  include 'init.php';

	  /* Start Dashboard Page */

	  $numUsers = 6;  // Number Of Latest Users

	  $latestUsers = getlatest("*", "users" , "UserID" ,"$numUsers");

	  $numItems = 6; // Number Of Latest Items

	  $latestItems = getlatest("*", "items" , "Item_ID" ,"$numItems");

	  $numComments = 4;	// Number Of Comments



	    ?>

		<div class="home-stats"> 
			<div class="container home-stats text-center">
				<h1>Dashboard</h1>
				<div class"row">
					<div class="col-md-3">
						<div class="stat st-members">
							<i class="fas fa-users"></i>
							<div class="info">
								Total Members
								<span><a href="members.php"><?php echo countItems('UserID','users') ?></a></span>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="stat st-pending">
							<i class="fas fa-user-plus"></i>
							<div class="info">
									Pending Members
								<span><a href="members.php?do=Manage&page=Pending">
									<?php echo checkItem("RegStatus", "users" , 0) ?>
								</a></span>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="stat st-items">
							<i class="fas fa-tag"></i>
							<div class="info">
								Total Items
								<span>
									<a href="items.php"><?php echo countItems('Item_ID','items') ?></a>
								</span>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="stat st-comments">
							<i class="fas fa-comments"></i>
							<div class="info">
								Total Comments
								<span>
									<span><a href="comments.php"><?php echo countItems('c_id','comments') ?></a></span>
								</span>
							</div>
					    </div>
					</div>
				</div>
			</div>
		</div>

		<div class="latest">
			<div class="container latest">
				<div class="row">
					<div class="col-sm-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								<i class="fa fa-users"></i> Latest <?php echo $numUsers?> Registerd Users
								<span class="toggle-info pull-right">
									<i class="fas fa-plus fa-lg"></i>
								</span>
							</div>
							<div class="panel-body">
								<ul class="list-unstyled latest-users">
									<?php 
										if(! empty($latestUsers)){
										foreach ($latestUsers as $user) {											  	
											echo '<li>'; 
												echo $user['Username'];
												echo '<a href="members.php?do=Edit&ID=' . $user['UserID'] . '">';
													echo '<span class="btn btn-success pull-right">';
														echo '<i class="fa fa-edit"></i> Edit';
															if($user['RegStatus'] == 0){
			  														echo "<a href='members.php?do=Activate&ID=" . $user['UserID']. "' class='btn btn-info pull-right activate '>
			  														<i class='fas fa-Check'></i></i> Activate</a>";
			  															}
													echo '</span>';
												echo '</a>';
											echo '</li>' ;
										}
									} else{
										echo 'There\'s No Users To Show';
									}	
									?>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								<i class="fa fa-tag"></i> Latest <?php echo $numItems; ?> Items
								<span class="toggle-info pull-right">
									<i class="fas fa-plus fa-lg"></i>
								</span>
							</div>
							<div class="panel-body">
								<ul class="list-unstyled latest-users">
									<?php 
										if(! empty($latestItems)){
										foreach ($latestItems as $item) {
											  	
											echo '<li>'; 
												echo $item['Name'];
												echo '<a href="items.php?do=Edit&itemid=' . $item['Item_ID'] . '">';
													echo '<span class="btn btn-success pull-right">';
														echo '<i class="fa fa-edit"></i> Edit';
															if($item['Approve'] == 0){
			  														echo "<a href='items.php?do=Approve&itemid=" . $item['Item_ID']. "' class='btn btn-info pull-right activate '>
			  														<i class='fas fa-Check'></i></i> Approve</a>";
			  															}
													echo '</span>';
												echo '</a>';
											echo '</li>' ;
										} 
									
									} else{
											echo 'There\'s No Items To Show';
										}
									?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			<!-- Start Latest Comment -->
			<div class="row">
					<div class="col-sm-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								<i class="far fa-comment-alt"></i>
								 Latest <?php echo $numComments; ?> Comments
								<span class="toggle-info pull-right">
									<i class="fas fa-plus fa-lg"></i>
								</span>
							</div>
							<div class="panel-body">
								<?php
										$stmt = $con->prepare("SELECT 
			  									Comments.* , users.Username AS Member
			  								FROM
			  									comments
			  								INNER JOIN
			  									users
			  								ON
			  									users.UserID = comments.user_id
			  								ORDER BY 
			  									c_id DESC
			  								LIMIT $numComments");

			  								$stmt->execute();
			  								$comments = $stmt->fetchAll();

			  								if(! empty($comments)){
			  								foreach ($comments as $comment) {
			  									echo '<div class="comment-box">';
			  										echo '<span class="member-n">
			  											<a href="members.php"?do=Edit&UserID=' . $comment['user_id'].'">
			  												'.$comment['Member'] . '</a></span>';
			  										echo '<p    class="member-c">' . $comment['comment'] . '</p>';
			  									echo '</div>';

			  								}
			  							} else{
			  								echo 'There\'s No Comments To Show';
			  							}
								?>
							</div>
						</div>
					</div>
				</div>
				<!-- End Latest Comment -->
			</div>
	    </div>



		<?php 	  




	 /* End Dashboard Page */

	  include $tpl . '/Footer.php';

	} else {
		
		header('Location: Index.php');
		exit();

	}



	ob_end_flush();

?>