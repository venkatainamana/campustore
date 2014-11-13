<?php
session_start();
include_once('includes/connection.php');
include_once('includes/product.php');
include_once('includes/user.php');

//instantiate Product and User class.
$product = new Product();
$user = new User();

//Check if the user has logged in
if(isset($_SESSION['logged_in'])) {
    $page_title = "Webshelf-Order History";
    include('includes/header.php');
    //Get the filter for order status
    $filter = isset($_GET['filter']) ? $_GET['filter'] :'';
    $user_id = $_SESSION['user_id'];

    if(empty($filter)) {
        //fetch active orders
        $query = $pdo->prepare("SELECT o.id, o.date_time, p.name FROM orders AS o JOIN product AS p ON o.product_id = p.id WHERE buyer_id = ? AND status = ? ORDER BY o.id");
        $query->bindValue(1, $user_id);
        $query->bindValue(2, 'Ordered');
        $query->execute() or die(print_r($query->errorInfo()));

        $purchase = $query->fetchAll(PDO::FETCH_ASSOC);

    }
    elseif($filter == 'Delivered'){
        //fetch completed orders
        $query = $pdo->prepare("SELECT o.id, o.date_time, p.name FROM orders AS o JOIN product AS p ON o.product_id = p.id WHERE buyer_id = ? AND status = ? ORDER BY o.id");
        $query->bindValue(1, $user_id);
        $query->bindValue(2, 'Delivered');
        $query->execute() or die(print_r($query->errorInfo()));

        $purchase = $query->fetchAll(PDO::FETCH_ASSOC);
    }
    elseif($filter == 'Cancelled'){
        //fetch cancelled orders
        $query = $pdo->prepare("SELECT o.id, o.date_time, p.name FROM orders AS o JOIN product AS p ON o.product_id = p.id WHERE buyer_id = ? AND status = ? ORDER BY o.id");
        $query->bindValue(1, $user_id);
        $query->bindValue(2, 'Cancelled');
        $query->execute() or die(print_r($query->errorInfo()));

        $purchase = $query->fetchAll(PDO::FETCH_ASSOC);
    }
    print("<div class='center_column'>");
    print("<br>&nbsp;&nbsp;<a href='account_menu.php' id='account'>Your Account</a>&nbsp;&gt;&nbsp;<span style='color: indianred'>Orders</span>");
    print("<h3>List of Purchase Orders</h3>");
    print("<a href='order_history.php'". ($filter=='' ? "style='color: indianred'>" : ">")."Active</a>&nbsp;&nbsp;&nbsp;&nbsp;");
    print("<a href='order_history.php?filter=Delivered'". ($filter=='Delivered' ? "style='color: indianred'>" : ">")."Completed</a>&nbsp;&nbsp;&nbsp;&nbsp;");
    print("<a href='order_history.php?filter=Cancelled'". ($filter=='Cancelled' ? "style='color: indianred'>" : ">")."Cancelled</a>");
    print("<br><br><table><tr><th>Order Id</th><th>Product</th><th>Date</th></tr>");
    foreach($purchase AS $row){
        print("<tr>");
        print("<td><a href='order_detail.php?order_id=".$row['id']."'>".$row['id']."</a></td><td>".$row['name']."</td><td>".$row['date_time']."</td>");
        print("</tr>");
    }
    print("</table>");
    print("</div>");
    ?>
<!--       <br><br><br>-->
<!--        <p>Display the order history of a user </p>-->


<?php
    include('includes/footer.php');
} else {
    include("signin.php");
}
?>
