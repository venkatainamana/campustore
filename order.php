<?php
session_start();
//echo "check if the item is still available.<br>
//if it is, then change its status to ordered.<br>
//Then display the contact info of the seller.<br>";
include_once('includes/connection.php');
include_once('includes/product.php');
include_once('includes/user.php');

//instantiate Product and User class.
$product = new Product();
$user = new User();

//get the action to be performed - BUY or CANCEL order
$action = (isset($_GET['action'])) ? $_GET['action'] :"";
date_default_timezone_set('America/Detroit');

//check if user has logged in
if (isset($_SESSION['logged_in'])) {
    //Fetching the user id from the session variable
    $buyer_id = $_SESSION['user_id'];

    //If the action is BUY, fetch the product id from $_GET
    if (isset($_GET['id']) && $action == 'buy' ) {
        $id = $_GET['id'];
        $quantity = $_GET['quantity'];
        $product_data = $product->fetch_data($id);          //fetch product data
        $image = "./uploads/icons/".$product_data['icon'];  // get the file path of image icon

        $query = $pdo->prepare("SELECT SUM(quantity) AS bought FROM orders WHERE product_id = ? AND (`status` = ? OR `STATUS` = ?) GROUP BY product_id;");
        $query->bindValue(1, $id);
        $query->bindValue(2, 'Ordered');
        $query->bindValue(3, 'Delivered');
        $query->execute() or die(print_r($query->errorInfo()));

        $quantity_bought = $query->fetch(PDO::FETCH_ASSOC);

        //find the quantity available
        $quantity_available = $product_data['quantity'] - $quantity_bought['bought'];

        $price = $quantity * $product_data['price'];
        $seller_data = $user->fetch_user($product_data['user_id']);   //fetch the seller details

        //if the product is still available
        if($product_data['order_status'] === 'Available' && ($quantity <= $quantity_available)) {

            //Create new order
            $query = $pdo->prepare("INSERT INTO orders (buyer_id, product_id, date_time, status, total_price, quantity) VALUES (?,?,?,?,?,?)");
            $query->bindValue(1, $buyer_id);
            $query->bindValue(2, $id);
            $query->bindValue(3, date("Y-m-d H:i:s"));
            $query->bindValue(4, "Ordered");
            $query->bindValue(5, $price);
            $query->bindValue(6, $quantity);
            $query->execute() or die(print_r($query->errorInfo(), true));

            $order_id = $pdo->lastInsertId();    // fetch the newly created Order ID

            if($quantity == $quantity_available){
                // Update the status in product table as "Not available"
                $query = $pdo->prepare("UPDATE product SET order_status = ? WHERE id = ?");
                $query->bindValue(1, "Not Available");
                $query->bindValue(2, $id);
                $query->execute() or die(print_r($query->errorInfo(), true));
            }

            $query = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
            $query->bindValue(1, $order_id);
            $query->execute() or die(print_r($query->errorInfo()));

            $order_data = $query->fetch(PDO::FETCH_ASSOC);
        } else {
            header("Location: product_detail.php?id=".$id);
            die();
        }

        $page_title = "Webshelf-Order details";
        include_once('includes/header.php');

        print("<br><h3 class='center_align'>Order placed Successfully!! </h3>");

    }
    //If the action to be performed is to CANCEL an order
    // Get the order Id from the $_GET
    elseif(isset($_GET['order_id']) && $action == 'cancel'){
        $order_id = $_GET['order_id'];
        //fetch the order details
        $query = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
        $query->bindValue(1, $order_id);
        $query->execute() or die(print_r($query->errorInfo()));
        $order_data = $query->fetch(PDO::FETCH_ASSOC);

        //fetch product data
        $product_data = $product->fetch_data($order_data['product_id']);
        $image = "./uploads/icons/".$product_data['icon'];
        $seller_data = $user->fetch_user($product_data['user_id']);   //fetch the seller details

        //Update the status as AVAILABLE in product table
        $order_data = $query->fetch(PDO::FETCH_ASSOC);
        $query = $pdo->prepare("UPDATE product SET order_status = ?, next_time = ? WHERE id = ?");
        $query->bindValue(1, "Available");
        $query->bindValue(2, date("Y-m-d H:i:s"));
        $query->bindValue(3, $product_data['id']);
        $query->execute() or die(print_r($query->errorInfo()));

        //Update the order status as CANCELLED in orders table
        $query = $pdo->prepare("UPDATE orders SET `status` = ? WHERE id = ?");
        $query->bindValue(1, "Cancelled");
        $query->bindValue(2, $order_id);
        $query->execute() or die(print_r($query->errorInfo()));

        $page_title = "Webshelf-Order Cancellation";
        include_once('includes/header.php');

        print("<br><h3 class='center_align'> Order cancelled!! </h3>");

    }
?>
<!--Display the details    -->
    <div class="left_column display_inline">
        <img height="150px" width="100px" src="<?php echo $image?>" alt="product image" class="product">
    </div>
    <div class="display_inline center_column text_wrap">
        <h3><?php echo $product_data['name']?></h3>
        <p>Seller: &nbsp;<a href=""><?php echo $seller_data['first_name']." ".$seller_data['last_name'] ?></a> </p>
    </div>
    <br><br>
    &nbsp;&nbsp;&nbsp;&nbsp;View <a href="order_detail.php?order_id=<?php echo $order_id ?>">Order</a> detail.<br>
    &nbsp;&nbsp;&nbsp;&nbsp;Go <a href="index.php">Back</a>
<?php
    include_once("includes/footer.php");
} else{
    header("Location: signin.php");
    exit;
}
?>