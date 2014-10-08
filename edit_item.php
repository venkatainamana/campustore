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
        <p>Edit a posted item by seller </p><br>
        <a href=".php">update</a><br>
    </div>                                                    
</body>                                                       
                                                              
</html>                                                       
                                                              
<?php                                                         
} else {                                                      
    include("signin.php");                                    
}                                                             
?>                                                            
     
