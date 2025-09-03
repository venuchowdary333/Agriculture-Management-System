<?php include("head.php") ?>
<?php include("dbConn.php") ?>

<?php 
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
$mail->Subject = 'Order Assigned';

$mail->setFrom("venu12201@gmail.com");
$order_id = $_POST['order_id'];
$deliveryboy_id = $_POST['deliveryboy_id'];
$sql4 = "SELECT COUNT(*) AS total_delivered 
FROM orders 
WHERE status != 'Delivered' 
AND deliveryboy_id = '".$deliveryboy_id."' 
AND date <= NOW()"; // This will check the full datetime    echo $sql4;
$result = $conn->query($sql4);
$row = $result->fetch_assoc();
echo $row['total_delivered'];
if(intval($row['total_delivered'])>=5){
    $url =  "msg.php?msg=You Can not assign order to this deliveryboy, already reached 5 orders today&color=text-success";
    header("Location:".$url);
}else{
    $sql = "update orders set status='DeliveryBoy Assigned',deliveryboy_id='".$deliveryboy_id."' where order_id = '".$order_id."'";
    $orders = $conn->query($sql);
    if($conn->query($sql)==TRUE){
        $delivery_boy_sql = "select * from deliveryboys where deliveryboy_id='".$deliveryboy_id."'";
        $deliveryboys = $conn->query($delivery_boy_sql);
        foreach($deliveryboys as $deliveryboy){
            $email  = $deliveryboy['email'];
            $email_body = '
            <h2>Hi '.$deliveryboy['name'].',Seller is assigned  a order to you!</h2>';
            $mail->Body = $email_body;
            $mail->addAddress($email); // to customer
            $mail->isHTML(true);
        
        
        
            if($mail->send()){?>
                <div id="body">
                 <b><div class="text-center" style="color:chartreuse;"><?php echo 'Mail Sent';?></div></b>  
                  <?php }else{
            echo'error';
          }
          $mail->smtpClose();
        }
        $url =  "msg.php?msg=Order Assigned To DeliveryBoy&color=text-success";
        header("Location:".$url);
        }else{
            $url = "msg.php?msg=Something Went Wrong ".$conn->error." &color=text-danger";
            header("Location:".$url);
        }
}


   

?>