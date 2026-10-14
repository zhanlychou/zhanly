<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "poultryease");

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM sales WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();

header("Location: index.php");
?>