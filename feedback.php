<?php
session_start();

if(isset($_SESSION['logged_in'])) {
include('includes/header.php')
?>
       <br><br><br>
        <p>Leave feedback to the seller/buyer after the order completed </p>
<?php
include('includes/footer.php');
} else {
    include("signin.php");
}
?>
