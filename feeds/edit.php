<?php
session_start(); 
// Starts session to access logged-in user data

if(!isset($_SESSION['user'])){ 
// Checks if user is NOT logged in

    header("Location: ../login.php"); 
    // Redirects to login page

    exit(); 
    // Stops script execution
}

$conn = new mysqli("localhost", "root", "", "poultryease"); 
// Connects to the database

$id = $_GET['id']; 
// Gets the ID from URL (e.g., edit.php?id=1)

$stmt = $conn->prepare("SELECT * FROM feeds WHERE id=?"); 
// Prepares SQL query to get feed record by ID

$stmt->bind_param("i",$id); 
// Binds ID parameter (i = integer)

$stmt->execute();  // Executes query

$res = $stmt->get_result();  // Gets result set

$row = $res->fetch_assoc(); // Fetches the row as an associative array
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Feed</title>
    <link rel="stylesheet" href="../css/feeds.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="header">
    <div class="title">
        <img src='../css/logo.png' alt=''>
        <h1>Edit Feed</h1>
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
    <h2>Edit Feed</h2>
    <hr>
    <br>

    <form method="POST" action="update.php">

        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

        <div class="input-group">
            <label for="date">Date: </label>
            <input type="date" name="date" value="<?php echo $row['date']; ?>" required>
        </div>
        <br>

        <div class="input-group">
            <label for="feed_type">Feed Type: </label>
            <input type="text" name="feed_type" value="<?php echo $row['feed_type']; ?>" required>
        </div>
        <br>

        <div class="input-group">
            <label for="quantity">Quantity: </label>
            <input type="number" name="quantity" value="<?php echo $row['quantity']; ?>" required>
        </div>
        <br>

        <div class="input-group">
            <label for="cost">Cost: </label>
            <input type="number" name="cost" value="<?php echo $row['cost']; ?>" required>
        </div>

        <div class="button-group">
            <button type="submit" name="update" class="sales_button">
                <i class="fa-solid fa-pen"></i> Update Feed
            </button>
        </div>

    </form>
</div>

</body>
</html>