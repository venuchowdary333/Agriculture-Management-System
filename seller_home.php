<?php include("head.php") ?>
<div class style="text-align:center;font-size:20px;color:white">Back Orders</div>
<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            background-image: url('https://t4.ftcdn.net/jpg/02/18/14/31/360_F_218143118_wBJifMoT9SHMTFocLvN6nGLBT2EEx42j.jpg');
            background-size: cover;
            background-position: cover;
            background-repeat: no-repeat;
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
</body>
</html>
<?php include("dbConn.php") ?>
<?php 
$sql="";
if($_SESSION['role']=='farmer'){
$farmer_id = $_SESSION['farmer_id'];
  $sql = " select * from backorders where farmer_id = '".$farmer_id."' and  status='Pending' ";                                                                                                           

}else if($_SESSION['role']=='seller'){
$seller_id = $_SESSION['seller_id'];
$sql = " select * from backorders where product_availability_id in(select product_availability_id from product_availability where seller_id='".$seller_id."') and  status='Pending' ";                                                                                                           

}
$backOrders = $conn->query($sql);
if($backOrders ->num_rows > 0){
    
    foreach($backOrders as $backOrder){
        $order_sql = "select * from orders where order_id='".$backOrder['order_id']."'";
        $orders= $conn->query($order_sql);
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
                                <?php echo $backOrder['created_at']?></div>
                                </div>
                            <div class="w-20">
                                <div class="h6">Status</div>
                                <div class="mt-5">
                                <?php echo $backOrder['status']?></div>
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
                                                    <div class="" style="font-size:14px">Quantity : <?php echo $backOrder['quantity'] ?></div>
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
                                <div class="h5" >Total price : $<?php echo $total_price ?></div>
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
                        
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-20"></div>
            </div>
        </div>
    <?php }?>
    <?php }?>
  <?php 
}else{
    $url = "msg.php?msg=There is No Orders&color=text-danger";
    header("Location:".$url);
}

?>