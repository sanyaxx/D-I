<?php

foreach ($rows as $row):
    // Fetch the quantity from the cart table for the current user and item
    $quantityQuery = "SELECT quantity FROM cart WHERE userID = ? AND itemID = ?";
    $quantityStmt = $connection->prepare($quantityQuery);
    $quantityStmt->bind_param("ii", $_SESSION['userID'], $row['itemID']);
    $quantityStmt->execute();
    $quantityResult = $quantityStmt->get_result();

    // Initialize the quantity to 0 by default
    $quantity = 0;

    // If a row is fetched, update the quantity
    if ($quantityRow = $quantityResult->fetch_assoc()) {
        $quantity = $quantityRow['quantity'];
    }

    // Add the itemID and quantity to the cartRows array
    $cartRows[$row['itemID']] = $quantity;

endforeach;

?>