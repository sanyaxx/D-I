<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
require_once("db_connect.php");

// Initialize arrays for out of stock and in stock items
$outOfStockItems = array();
$inStockItems = array();

// Prepare and bind the SQL statement for out of stock items
$outOfStockSQL = "SELECT * FROM cart INNER JOIN items ON cart.itemID = items.itemID WHERE cart.userID = ? AND cart.quantity > items.stock";
$outOfStockStmt = $connection->prepare($outOfStockSQL);
$category = $_SESSION['userID'];
$outOfStockStmt->bind_param("s", $category);
$outOfStockStmt->execute();
$outOfStockResult = $outOfStockStmt->get_result();

// Check if there are rows in the result for out of stock items
if ($outOfStockResult->num_rows > 0) {
    // Loop through each row of data and add it to the out of stock items array
    while($outOfStockitem = $outOfStockResult->fetch_assoc()) {
        $outOfStockitems[] = $outOfStockitem;
    }
}

// Prepare and bind the SQL statement for in stock items
$inStockSQL = "SELECT * FROM cart INNER JOIN items ON cart.itemID = items.itemID WHERE cart.userID = ? AND cart.quantity <= items.stock";
$inStockStmt = $connection->prepare($inStockSQL);
$inStockStmt->bind_param("s", $category);
$inStockStmt->execute();
$inStockResult = $inStockStmt->get_result();

// Check if there are rows in the result for in stock items
if ($inStockResult->num_rows > 0) {
    // Loop through each row of data and add it to the in stock items array
    while($inStockItem = $inStockResult->fetch_assoc()) {
        $inStockItems[] = $inStockItem;
    }
}

// Close the database connection
mysqli_close($connection);

// Now, include the HTML content from the cart.html file
include("../html/cart.html");
?>
