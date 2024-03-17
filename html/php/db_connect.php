<?php
// Database configuration
$host = "localhost"; // Hostname
$username = "root"; // Database username
$password = ""; // Database password
$database = "food4you"; // Database name

// Establish database connection
$connection = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
?>