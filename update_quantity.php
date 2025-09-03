<?php include("head.php") ?>
<?php include("dbConn.php") ?>
<?php
$product_id = $_GET['product_id'];
$price = $_GET['price'];
?>


<div class="row">
    <div class="w-30"></div>
    <div class="w-20">
    <div class="card mt-100  P-15 bg-secondary">
        <div class="text-center text-secondary mt-20  h5">Update Quantity</div>
        <form action="update_quantity_action.php" method="POST">
            <input type="hidden" name="product_id" value="<?php echo $product_id ?>" >
            <div class="form-group  mt-25">
                <input type="number" min="1" name="quantity" id="quantity" class="form-control p-5 bg-secondary" placeholder="" required>
                <label for="quantity" class="form-label p-5">Enter Quantity</label>
            </div>
            <div class="form-group  mt-25">
                <input type="number" min="1" max="<?php echo $price ?>" name="price" id="price" class="form-control p-5 bg-secondary" placeholder="" required>
                <label for="price" class="form-label p-5">Enter Price</label>
            </div>
            <input type="submit" value="Update Quantity" class="btn bg-primary text-white p-10 mt-25">
        </form>
    </div>
    <div class="w-30"></div>
</div>