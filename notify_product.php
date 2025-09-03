<?php include("head.php") ?>
<?php include("dbConn.php") ?>


<?php 
  $product_availability_id = $_GET['product_availability_id'];
  $farmer_id = $_SESSION['farmer_id'];
  $sql = "insert into product_notifications (product_availability_id,farmer_id,status) values ('".$product_availability_id."','".$farmer_id."','Notify')";
  if($conn->query($sql)==TRUE){
    $url =  "msg.php?msg=Product Notified&color=text-success";
    header("Location:".$url);
    }else{
        $url = "msg.php?msg=Something Went Wrong ".$conn->error." &color=text-danger";
        header("Location:".$url);
    }

?>