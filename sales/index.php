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

    $stmt = $conn->prepare("SELECT * FROM sales WHERE customer_name LIKE ?");
    $like = "%".$search."%";
    $stmt->bind_param("s",$like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM sales ORDER BY date DESC");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sales</title>
    <link rel="stylesheet" href="../css/sales.css">
</head>
<body>

<div class="header">
    <div class="title">
        <img src='../css/logo.png' alt=''>
        <h1>Sales</h1>
    </div>
    
    <div class="user">
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?></p> |
        <a href="../logout.php">Logout</a>
    </div>
</div>

<div class="navigation_container">
    <div class="navigation">
        <a href="../main.php">Back to Dashboard</a> 
        <a href="add.php" class="btn add-record">Add Sale</a>
    </div>

    <!-- SEARCH -->
    <div class="search">
        <form method="GET">
            <label for="search">Search Customer:</label>
            <input type="text" name="search" value="<?php echo $search; ?>">
            <button type="submit" class="btn search-record">Search</button>
        </form>
    </div>
</div>

<!-- TABLE -->
<table class="sales-table" border="1">
<tr>
    <th>ID</th>
    <th>Date</th>
    <th>Customer</th>
    <th>Trays</th>
    <th>Half Trays</th>
    <th>Price</th>
    <th>Total</th>
    <th>Action</th>
</tr>

<?php if ($result->num_rows > 0): ?>
    <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['date']); ?></td>
            <td><?php echo htmlspecialchars($row['customer_name']); ?></td>
            <td><?php echo $row['trays']; ?></td>
            <td><?php echo $row['half_trays']; ?></td>
            <td><?php echo $row['price_per_tray']; ?></td>
            <td><?php echo $row['total_amount']; ?></td>
            <td>
                <a href="edit.php?id=<?php echo $row['id']; ?>">Edit</a> |
                <a href="delete.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Delete this record?')">Delete</a>
            </td>
        </tr>
    <?php endwhile; ?>
<?php else: ?>
<tr>
    <td colspan="8">No records found</td>
</tr>
<?php endif; ?>

</table>

</body>
</html>