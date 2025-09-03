<?php include("head.php") ?>
<?php include("dbConn.php") ?>
<?php 
    $order_item_id = $_GET['order_item_id'];

    $sql = "select * from order_items where order_item_id='".$order_item_id."'";
    $order_items = $conn->query($sql);
    $sql = "delete from order_items where order_item_id='".$order_item_id."'";
    $order_items = $conn->query($sql);
    if($order_items ->num_rows == 0){
        $sql = "delete from orders where order_id='".$order_items['order_id']."'";
        if($conn->query($sql)==TRUE){
            $url =  "msg.php?msg= Removed from Cart&color=text-success";
            header("Location:".$url);
        }else{
            $url = "msg.php?msg=Something Went Wrong ".$conn->error."&color=text-danger";
            header("Location:".$url);
        }
    }else{
        $url = "view_cart.php";
        header("Location:".$url);
    }

?>

