<?php
// Database configuration
$host = "localhost"; // Hostname
$username = "root"; // Database username
$password = ""; // Database password
$database = "food4you"; // Database name

// Establish database connection
$connection = new mysqli($host, $username, $password, $database);

// Check connection
if ($connection->connect_error) { // Change $conn to $connection here
    die("Connection failed: " . $connection->connect_error); // Change $conn to $connection here
}
?>
