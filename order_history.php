<?php
session_start();

if(isset($_SESSION['logged_in'])) {
    include('includes/header.php');
?>
       <br><br><br>
        <p>Display the order history of a user </p>
    </div>
</body>

</html>

<?php
    include('includes/footer.php');
} else {
    include("signin.php");
}
?>
