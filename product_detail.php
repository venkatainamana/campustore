<?php

include_once('includes/connection.php');
include_once('includes/product.php');
$product = new Product();


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $data = $product->fetch_data($id);
    include('includes/header.php');
    //fetch the image file-path for the given product id from picture table
    $image = $product->fetch_image($id);

    $query = $pdo->prepare("SELECT * FROM user WHERE id = ?");
    $query->bindValue(1, $data['user_id']);
    $query->execute() or die(print_r($query->errorInfo(), true));
    $user = $query->fetch();


?>
    <html>
    <body>
    <div class="display_product">
        <ul class="product_detail">
            <li>
                <img height="100%" width="100%" src="<?php echo $image['path']?>" alt="product image" class="product">

            </li>
            <li>
                <h3><?php echo $data['name']?></h3>
                <p><?php echo $data['description']?></p>
                <p>Sold by &nbsp;<a href=""><?php echo $user['first_name']." ".$user['last_name'] ?></a> </p>
                <em>User Feedback </em><br><br>
                <p>Price: &nbsp;&dollar; <?php echo $data['price'] ?> </p>
                <p>Quantity: &nbsp;<?php echo $data['quantity']?> </p>
            </li>
        </ul><br>
        <a href="order.php">Order</a>
        <a href="index.php">Back</a>
    </div>
    </body>
    </html>

<!--	<h2>--><?php //echo $data['name'];?><!--</h2>	-->
<!--	        <small>posted-->
<!--		   --><?php //
//			date_default_timezone_set('America/Detroit');
//			echo date('l jS', $data['create_date']);?>
<!--		</small>-->
<!--	<p>-->
<!--	    --><?php //echo $data['description'];?>
<!--	</p>-->

<?php
    include('includes/footer.php');
} else {
    header('Location: index.php');
    exit();
}


?>
