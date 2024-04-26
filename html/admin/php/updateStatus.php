<?php
// Include database connection
require_once("db_connect.php");

// Check if orderID and status are set in the POST request
if(isset($_POST['userID'], $_POST['orderID'], $_POST['status'])) {
    $userID = $_POST['userID'];
    $orderID = $_POST['orderID'];
    $status = $_POST['status'];

    // Prepare and bind the SQL statement to update the status in the orders table
    $sql = "UPDATE orders SET status = ? WHERE orderID = ? AND userID = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sii", $status, $orderID, $userID);

    // Execute the statement
    if ($stmt->execute()) {
        // If successful, send a success response
        http_response_code(200);
        echo "Status updated successfully!";
    } else {
        // If an error occurred, send an error response
        http_response_code(500);
        echo "Error updating status!";
    }

    // Close the statement
    $stmt->close();

    // Close the database connection
    mysqli_close($connection);
} else {
    // If orderID or status is not set, send a bad request response
    http_response_code(400);
    echo "Bad request!";
}
?>
