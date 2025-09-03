<?php
include("head.php");
include("dbConn.php");

$product_availability_id = $_POST['product_availability_id'];
$farmer_id = $_SESSION['farmer_id'];
$seller_id = $_POST['seller_id'];
$quantity = $_POST['quantity'];

// 1. Check available stock
$checkStock = "SELECT quantity FROM product_availability WHERE product_availability_id = '$product_availability_id'";
$stockResult = $conn->query($checkStock);

if ($stockResult->num_rows > 0) {
    $row = $stockResult->fetch_assoc();
    $available_stock = (int)$row['quantity'];

    if ($quantity > $available_stock) {
        // Insert stock request notification
        $insertRequest = "INSERT INTO stock_requests (product_availability_id, seller_id, farmer_id, requested_quantity)
                          VALUES ('$product_availability_id', '$seller_id', '$farmer_id', '$quantity')";
        $conn->query($insertRequest);

        $url = "msg.php?msg=Stock not available. Seller has been notified for extra quantity.&color=text-warning";
        header("Location:" . $url);
        exit();
    }
}

// 2. Check for existing cart
$sql = "SELECT * FROM orders WHERE farmer_id='$farmer_id' AND seller_id='$seller_id' AND status='cart'";
$orders = $conn->query($sql);

if ($orders->num_rows > 0) {
    foreach ($orders as $order) {
        $order_id = $order['order_id'];
    }
} else {
    $sql = "INSERT INTO orders (seller_id, farmer_id, status, date) VALUES ('$seller_id', '$farmer_id', 'cart', NOW())";
    $conn->query($sql);
    $order_id = $conn->insert_id;
}

// 3. Add or update order items
$sql = "SELECT * FROM order_items WHERE product_availability_id='$product_availability_id' AND order_id='$order_id'";
$order_items = $conn->query($sql);

if ($order_items->num_rows > 0) {
    $sql = "UPDATE order_items 
            SET quantity = quantity + '$quantity' 
            WHERE product_availability_id = '$product_availability_id' AND order_id = '$order_id'";
    if ($conn->query($sql) === TRUE) {
        header("Location: msg.php?msg=Product updated in cart&color=text-success");
    } else {
        header("Location: msg.php?msg=Something went wrong&color=text-danger");
    }
} else {
    $sql = "INSERT INTO order_items (product_availability_id, order_id, quantity)
            VALUES ('$product_availability_id', '$order_id', '$quantity')";
    if ($conn->query($sql) === TRUE) {
        header("Location: msg.php?msg=Product added to cart&color=text-success");
    } else {
        header("Location: msg.php?msg=Something went wrong: " . $conn->error . "&color=text-danger");
    }
}
?>
