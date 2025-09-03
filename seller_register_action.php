<?php include("head.php") ?>
<?php include("dbConn.php") ?>


<?php 
$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$password = $_POST['password'];
$state = $_POST['state'];
$city = $_POST['city'];
$zipcode = $_POST['zipcode'];
$address = $_POST['address'];
$location_id = $_POST['location_id'];
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
$mail->Subject = "Welcome to Agriculture!" ;

$mail->setFrom("venu12201@gmail.com");
$mail->isHTML(true);
$mail->addAddress($email);

$sql = "select * from sellers where email='".$email."' or phone='".$phone."' ";
$sellers = $conn->query($sql);
if($sellers->num_rows>0){
   $url =  "msg.php?msg=Alredy Exist&color=text-danger";
   header("Location:".$url);
}else{
    $sql = "insert into sellers(first_name,last_name,phone,email,password,state,city,zipcode,address,location_id)
    values('".$first_name."','".$last_name."', '".$phone."', '".$email."', '".$password."','".$state."','".$city."','".$zipcode."','".$address."','".$location_id."')";
    echo $sql; 
    if($conn->query($sql)==TRUE){
        $mail->Body = '
        <h2>Welcome to Agriculture!</h2>
        <p>Your account has been successfully created. You can now log in and start exploring our products.</p>
        <a href="http://localhost/agriculture2/seller_login.php" class="btn">Login Now</a>';
    if($mail->send()){?>
        <div id="body">
         <b><div class="text-center" style="color:chartreuse;"><?php echo 'Mail Sent';?></div></b>  
          <?php }else{
    echo'error';
  }
    $mail->smtpClose();
    $url =  "msg.php?msg=Seller Registered Successfully&color=text-success";
    header("Location:".$url);
    }else{
        $url = "msg.php?msg=Something Went Wrong ".$conn->error." &color=text-danger";
        // header("Location:".$url);
    }
}
?>