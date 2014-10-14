<?php
session_start();

if(isset($_SESSION['logged_in'])) {
    echo "Welcome Homepage!";
	
	include('includes/header.php');
?>
       <br><br><br>
	<p>Display the active orders and shopping cart... </p>
        <p>For each active order, provide an order detail link</p>
        <a href="order_detail.php">Order detail</a><br>
        <a href="order_history.php">Order history</a><br>
        <a href="update_personal_info.php">Update personal info</a><br>

	<p>Display the selling items</p>
	<p>for each item, provide an "Edit item" button</p>
        <a href="edit_item.php">Edit item</a><br>
        <a href="sell.php">Sell a new item</a><br>
        <a href="signout.php">Signout</a><br>
  <?php
	
	include('includes/footer.php');
} else {
    include("signin.php");
}
?>

