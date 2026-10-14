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

if(isset($_POST['update'])){

    $id = $_POST['id'];
    $date = $_POST['date'];
    $total = $_POST['total_eggs'];
    $damaged = $_POST['damaged_eggs'];

    // VALIDATION
    if(empty($date) || $total === "" || $damaged === ""){
        echo "All fields are required!";
    } else {

        $stmt = $conn->prepare("UPDATE egg_production SET date=?, total_eggs=?, damaged_eggs=? WHERE id=?");
        $stmt->bind_param("siii", $date, $total, $damaged, $id);
        $stmt->execute();

        header("Location: index.php");
        exit();
    }
}
?>