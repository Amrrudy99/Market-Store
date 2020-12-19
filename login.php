<?php
	ob_start();
	session_start();
	$PageTitle = 'Login';
	if (isset($_SESSION['user'])) {
	  	header('Location: index.php'); 
	}
	include 'init.php';

	//Check If User Coming From HTTP Post Request 
    
    if ($_SERVER['REQUEST_METHOD'] =='POST'){

    	if(isset($_POST['login'])) {

	    	$user 	= $_POST['username'];
	    	$pass	= $_POST['password'];
	    	$hashedPass = sha1($pass);



	    //Check If User Exist In DataBase
	       
	       $stmt = $con->prepare("SELECT
	                                    UserID , Username , Password 
	                                    FROM
	                                       users 
	                                    WHERE
	                                        Username = ?
	                                    AND 
	                                        Password = ? ");

	       $stmt->execute(array($user,$hashedPass));

	       $get = $stmt->fetch();

	       $count = $stmt->rowCount();

	        // IF Count > 0 This Mean The DataBase Contain Record About This UserName    :)

	        if ($count > 0){

	          $_SESSION['user'] = $user;  //Register Session Name

	          $_SESSION['UID'] = $get['UserID']; //Register User ID in Session

				header('Location: index.php'); // Redirect To Dashboard Page

	            exit(); 
	        }   
	    } else {

	    	$formErrors = array();

	    	$username  = $_POST['username'];
	    	$password  = $_POST['password'];
	    	$password2 = $_POST['confirm-password'];
	    	$email     = $_POST['email'];

	    	if (isset($username) ) {

	    		$filterdUser = filter_var($username , FILTER_SANITIZE_STRING);

	    		if (strlen($filterdUser) < 4 ) {

	    			$formErrors[] = 'Username Must Be Larger Than 4 Characters';

	    		}
	    	}

	    	if (isset($password) && isset($password2) ) {

	    		if ( empty($password)){

	    			$formErrors[] = 'Sorry Password Cant\' Be Empty'; 

	    		}

	    		if (sha1($password) !== sha1($password2) ) {

	    			$formErrors[] = 'Sorry Password Is Not Match';

	    		}
	    	}

	    	if (isset($email) ) {

	    		$filterdEmail = filter_var($email, FILTER_SANITIZE_EMAIL);

	    		if (filter_var($filterdEmail, FILTER_VALIDATE_EMAIL) != true) {

	    			$formErrors[] = 'This Email Is Not Valid';

	    		}
	    	}

	    	// Check IF There's No Error Proceed The User ADD

				if (empty($formErrors))
				{

				// Check If User Exist In DataBase

					$check = checkItem("Username", "users" , $username);

					if ($check == 1)
					{

						$formErrors[] = 'Sorry This User Is Exist';

					}
					else
					{

						// Insert User Info In Data Base

							$stmt = $con->prepare("INSERT INTO
													 	users(Username,Password,Email, RegStatus, Date)
													 	VALUES(:zuser, :zpass, :zmail, 0 , now()) ");
							$stmt->execute(array(

								'zuser' => $username,
								'zpass' => sha1($password),
								'zmail' => $email
							));


						 // Echo Success Message

						 $succesMsg = 'Congrats You Are Now Registerd User';

				    }

			    }

	    }
   }

?>

	<div class="container login-page">
		<h1 class="text-center">
			<span class="active" data-class="login">Login</span> |	
			<span data-class="signup">SignUp</span>
		</h1>
		<!--------------------------------------          Start Login Form       ---------------------------------------------------------------->
		<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
			<div class="input-container">
				<input class="form-control" type="text" name="username" autocomplete="off" placeholder="username" />
			</div>
			<div class="input-container">
			<input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="password" />
			</div>
			<input class="btn btn-primary btn-block" name="login" type="submit" value="Login" />
		</form>
		<!--------------------------------------          End Login Form       ---------------------------------------------------------------->

		<!--------------------------------------          Start Sign Up Form       ----------------------------------------------------------->
		<form class="signup" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
			<div class="input-container">
			<input pattern=".{3,}" title="Username Must Be 3 Chars" class="form-control" type="text" name="username" autocomplete="off" placeholder="username" required />
		    </div>
		    <div class="input-container">
			<input minlength="4" class="form-control" type="password" name="password" autocomplete="new-password" placeholder="password" required />
			</div>
			<div class="input-container">
			<input minlength="3" class="form-control" type="password" name="confirm-password" autocomplete="new-password" placeholder="confirm password" required />
			</div>
			<div class="input-container">
			<input class="form-control" type="email" name="email" placeholder="email" />
			</div>
			<input class="btn btn-success btn-block" name="signup" type="submit" value="Sign Up" />
		</form>
		<div class="the-errors text-center">
			<?php 
				if (!empty($formErrors)) {
					foreach ($formErrors as $error) {
						echo $error . '</br>';
					}
				}

				if (isset($succesMsg)) {

					echo '<div class="msg success">' . $succesMsg . '</div>';
				}
			 ?>
		</div>
	</div>
	<!--------------------------------------          End Sign Up Form       ---------------------------------------------------------------->

<?php
	
	include $tpl . 'footer.php' ;
	ob_end_flush();

?>