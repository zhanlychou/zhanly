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

// GET RECORD
if(isset($_GET['id'])){
    $id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM egg_production WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Egg Record</title>
    <link rel="stylesheet" href="../css/eggs.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="header">
    <div class="title">
        <img src='../css/logo.png' alt=''>
        <h1>Edit Egg Production</h1>
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

<div class="eggs-table">
    <h2>Edit Egg Production</h2>
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
            <label for="total_eggs">Total Eggs: </label>
            <input type="number" name="total_eggs" min="0" value="<?php echo $row['total_eggs']; ?>" required>
        </div>
        <br>

        <div class="input-group">
            <label for="damaged_eggs">Damaged Eggs: </label>
            <input type="number" name="damaged_eggs" min="0" value="<?php echo $row['damaged_eggs']; ?>" required>
        </div>
        <br>

        <button type="submit" name="update" class="addegg_button">
            <i class="fa-solid fa-pen"></i> Update Record
        </button>

    </form>
</div>

</body>
</html>