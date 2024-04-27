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
        // Fetch the quantity for out of stock items
        fetchCartQty($outOfStockitem);
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
    while($row = $inStockResult->fetch_assoc()) {
        $rows[] = $row;
        // Fetch the quantity for in stock items
        fetchCartQty($row);
    }
}

// Close the database connection
mysqli_close($connection);

// Now, include the HTML content from the cart.html file
include("../html/cart.html");

// Function to fetch cart quantity
function fetchCartQty($item) {
    global $connection, $_SESSION, $cartRows;
    // Fetch the quantity from the cart table for the current user and item
    $quantityQuery = "SELECT quantity FROM cart WHERE userID = ? AND itemID = ?";
    $quantityStmt = $connection->prepare($quantityQuery);
    $quantityStmt->bind_param("ii", $_SESSION['userID'], $item['itemID']);
    $quantityStmt->execute();
    $quantityResult = $quantityStmt->get_result();

    // Initialize the quantity to 0 by default
    $quantity = 0;

    // If a row is fetched, update the quantity
    if ($quantityRow = $quantityResult->fetch_assoc()) {
        $quantity = $quantityRow['quantity'];
    }

    // Add the itemID and quantity to the cartRows array
    $cartRows[$item['itemID']] = $quantity;
}
?>
