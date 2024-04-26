<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
require_once("db_connect.php");

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if itemID and quantity are set in the POST request
    if (isset($_POST["itemID"]) && isset($_POST["newQuantity"])) {
        // Retrieve itemID and quantity from POST data
        $itemID = $_POST["itemID"];
        $newQuantity = $_POST["newQuantity"];

        $sql = "UPDATE items SET stock = ? WHERE itemID = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $newQuantity, $itemID);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "Stock quantity updated successfully";
        } else {
            echo "Failed to update stock quantity";
        }

        // Close statement and connection
        $stmt->close();
    } else {
        echo "Failed to decode JSON data";
    }
} else {
    echo "Invalid request method";
}

?>