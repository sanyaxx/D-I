<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
require_once("db_connect.php");

// Prepare and bind the SQL statement with a placeholder for the category
$sql =  "SELECT * FROM cart INNER JOIN items ON cart.itemID = items.itemID WHERE cart.userID = ? AND cart.quantity <= items.stock";
$stmt = $connection->prepare($sql);
$category = $_SESSION['userID'];
$stmt->bind_param("s", $category);
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

    // Now, include the HTML content from the appetizer.html file
    include("../html/checkout.html");

} else {
    echo "0 results";
}