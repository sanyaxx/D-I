<?php
// Include database connection
require_once("db_connect.php");

$orderID = $_GET['orderID'];
if (!isset($orderID)) {
    // Handle error, orderID is not provided
}

// Prepare and bind the SQL statement with a placeholder for the category
$query = "SELECT 
            status
        FROM 
            orders 
        WHERE 
            userID=? AND orderID=?
        GROUP BY 
            orders.orderID
        ";

$stmt = $connection->prepare($query);
$status = 'Pending';
$stmt->bind_param("ii", $_SESSION['userID'], $orderID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo $row['status'];
} else {
    echo "Processing";
}

include("../html/checkoutloading.html");

// Close database connection
mysqli_close($connection);
?>