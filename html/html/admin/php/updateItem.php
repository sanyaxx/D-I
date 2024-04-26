<?php
// Include database connection
require_once("db_connect.php");

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Decode the JSON data sent via AJAX
    $data = json_decode(file_get_contents("php://input"), true);

    // Extract data from the decoded JSON
    $itemID = $data['itemID'];
    $name = $data['name'];
    $desc = $data['desc'];
    $price = $data['price'];
    $stock = $data['stock'];
    $isDelete = $data['isDelete']; // Check if it's a delete operation

    // If it's a delete operation, delete the row
    if ($isDelete) {
        $sql = "DELETE FROM items WHERE itemID=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $itemID);
        if ($stmt->execute()) {
            echo json_encode(array("status" => "success", "message" => "Item deleted successfully."));
        } else {
            echo json_encode(array("status" => "error", "message" => "Failed to delete item."));
        }
        $stmt->close();
    } else {
        // Prepare and bind the SQL statement to update the item
        $sql = "UPDATE items SET name=?, description=?, price=?, stock=? WHERE itemID=?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("ssdsi", $name, $desc, $price, $stock, $itemID);

        // Execute the update query
        if ($stmt->execute()) {
            // If the update was successful, return a success message
            echo json_encode(array("status" => "success", "message" => "Item updated successfully."));
        } else {
            // If the update failed, return an error message
            echo json_encode(array("status" => "error", "message" => "Failed to update item."));
        }
        $stmt->close();
    }
}

// Close the database connection
mysqli_close($connection);
?>

