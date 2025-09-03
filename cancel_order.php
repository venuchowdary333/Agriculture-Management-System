<?php include("head.php") ?>
<?php include("dbConn.php") ?>

<?php 
    $order_id = $_POST['order_id'];
    $payment_id = $_POST['payment_id'];

    $sql = "update orders set status='Order Cancelled' where order_id = '".$order_id."'";
    $orders = $conn->query($sql);
    $sql = "update payments set status ='Refunded' where payment_id = '".$payment_id."'";
    $payments = $conn->query($sql);
    if($conn->query($sql)==TRUE){
        $url =  "msg.php?msg=Order Cancelled and Payment Refunded&color=text-success";
        header("Location:".$url);
        }else{
            $url = "msg.php?msg=Something Went Wrong ".$conn->error." &color=text-danger";
            header("Location:".$url);
        }
   

?>