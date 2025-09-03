<?php include("head.php") ?>
<?php include("dbConn.php") ?>

<?php 
 $payment_id = $_GET['payment_id'];
 $sql = "select * from payments where payment_id = '".$payment_id."'";
 $payments = $conn->query($sql);
?>

<div class="text-center h4 text-secondary  mt-40">View Payments</div>
<div class="p-15">
<table id="mytable" class="table text-secondary w-100">
   <thead>     
    <tr>
    <th>Payment Id</th>
    <th>Payment Type</th>
    <th>Card Number</th>
    <th>Holder Name</th>
    <th>Cvv</th>
    <th>Amount</th>
    <th>Status</th>
  </tr>
</thead>
<tbody>
    <?php foreach($payments as $payment){ ?>
        <tr>
            <td><?php echo $payment['payment_id']?></td>
            <td><?php echo $payment['payment_type']?></td>
            <td><?php echo $payment['card_number']?></td>
            <td><?php echo $payment['holder_name']?></td>
            <td><?php echo $payment['cvv']?></td>
            <td><?php echo $payment['amount']?></td>
            <td><?php echo $payment['status']?></td>
        <tr>
    <?php  }?>
</tbody>
</table>
</div>