<?php
session_start();

if(isset($_SESSION['logged_in'])) {
    include('includes/header.php');
?>
       <br><br><br>
        <p>update personal info </p>
	
<?php
    include('includes/footer.php');
} else {
    include('signin.php');
}
?>
