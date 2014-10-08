<?php
session_start();

if(isset($_SESSION['logged_in'])) {
    echo "Welcome Homepage!";
} else {
    include("signin.php");
}
?>
