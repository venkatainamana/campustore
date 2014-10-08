<?php

try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=campustore', 'steven', 'lxy654321');
} catch(PDOException $e) {
    exit('Database error.');
}
?>
