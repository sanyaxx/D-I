<?php

// Include database connection
require_once("db_connect.php");

// Check if the user is logged in
if (isset($_SESSION["userID"])) {
    // Fetch total quantity from the cart for the current user
    $totalQuantityQuery = "SELECT SUM(quantity) AS total_quantity FROM cart WHERE userID = ?";
    $totalQuantityStmt = $connection->prepare($totalQuantityQuery);
    $totalQuantityStmt->bind_param("i", $_SESSION['userID']);
    $totalQuantityStmt->execute();
    $totalQuantityResult = $totalQuantityStmt->get_result();
    $totalQuantityRow = $totalQuantityResult->fetch_assoc();
    $totalQuantity = $totalQuantityRow['total_quantity'] ?? 0;

    // Return the total quantity
    echo $totalQuantity;
} else {
    // If the user is not logged in, return 0
    echo 0;
}

?>
