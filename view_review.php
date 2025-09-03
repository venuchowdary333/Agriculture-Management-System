<?php include("head.php") ?>
<?php include("dbConn.php") ?>

<?php 
 $sql = "select * from reviews";
 $reviews = $conn->query($sql);
?>


<div class="text-center h4 text-secondary  mt-40">View Ratings</div>
<div class="p-15">
<table id="mytable" class="table text-secondary w-100">
   <thead>     
    <tr>
    <th>Farmer</th>
    <th>Rating</th>
    <th>Review</th>
  </tr>
</thead>
<tbody>
    <?php foreach($reviews as $review){
        $sql2 = "select * from farmers where farmer_id = '".$review['farmer_id']."'";
        $farmers = $conn->query($sql2); ?>
        <tr>
            <td>
            <?php foreach($farmers as $farmer){ ?>
                    <?php echo $farmer['first_name']?> <?php echo $farmer['last_name']?>
            <?php }?>
            </td>
            <td><?php echo $review['rating']?></td>
            <td><?php echo $review['review']?></td>
        <tr>
    <?php  }?>
</tbody>
</table>
</div>