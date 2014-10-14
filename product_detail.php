<?php

include_once('includes/connection.php');
include_once('includes/product.php');
$product = new Product();


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $data = $product->fetch_data($id);
    include('includes/header.php');
?>


	<h2><?php echo $data['name'];?></h2>	
	        <small>posted
		   <?php 
			date_default_timezone_set('America/Detroit');
			echo date('l jS', $data['create_date']);?>
		</small>
	<p>
	    <?php echo $data['description'];?>
	</p>
	<a href="order.php">Order</a>
	<a href="index.php">Back</a>
<?php
    include('includes/footer.php');
} else {
    header('Location: index.php');
    exit();
}


?>
