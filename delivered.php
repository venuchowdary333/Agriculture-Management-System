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
    $mail->Subject = 'Order Successfully Delivered';
    $mail->Body = '
    <h2>Your Order Has Arrived!</h2>
    <p>We hope everything arrived in perfect condition.</p>';
    $mail->setFrom("venu12201@gmail.com");
    $mail->isHTML(true);
    $sql = "update orders set status='Delivered' where order_id = '".$order_id."'";
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
        $url =  "msg.php?msg=Order Delivered&color=text-success";
        header("Location:".$url);
        }else{
            $url = "msg.php?msg=Something Went Wrong ".$conn->error." &color=text-danger";
            header("Location:".$url);
        }
   

?>