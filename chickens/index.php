<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: ../login.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "poultryease");

// SEARCH
$search = "";
if(isset($_GET['search'])){
    $search = $_GET['search'];

    $stmt = $conn->prepare("SELECT * FROM chickens WHERE batch_name LIKE ?");
    $like = "%".$search."%";
    $stmt->bind_param("s",$like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM chickens");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Chickens</title>
    <link rel="stylesheet" href="../css/chickens.css">
</head>
<body>

<div class="header">
    <div class="title">
        <img src='../css/logo.png' alt=''>
        <h1>Chicken Management</h1>
    </div>
    
    <div class="user">
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?></p> |
        <a href="../logout.php">Logout</a>
    </div>
</div>

<div class="navigation_container">
    <div class="navigation">
        <a href="../main.php">Back to Dashboard</a> 
        <a href="add.php" class="btn add-record">Add Batch</a>
    </div>

    <!-- SEARCH -->
    <div class="search">
        <form method="GET">
            <label for="search">Search Batch:</label>
            <input type="text" name="search" value="<?php echo $search; ?>">
            <button type="submit" class="btn search-record">Search</button>
        </form>
    </div>
</div>

<!-- TABLE -->
<table class="sales-table" border="1">
<tr>
    <th>ID</th>
    <th>Batch</th>
    <th>Total</th>
    <th>Mortality</th>
    <th>Active</th>
    <th>Action</th>
</tr>

<?php if ($result->num_rows > 0): ?>
    <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['batch_name']); ?></td>
            <td><?php echo $row['total_chicken']; ?></td>
            <td><?php echo $row['mortality']; ?></td>
            <td><?php echo $row['active_chickens']; ?></td>
            <td>
                <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a> |
                <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Delete this record?')">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
<?php else: ?>
<tr>
    <td colspan="6">No records found</td>
</tr>
<?php endif; ?>

</table>

</body>
</html>