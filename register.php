<?php
session_start(); 
// Starts session (not required here but useful if you plan to auto-login after register)

// DATABASE CONNECTION
$conn = new mysqli("localhost", "root", "", "poultryease"); 
// Connects to MySQL database (host, username, password, database name)

// CHECK CONNECTION
if ($conn->connect_error) { 
// Checks if connection failed

    die("Connection failed"); 
    // Stops the script if connection is unsuccessful
}

// REGISTER PROCESS
if (isset($_POST['register'])) { 
// Checks if register button is clicked

    // GET INPUT
    $username = trim($_POST['username']); 
    // Gets username and removes extra spaces

    $password = trim($_POST['password']); 
    // Gets password input

    $confirm = trim($_POST['confirm']); 
    // Gets confirm password input

    // VALIDATION
    if (empty($username) || empty($password) || empty($confirm)) { 
    // Checks if any field is empty

        echo "All fields are required!"; 
        // Displays error message

    } elseif ($password !== $confirm) { 
    // Checks if password and confirm password do not match

        echo "Passwords do not match!"; 
        // Displays error

    } else {

        // CHECK IF USERNAME EXISTS
        $check = $conn->prepare("SELECT id FROM users WHERE username = ?"); 
        // Prepares query to check if username already exists

        $check->bind_param("s", $username); 
        // Binds username parameter (s = string)

        $check->execute(); 
        // Executes query

        $check->store_result(); 
        // Stores result to check number of rows

        if ($check->num_rows > 0) { 
        // If username already exists

            echo "Username already taken!"; 
            // Shows error message

        } else {

            // HASH PASSWORD
            $hashed = password_hash($password, PASSWORD_DEFAULT); 
            // Encrypts password securely before storing

            // INSERT USER
            $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)"); 
            // Prepares insert query

            $stmt->bind_param("ss", $username, $hashed); 
            // Binds username and hashed password

            $stmt->execute(); 
            // Executes insert query

            echo "Registration successful! <a href='login.php'>Login here</a>"; 
            // Success message with login link
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title> 
    <!-- Page title -->

    <link rel="stylesheet" href="css/style.css"> 
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- External CSS for design -->
</head>
<body class="login_body">

<div class='login_container'>

    <div class='title'>
        <img src='css/logo.png' alt=''>
        <h1>PoultryEase</h1>
    </div>

    <div class='form'>
        <h2>Register</h2> 
    <!-- Heading -->

        <form method="POST"> 
        <!-- Form using POST method -->

            <div class="input-group">
                <i class="fa fa-user"></i>
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <!-- Username input (required) -->

            <div class="input-group">
                <i class="fa fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <!-- Password input -->

            <div class="input-group">
                <i class="fa fa-lock"></i>
                <input type="password" name="confirm" placeholder="Confirm Password" required>
            </div>
            <!-- Confirm password input -->
            <button type="submit" name="register">Register</button>
            <!-- Submit button -->

        </form>

        <p>
        Already have an account? 
        <a href="login.php">Login here</a>
        <!-- Link to login page -->
        </p>
    </div>
</div>
</body>
</html>