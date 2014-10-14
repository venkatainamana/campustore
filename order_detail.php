<?php
session_start();

if(isset($_SESSION['logged_in'])) {
include('includes/header.php');
?>
       <br><br><br>
        <p>Display the details of an order </p>
        <a href=".php">Cancel order</a><br>
        <a href=".php">Compelet order</a><br>
        <a href="feedback.php">Leave feedback</a><br>
    </div>                                                    
</body>                                                       
                                                              
</html>                                                       
                                                              
<?php                                                         
include('includes/footer.php');
} else {                                                      
    include("signin.php");                                    
}                                                             
?>                                                            
     
