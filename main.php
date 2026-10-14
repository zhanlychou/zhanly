<?php
session_start(); 
// Starts the session to access stored user login data

if(!isset($_SESSION['user'])){ 
// Checks if the 'user' session does NOT exist (not logged in)

    header("Location: login.php"); 
    // Redirects user to login page if not logged in

    exit(); 
    // Stops the script execution
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>PoultryEase Dashboard</title> 
    <!-- Title of the webpage -->

    <link rel="stylesheet" href="css/eggs.css"> 
       <!-- Links external CSS file for styling -->
</head>

<body>

<div class="dashboard"> 
<!-- Main container for dashboard -->

    <div class="header"> 
    <!-- Header section -->
        <div class="title">
            <img src='css/logo.png' alt=''>
            <h1>PoultryEase</h1> 
        </div>
        <!-- System title -->

         <div class="user">
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?></p>|
        <a href="../logout.php">Logout</a>
    </div>
    </div>
    <div class="welcome">
        <h1>PoultryEase Dashboard</h1>
    </div>
    <div class="cards"> 
    <!-- Container for dashboard menu cards -->

        <a href="eggs/index.php" class="card eggs"> 
        <!-- Card linking to egg production module -->

            <h2>Egg Production</h2> 
            <!-- Title of module -->

            <p>Manage daily egg records</p> 
            <!-- Description -->

        </a>

        <a href="sales/index.php" class="card sales"> 
        <!-- Card linking to sales module -->

            <h2>Sales</h2> 
            <!-- Title -->

            <p>Track sales transactions</p> 
            <!-- Description -->

        </a>

        <a href="feeds/index.php" class="card feeds"> 
        <!-- Card linking to feeds module -->

            <h2>Feeds</h2> 
            <!-- Title -->

            <p>Monitor feed usage</p> 
            <!-- Description -->

        </a>

        <a href="chickens/index.php" class="card chickens"> 
        <!-- Card linking to chickens module -->

            <h2>Chickens</h2> 
            <!-- Title -->

            <p>Manage poultry batches</p> 
            <!-- Description -->

        </a>

    </div>
</div>

</body>
</html>