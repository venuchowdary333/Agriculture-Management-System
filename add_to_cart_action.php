<?php include("head.php") ?>
<?php include("dbConn.php") ?>

<?php
$product_availability_id = $_POST['product_availability_id'];
$farmer_id = $_SESSION['farmer_id'];
$seller_id = $_POST['seller_id'];
$quantity = intval($_POST['quantity']); // Ensure it's an integer
$my_quantity = intval($_POST['quantity']); // Ensure it's an integer
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
$mail->Subject = 'Product Notified';

$mail->setFrom("venu12201@gmail.com");
$mail->isHTML(true);

// Get available stock
$checkStock = "SELECT quantity FROM product_availability WHERE product_availability_id = '$product_availability_id'";
$stockResult = $conn->query($checkStock);

if ($stockResult->num_rows > 0) {
    $row = $stockResult->fetch_assoc();
    $available_stock = intval($row['quantity']);

    if ($quantity > $available_stock) {
        $extra_needed = $quantity - $available_stock;

        // Notify seller about extra needed
        $insertRequest = "INSERT INTO product_notifications (product_availability_id, farmer_id, requested_quantity,status)
                          VALUES ('".$product_availability_id."', '".$farmer_id."', '".$extra_needed."','Notify')";
        $conn->query($insertRequest);

        // Adjust order quantity to only available stock
        $quantity = $available_stock;

        // Show message about partial fulfillment
        
        $seller_sql = "select * from sellers where seller_id='".$seller_id."'";
        $sellers = $conn->query($seller_sql);
        foreach($sellers as $seller){
            $mail->Body = '
            <p>Hi '.$seller['first_name'].' Only '.$available_stock.' available. The product has been  notified for extra '.$extra_needed.'';
            $mail->addAddress($seller['email']);
            if($mail->send()){?>
                <div id="body">
                 <b><div class="text-center" style="color:chartreuse;"><?php echo 'Mail Sent';?></div></b>  
                  <?php }else{
            echo'error';
          }

        }
           
        $msg = "Only $available_stock available. The product has been  notified for extra $extra_needed. ";
        $msgColor = "text-warning";
    } else {

        $msg = "";
        $msgColor = "text-success";
    }

    // Proceed to add available quantity to cart
    $sql = "SELECT * FROM orders WHERE farmer_id='".$farmer_id."' AND seller_id='".$seller_id."' AND status='cart'";
    $orders = $conn->query($sql);

    if ($orders->num_rows > 0) {
        $order = $orders->fetch_assoc();
        $order_id = $order['order_id'];
    } else {
        $sql = "INSERT INTO orders(seller_id, farmer_id, status, date) VALUES('".$seller_id."', '".$farmer_id."', 'cart', NOW())";
        $conn->query($sql);
        $order_id = $conn->insert_id;
    }

    $sql = "SELECT * FROM order_items WHERE product_availability_id='".$product_availability_id."' AND order_id='".$order_id."'";
    $order_items = $conn->query($sql);

    if ($order_items->num_rows > 0) {
        $sql = "UPDATE order_items SET quantity = quantity + $my_quantity 
                WHERE product_availability_id='".$product_availability_id."' AND order_id='".$order_id."'";
        $conn->query($sql);
        $msg .= "Product quantity updated in cart.";
    } else {
        $sql = "INSERT INTO order_items(product_availability_id, order_id, quantity)
                VALUES('".$product_availability_id."', '".$order_id."', '".$my_quantity."')";
        $conn->query($sql);
        $msg .= "Product added to cart.";
    }

    header("Location: msg.php?msg=" . urlencode($msg) . "&color=$msgColor");
    exit();
} else {
    $msg = "Invalid product availability.";
    $msgColor = "text-danger";
    header("Location: msg.php?msg=" . urlencode($msg) . "&color=$msgColor");
    exit();
}
?>
