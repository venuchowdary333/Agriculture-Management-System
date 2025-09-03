<?php include("head.php") ?>
<?php include("dbConn.php") ?>
<?php 

 $order_id = $_POST['order_id'];
 $total_price = $_POST['total_price'];
 

    
?>
<div class="row">
    <div class="w-35"></div>
    <div class="w-30">
        <div class="card mt-40 p-15 bg-secondary">
        <div class="text-center h4 text-secondary  mt-10">Pay Now</div>
        <form action="pay_now.php" method="POST">
            <input type="hidden" name="order_id" value="<?php echo $order_id ?>" >
            <input type="hidden" name="total_price" value="<?php echo $total_price ?>" >
            <div class="form-group mt-15">
                <label class="form-label p-5"></label>
                <select name="payment_type" id="payment_type" class="form-control p-5 bg-secondary" placeholder="" required>>
                    <option value="">Choose CardType</option>
                    <option value="credit_card">Credit Card</option>
                    <option value="debit_card">Debit Card</option>
                </select>
            </div>
            <div class="form-group mt-25">
            <select name="order_type" id="order_type" class="form-control p-5 bg-secondary" placeholder="" required>>
                    <option value="">Choose OrderType</option>
                    <option value="delivery">Delivery</option>
                    <option value="pickup">Pick Up</option>
                </select>
                <label for="order_type" class="form-label">Order Type</label>
            </div>
            <div class="form-group mt-25">
                <input type="number" name="card_number" id="card_number" class="form-control bg-secondary" placeholder="" required>
                <label for="card_number" class="form-label">Enter Card Number</label>
            </div>
            <div class="form-group mt-25">
                <input type="text" name="holder_name" id="holder_name" class="form-control bg-secondary" placeholder="" required>
                <label for="holder_name" class="form-label ">Enter Holder Name</label>
            </div>
            <div class="form-group mt-25">
                <input type="number" name="cvv" id="cvv" class="form-control bg-secondary" placeholder="" required>
                <label for="cvv" class="form-label ">CVV</label>
            </div>
            <div class="form-group mt-25">
                <input type="text" name="expiry_date" id="expiry_date" class="form-control bg-secondary" placeholder="" required>
                <label for="expiry_date" class="form-label ">Expriry Date</label>
            </div>
            <div class="form-group mt-25">
                <input  type="text" disabled name="amount" value="$<?php echo $total_price ?>" id="amount" class="form-control p-5 bg-secondary" placeholder="" required>
                <label for="amount"  class="form-label"></label>
            </div>
            <input type="submit" value="Order Now" class="btn bg-success p-10 mt-20 text-white">
        </form>
        </div>
    </div>
</div>

















<!-- $sql = "update orders set status='Ordered' where order_id='".$order_id."'";
    if($conn->query($sql)==TRUE){
        $url =  "msg.php?msg=Ordered Successfully&color=text-success";
        header("Location:".$url);
    } -->