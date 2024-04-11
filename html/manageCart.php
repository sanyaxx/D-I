<?php

// Include database connection
require_once("db_connect.php");

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if itemID and quantity are set in the POST request
    if (isset($_POST["itemID"]) && isset($_POST["quantity"])) {
        // Retrieve itemID and quantity from POST data
        $itemID = $_POST["itemID"];
        $quantity = $_POST["quantity"];
        $userID = $_SESSION['userID'];

        // Check if the item already exists in the cart for the current user
        $existingCartItemQuery = "SELECT * FROM cart WHERE userID = ? AND itemID = ?";
        $existingCartItemStmt = $connection->prepare($existingCartItemQuery);
        $existingCartItemStmt->bind_param("ii", $userID, $itemID);
        $existingCartItemStmt->execute();
        $existingCartItemResult = $existingCartItemStmt->get_result();

        if ($existingCartItemResult->num_rows > 0) {
            // If the item already exists, update its quantity
            $updateCartItemQuery = "UPDATE cart SET quantity = ? WHERE userID = ? AND itemID = ?";
            $updateCartItemStmt = $connection->prepare($updateCartItemQuery);
            $updateCartItemStmt->bind_param("iii", $quantity, $userID, $itemID);

            if ($quantity == 0) {
                // If quantity becomes zero, delete the item from the cart
                $deleteCartItemQuery = "DELETE FROM cart WHERE userID = ? AND itemID = ?";
                $deleteCartItemStmt = $connection->prepare($deleteCartItemQuery);
                $deleteCartItemStmt->bind_param("ii", $userID, $itemID);
                if ($deleteCartItemStmt->execute()) {
                    echo "Item deleted from cart successfully";
                } else {
                    echo "Error: Failed to delete item from cart";
                }
            } else {
                // Update the quantity of the existing item in the cart
                if ($updateCartItemStmt->execute()) {
                    echo "Cart updated successfully";
                } else {
                    echo "Error: Failed to update cart";
                }
            }
        } else {
            // If the item does not exist in the cart, insert it
            $insertCartItemQuery = "INSERT INTO cart (userID, itemID, quantity) VALUES (?, ?, ?)";
            $insertCartItemStmt = $connection->prepare($insertCartItemQuery);
            $insertCartItemStmt->bind_param("iii", $userID, $itemID, $quantity);

            if ($insertCartItemStmt->execute()) {
                echo "Item added to cart successfully";
            } else {
                echo "Error: Failed to add item to cart";
            }
        }
    } else {
        // Respond with an error message if itemID or quantity is not set in the POST request
        echo "Error: itemID or quantity not set in the request";
    }
} else {
    // Respond with an error message if the request method is not POST
    echo "Error: Only POST requests are allowed";
}
?>
