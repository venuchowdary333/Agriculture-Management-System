<?php include("head.php") ?>
<?php include("dbConn.php") ?>

<div class="row">
    <div class="w-10"></div>
    <div class="w-40">
        <div class="card mt-100  bg-secondary">
            <div class="row">
                <div class="w-50">
                    <img src="https://media.licdn.com/dms/image/D5612AQG6Rb_DhL5cAg/article-cover_image-shrink_600_2000/0/1708009028937?e=2147483647&v=beta&t=_y0344RxWZ84g32-qy0iBNKn5fk_Mc-dPInoh6To8zg" alt="" class="img" style="width:500px; height:250px;">  
                </div>
                <div class="w-50 p-10">
                    <div class="text-center text-secondary mt-20  h5">Add Category</div>
                    <form action="add_category_action.php" method="POST">
                        <div class="form-group  mt-25">
                            <input type="text" name="category_name" id="category_name" class="form-control p-5 bg-secondary" placeholder="" required>
                            <label for="category_name" class="form-label p-5">Enter Category Name</label>
                            <!-- <div class="middle"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16"><path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/></svg></div> -->
                        </div>
                        <input type="submit" value="Add Category" class="btn bg-primary text-white p-10 mt-25">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="w-40 mt-35 p-10">
        <?php 
        $sql = "select * from categories";
        $categories = $conn->query($sql);
        ?>
        <div class="text-center h4 text-secondary  mt-40">View Categories</div>
        <div class="p-15">
        <table id="mytable" class="table text-secondary w-100">
        <thead>     
            <tr>
            <th>Category Name</th>
        </tr>
        </thead>
        <tbody>
            <?php foreach($categories as $category){ ?>
                <tr>
                    <td><?php echo $category['category_name']?></td>
                <tr>
            <?php  }?>
        </tbody>
        </table>
        </div>
    </div>
</div>