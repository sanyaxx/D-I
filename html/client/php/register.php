<?php

// Include database connection
require_once("db_connect.php");

// Retrieve submitted username and password
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve submitted username and password
    $email = $_POST['email'];
    $full_name = $_POST['full_name'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirmation = $_POST['confirmation'];

    // Check if username is taken
    // Perform validation against the database using prepared statement
    $query = "SELECT * FROM customers WHERE username= ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if there is a matching record
    if ($result->num_rows > 0) {
        // Set message if username is taken
        echo '<script type="text/javascript">alert("Username taken!"); history.back();</script>';
        exit();
    } else {
        // Insert the new user into the database
        $query = "INSERT INTO customers (username, password, name, email, phone) VALUES (?, ?, ?, ?, ?)";
        $stmt = $connection->prepare($query);
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bind_param("ssssi", $username, $hashed_password, $full_name, $email, $phone);
        if ($stmt->execute()) {
            // Set message if registration is successful
            echo '<script type="text/javascript">alert("Account successfully registered! Please login to your account."); window.location.href = "../html/login.html";</script>';
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}

// Close prepared statement and database connection
$stmt->close();
$connection->close();

