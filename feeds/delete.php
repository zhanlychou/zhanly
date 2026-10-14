<?php
session_start(); 
// Starts session to access user login data

if(!isset($_SESSION['user'])){ 
// Checks if user is NOT logged in

    header("Location: ../login.php"); 
    // Redirects to login page

    exit(); 
    // Stops execution
}

$conn = new mysqli("localhost", "root", "", "poultryease"); 
// Connects to the database

$id = $_GET['id']; 
// Gets the ID of the record to delete from the URL (e.g., delete.php?id=1)

$stmt = $conn->prepare("DELETE FROM feeds WHERE id=?"); 
// Prepares SQL query to delete a record based on ID

$stmt->bind_param("i",$id); 
// Binds the ID parameter (i = integer)

$stmt->execute(); 
// Executes the delete query

header("Location: index.php"); 
// Redirects back to the feed list page after deletion
?>