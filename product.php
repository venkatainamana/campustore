<?php

include_once('includes/connection.php');
include_once('includes/product.php');
$product = new Product();


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $data = $product->fetch_data($id);
?>

<html>
<head>
    <title>WebShelf</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>

    <div class="container">
        <a href="index.php" id="logo">WebShelf</a>
 
	<h2><?php echo $data['name'];?></h2>	
	        <small>posted
		   <?php 
			date_default_timezone_set('America/Detroit');
			echo date('l jS', $data['create_date']);?>
		</small>
	<p>
	    <?php echo $data['description'];?>
	</p>
	
	<a href="index.php">Back</a>
    </div>


</body>
</html>
<?php
} else {
    header('Location: index.php');
    exit();
}


?>
