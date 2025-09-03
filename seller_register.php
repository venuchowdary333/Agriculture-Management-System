<?php include("head.php") ?>
<?php include("dbConn.php") ?>
<?php 
$sql = "select * from locations";
$locations= $conn->query($sql);
?>

<div class="row">
    <div class="w-35"></div>
    <div class="w-25">
        <div class="card mt-30 p-15 bg-secondary">
            <form action="seller_register_action.php" method="post">
                <div class="text-center text-secondary h5">Seller Registration</div>
                    <div class="form-group mt-25">
                        <label class="form-label p-5"></label>
                        <select name="location_id" id="location_id" class="form-control p-5 bg-secondary" placeholder="" required>>
                            <option value="">Choose Location</option>
                            <?php foreach($locations as $location){ ?>
                                <option value="<?php echo $location['location_id']?>"><?php echo $location['location_name']?></option>
                                <?php  }?>
                        </select>
                    </div>
                    <div class="form-group mt-15">
                        <input type="text" name="first_name" id="first_name" class="form-control p-5 bg-secondary" placeholder="" required>
                        <label for="first_name" class="form-label p-5">Enter First Name</label>
                        <div class="middle"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16"><path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/><path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/></svg></div>
                    </div>
                    <div class="form-group mt-25">
                        <input type="text" name="last_name" id="last_name" class="form-control p-5 bg-secondary" placeholder="" required>
                        <label for="last_name" class="form-label p-5">Enter Last Name</label>
                        <div class="middle"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16"><path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/><path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/></svg></div>
                    </div>
                    <div class="form-group mt-25">
                        <input type="phone" name="phone" id="phone" class="form-control p-5 bg-secondary" placeholder="" required>
                        <label for="number" class="form-label p-5">Enter Phone Number</label>
                        <div class="middle"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16"><path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.6 17.6 0 0 0 4.168 6.608 17.6 17.6 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.68.68 0 0 0-.58-.122l-2.19.547a1.75 1.75 0 0 1-1.657-.459L5.482 8.062a1.75 1.75 0 0 1-.46-1.657l.548-2.19a.68.68 0 0 0-.122-.58zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.68.68 0 0 0 .178.643l2.457 2.457a.68.68 0 0 0 .644.178l2.189-.547a1.75 1.75 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.6 18.6 0 0 1-7.01-4.42 18.6 18.6 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877z"/></svg></div>
                    </div>
                    <div class="form-group mt-25">
                        <input type="email" name="email" id="email" class="form-control p-5 bg-secondary" placeholder="" required>
                        <label for="email" class="form-label p-5">Enter Email</label>
                        <div class="middle"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16"><path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"/></svg></div>
                    </div>
                    <div class="form-group mt-25">
                        <input type="password" name="password" id="password" class="form-control p-5 bg-secondary" placeholder="" required>
                        <label for="password" class="form-label p-5">Enter Password</label>
                        <div class="middle"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16"><path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z"/><path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z"/></svg></div>
                    </div>
                    <div class="form-group mt-25">
                        <input type="state" name="state" id="state" class="form-control p-5 bg-secondary" placeholder="" required> 
                        <label for="text" class="form-label p-5">Enter State</label>
                    </div>
                    <div class="form-group mt-25">
                        <input type="city" name="city" id="city" class="form-control p-5 bg-secondary" placeholder="" required>
                        <label for="text" class="form-label p-5">Enter City</label>
                    </div>
                    <div class="form-group mt-25">
                        <input type="zipcode" min="1" name="zipcode" id="zipcode" class="form-control p-5 bg-secondary" placeholder="" required>
                        <label for="number" class="form-label p-5">Enter Zipcode</label>
                    </div>
                    <div class="form-group mt-25">
                        <textarea name="address" id="address" class="form-control p-5 bg-secondary" placeholder="" required></textarea>
                        <label for="text" class="form-label p-5">Enter Address</label>
                    </div>
                    <input type="submit" value="Register" class="btn bg-primary text-white p-5 mt-5 ">
            </form>
        </div>
    </div>
    
</div>