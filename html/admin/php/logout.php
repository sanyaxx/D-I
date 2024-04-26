<?php
session_start(); // Start the session

// Clear all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect the user to the login page
header("Location: ../html/login.html");
exit;
?>
