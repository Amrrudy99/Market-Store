<?php 
	session_start();
  $NoNavbar = '';
  $PageTitle = 'Login';

	if (isset($_SESSION['Username'])) {
	  	header('Location: dashboard.php'); // Redirect To Dashboard Page
	}
	
    include 'init.php';
	 

	//Check If User Coming From HTTP Post Request 
    
    if ($_SERVER['REQUEST_METHOD']=='POST'){

    	$username 	= $_POST['user'];
    	$password 	= $_POST['pass'];
    	$hashedPass = sha1($password);
    	

    //Check If User Exist In DataBase
       
       $stmt = $con->prepare("SELECT
                                     UserID, UserName , Password 
                                    FROM
                                       users 
                                    WHERE
                                        UserName = ?
                                    AND 
                                        Password = ? 
                                    AND
                                        GroupID = 1
                                    LIMIT 1");

       $stmt->execute(array($username,$hashedPass));
       $row   = $stmt->fetch();
       $count = $stmt->rowCount();

        // IF Count > 0 This Mean The DataBase Contain Record About This UserName    :)

        if ($count > 0){
          $_SESSION['Username'] = $username;  //Register Session Name
          $_SESSION['ID'] = $row['UserID'];   //Register Session ID
          header('Location: dashboard.php'); // Redirect To Dashboard Page
          exit(); 
        }        
    }


?>
	<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
		<H4 class="text-center">Admin Login</H4>
		<input class="form-control "  type="text"     name="user"      placeholder="Username" autocomplete="off" />
		<input class="form-control "  type="password" name="pass"  placeholder="Password" autocomplete="new-password">
		<input class="btn btn-primary btn-block"  type="submit"   value="Login">
	</form>
 		

<?php include $tpl . '/Footer.php'; ?>