<?php
session_start();
include_once('includes/connection.php');

if (isset($_SESSION['logged_in'])) {
    if(isset($_POST['title'],$_POST['content'])) {
        $title = $_POST['title'];
        $content = nl2br($_POST['content']);
        if (empty($title) or empty($content)) {
            $error = "All fields are required!";
         } else {
            $query = $pdo->prepare("INSERT INTO product (name,description,create_date,price,order_status,quantity,user_id) VALUES (?, ?, ?, ? ,?, ?, ?)");
            $query->bindValue(1, $title);
            $query->bindValue(2, $content);
            $query->bindValue(3, time());
            $query->bindValue(4, 10.0);
            $query->bindValue(5, "normal");
            $query->bindValue(6, 1);
            $query->bindValue(7, 1);

            $query->execute() or die(print_r($query->errorInfo(), true));

            header("Location: index.php");
         }
    }

    include('includes/header.php');
?>

 <br /><br />                                          
        <h4>Sell a product</h4>                                  
                                                              
        <?php if (isset($error)) { ?>                         
            <small style="color: #aa0000;"><?php echo $error;?></small>     
            <br /><br />                                      
        <?php } ?>                                            
                                                              
        <form action="sell.php" method ="post" autocomplete="off">
            <input type="text" name="title" placeholder="Title"/><br /><br />
            <textarea rows="15" name="content" cols="50" placeholder="content">
</textarea><br />
            <input type="submit" value="Add Product"/>
        </form>                                               
   </div>                                                     
</body>                                                       
</html>                                                       
                                                              
<?php                                                         
    include('includes/footer.php');
} else{                                                       
    header('Location: index.php');                            
}                                                             
                                                              
?>                    
