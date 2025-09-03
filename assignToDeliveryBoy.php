<?php include("head.php") ?>
<?php include("dbConn.php") ?>
<?php 
$order_id = $_POST['order_id'];
$sql = "select * from deliveryboys";
$deliveryboys = $conn->query($sql);
?>

<div class="row">
    <div class="w-20"></div>
    <div class="w-60">
        <div class="card mt-100  bg-secondary">
            <div class="row">
                <div class="w-50">
                    <img src="https://news.mit.edu/sites/default/files/styles/news_article__image_gallery/public/images/201607/Greenhouse-agriculture_0.jpg?itok=1KcBWb7U" alt="" class="img" style="width:500px; height:450px;">  
                </div>
                <div class="w-50 p-10">
                    <form action="assignDeliveryBoyAction.php" method="POST" >
                        <input type="hidden" name="order_id" value="<?php echo $order_id ?>">
                        <div class="form-group  mt-25">
                            <select name="deliveryboy_id" id="deliveryboy_id" class="form-control p-15 bg-secondary" placeholder="" required style="padding:20px">
                                <option value="">Choose DeliveryBoy</option>
                                <?php foreach($deliveryboys as $deliveryboy){ ?>
                                    <?php 
                                        $sql3 ="select * from locations where location_id='".$deliveryboy['location_id']."'";
                                        $locations = $conn->query($sql3);
                                        
                                        ?>
                                        <?php foreach($locations as $location){?>
                                    <option value="<?php echo $deliveryboy['deliveryboy_id']?>"><?php echo $deliveryboy['name']?>--<?php echo $location['location_name']?>(<?php echo $location['zipcode']?>)</option>
                                    <?php  }?>
                                    <?php  }?>
                            </select>
                        </div>
                    
                        <input type="submit" value="Assign" class="btn bg-primary text-white p-10 mt-15">
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>