<?php
// Include layout.php to establish database connection
require_once("php\db_connect.php");

// Retrieve submitted username and password
$username = $_POST['username'];
$password = $_POST['password'];

// Validate inputs (basic validation example)
if (empty($username) || empty($password)) {
    echo "Username and password are required.";
} else {
    // Perform validation against the database
    $query = "SELECT * FROM your_table WHERE username='$username' AND password='$password'";
    $result = mysqli_query($connection, $query);

    // Check if there is a matching record
    if (mysqli_num_rows($result) > 0) {
        // Matching record found, proceed with adding the record to the database
        // Add your SQL insert statement here
        echo "Login successful. Record added to the database.";
    } else {
        // No matching record found, display an error message
        echo "Invalid username or password.";
    }
}

// Close database connection
mysqli_close($connection);
?>
