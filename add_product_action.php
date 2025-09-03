<?php include("head.php") ?>
<?php include("dbConn.php") ?>


<?php 
$product_name = $_POST['product_name'];
$price = $_POST['price'];
$description = $_POST['description'];
$category_id = $_POST['category_id'];
$target_path = $target_path.basename($_FILES['image']['name']);   
    echo $target_path;
    if(move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {  
        echo "File uploaded successfully!";  
    } else{  
        echo "Sorry, file not uploaded, please try again!";  
    }  
$image = $_FILES["image"]["name"];



$sql = "insert into products(product_name,price,image,description,category_id)
values('".$product_name."','".$price."','".$image."', '".$description."','".$category_id."')";
echo $sql; 
if($conn->query($sql)==TRUE){
$url =  "msg.php?msg= Product Added  Successfully&color=text-success";
header("Location:".$url);
}else{
    $url = "msg.php?msg=Something Went Wrong ".$conn->error." &color=text-danger";
    header("Location:".$url);
}
?>