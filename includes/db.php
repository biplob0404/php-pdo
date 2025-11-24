<?php

try {
    $user_db = "root";
    $db_pass = "";
    $conn = new PDO("mysql:host=localhost;dbname=pdo_pp",$user_db,$db_pass);
    $conn -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    echo "Connected Successfully";
} catch (PDOException $e) {
    echo "Server not connected". $e->getMessage();
}