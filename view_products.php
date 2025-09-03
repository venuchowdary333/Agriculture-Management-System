<?php include("head.php") ?>
<?php include("dbConn.php") ?>

<?php 
    $category_id = $_GET['category_id'];
    $product_name = $_GET['product_name'];
    if($category_id == null){
        $category_id = "";
    }
    if($product_name == null){
        $product_name = "";
    }
    $sql = "select * from products";
    if($category_id == ""){
        $sql = "select * from products where product_name like '%".$product_name."%'";
    }else if($category_id != ""){
        $sql = "select * from products where product_name like '%".$product_name."%' and category_id = '".$category_id."'";
    }
    
    $products = $conn->query($sql);
    $sql = "select * from categories";
    $categories = $conn->query($sql);
?>

<div class="text-center h4 text-secondary  mt-40">View Products</div>
<div class="w-80 m-auto">
    <form action="view_products.php">
        <div class="row">
            <div class="w-30">
                <div class="form-group p-5 mt-25">
                    <select name="category_id" id="category_id" class="form-control p-5 bg-secondary" placeholder="">
                        <option value="">Choose Category</option>
                        <?php foreach($categories as $category){ ?>
                            <option value="<?php echo $category['category_id']?>"><?php echo $category['category_name']?></option>
                            <?php  }?>
                    </select>
                </div>
            </div>
            <div class="w-30">
                <div class="form-group p-5 mt-25">
                    <input type="text" name="product_name" id="product_name" class="form-control p-5 bg-secondary" placeholder="">
                    <label for="product_name" class="form-label p-5">Enter Product Name</label>
                </div>
            </div>
            <div class="w-30">
                <input type="submit" value="Search" class="btn bg-primary text-white p-10 mt-20">
            </div>
        </div>

    </from>
</div>

<div class="row">
    <?php foreach($products as $product){
        $sql2 = "select * from categories where category_id= '".$product['category_id']."'";
        $categories = $conn->query($sql2);
        // echo $sql2
         ?>
    
        <div class="w-5"></div>
        <div class="w-15">
            <div class="card mt-20 p-10 bg-secondary">
            <div class="text-center h5 text-secondary  mt-5"><?php echo $product['product_name'] ?></div>
               
                <div class="row">
                    <div class=" w-100 p-10 mt-5">
                        <div class="" >
                            <img src="static/<?php echo $product['image']?>" class="img img-bordered" style="width:250px; height:150px;">
                        </div>
                        <div class="div">
                            <div class="h6">price: $<?php echo $product['price'] ?></div>
                        </div>
                        <?php foreach($categories as $category){ ?>
                            <div class="div">
                                <div class="h6"><?php echo $category['category_name']?> Category</div>
                            </div>
                        <?php }?>
                        <?php if($_SESSION['role']=='admin'){?>
                            <a href="view_availability.php?product_id=<?php echo $product['product_id'] ?>" class="btn bg-primary text-white p-10 mt-5">View Availability</a>
                        <?php } ?>
                        <?php
                            if($_SESSION['role']=='seller'){
                                $sql = "select * from product_availabily where product_id='".$product['product_id']."' and seller_id='".$_SESSION['seller_id']."' ";    
                            }
                        ?>
                        <?php if($_SESSION['role']=='seller'){?>
                            <a href="update_quantity.php?product_id=<?php echo $product['product_id'] ?>&price=<?php echo $product['price'] ?>" class="btn bg-primary text-white p-10 mt-5">Update Quantity</a>
                        <?php } ?>
                        <?php if($_SESSION['role']=='farmer'){?>
                            <a href="view_availability.php?product_id=<?php echo $product['product_id'] ?>" class="btn bg-primary text-white p-10 mt-5">add To cart</a>
                        <?php } ?>
                        <div class="div">
                            <div class=""><?php echo $product['description'] ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php }?>
</div>