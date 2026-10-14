<?php
session_start(); 
// Starts the session so we can access and modify session data

session_unset(); 
// Removes all session variables (like user data stored during login)

session_destroy(); 
// Completely destroys the session on the server

header("Location: login.php"); 
// Redirects the user back to the login page

exit(); 
// Stops the script immediately after redirect
?>