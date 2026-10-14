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
    $customer = $_POST['customer'];
    $trays = $_POST['trays'];
    $half = $_POST['half_trays'];
    $price = $_POST['price'];

    $total = ($trays + ($half / 2)) * $price;

    $stmt = $conn->prepare("UPDATE sales SET date=?, customer_name=?, trays=?, half_trays=?, price_per_tray=?, total_amount=? WHERE id=?");
    $stmt->bind_param("ssiiidi", $date, $customer, $trays, $half, $price, $total, $id);
    $stmt->execute();

    header("Location: index.php");
}
?>