<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "poultryease");

if(isset($_POST['add'])){
    $date = $_POST['date'];
    $customer = $_POST['customer'];
    $trays = $_POST['trays'];
    $half = $_POST['half_trays'];
    $price = $_POST['price'];

    // COMPUTE TOTAL
    $total = ($trays + ($half / 2)) * $price;

    $stmt = $conn->prepare("INSERT INTO sales (date, customer_name, trays, half_trays, price_per_tray, total_amount) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiiid", $date, $customer, $trays, $half, $price, $total);
    $stmt->execute();

    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Sale</title>
    <link rel="stylesheet" href="../css/sales.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="header">
    <div class="title">
        <img src='../css/logo.png' alt=''>
        <h1>Add Sale</h1>
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
    <h2>Add Sale</h2>
    <hr>
    <br>

    <form method="POST">

        <div class="input-group">
            <label for="date">Date: </label>
            <input type="date" name="date" required>
        </div>
        <br>

        <div class="input-group">
            <label for="customer">Customer: </label>
            <input type="text" name="customer" required>
        </div>
        <br>

        <div class="input-group">
            <label for="trays">Trays: </label>
            <input type="number" name="trays" min="0" value="0" required>
        </div>
        <br>

        <div class="input-group">
            <label for="half_trays">Half Trays: </label>
            <input type="number" name="half_trays" min="0" value="0" required>
        </div>
        <br>

        <div class="input-group">
            <label for="price">Price per Tray: </label>
            <input type="number" step="0.01" name="price" min="0" value="0" required>
        </div>

        <div class="button-group">
            <button type="submit" name="add" class="sales_button">
                <i class="fa-solid fa-plus"></i> Add Sale
            </button>
        </div>

    </form>
</div>

</body>
</html>