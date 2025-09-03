<?php include("head.php") ?>
<?php include("dbConn.php") ?>
<?php 
$email = $_POST['email'];
$password = $_POST['password'];

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
$mail->Subject = "You just logged into AgriCulture!" ;

$mail->setFrom("venu12201@gmail.com");
$mail->isHTML(true);
$mail->addAddress($email);

$sql = "select * from farmers where email='".$email."' and password='".$password."' ";
$results = $conn->query($sql);
$sql3 = "select * from farmers where email='".$email."' and password='".$password."'";
$results3 = $conn->query($sql3);

if($results ->num_rows == 0){
    $url = "msg.php?msg=Invalid Login Details&color=text-danger";
    header("Location:".$url);
}elseif($results3->num_rows > 0) { 
    while($row = $results3->fetch_assoc()) {
        
        $_SESSION["role"] = 'farmer';
        $_SESSION["farmer_id"] = $row["farmer_id"];
        $mail->Body = '<p>This is a quick notice that your account was just accessed.</p>';
        if($mail->send()){?>
            <div id="body">
             <b><div class="text-center" style="color:chartreuse;"><?php echo 'Mail Sent';?></div></b>  
              <?php }else{
        echo'error';
      }
      $mail->smtpClose();
        $url = "farmer_home.php";
        header("Location:".$url);
    }
}
else{
    $url = "msg.php?msg=Invalid Login Details&color=text-danger";
    header("Location:".$url);
}



?>

