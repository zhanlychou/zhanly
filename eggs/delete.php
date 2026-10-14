<?php
session_start();

if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "poultryease");

if ($conn->connect_error) {
    die("Connection failed");
}

if(isset($_GET['id'])){
    $id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM egg_production WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

header("Location: index.php");
exit();
?>