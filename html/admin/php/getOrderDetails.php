<?php
// Include database connection
require_once("db_connect.php");

// Check if both userID and orderID are set in the URL parameters
if (isset($_GET['userID']) && isset($_GET['orderID'])) {
    // Retrieve userID and orderID from the URL parameters
    $userID = $_GET['userID'];
    $orderID = $_GET['orderID'];

    // Prepare and bind the SQL statement
    $sql = "SELECT 
            MIN(orders.orderID) AS orderID, 
            GROUP_CONCAT(items.name) AS itemNames, 
            SUM(orders.total_price) AS total_price, 
            orders.payment, 
            MIN(orders.date) AS order_date,
            customers.userID,
            customers.username,
            customers.email
        FROM 
            orders 
        INNER JOIN 
            items ON orders.itemID = items.itemID
        INNER JOIN 
            customers ON orders.userID = customers.userID
        WHERE 
            orders.userID=? AND orders.orderID=?
        GROUP BY 
            orders.orderID, DATE(orders.date)";

    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ss", $userID, $orderID);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if there are rows in the result
    if ($result->num_rows > 0) {
        // Fetch the row
        $row = $result->fetch_assoc();

        // Close the statement
        $stmt->close();

        // Close the database connection
        mysqli_close($connection);

        // Now, include the HTML content to display the order details
        include("../html/orderDetails.html");
    } else {
        echo "Order not found.";
    }
} else {
    echo "Invalid URL parameters.";
}
?>
