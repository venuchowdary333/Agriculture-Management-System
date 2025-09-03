<?php include("head.php") ?>
<?php include ("dbConn.php") ?>

<?php 
$userName = $_POST['userName'];
$password = $_POST['password'];

if($userName=='admin' && $password=='admin' ){
    $_SESSION['role'] = 'admin';
    $url = "admin_home.php";
    header("Location:".$url);
}else{
    $url = "msg.php?msg=Invalid Login Details&color=text-danger";
    header("Location:".$url);
}


?>