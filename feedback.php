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
        <p>Leave feedback to the seller/buyer after the order completed </p>
	
    </div>
</body>

</html>

<?php
} else {
    include("signin.php");
}
?>
