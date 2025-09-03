<?php include("links.php") ?>
<?php SESSION_start(); ?>
<?php 
if(empty($_SESSION['role'])){?>

<nav class="nav bg-primary  w-90 mt-15">
    <div class="nav-item">
        <div class="logo p-10 text-secondary">Agriculture Store Management Platform</div>
    </div>
    <div class="nav-item ">
        <div class="nav-menu">
            <div class="nav-menu-item"><a href="index.php" class="nav-link text-primary p-15">Home</a></div>
            <div class="nav-menu-item"><a href="admin_login.php"class="nav-link text-primary p-15">Admin</a></div>
            <div class="nav-menu-item"><a href="seller_login.php" class="nav-link text-primary p-15">Seller</a></div>
            <div class="nav-menu-item"><a href="farmer_login.php" class="nav-link text-primary p-15">Farmer</a></div>
            <div class="nav-menu-item"><a href="dLogin.php" class="nav-link text-primary p-15">DeliveryBoy</a></div>
        </div>
    </div>
</nav>

<?php }elseif($_SESSION['role']=='admin'){?>
<nav class="nav bg-primary  w-90 mt-15 p-15">
    <div class="nav-item">
        <div class="logo p-10 text-secondary">Agriculture</div>
    </div>
    <div class="nav-item ">
        <div class="nav-menu">
            <div class="nav-menu-item"><a href="admin_home.php" class="nav-link text-primary p-15">Home</a></div>
            <div class="nav-menu-item"><a href="delivery_boys.php"class="nav-link text-primary p-15">DeliveryBoys</a></div>
            <div class="nav-menu-item"><a href="view_seller.php"class="nav-link text-primary p-15">Sellers</a></div>
            <div class="nav-menu-item"><a href="add_location.php"class="nav-link text-primary p-15">Locations</a></div>
            <div class="nav-menu-item"><a href="add_category.php" class="nav-link text-primary p-15">Categories</a></div>
            <div class="nav-menu-item"><a href="add_product.php" class="nav-link text-primary p-15">AddProduct</a></div>
            <div class="nav-menu-item"><a href="view_products.php?category_id=&product_name=" class="nav-link text-primary p-15">Products</a></div>
            <div class="nav-menu-item"><a href="view_cart.php?view_type=Ordered" class="nav-link text-primary p-15">Orders</a></div>
            <div class="nav-menu-item"><a href="view_cart.php?view_type=Dispatched" class="nav-link text-primary p-15">Dispatched</a></div>
            <div class="nav-menu-item"><a href="view_cart.php?view_type=History" class="nav-link text-primary p-15">History</a></div>
            <div class="nav-menu-item"><a href="logout.php" class="nav-link text-primary p-15">Logout</a></div>
        </div>
    </div>
</nav>
<?php }else if($_SESSION['role']=='seller'){?>

<nav class="nav bg-primary  w-90 mt-15">
    <div class="nav-item">
        <div class="logo p-10 text-secondary">Agriculture Store Management Platform</div>
    </div>
    <div class="nav-item ">
        <div class="nav-menu">
            <div class="nav-menu-item"><a href="seller_home.php" class="nav-link text-primary p-15">Back Orders</a></div>
            <div class="nav-menu-item"><a href="add_product.php" class="nav-link text-primary p-15">Products</a></div>
            <div class="nav-menu-item"><a href="view_products.php?category_id=&product_name=" class="nav-link text-primary p-15">View Products</a></div>
            <div class="nav-menu-item"><a href="view_cart.php?view_type=Ordered" class="nav-link text-primary p-15">Orders</a></div>
            <div class="nav-menu-item"><a href="view_cart.php?view_type=Dispatched" class="nav-link text-primary p-15">Dispatched</a></div>
            <div class="nav-menu-item"><a href="view_cart.php?view_type=History" class="nav-link text-primary p-15">History</a></div>
            <div class="nav-menu-item"><a href="logout.php" class="nav-link text-primary p-15">Logout</a></div>
        </div>
    </div>
</nav>

<?php }elseif($_SESSION['role']=='farmer'){?>

<nav class="nav bg-primary  w-90 mt-15">
    <div class="nav-item">
        <div class="logo p-10 text-secondary">Agriculture Store Management Platform</div>
    </div>
    <div class="nav-item ">
        <div class="nav-menu">
            <div class="nav-menu-item"><a href="farmer_home.php" class="nav-link text-primary p-15">Farmer Home</a></div>
            <div class="nav-menu-item"><a href="view_products.php?category_id=&product_name=" class="nav-link text-primary p-15">View Products</a></div>
            <div class="nav-menu-item"><a href="view_cart.php?view_type=Cart" class="nav-link text-primary p-15">View Cart</a></div>
            <div class="nav-menu-item"><a href="view_cart.php?view_type=Ordered" class="nav-link text-primary p-15">Orders</a></div>
            <div class="nav-menu-item"><a href="view_cart.php?view_type=History" class="nav-link text-primary p-15">History</a></div>
            <div class="nav-menu-item"><a href="logout.php" class="nav-link text-primary p-15">Logout</a></div>
        </div>
    </div>
</nav>

<?php }elseif($_SESSION['role']=='deliveryboy'){?>

    <nav class="nav bg-primary  w-90 mt-15">
    <div class="nav-item">
        <div class="logo p-10 text-secondary">Agriculture Store Management Platform</div>
    </div>
    <div class="nav-item ">
        <div class="nav-menu">
            <div class="nav-menu-item"><a href="deliveryboy_home.php" class="nav-link text-primary p-15">DeliveyBoy Home</a></div>
            <div class="nav-menu-item"><a href="view_cart.php?view_type=Ordered" class="nav-link text-primary p-15">Orders</a></div>
            <div class="nav-menu-item"><a href="view_cart.php?view_type=History" class="nav-link text-primary p-15">History</a></div>
            <div class="nav-menu-item"><a href="logout.php" class="nav-link text-primary p-15">Logout</a></div>
        </div>
    </div>
</nav>


<?php }


?>



