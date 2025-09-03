<?php include("head.php") ?>
<?php include("dbConn.php") ?>
<?php 
$location_name = $_POST['location_name'];
$zipcode = $_POST['zipcode'];

$sql = "select * from locations where location_name='".$location_name."' ";
$locations = $conn->query($sql);
if($locations->num_rows>0){
   $url =  "msg.php?msg=Already Exist&color=text-danger";
   header("Location:".$url);
}else{
    $sql = "insert into locations(location_name,zipcode)
    values('".$location_name."','".$zipcode."')"; 
    if($conn->query($sql)==TRUE){
       $url =  "add_location.php";
       header("Location:".$url);
    }else{
        $url = "msg.php?msg=Something Went Wrong&color=text-danger";
        header("Location:".$url);
    }
}
?>