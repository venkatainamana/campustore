<?php
session_start();
include_once("includes/connection.php");

if (isset($_POST['email'], $_POST['nick_name'], $_POST['first_name'], $_POST['last_name'], $_POST['password'])) {
	$email = $_POST['email'];
	$password = md5($_POST['password']);
	$confirm_password = md5($_POST['confirm_password']);
	$nick_name = $_POST['nick_name'];
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];	
        $phone = $_POST['phone'];
        $address = $_POST['address'];

	if (empty($email) or empty($password) or empty($confirm_password) or empty($nick_name) or empty($first_name) or empty($last_name) or empty($phone) or empty($address)) {
	    $error = "You must fill all the fields!";
	} else if ($password != $confirm_password){
	    $error = "password and confirm password don't match!";
	} else {
	    $query = $pdo->prepare("INSERT INTO user (email, password,nick_name, first_name, last_name, phone, address,type, status, banned_util) values (?,?,?,?,?,?,?,?,?,?)");
	    $query->bindValue(1, $email);
	    $query->bindValue(2, $password);
	    $query->bindValue(3, $nick_name);
	    $query->bindValue(4, $first_name);
	    $query->bindValue(5, $last_name);
	    $query->bindValue(6, $phone);
	    $query->bindValue(7, $address);
	    $query->bindValue(8, 'regular');
	    $query->bindValue(9, 'normal');
	    $query->bindValue(10, '2050-07-24');
	    $query->execute();
	    
	    header("Location: signin.php");
	}
    }
?>
<!DOCTYPE html>
<head>
    <title>WebShelf - Sign up</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
    <div class = "container">
	<a href="index.php" id="logo">WebShelf</a>

	<br /><br />

	<?php if (isset($error)) {?>
	    <small style="color:#aa0000;"><?php echo $error;?>
	    <br />
	<?php } ?>

	<form action="signup.php" method="post" autocomplete="off">
	     <input type="text" name="email" placeholder="Email">
	     <br /><br />
	     <input type="password" name="password" placeholder="Password">
	     <br /><br />
	     <input type="password" name="confirm_password" placeholder="Confirm Password">
	     <br /><br />
	     <input type="text" name="nick_name" placeholder="Nick Name">
	     <br /><br />
	     <input type="text" name="first_name" placeholder="First Name">
	     <br /><br />
	     <input type="text" name="last_name" placeholder="Last Name">
	     <br /><br />     
             <input type="text" name="phone" placeholder="Phone Number">
	     <br /><br />     
             <input type="text" name="address" placeholder="Address">
	     <br /><br />     
     
	     <input type="submit" value="Sign up">
	</form>
    </div>
</body>
</html>
