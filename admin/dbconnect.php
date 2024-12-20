<?php
$server = "localhost";
$port = 3306;
$user = "root";
$password = "";
try {
    $conn = new PDO("mysql:host=$server;port=$port;dbname=b100test", $user, $password);
    // echo "Successfully Connected!";
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>;