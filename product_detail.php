<?php
session_start();
include_once('includes/connection.php');
include_once('includes/product.php');
include_once('includes/header.php');
$product = new Product();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $data = $product->fetch_data($id); //fetch product data

    //fetch the image file-path for the given product id from picture table
    $image = $product->fetch_image($id);

    if (isset($_GET['action']) && ($_GET['action'] == 'order')) {
        //check if user has logged in
        if (isset($_SESSION['logged_in'])) {
            //Fetching the user id from the session variable
            $user_id = $_SESSION['user_id'];
            date_default_timezone_set('America/Detroit');

            $query = $pdo->prepare("INSERT INTO orders (buyer_id, product_id, date_time, status, total_price, quantity) VALUES (?,?,?,?,?,?)");
            $query->bindValue(1, $user_id);
            $query->bindValue(2, $id);
            $query->bindValue(3, date("Y-m-d H:i:s"));
            $query->bindValue(4, "Ordered");
            $query->bindValue(5, $data['price']);
            $query->bindValue(6, $data['quantity']);
            $query->execute() or die(print_r($query->errorInfo(), true));

            $order_id = $pdo->lastInsertId();
            header("Location: order.php?orderFilter=active");
            exit;
        }else{
            header("Location: signin.php");
            exit;
        }
    }

    $query = $pdo->prepare("SELECT * FROM user WHERE id = ?");
    $query->bindValue(1, $data['user_id']);
    $query->execute() or die(print_r($query->errorInfo(), true));
    $user = $query->fetch();

?>
    <html>
    <body>
    <div id="display_product" class="container">
        <ul class="nostyle_horizontal">
            <li>
                <img height="100%" width="100%" src="<?php echo $image['path']?>" alt="product image" class="product">

            </li>
            <li>
                <h3><?php echo $data['name']?></h3>
                <p><?php echo $data['description']?></p>
                <p>Sold by &nbsp;<a href=""><?php echo $user['first_name']." ".$user['last_name'] ?></a> </p>
                <em>User Feedback </em><br><br>
                <p>Price: &nbsp;&dollar; <?php echo $data['price'] ?> </p>
                <p>Quantity: &nbsp;<?php echo $data['quantity']?> </p><br><br>
                <a href="product_detail.php?id=<?php echo $data['id']; ?>&action=order">Order</a>
                <a href="index.php">Back</a>
            </li>
        </ul><br>
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
