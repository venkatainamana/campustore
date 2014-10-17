<?php
session_start();

if(isset($_SESSION['logged_in'])) {
include("includes/header.php");
?>
       <br><br><br>
        <p>Edit a posted item by seller </p><br>
        <a href=".php">update</a><br>                                                             
<?php              
include("includes/footer.php");                                           
} else {                                                      
    include("signin.php");                                    
}                                                             

?>                                                            
     
