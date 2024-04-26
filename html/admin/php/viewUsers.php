<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
require_once("db_connect.php");

// Initialize the cart rows array
$cartRows = array();

// Prepare and bind the SQL statement with a placeholder for the category
$sql = "SELECT * FROM customers";
$stmt = $connection->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

// Check if there are rows in the result
if ($result->num_rows > 0) {
    // Initialize an array to store the rows
    $rows = array();

    // Loop through each row of data
    while($row = $result->fetch_assoc()) {
        // Add the row to the array
        $rows[] = $row; 
    }

    // Close the database connection
    mysqli_close($connection);

    // Now, include the HTML content from the cart.html file
    include("../html/viewUsers.html");

} else {
    echo "0 results";
}
?>