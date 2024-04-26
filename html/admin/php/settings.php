<?php

// Include database connection
require_once("db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input
    $username = $_POST['username'];
    $password = $_POST['password'];

    // You can add more validation here if needed

    // Update restaurant details in the database
    $sql = "UPDATE admin SET username = ?, password = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ss", $username, $password);

    if ($stmt->execute()) {
        // If successful, redirect to the settings page with a success message
        header("Location: ../html/settings.html?success=1");
        exit;
    } else {
        // If an error occurred, redirect to the settings page with an error message
        header("Location: ../html/settings.html?error=1");
        exit;
    }

    $stmt->close();
}

mysqli_close($connection);
?>
