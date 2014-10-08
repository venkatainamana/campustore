<?php
session_start();

if(isset($_SESSION['logged_in'])) {
?>
<!DOCTYPE html>
<head>
    <title>WebShelf</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>

    <div class="container">
        <a href="index.php" id="logo">WebShelf</a>
        <br><br><br>
        <p>Display the details of an order </p>
        <a href=".php">Cancel order</a><br>
        <a href=".php">Compelet order</a><br>
        <a href="feedback.php">Leave feedback</a><br>
    </div>                                                    
</body>                                                       
                                                              
</html>                                                       
                                                              
<?php                                                         
} else {                                                      
    include("signin.php");                                    
}                                                             
?>                                                            
     
