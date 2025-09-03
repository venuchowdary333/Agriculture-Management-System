<?php include("head.php") ?>
<?php include("dbConn.php") ?>
<?php

$farmer_id = $_SESSION['farmer_id'];
$rating = $_POST['rating'];
$review = $_POST['review'];
$order_id = $_POST['order_id'];

$sql = "insert into reviews(rating,review,farmer_id,order_id)
values('".$rating."','".$review."','".$_SESSION['farmer_id']."','".$order_id."')";
if($conn->query($sql)==TRUE){
$url =  "msg.php?msg=Thank you for your Review &color=text-success";
header("Location:".$url);
}else{
    $url = "msg.php?msg=Something Went Wrong ".$conn->error." &color=text-danger";
    header("Location:".$url);
}
$sql = "update orders set status='Reviewed' where order_id = '".$order_id."'";
$orders = $conn->query($sql);

?>