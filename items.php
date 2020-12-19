<?php 
	session_start();
  	$PageTitle = 'Show Items';
  	include 'init.php'; 

  	// Check If Get Request itemid is Numeric $ Get The Integer Value of It
	$itemid = isset($_GET['itemid'] ) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
	// Selsect All Data Depend On This ID
	$stmt = $con->prepare("SELECT
								items.*, categories.Name AS category_name,
								users.Username
							FROM 
							 	items 
							INNER JOIN
								categories
							ON
								categories.ID = items.Cat_ID
							INNER JOIN
								users
							ON
								users.UserID = items.Member_ID
							WHERE
							 	Item_ID = ? 
							And 
							 	Approve = 1");
	// Execute Query
	$stmt->execute(array($itemid));
	$count = $stmt->rowCount();
	if ($count > 0){
	//Fetch The Data
	$item   = $stmt->fetch();

?>

<h1 class="text-center"><?php echo $item['Name']; ?></h1>
<div class="container">
	<div class="row">
		<div class="col-md-3">
			<img class="img-responsive img-thumbnail center-block" src="img1.png" alt="" />
		</div>
		<div class="col-md-9 item-info">	
			<h2><?php echo $item['Name'];?></h2>
			<p><?php echo $item['Description'];?></p>
			<ul class="list-unstyled">
				<li>
					<i class="fas fa-calendar-alt"></i>
					<span>Add Date</span> : <?php echo $item['Add_Date']?>
				</li>
				<li>
					<i class="fas fa-money-bill-alt"></i>
					<span>Price</span> : <?php echo $item['Price']?>
				</li>
				<li>
					<i class="fas fa-warehouse"></i>
					<span>Made In</span> : <?php echo $item['Country_Made']?>
				</li>
				<li>
					<i class="fas fa-tags"></i>
					<span>Category</span> : <a href="categories.php?pageid=<?php echo $item['Cat_ID']; ?>"><?php echo $item['category_name']?></a>
				</li>
				<li>
					<i class="fas fa-user"></i>
					<span>Add By</span> : <a href="#"><?php echo $item['Username']?></a>
				</li>
				<li class="tags-items">
					<i class="fas fa-user"></i>
					<span>Tags</span> : 
					<?php 
						$allTags = explode(",", $item['tags']);
						foreach ($allTags as $tag) {
							$tag = str_replace(' ', '', $tag);
							$lowertag = strtolower($tag);
							if (!empty($tag)){
								echo "<a href='tags.php?name={$lowertag}'>" . $tag . '</a> | ';
							}
						}
					?>
				</li>
			</ul>
		</div>
	</div>
	<!-- 	Start Add Comment -->
	<?php if (isset($_SESSION['user'])) { ?>
	<hr class="custom-hr">
	<div class="row">
		<div class="col-md-offset-3">
			<div class="add-comment">
				<h3> Add Your Comment</h3> 
				<form action="<?php echo $_SERVER['PHP_SELF'] . '?itemid=' . $item['Item_ID'] ?>" method="POST">
					<textarea name="comment" required="required"></textarea>
					<input class="btn btn-primary" type="submit"  value="Add Comment">
				</form>
				<?php
					if($_SERVER['REQUEST_METHOD'] == 'POST') {

						$comment = FILTER_VAR($_POST['comment'],FILTER_SANITIZE_STRING);
						$itemid  = $item['Item_ID'];
						$userid  = $item['Member_ID'];
						

						if (! empty($comment)) {

							$stmt = $con->prepare("INSERT INTO 
													comments(comment, status , comment_date, item_id, user_id )
													VALUES(:zcomment , 0 , NOW(), :zitemid, :zuserid)");

							$stmt->execute(array(

								'zcomment' => $comment,
								'zitemid' => $itemid,
								'zuserid'  => $userid

							));

							if ($stmt) {

								echo '<div class="alert alert-success">Comment Add</div>';
								
							}
						}
					}
				?>
			</div>
		</div>
	</div>
	<!-- 	End Add Comment -->
 	<?php } else { echo '<a href="login.php">Login</a> or <a href="login.php">Register</a> To Add Comment'; } ?>
	<hr class="custom-hr">
	<?php
				// Select All Comments

	  		$stmt = $con->prepare("SELECT 
	  									Comments.*, users.Username AS Member
	  								FROM
	  									comments
	  								INNER JOIN
	  									users
	  								ON
	  									users.UserID = comments.user_id
	  								WHERE 
	  									item_id = ?
	  								AND
	  									status = 1
	  								ORDER BY
	  									 c_id DESC");
	  		$stmt->execute(array($item['Item_ID']));
	  		$comments = $stmt->fetchAll();
	  		
		?>
	
		<?php foreach ($comments as $comment) { ?>
			<div class="comment-box">
				<div class="row">
					<div class="col-sm-2 text-center">
						<img class="img-responsive img-thumbnail img-circle center-block" src="img.png" alt="" />
						<?php echo $comment['Member'] ?></div>
		  			<div class="col-sm-10">
		  				<p class="lead"><?php echo $comment['comment'] ?></p>
		  			</div>
		  		</div> 
	  		</div>
	  		<hr class="custom-hr">
	  	<?php 	} ?>
</div>

<?php 
	} else {
		echo '<div class="container">';
			echo '<div class="alert alert-danger">There\'s no Such ID Or This Item Is Waiting Approvel</div>';
		echo '</div>';
	}
  	include $tpl . '/Footer.php';

?>