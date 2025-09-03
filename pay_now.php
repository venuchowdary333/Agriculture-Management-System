<?php
include("head.php");
include("dbConn.php");

$order_id = $_POST['order_id'];
$payment_type = $_POST['payment_type'];
$card_number = $_POST['card_number'];
$holder_name = $_POST['holder_name'];
$cvv = $_POST['cvv'];
$expiry_date = $_POST['expiry_date'];
$total_price = $_POST['total_price'];
$order_type = $_POST['order_type'];

require 'includes/PhpMailer.php';
require 'includes/SMTP.php';
require 'includes/Exception.php';

use PhpMailer\PhpMailer\PhpMailer;
use PhpMailer\PhpMailer\SMTP;
use PhpMailer\PhpMailer\Exception;

$mail = new PhpMailer();
$mail->isSMTP();
$mail->Host = "smtp.gmail.com";
$mail->SMTPAuth = "true";
$mail->SMTPSecure = "tls";
$mail->Port = "587";
$mail->Username = "venu12201@gmail.com";
$mail->Password = "pswq mcli gqcb oqwx";
$mail->Subject = 'Order Placed Successfully';

$mail->setFrom("venu12201@gmail.com");

// Insert payment
$sql = "INSERT INTO payments(payment_type, card_number, holder_name, cvv, expiry_date, amount, status, order_id)
        VALUES('$payment_type', '$card_number', '$holder_name', '$cvv', '$expiry_date', '$total_price', 'Paid', '$order_id')";

if ($conn->query($sql) === TRUE) {
    $order_items = $conn->query("SELECT * FROM order_items WHERE order_id='$order_id'");

    foreach ($order_items as $order_item) {
        $order_qty = intval($order_item['quantity']); // originally requested
        $product_availability_id = $order_item['product_availability_id'];
        $order_item_id = $order_item['order_item_id'];

        $result2 = $conn->query("SELECT quantity FROM product_availability WHERE product_availability_id='$product_availability_id'");
        $row2 = $result2->fetch_assoc();
        $available_qty = intval($row2['quantity']);

        if ($order_qty <= $available_qty) {
            // Fully fulfill
            $remaining_stock = $available_qty - $order_qty;
            $conn->query("UPDATE product_availability SET quantity='$remaining_stock' WHERE product_availability_id='$product_availability_id'");

            // Update order_items with fulfilled and requested quantities
            $conn->query("UPDATE order_items 
                          SET quantity='$order_qty', 
                              request_quantity='$order_qty'
                          WHERE order_item_id='$order_item_id'");
        } else {
            // Partial fulfill
            $fulfilled_qty = $available_qty;
            $backorder_qty = $order_qty - $available_qty;

            if ($fulfilled_qty > 0) {
                // Set stock to zero
                $conn->query("UPDATE product_availability SET quantity=0 WHERE product_availability_id='$product_availability_id'");
            }

            // Update order_items with fulfilled and requested quantities
            $conn->query("UPDATE order_items 
                          SET quantity='$fulfilled_qty', 
                              request_quantity='$order_qty'
                              
                          WHERE order_item_id='$order_item_id'");

            // Get farmer ID
            $farmer_result = $conn->query("SELECT farmer_id FROM orders WHERE order_id='$order_id'");
            $farmer_data = $farmer_result->fetch_assoc();
            $farmer_id = $farmer_data['farmer_id'];

            // Insert into backorders
            $conn->query("INSERT INTO backorders (farmer_id, product_availability_id, order_id, quantity, status)
                          VALUES ('$farmer_id', '$product_availability_id', '$order_id', '$backorder_qty', 'Pending')");
        }


    }

    // Update order status finally
    $conn->query("UPDATE orders SET status='Ordered',total_price='".$total_price."', order_type='$order_type' WHERE order_id='$order_id'");

    // Fetch order + user info
    $order_details = $conn->query("SELECT * FROM orders o 
    JOIN farmers f ON o.farmer_id = f.farmer_id 
    WHERE o.order_id = '$order_id'")->fetch_assoc();

    $items = $conn->query("SELECT oi.*, p.product_name, pa.price 
    FROM order_items oi 
    JOIN product_availability pa ON oi.product_availability_id = pa.product_availability_id 
    JOIN products p ON pa.product_id = p.product_id 
    WHERE oi.order_id = '$order_id'");

    // Start email body
    $email_body = '
    <h2>Thank you for your order!</h2>
    <p>Your order has been successfully placed. Here are the details:</p>
    <p><strong>Order ID:</strong> '.$order_id.'</p>
    <p><strong>Customer Name:</strong> '.$order_details['name'].'</p>
    <p><strong>Email:</strong> '.$order_details['email'].'</p>
    <p><strong>Order Date:</strong> '.$order_details['date'].'</p>
    <p><strong>Order Type:</strong> '.$order_details['order_type'].'</p>
    <br>
    <h3>Order Items:</h3>
    <table border="1" cellpadding="8" cellspacing="0" width="100%">
    <tr>
    <th>Product</th>
    <th>Price</th>
    <th>Qty</th>
    <th>Total</th>
    </tr>';

    $grand_total = 0;
    while ($row = $items->fetch_assoc()) {
    $qty = $row['request_quantity'];
    $price = $row['price'];
    $total = $qty * $price;
    $grand_total += $total;

    $email_body .= '
    <tr>
        <td>'.$row['product_name'].'</td>
        <td>'.$price.'</td>
        <td>'.$qty.'</td>
        <td>'.$total.'</td>
    </tr>';
    }

    $email_body .= '
    <tr>
    <td colspan="3" align="right"><strong>Grand Total:</strong></td>
    <td><strong>'.$grand_total.'</strong></td>
    </tr>
    </table>';

    // Set email content
    $mail->Body = $email_body;
    $mail->addAddress($order_details['email']); // to customer
    $mail->isHTML(true);



    if($mail->send()){?>
        <div id="body">
         <b><div class="text-center" style="color:chartreuse;"><?php echo 'Mail Sent';?></div></b>  
          <?php }else{
    echo'error';
  }
  $mail->smtpClose();

    header("Location: msg.php?msg=Order Placed&color=text-success");
} else {
    header("Location: msg.php?msg=Something Went Wrong " . $conn->error . "&color=text-danger");
}
?>
