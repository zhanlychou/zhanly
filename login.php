<?php
session_start(); // Starts a session to store user data (like login info)

// DATABASE CONNECTION
$conn = new mysqli("localhost", "root", "", "poultryease"); 
// Creates a new MySQL connection (host, username, password, database name)

// CHECK CONNECTION
if ($conn->connect_error) { // Checks if there is an error in connection
    die("Connection failed"); // Stops the script if connection fails
}

// LOGIN PROCESS
if (isset($_POST['login'])) { // Checks if login button is clicked

    // GET INPUT
    $username = trim($_POST['username']); // Gets username input and removes extra spaces
    $password = trim($_POST['password']); // Gets password input and removes extra spaces

    // VALIDATION
    if (empty($username) || empty($password)) { // Checks if fields are empty
        echo "All fields are required!"; // Displays error message
    } else {

        // PREPARED STATEMENT (SQL INJECTION SAFE)
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?"); 
        // Prepares SQL query safely to avoid SQL injection

        $stmt->bind_param("s", $username); 
        // Binds the username parameter (s = string)

        $stmt->execute(); // Executes the query

        $result = $stmt->get_result(); 
        // Gets the result of the executed query

        $user = $result->fetch_assoc(); 
        // Fetches the result as an associative array (row data)

        // VERIFY PASSWORD (HASHED)
        if ($user && password_verify($password, $user['password'])) { 
        // Checks if user exists AND verifies hashed password

            // CREATE SESSION
            $_SESSION['user'] = $user['username']; 
            // Stores username in session for future use

            // REDIRECT TO DASHBOARD
            header("Location: main.php"); 
            // Redirects user to main page after login

            exit(); // Stops further script execution

        } else {
            echo "Invalid username or password!"; 
            // Displays error if login fails
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title> <!-- Title of the webpage -->
    <link rel="stylesheet" href="css/style.css"> 
    <!-- Links external CSS file for styling -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body class="login_body">

<div class="login_container">

    <div class="title">
        <img src="css/logo.png" alt="">
        <h1>PoultryEase</h1>
    </div>

    <div class="form">
        <h2>LOGIN</h2> <!-- Page heading -->
        <form method="POST">

            <div class="input-group">
                <i class="fa fa-user"></i>
                <input type="text" name="username" placeholder="Username" required>
            </div>

            <div class="input-group">
                <i class="fa fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <button type="submit" name="login">Login</button>

            <p>
                Don't have an account? 
                <a href="register.php">Register here</a>
            </p>
        </form>
    </div>
</div>

</body>
</html>