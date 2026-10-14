<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "poultryease");

if(isset($_POST['update'])){
    $id = $_POST['id'];
    $batch = $_POST['batch_name'];
    $total = $_POST['total_chicken'];
    $mortality = $_POST['mortality'];

    $stmt = $conn->prepare("UPDATE chickens SET batch_name=?, total_chicken=?, mortality=? WHERE id=?");
    $stmt->bind_param("siii", $batch, $total, $mortality, $id);
    $stmt->execute();

    header("Location: index.php");
}
?>