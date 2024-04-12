<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
require_once("db_connect.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Prepare and bind the SQL statement with a placeholder for the category
$sql = "SELECT MIN(orders.orderID) AS orderID, GROUP_CONCAT(items.name) AS itemNames, SUM(orders.total_price) AS total_price, orders.payment, orders.`date` 
        FROM orders 
        INNER JOIN items ON orders.itemID = items.itemID
        WHERE orders.userID=? 
        GROUP BY orders.`date`";

$stmt = $connection->prepare($sql);
$stmt->bind_param("s", $_SESSION['userID']);
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

    // Now, include the HTML content from the history.html file
    include("history.html");

} else {
    echo "0 results";
}
