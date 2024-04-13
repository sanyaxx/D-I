<?php
// Connect to the database
require_once("db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve all items from the user's cart where quantity > stock
    $userID = $_SESSION['userID'];
    $query = "SELECT * FROM cart c JOIN items i ON c.itemID = i.itemID WHERE c.userID = ? AND c.quantity <= i.stock";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    // Initialize total price
    $totalPrice = 0;

    // Prepare statement to insert into orders table
    $insertQuery = "INSERT INTO orders (userID, itemID, quantity, total_price, payment) VALUES (?, ?, ?, ?, ?)";
    $insertStmt = $connection->prepare($insertQuery);

    // Prepare statement to delete from cart table
    $deleteQuery = "DELETE FROM cart WHERE userID = ? AND itemID = ?";
    $deleteStmt = $connection->prepare($deleteQuery);

    // Loop through each item in the cart
    while ($row = $result->fetch_assoc()) {
        $itemID = $row['itemID'];
        $quantityOrdered = $row['quantity'];

        // Retrieve item details from items table
        $getItemQuery = "SELECT price FROM items WHERE itemID = ?";
        $getItemStmt = $connection->prepare($getItemQuery);
        $getItemStmt->bind_param("i", $itemID);
        $getItemStmt->execute();
        $itemResult = $getItemStmt->get_result();
        $itemRow = $itemResult->fetch_assoc();
        $itemPrice = $itemRow['price'];

        // Calculate total price for the item
        $totalItemPrice = $quantityOrdered * $itemPrice;
        $totalPrice += $totalItemPrice;

        // Insert order details into orders table
        $payment = $_POST['payment'];
        $insertStmt->bind_param("iiids", $userID, $itemID, $quantityOrdered, $totalItemPrice, $payment);
        $insertStmt->execute();

        // Update quantity of items in stock
        $updateQuery = "UPDATE items SET stock = stock - ? WHERE itemID = ?";
        $updateStmt = $connection->prepare($updateQuery);
        $updateStmt->bind_param("ii", $quantityOrdered, $itemID);
        $updateStmt->execute();

        // Delete item from cart
        $deleteStmt->bind_param("ii", $userID, $itemID);
        $deleteStmt->execute();
    }

    // Close the prepared statements
    $insertStmt->close();
    $deleteStmt->close();

    // Close the database connection
    mysqli_close($connection);

    // Redirect to a success page or handle the response accordingly
    echo '<script type="text/javascript">alert("Order placed!"); window.location.href = "Home.html";</script>';
    exit();
}
?>
