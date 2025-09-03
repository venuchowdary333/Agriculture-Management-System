<?php include("head.php") ?>
<?php include("dbConn.php") ?>
<?php
$farmer_id = $_SESSION['farmer_id'];
$order_id = $_POST['order_id'];
?>
<div class="row">
    <div class="w-30"></div>
    <div class="w-30">
        <div class="card mt-40 p-15 bg-secondary">
            <div class="text-center h4 text-secondary  mt-10">Give Review & Ratings Here</div>
            <form action="reviews_action.php" method="POST">
                <input type="hidden" name="order_id" value="<?php echo $order_id ?>" >
                <input type="hidden" name="farmer_id" value="<?php echo $farmer_id ?>" >
                <div class="form-group mt-15">
                    <label class="form-label p-5"></label>
                    <select name="rating" id="rating" class="form-control p-5 bg-secondary" placeholder="" required>>
                        <option value="">Choose Rating</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
                <div class="form-group  mt-25">
                    <textarea name="review" id="review" class="form-control bg-secondary" placeholder="" required></textarea>
                    <label for="review" class="form-label p-5">Enter Review</label>
                </div>
                <input type="submit" value="Give Review & Rating" class="btn bg-primary text-white p-10 mt-15">
            </form>
        </div>
    </div>
    <div class="w-30"></div>
</div>


