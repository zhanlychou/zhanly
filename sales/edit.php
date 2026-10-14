<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "poultryease");

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM sales WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Sale</title>
    <link rel="stylesheet" href="../css/sales.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="header">
    <div class="title">
        <img src='../css/logo.png' alt=''>
        <h1>Edit Sale</h1>
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
    <h2>Edit Sale</h2>
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
            <label for="customer">Customer: </label>
            <input type="text" name="customer" value="<?php echo $row['customer_name']; ?>" required>
        </div>
        <br>

        <div class="input-group">
            <label for="trays">Trays: </label>
            <input type="number" name="trays" value="<?php echo $row['trays']; ?>" required>
        </div>
        <br>

        <div class="input-group">
            <label for="half_trays">Half Trays: </label>
            <input type="number" name="half_trays" value="<?php echo $row['half_trays']; ?>" required>
        </div>
        <br>

        <div class="input-group">
            <label for="price">Price per Tray: </label>
            <input type="number" name="price" value="<?php echo $row['price_per_tray']; ?>" required>
        </div>

        <div class="button-group">
            <button type="submit" name="update" class="sales_button">
                <i class="fa-solid fa-pen"></i> Update Sale
            </button>
        </div>

    </form>
</div>

</body>
</html>