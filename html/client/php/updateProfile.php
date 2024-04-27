<?php

// Include the database connection file
require_once("db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Decode the JSON data sent via AJAX
    $data = json_decode(file_get_contents("php://input"), true);

    $name = $data['name'];
    $email = $data['email'];
    $phone = $data['phone'];

    // Prepare and bind the update statement
    $sql = "UPDATE customers SET name=?, email=?, phone=? WHERE userID=?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ssii", $name, $email, $phone, $_SESSION['userID']);

    // Execute the update statement
    if ($stmt->execute()) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $connection->error;
    }

    // Close the statement and database connection
    $stmt->close();
    $connection->close();

} else {
    // Handle the case where the request method is not POST
    echo "Invalid request method";
}
?>

