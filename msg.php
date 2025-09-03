<?php include 'head.php'; ?>
<?php 
    $msg = $_GET['msg'];
    $color = $_GET['color'];
?>
<div  class="row mt-50">
    <div class="w-20">
    </div>
    <div class="w-60">  
        <div  class="text-center h1 mt-5  <?php echo $color ?>"><?php echo $msg ?></div>
    </div>
    <div class="w-30">
    </div>
</div>