<?php
// Include database connection
require_once("db_connect.php");

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $itemName = $_POST['item-name'];
    $itemDescription = $_POST['item-description'];
    $itemPrice = $_POST['item-price'];
    $itemCategory = $_POST['item-category'];
    $itemQuantity = $_POST['item-quantity'];
    $itemImage = $_POST['item-img'];

    // Prepare and bind the SQL statement to insert a new item
    $sql = "INSERT INTO items (name, description, price, category, stock, img) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ssdsis", $itemName, $itemDescription, $itemPrice, $itemCategory, $itemQuantity, $itemImage);

    // Execute the insert query
    if ($stmt->execute()) {
        // If the insertion was successful, return a success message
        echo json_encode(array("status" => "success", "message" => "Item added successfully."));
    } else {
        // If the insertion failed, return an error message
        echo json_encode(array("status" => "error", "message" => "Failed to add item."));
    }
    $stmt->close();
}

// Close the database connection
mysqli_close($connection);
?>
<script>
    // Reload the page after 2 seconds if the insertion was successful
    setTimeout(function () {
        window.location.reload();
    }, 2000);
</script>
