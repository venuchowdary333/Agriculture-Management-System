<?php include("head.php") ?>
<?php include("dbConn.php") ?>


<?php 
    $product_id = $_GET['product_id'];
    $sql = "select * from product_availability where product_id='".$product_id."' ";
    $product_availability = $conn->query($sql);
?>

<div class="row">
    <div class="w-20"></div>
    <div class="w-60 mt-30">
        <div class="text-center h4 text-secondary ">View Products Quantity</div>
            <div class="p-20">
            <table id="table" class="table text-secondary w-100 mt-20">
            <thead>     
                <tr>
                <th>Seller Name</th>
                <th>Quantity</th>
                <th>Rating</th>

                <?php if($_SESSION['role']=='farmer'){?>
                    <th>Action </th>
                <?php } ?>
                
            </tr>
            </thead>
            <tbody>
                <?php foreach($product_availability as $product_availability){
                    $sql2 = "select * from sellers where seller_id= '".$product_availability['seller_id']."'";
                    $sellers = $conn->query($sql2); ?>
                    <tr>
                        <td><?php foreach($sellers as $seller){ ?>
                            <div class="div">
                                <div class="h6"><?php echo $seller['first_name']?> <?php echo $seller['last_name']?></div>
                            </div>
                        <?php }?></td>
                        <td><?php echo $product_availability['quantity']?></td>
                        <td>
                            <?php 
                            $sql = "select AVG(rating) as rating from reviews where order_id  in (select order_id from order_items where product_availability_id in (select product_availability_id from product_availability where product_id='".$product_id."' and seller_id = '".$product_availability['seller_id']."' ))";
                            $reviews = $conn->query($sql);
                            foreach($reviews as $review){
                                if($review['rating']==''){
                                    echo "No Review";
                                }else{?>
                                    <a href="view_review.php?product_availability_id = <?php echo $product_availability['product_availability_id']?>" class="btn bd-success"><?php echo $review['rating']?> </a>
                                <?php } 
                            }?>
                        </td>

                        <td>
                        <?php if($_SESSION['role']=='farmer'){?>
                        
                            <div class="row">
                                <div class="w-100">
                                    <form action="add_to_cart_action.php" method="POST">
                                        <input type="hidden" name="product_availability_id" value="<?php echo $product_availability['product_availability_id']?>">
                                        <input type="hidden" name="seller_id" value="<?php echo $product_availability['seller_id']?>">
                                        <div class="row">
                                            <div class="w-5"></div>
                                           
                                        
                                                <div class="w-50">
                                                <div class="form-group  mt-10">
                                                    <input type="number" min="1"  name="quantity" id="quantity" class="form-control p-5 bg-secondary" placeholder="" required>
                                                    <label for="quantity" class="form-label p-5">Enter Quantity</label>
                                                </div>
                                            </div>
                                            <div class="w-45">
                                                <input type="submit" value="add To cart" class="btn bg-primary text-white p-5 mt-5">
                                            </div>
                                      
                                        </div>
                                    </form>
                                </div>
                                <div class="w-30"></div>
                            </div>
                        <?php } ?>
                        </td>
                    
                    <tr>
                <?php  }?>
            </tbody>
            </table>
        </div>
    </div>
    <div class="w-20"></div>
</div>

