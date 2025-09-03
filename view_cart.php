<?php include("head.php") ?>
<?php include("dbConn.php") ?>
<?php 
$view_type = $_GET['view_type'];
$sql=null;
if($_SESSION['role']=='farmer'){
$farmer_id = $_SESSION['farmer_id'];
    if($view_type=='Cart'){
        $sql = " select * from orders where farmer_id = '".$farmer_id."' and  status='Cart'  ORDER BY order_id DESC";                                                                                                           
    }else if($view_type=='Ordered'){
        $sql = "SELECT * FROM orders 
        WHERE farmer_id = '$farmer_id' 
        AND (status = 'Delivered' OR status = 'DeliveryBoy Assigned' OR status = 'Dispatched' OR status = 'Ordered')
        ORDER BY 
            CASE 
                WHEN status = 'Dispatched' THEN 1
                ELSE 2
            END,
            order_id DESC";
                }else if($view_type=='History'){
        $sql = " select * from orders where farmer_id = '".$farmer_id."' and  (status='Order Cancelled' or status='Delivered' or status='Reviewed')  ORDER BY order_id DESC";
    }
}else if($_SESSION['role']=='seller'){
$seller_id = $_SESSION['seller_id'];
    if($view_type=='Ordered'){
        $sql = " select * from orders where seller_id = '".$seller_id."' and  (status='Ordered' or status='DeliveryBoy Assigned')  ORDER BY order_id DESC ";                                                                                                           
    }else if($view_type=='Dispatched'){
        $sql = " select * from orders where seller_id = '".$seller_id."' and  status='Dispatched'  ORDER BY order_id DESC";
    }else if($view_type=='History'){
        $sql = " select * from orders where seller_id = '".$seller_id."' and  (status='Order Cancelled' or status='Delivered' or status='Reviewed')  ORDER BY order_id DESC ";
    }
}else if($_SESSION['role']=='admin'){
    if($view_type=='Ordered'){
        $sql = " select * from orders where (status='Ordered' or status='DeliveryBoy Assigned')  ORDER BY order_id DESC ";                                                                                                           
    }else if($view_type=='Dispatched'){
        $sql = " select * from orders where status='Dispatched'  ORDER BY order_id DESC";
    }else if($view_type=='History'){
        $sql = " select * from orders where (status='Order Cancelled' or status='Delivered' or status='Reviewed')  ORDER BY order_id DESC ";
    }
}else if($_SESSION['role']=='deliveryboy'){
    if($view_type=='Ordered'){
        $sql = " select * from orders where (status='DeliveryBoy Assigned' or status='Dispatched') and deliveryboy_id='".$_SESSION['deliveryboy_id']."'  ORDER BY order_id DESC";                                                                                                           
    }else if($view_type=='History'){
        $sql = " select * from orders where (status='Order Cancelled' or status='Delivered' or status='Reviewed') and deliveryboy_id='".$_SESSION['deliveryboy_id']."'  ORDER BY order_id DESC";
    }
}
$orders = $conn->query($sql);
if($orders ->num_rows > 0){
    foreach($orders as $order){
        $sql = "select * from sellers  where seller_id= '".$order['seller_id']."'";
        $sellers = $conn->query($sql);
        $sql = "select * from farmers  where farmer_id= '".$order['farmer_id']."'";
        $farmers = $conn->query($sql);
        $sql = "select * from order_items where order_id = '".$order['order_id']."'";
        $order_items = $conn->query($sql);
        $sql = "select * from payments where order_id = '".$order['order_id']."'";
        $payments = $conn->query($sql);
        ?>
        <div class="row p-25">
            <div class="w-100">
                <div class="card mt-50 p-15 bg-secondary">
                    <div class="card-header">
                        <div class="row">
                            <div class="w-20">
                                <div class="w-100 h6">Seller</div>
                                <div class="">
                                <?php foreach($sellers as $seller){ ?>
                                    <div class="mt-5">
                                        <?php echo $seller['first_name']?> <?php echo $seller['last_name']?>
                                    </div>
                                <?php }?> 
                                </div>
                            </div>
                            <div class="w-20">
                                <div class="h6">Farmer</div>
                                <div class="">
                                    <?php foreach($farmers as $farmer){ ?>
                                        <div class="mt-5">
                                            <?php echo $farmer['first_name']?> <?php echo $farmer['last_name']?>
                                        </div>
                                    <?php }?> 
                                </div>
                            </div>
                            <div class="w-20">
                                <div class="h6">Date</div>
                                <div class="mt-5">
                                <?php echo $order['date']?></div>
                                </div>
                            <div class="w-20">
                                <div class="h6">Status</div>
                                <div class="mt-5">
                                <?php echo $order['status']?></div>
                            </div>
                            <div class="w-20">
                                <?php if($order['status']!='Cart'){
                                        foreach($payments as $payment){?>
                                    <div class="mt-10">
                                        <a href="view_payments.php?order_id=<?php echo $order['order_id'] ?>&payment_id=<?php echo $payment['payment_id'] ?>" class="btn bg-success p-5 text-white ">View Payments</a>
                                    </div>
                                <?php } }?>
                            </div>
                            <!-- <div class="w-10">
                                <?php if($order['status']=='Reviewed'){?>
                                    <div class=" h6">Reviews</div>
                                    <div class="mt-5">
                                        <a href="view_review.php?farmer_id=<?php echo $farmer['farmer_id'] ?>&order_id=<?php echo $order['order_id'] ?>" class="btn bg-success p-5 text-white  mt-5">View Reviews</a>
                                    </div>
                                <?php } ?>
                            </div> -->
                        </div>
                    </div>
                    <div class="card-body mt-5">
                        <div class="row">
                            <?php
                            $total_price = 0;
                                foreach($order_items as $order_item){
                                    $sql = "select * from product_availability where product_availability_id = '".$order_item['product_availability_id']."'";
                                    $product_availability = $conn->query($sql);
                                ?>
                                <!-- <div class="w-5 p-15"></div> -->
                                <div class="w-18 p-15">
                                    <div class="card mt-10 p-15 bg-secondary">
                                        <?php foreach($product_availability as $product_availabile){
                                            $sql = "select * from products where product_id =  '".$product_availabile['product_id']."'";
                                            $products = $conn->query($sql);
                                                foreach($products as $product){
                                                    $total_price = $total_price+$product_availabile['price']*$order_item['quantity'];
                                                    ?>
                                                <div class="text-center h5 text-secondary  mt-5"><?php echo $product['product_name'] ?></div>
                                                <div class="" >
                                                    <img src="static/<?php echo $product['image']?>" class="img img-bordered" style="width:250px; height:150px;">
                                                </div>
                                                <div class="">
                                                    <div class="" style="font-size:14px">Quantity : <?php echo $order_item['quantity'] ?></div>
                                                </div>
                                                <div class="">
                                                    <div class="" style="font-size:14px">Price : $<?php echo $product_availabile['price'] ?></div>
                                                </div>
                                                <div class="">
                                                    <div class="" style="font-size:14px">Total price : $<?php echo $product_availabile['price']*$order_item['quantity'] ?></div>
                                                </div>
                                                <?php if($_SESSION['role']=='farmer'){
                                                    if($order['status']=='Cart'){
                                                    ?>
                                                    <a href="remove.php?order_item_id=<?php echo $order_item['order_item_id'] ?>&order_id=<?php echo $order_item['order_id'] ?>" class="btn bg-danger p-5  text-white mt-5">Remove</a>
                                                <?php } } ?>
                                        <?php } }?> 
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row p-10 mt-5">
                            <div class="w-20">
                                <div class="h5" >Total price : $<?php echo $product_availabile['price']*$order_item['quantity'] ?></div>
                            </div>
                            <div class="w-20">
                                <div class="h5" >Order Type : <?php echo $order['order_type'] ?></div>
                            </div>
                            <?php if($order['order_type']=='delivery'){ ?>
                            <div class="w-20">
                                <?php 
                                $delivery_sql = "select * from deliveryboys where deliveryboy_id='".$order['deliveryboy_id']."'";
                                $deliveryboys = $conn->query($delivery_sql);
                                 ?>
                                 <?php foreach($deliveryboys as $deliveryboy){ ?>
                                <div class="h5" >DeliveryBoy : <?php echo $deliveryboy['name'] ?></div>
                                <?php }?>
                            </div>
                            <?php }?>
                            <div class="w-20">
                                <?php if($_SESSION['role']=='farmer'){
                                    if($order['status']=='cart'){
                                    ?>
                                    <form action="order_now.php" method="post">
                                        <input type="hidden" name="order_id" value="<?php echo $order['order_id'] ?>">
                                        <input type="hidden" name="total_price" value="<?php echo $total_price ?>">
                                        <input type="submit" value="Order Now" class="btn bg-success p-10  text-white">
                                    </form>

                                <?php }  ?>
                                <?php
                                    if($order['status']=='Ordered'){
                                        foreach($payments as $payment){?>
                                    <form action="cancel_order.php" method="post">
                                        <input type="hidden" name="order_id" value="<?php echo $order['order_id'] ?>">
                                        <input type="hidden" name="payment_id" value="<?php echo $payment['payment_id'] ?>">
                                        <input type="submit" value="Cancel Order" class="btn bg-danger p-10  text-white">
                                    </form>
                                <?php }} ?>
                                <?php
                                    if($order['status']=='Dispatched'){?>
                                    <form action="delivered.php" method="post">
                                        <input type="hidden" name="order_id" value="<?php echo $order['order_id'] ?>">
                                        <input type="submit" value="mark as received" class="btn bg-success p-10  text-white">
                                    </form>
                                <?php } ?>
                                <?php
                                    if($order['status']=='Delivered'){
                                        foreach($farmers as $farmer){
                                        ?>
                                    <form action="reviews.php" method="post">
                                        <input type="hidden" name="order_id" value="<?php echo $order['order_id'] ?>">
                                        <input type="hidden" name="farmer_id" value="<?php echo $farmer['farmer_id'] ?>">
                                        <input type="submit" value="Give Review&Rating" class="btn bg-success p-10  text-white">
                                    </form>
                                <?php }}} ?>
                            </div>
                            <div class="w-20">
                                <?php if($_SESSION['role']!='farmer'){
                                    if($order['status']=='Ordered'){

                                    ?>
                                    <?php if($order['order_type']=='delivery'){ 
                                        ?>

                                    <form action="assignToDeliveryBoy.php" method="post">
                                        <input type="hidden" name="order_id" value="<?php echo $order['order_id'] ?>">
                                        <input type="submit" value="Assign DeliveryBoy" class="btn bg-success p-10  text-white">
                                    </form>
                                    <?php }else { ?>
                                        <form action="dispatched.php" method="post">
                                        <input type="hidden" name="order_id" value="<?php echo $order['order_id'] ?>">
                                        <input type="submit" value="Dispatched" class="btn bg-success p-10  text-white">
                                    </form>
                                        <?php } ?>
                                <?php } } ?>
                                <?php if($_SESSION['role']=='deliveryboy'){?>
                                    <?php if($order['status']=='DeliveryBoy Assigned'){?>
                                        <form action="dispatched.php" method="post">
                                        <input type="hidden" name="order_id" value="<?php echo $order['order_id'] ?>">
                                        <input type="submit" value="Dispatched" class="btn bg-success p-10  text-white">
                                        <?php } ?>
                                    <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-20"></div>
            </div>
        </div>
    <?php }?>
  <?php 
}else{
    $url = "msg.php?msg=There is No Orders&color=text-danger";
    header("Location:".$url);
}

?>