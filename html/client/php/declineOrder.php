<?php
// Include database connection
require_once("db_connect.php");

// Get the orderID from the AJAX request
$orderID = $_POST['orderID'];

// Prepare and execute SQL query to retrieve items and quantities from the orders table
$query = "SELECT itemID, quantity 
          FROM orders
          WHERE orderID = ?";
$stmt = $connection->prepare($query);
$stmt->bind_param("i", $orderID);
$stmt->execute();
$result = $stmt->get_result();

// Check if there are rows returned
if ($result->num_rows > 0) {
    // Loop through each row
    while ($row = $result->fetch_assoc()) {
        $itemID = $row['itemID'];
        $quantity = $row['quantity'];

        // Prepare and execute SQL query to update the stock in the items table
        $updateQuery = "UPDATE items SET stock = stock + ? WHERE itemID = ?";
        $updateStmt = $connection->prepare($updateQuery);
        $updateStmt->bind_param("ii", $quantity, $itemID);
        $updateStmt->execute();

        // Close the prepared statement
        $updateStmt->close();
    }
}

// Close the database connection
mysqli_close($connection);
?>
