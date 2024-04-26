<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
require_once("db_connect.php");

// Prepare and bind the SQL statement to select all orders
$sql = "SELECT * FROM orders
        GROUP BY orderID
        ORDER BY `date` DESC";

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

    // Close the statement
    $stmt->close();

    // Close the database connection
    mysqli_close($connection);

    // Now, include the HTML content from the order_history.html file
    include("../html/order_history.html");

} else {
    echo "0 results";
}
?>