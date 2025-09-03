<?php include("head.php") ?>
<?php include("dbConn.php") ?>
<?php 
$sql = "select * from categories";
$categories = $conn->query($sql);
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
                    <div class="text-center text-secondary mt-5  h5">Add product</div>
                    <form action="add_product_action.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group  mt-25">
                            <select name="category_id" id="category_id" class="form-control p-5 bg-secondary" placeholder="" required>
                                <option value="">Choose Category</option>
                                <?php foreach($categories as $category){ ?>
                                    <option value="<?php echo $category['category_id']?>"><?php echo $category['category_name']?></option>
                                    <?php  }?>
                            </select>
                        </div>
                        <div class="form-group  mt-25">
                            <input type="text" name="product_name" id="product_name" class="form-control p-5 bg-secondary" placeholder="" required>
                            <label for="product_name" class="form-label p-5">Enter Product Name</label>
                        </div>
                        <div class="form-group  mt-25">
                            <input type="number" min="1" name="price" id="price" class="form-control p-5 bg-secondary" placeholder="" required>
                            <label for="price" class="form-label p-5">Enter price</label>
                        </div>
                        <div class="form-group mt-25">
                            <input type="file" name="image" id="image" placeholder="" required class="form-control p-5 bg-secondary">
                            <label for="image" class="form-control-label">Picture</label>
                        </div>
                        <div class="form-group  mt-25">
                            <textarea name="description" id="location_name" class="form-control p-5 bg-secondary" placeholder="" required></textarea>
                            <label for="description" class="form-label p-5">Enter Description</label>
                        </div>
                        <input type="submit" value="Add Product" class="btn bg-primary text-white p-10 mt-15">
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>