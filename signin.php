<?php
session_start();
include_once("includes/connection.php");

if (isset($_POST['email'], $_POST['password'])) {
	$username = $_POST['email'];
	$password = md5($_POST['password']);
	
	if (empty($username) or empty($password)) {
	    $error = "email or password is empty!";
	} else {
	    $query = $pdo->prepare("SELECT * FROM user WHERE email = ? and password = ?");
	    $query->bindValue(1, $username);
	    $query->bindValue(2, $password);
	    $query->execute();
	    $num = $query->rowCount();

	    if ($num == 1) {
		$_SESSION['logged_in'] = true;
		$users = $query->fetchall();
		$user_type = $users[0]['type'];
            /* Added user id to session variable  - Change by ramyaps*/
        $_SESSION['user_id'] = $users[0]['id'];
            /* End of change by ramyaps*/

		if($user_type == "admin") {
		    //echo "admin";
		    header("Location: admin/index.php");
		} else {
		    //echo "regular";
		    header("Location: home_page.php");
		}
		
	    } else {
		$error = "username and password don't match!";
	    }
	}
    }
    
    include('includes/header.php');
?>
	<br /><br />

	<?php if (isset($error)) {?>
	    <small style="color:#aa0000;"><?php echo $error;?>
	    <br />
	<?php } ?>

	<form action="signin.php" method="post" autocomplete="off">
	     <input type="text" name="email" placeholder="Email">
	     <br /><br />
	     <input type="password" name="password" placeholder="Password">
	     <br /><br />
	     <input type="submit" value="Login">
	     &nbsp;&nbsp;
	     <a href="signup.php">Sign up</a>
	</form>
	
<?php
    include('includes/footer.php');
?>
