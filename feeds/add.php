<?php
session_start(); 
// Starts session to access logged-in user data

if(!isset($_SESSION['user'])){ 
// Checks if user is NOT logged in

    header("Location: ../login.php"); 
    // Redirects to login page (since this file is inside a folder, use ../)

    exit(); 
    // Stops execution
}

$conn = new mysqli("localhost", "root", "", "poultryease"); 
// Connects to the database

if(isset($_POST['add'])){ 
// Checks if Add button is clicked

    $date = $_POST['date']; 
    // Gets the date input

    $type = $_POST['feed_type']; 
    // Gets the feed type input

    $qty = $_POST['quantity']; 
    // Gets the quantity input

    $cost = $_POST['cost']; 
    // Gets the cost input

    $stmt = $conn->prepare("INSERT INTO feeds (date, feed_type, quantity, cost) VALUES (?, ?, ?, ?)"); 
    // Prepares SQL query to insert feed data

    $stmt->bind_param("ssdd", $date, $type, $qty, $cost); 
    // Binds parameters:
    // s = string (date, feed_type)
    // d = double/decimal (quantity, cost)

    $stmt->execute(); 
    // Executes the insert query

    header("Location: index.php"); 
    // Redirects back to feed list page after adding

}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Feed</title>
    <link rel="stylesheet" href="../css/feeds.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="header">
    <div class="title">
        <img src='../css/logo.png' alt=''>
        <h1>Add Feed</h1>
    </div>
    
    <div class="user">
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?></p> |
        <a href="../logout.php">Logout</a>
    </div>
</div>

<div class="navigation_container">
    <div class="navigation">
        <a href="index.php">Back</a>
    </div>
</div>

<div class="sales-table">
    <h2>Add Feed</h2>
    <hr>
    <br>

    <form method="POST">

        <div class="input-group">
            <label for="date">Date: </label>
            <input type="date" name="date" required>
        </div>
        <br>

        <div class="input-group">
            <label for="feed_type">Feed Type: </label>
            <input type="text" name="feed_type" required>
        </div>
        <br>

        <div class="input-group">
            <label for="quantity">Quantity: </label>
            <input type="number" step="0.01" name="quantity" min="0" value="0" required>
        </div>
        <br>

        <div class="input-group">
            <label for="cost">Cost: </label>
            <input type="number" step="0.01" name="cost" min="0" value="0" required>
        </div>

        <div class="button-group">
            <button type="submit" name="add" class="sales_button">
                <i class="fa-solid fa-plus"></i> Add Feed
            </button>
        </div>

    </form>
</div>

</body>
</html>