<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "poultryease");

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM chickens WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Chicken Batch</title>
    <link rel="stylesheet" href="../css/chickens.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="header">
    <div class="title">
        <img src='../css/logo.png' alt=''>
        <h1>Edit Chicken Batch</h1>
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
    <h2>Edit Chicken Batch</h2>
    <hr>
    <br>

    <form method="POST" action="update.php">

        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

        <div class="input-group">
            <label for="batch_name">Batch Name: </label>
            <input type="text" name="batch_name" value="<?php echo $row['batch_name']; ?>" required>
        </div>
        <br>

        <div class="input-group">
            <label for="total_chicken">Total Chickens: </label>
            <input type="number" name="total_chicken" value="<?php echo $row['total_chicken']; ?>" required>
        </div>
        <br>

        <div class="input-group">
            <label for="mortality">Mortality: </label>
            <input type="number" name="mortality" value="<?php echo $row['mortality']; ?>" required>
        </div>

        <div class="button-group">
            <button type="submit" name="update" class="sales_button">
                <i class="fa-solid fa-pen"></i> Update Batch
            </button>
        </div>

    </form>
</div>

</body>
</html>