<?php 
include("head.php");
include("dbConn.php");

$product_id = $_POST['product_id'];
$quantity = $_POST['quantity'];
$price = $_POST['price'];
$seller_id = $_SESSION['seller_id'];

require 'includes/PhpMailer.php';
require 'includes/SMTP.php';
require 'includes/Exception.php';

use PhpMailer\PhpMailer\PhpMailer;
use PhpMailer\PhpMailer\SMTP;
use PhpMailer\PhpMailer\Exception;

$mail = new PhpMailer();
$mail->isSMTP();
$mail->Host = "smtp.gmail.com";
$mail->SMTPAuth = true;
$mail->SMTPSecure = "tls";
$mail->Port = 587;
$mail->Username = "venu12201@gmail.com";
$mail->Password = "pswq mcli gqcb oqwx";
$mail->setFrom("venu12201@gmail.com");
$mail->isHTML(true);
$mail->Subject = "Product Back in Stock - Hurry Up!";

$conn->begin_transaction();

try {
    $sql = "SELECT * FROM product_availability WHERE seller_id='$seller_id' AND product_id='$product_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $product_available = $result->fetch_assoc();
        $new_quantity = intval($product_available['quantity']) + intval($quantity);
        $product_availability_id = $product_available['product_availability_id'];

        // Update quantity and price
        $sql1 = "UPDATE product_availability SET quantity='$new_quantity', price='$price' WHERE product_availability_id='$product_availability_id'";
        $conn->query($sql1);

        // Fulfill backorders
        $backorders_sql = "SELECT * FROM backorders WHERE product_availability_id='$product_availability_id' AND status='Pending' ORDER BY created_at ASC";
        $backorders = $conn->query($backorders_sql);

        while ($backorder = $backorders->fetch_assoc()) {
            $needed_qty = intval($backorder['quantity']);
            $available_qty = $new_quantity;

            if ($available_qty >= $needed_qty) {
                // Mark as fulfilled
                $conn->query("UPDATE backorders SET status='Fulfilled' WHERE backorder_id = ".$backorder['backorder_id']);

                // Deduct stock
                $new_quantity -= $needed_qty;
                $conn->query("UPDATE product_availability SET quantity='$new_quantity' WHERE product_availability_id='$product_availability_id'");

                // Create order
                $original_order_id = $backorder['order_id'];
                $order_type = "Standard"; // fallback

                $order_type_query = "SELECT order_type FROM orders WHERE order_id = '$original_order_id'";
                $order_type_result = $conn->query($order_type_query);
                if ($order_type_result && $order_type_result->num_rows > 0) {
                    $order_type_row = $order_type_result->fetch_assoc();
                    $order_type = $order_type_row['order_type'];
                }

                // 2. Insert new order with same order_type
                $conn->query("INSERT INTO orders(seller_id, farmer_id, status, date, order_type) 
                            VALUES('$seller_id', '".$backorder['farmer_id']."', 'Ordered', NOW(), '$order_type')");
                $order_id = $conn->insert_id;

                // // Add order item
                $conn->query("INSERT INTO order_items(product_availability_id, order_id, quantity) 
                              VALUES('$product_availability_id', '$order_id', '".$backorder['quantity']."')");

                // Send email
                $farmer_sql = "SELECT * FROM farmers WHERE farmer_id='".$backorder['farmer_id']."'";
                $farmer_result = $conn->query($farmer_sql);
                if ($farmer_row = $farmer_result->fetch_assoc()) {
                    $product_sql = "SELECT * FROM products WHERE product_id='$product_id'";
                    $product_result = $conn->query($product_sql);
                    $product = $product_result->fetch_assoc();

                    $mail->addAddress($farmer_row['email']);
                    $mail->Body = "
                        <html><body>
                        <h2>Hello!</h2>
                        <p>Great news – the product <strong>".$product['product_name']."</strong> you were waiting for is <strong>back in stock</strong>!</p>
                        </body></html>";
                    
                    $mail->send();
                    $mail->clearAddresses();
                }
            } else {
                break; // Stop if current stock can't fulfill more
            }
        }

        // Notify other farmers who subscribed
        $notifications_sql = "SELECT * FROM product_notifications 
                              WHERE product_availability_id='$product_availability_id' AND status='Notify'";
        $notifications = $conn->query($notifications_sql);

        while ($notification = $notifications->fetch_assoc()) {
            $farmer_sql = "SELECT * FROM farmers WHERE farmer_id='".$notification['farmer_id']."'";
            $farmer_result = $conn->query($farmer_sql);
            if ($farmer_row = $farmer_result->fetch_assoc()) {
                $product_sql = "SELECT * FROM products WHERE product_id='$product_id'";
                $product_result = $conn->query($product_sql);
                $product = $product_result->fetch_assoc();

                $mail->addAddress($farmer_row['email']);
                $mail->Body = "
                    <html><body>
                    <h2>Hello!</h2>
                    <p>Great news – the product <strong>".$product['product_name']."</strong> is back in stock!</p>
                    </body></html>";
                $mail->send();
                $mail->clearAddresses();
            }

            $conn->query("UPDATE product_notifications SET status='Notified' WHERE product_availability_id='".$notification['product_availability_id']."'");
        }

        $conn->commit();
        header("Location: msg.php?msg=Quantity Updated Successfully&color=text-success");

    } else {
        // Insert new product availability
        $sql2 = "INSERT INTO product_availability(quantity, product_id, seller_id, price) 
                 VALUES('$quantity', '$product_id', '$seller_id', '$price')";
        $conn->query($sql2);
        $conn->commit();
        header("Location: msg.php?msg=Quantity Added Successfully&color=text-success");
    }

} catch (Exception $e) {
    $conn->rollback();
    header("Location: msg.php?msg=Something went wrong: ".$conn->error."&color=text-danger");
}
?>
