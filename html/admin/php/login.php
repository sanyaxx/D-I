<?php
// Include database connection
require_once("db_connect.php");

// Retrieve submitted username and password
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve submitted username and password
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Perform validation against the database
    $query = "SELECT * FROM admin WHERE username = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Fetch the row from the result set
        $row = $result->fetch_assoc();
        if (password_verify($password, $row["password"])) {
            // Password is correct
            // Start a session and store necessary data (if any)
            // session_start();
            // $_SESSION['userID'] = $row['userID'];          

            // Redirect to home page
            header("Location: ../html/Restauranthome.html");
            exit(); // Ensure script stops execution after redirection
        } else {
            // Password is incorrect
            echo '<script type="text/javascript">alert("Incorrect password!"); window.location.href = "../html/login.html";</script>';
            exit();
        }
    } else {
        // No matching username found
        echo '<script type="text/javascript">alert("Username not found!"); window.location.href = "../html/login.html";</script>';
        exit();
    }
}

// Close database connection
mysqli_close($connection);
?>
