<?php include("head.php") ?>
<?php include("dbConn.php") ?>

<?php 
    $order_id = $_POST['order_id'];
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
    $mail->Subject = 'Product Dispatched - Tracking Info Inside';
    $mail->Body = '
        <p>Your order has been dispatched and is on its way.</p>
        <p>Track your delivery here:</p>
        <a href="http://localhost/agriculture2/index.php" class="btn">Track Order</a>';
    $mail->setFrom("venu12201@gmail.com");
    $mail->isHTML(true);

    $sql = "UPDATE orders SET status='Dispatched', dispatched_at=NOW() WHERE order_id='$order_id'";


    $orders = $conn->query($sql);
    if($conn->query($sql)==TRUE){
        $sql2 ="select * from orders where order_id = '".$order_id."'";
        $orders = $conn->query($sql2);
        foreach($orders as $order){
            $sql3 = "select * from farmers where farmer_id='".$order['farmer_id']."'";
            $farmers = $conn->query($sql3);
            foreach($farmers as $farmer){
                $mail->addAddress($farmer['email']);
                if($mail->send()){?>
                    <div id="body">
                     <b><div class="text-center" style="color:chartreuse;"><?php echo 'Mail Sent';?></div></b>  
                      <?php }else{
                echo'error';
              }
              
              
            }
        }
        
        $url =  "msg.php?msg=Order Dispatched&color=text-success";
        header("Location:".$url);
        }else{
            $url = "msg.php?msg=Something Went Wrong ".$conn->error." &color=text-danger";
            header("Location:".$url);
        }
   


?>