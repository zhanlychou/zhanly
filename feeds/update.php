<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "poultryease");

if(isset($_POST['update'])){
    $id = $_POST['id'];
    $date = $_POST['date'];
    $type = $_POST['feed_type'];
    $qty = $_POST['quantity'];
    $cost = $_POST['cost'];

    $stmt = $conn->prepare("UPDATE feeds SET date=?, feed_type=?, quantity=?, cost=? WHERE id=?");
    $stmt->bind_param("ssdsi", $date, $type, $qty, $cost, $id);
    $stmt->execute();

    header("Location: index.php");
}
?>