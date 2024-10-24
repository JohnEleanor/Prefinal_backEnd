<?php

$server = "localhost";
$user = "root";
$pass = "";
$db = "postman";

try {
    $conn = new pdo("mysql:host=$server;dbname=$db;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connect failed :" . $e->getMessage();
}
?>
