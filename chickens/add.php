<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "poultryease");

if(isset($_POST['add'])){
    $batch = $_POST['batch_name'];
    $total = $_POST['total_chicken'];
    $mortality = $_POST['mortality'];

    $stmt = $conn->prepare("INSERT INTO chickens (batch_name, total_chicken, mortality) VALUES (?, ?, ?)");
    $stmt->bind_param("sii", $batch, $total, $mortality);
    $stmt->execute();

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Chicken Batch</title>
    <link rel="stylesheet" href="../css/chickens.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="header">
    <div class="title">
        <img src='../css/logo.png' alt=''>
        <h1>Add Chicken Batch</h1>
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
    <h2>Add Chicken Batch</h2>
    <hr>
    <br>

    <form method="POST">

        <div class="input-group">
            <label for="batch_name">Batch Name: </label>
            <input type="text" name="batch_name" required>
        </div>
        <br>

        <div class="input-group">
            <label for="total_chicken">Total Chickens: </label>
            <input type="number" name="total_chicken" min="0" value="0" required>
        </div>
        <br>

        <div class="input-group">
            <label for="mortality">Mortality: </label>
            <input type="number" name="mortality" min="0" value="0" required>
        </div>

        <div class="button-group">
            <button type="submit" name="add" class="sales_button">
                <i class="fa-solid fa-plus"></i> Add Batch
            </button>
        </div>

    </form>
</div>

</body>
</html>