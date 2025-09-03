<?php include("head.php") ?>
<?php include("dbConn.php") ?>
<?php 
    $sql = "select * from sellers";
    $sellers = $conn->query($sql);
?>
<div class="text-center h4 text-secondary  mt-40">View Sellers</div>
<div class="p-15">
<table id="mytable" class="table text-secondary w-100">
   <thead>     
    <tr>
    <th>Seller Id</th>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Email</th>
    <th>Phone Number</th>
    <th>State</th>
    <th>City</th>
    <th>Zipcode</th>
    <th>Address</th>
    <th>Status</th>
    <th>Action</th>
  </tr>
</thead>
<tbody>
    <?php foreach($sellers as $seller){ ?>
        <tr>
            <td><?php echo $seller['seller_id']?></td>
            <td><?php echo $seller['first_name']?></td>
            <td><?php echo $seller['last_name']?></td>
            <td><?php echo $seller['email']?></td>
            <td><?php echo $seller['phone']?></td>
            <td><?php echo $seller['state']?></td>
            <td><?php echo $seller['city']?></td>
            <td><?php echo $seller['zipcode']?></td>
            <td><?php echo $seller['address']?></td>
            <td><?php echo $seller['status'] ?></td>
            <td>
                <?php 
                if($seller['status']=='UnAuthorized'){?>
                <a href="deactivate_seller.php?seller_id=<?php echo $seller['seller_id']?>" class="btn bg-success text-white p-5">Verify</a>
                <?php }else{?>
                <a href="deactivate_seller.php?seller_id=<?php echo $seller['seller_id']?>" class="btn bg-danger text-white p-5">Not Verified</a>
                <?php }?>
            </td>
        
        <tr>
    <?php  }?>
</tbody>
</table>
</div>