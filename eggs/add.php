<?php
session_start();

// PROTECT PAGE
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit();
}

// DATABASE CONNECTION
$conn = new mysqli("localhost", "root", "", "poultryease");

if ($conn->connect_error) {
    die("Connection failed");
}

// ADD PROCESS
if(isset($_POST['add'])){

    $date = $_POST['date'];
    $total = $_POST['total_eggs'];
    $damaged = $_POST['damaged_eggs'];

    // VALIDATION
    if(empty($date) || $total === "" || $damaged === ""){
        echo "All fields are required!";
    } elseif($total < 0 || $damaged < 0){
        echo "Invalid input!";
    } else {

        // INSERT (Prepared Statement)
        $stmt = $conn->prepare("INSERT INTO egg_production (date, total_eggs, damaged_eggs) VALUES (?, ?, ?)");
        $stmt->bind_param("sii", $date, $total, $damaged);
        $stmt->execute();

        // REDIRECT BACK
        header("Location: index.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Egg Record</title>
    <link rel="stylesheet" href="../css/eggs.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="header">
    <div class="title">
        <img src='../css/logo.png' alt=''>
        <h1>Add Egg Production</h1>
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
    <h2>Add Egg Production</h2>
    <hr>
    <br>
    <form method="POST">

        <div class="input-group">
            <label for="Date">Date: </label>
            <input type="date" name="date" placeholder="Date" required>
        </div>
    <br>
         <div class="input-group">
            <label for="TotalEggs">Total Eggs: </label>
            <input type="number" name="total_eggs" min="0" value="0" required>
        </div>
    <br>
         <div class="input-group">
            <label for="DamagedEggs">Damaged Eggs: </label>
            <input type="number" name="damaged_eggs" min="0" value="0" required>
        </div>

    

    <div class="button-group">
            <button type="submit" name="add" class="addegg_button">
            <i class="fa-solid fa-plus"></i> Add Record
        </button>
    </div>

</form>
</div>

</body>
</html>