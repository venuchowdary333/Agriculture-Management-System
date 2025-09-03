<?php include("head.php") ?>
<?php include("dbConn.php") ?>
<?php 

$seller_id = $_GET['seller_id'];
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


$sql = "select * from sellers where seller_id='".$seller_id."'";
$results = $conn->query($sql);
foreach($results as $result){
  if($result['status']=='Authorized'){ 
    $sql = "update sellers set status='UnAuthorized' where seller_id='".$seller_id."'";
    if($conn->query($sql)==TRUE){
      $mail->addAddress($result['email']);
      $mail->Body = '<p>This is a quick notice that your account was just deactivated.</p>';
      if($mail->send()){?>
          <div id="body">
           <b><div class="text-center" style="color:chartreuse;"><?php echo 'Mail Sent';?></div></b>  
            <?php }else{
      echo'error';
    }
    $mail->smtpClose();
      $url =  "view_seller.php";
      header("Location:".$url);
     }else{
      $url = "msg.php?msg=Something Went Wrong&color=text-danger";
      header("Location:".$url);
  }
    }else{
        $sql = "update sellers set status='Authorized' where seller_id='".$seller_id."'";
        if($conn->query($sql)==TRUE){
          $mail->addAddress($result['email']);
          $mail->Body = '<p>This is a quick notice that your account was just activated.</p>';
          if($mail->send()){?>
              <div id="body">
               <b><div class="text-center" style="color:chartreuse;"><?php echo 'Mail Sent';?></div></b>  
                <?php }else{
          echo'error';
        }
        $mail->smtpClose();
          $url =  "view_seller.php";
          header("Location:".$url);
         }else{
          $url = "msg.php?msg=Something Went Wrong&color=text-danger";
          header("Location:".$url);
      }
    }
   
}


?>
