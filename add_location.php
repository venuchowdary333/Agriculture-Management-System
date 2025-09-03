<?php include("head.php") ?>
<?php include("dbConn.php") ?>

<div class="row">
    <div class="w-10"></div>
    <div class="w-40">
        <div class="card mt-100  bg-secondary">
            <div class="row">
                <div class="w-50">
                    <img src="https://t4.ftcdn.net/jpg/01/57/31/55/360_F_157315504_VRxLgC9W8UgdJx81UQeL8CIlf0YH895U.jpg" alt="" class="img" style="width:500px; height:250px;">  
                </div>
                <div class="w-50 p-5">
                    <div class="text-center text-secondary mt-5  h5">Add Location</div>
                    <form action="add_location_action.php" method="POST">
                        <div class="form-group  mt-25">
                            <input type="text"  name="location_name" id="location_name" class="form-control p-5 bg-secondary" placeholder="" required>
                            <label for="location_name" class="form-label p-5">Enter Location Name</label>
                            <div class="middle"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16"><path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/></svg></div>
                        </div>
                        <div class="form-group  mt-25">
                            <input type="number" min="1" name="zipcode" id="zipcode" class="form-control p-5 bg-secondary" placeholder="" required>
                            <label for="zipcode" class="form-label p-5">Enter Zipcode</label>
                            <div class="middle"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4 4a4 4 0 1 1 4.5 3.969V13.5a.5.5 0 0 1-1 0V7.97A4 4 0 0 1 4 3.999zm2.493 8.574a.5.5 0 0 1-.411.575c-.712.118-1.28.295-1.655.493a1.3 1.3 0 0 0-.37.265.3.3 0 0 0-.057.09V14l.002.008.016.033a.6.6 0 0 0 .145.15c.165.13.435.27.813.395.751.25 1.82.414 3.024.414s2.273-.163 3.024-.414c.378-.126.648-.265.813-.395a.6.6 0 0 0 .146-.15l.015-.033L12 14v-.004a.3.3 0 0 0-.057-.09 1.3 1.3 0 0 0-.37-.264c-.376-.198-.943-.375-1.655-.493a.5.5 0 1 1 .164-.986c.77.127 1.452.328 1.957.594C12.5 13 13 13.4 13 14c0 .426-.26.752-.544.977-.29.228-.68.413-1.116.558-.878.293-2.059.465-3.34.465s-2.462-.172-3.34-.465c-.436-.145-.826-.33-1.116-.558C3.26 14.752 3 14.426 3 14c0-.599.5-1 .961-1.243.505-.266 1.187-.467 1.957-.594a.5.5 0 0 1 .575.411"/></svg></div>
                        </div>
                        <input type="submit" value="Add Location" class="btn bg-primary text-white p-10 mt-15">
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="w-40 mt-35 p-10">
        <?php 
        $sql = "select * from locations";
        $locations = $conn->query($sql);
        ?>
        <div class="text-center h4 text-secondary  mt-40">View Locations</div>
        <div class="p-15">
        <table id="mytable" class="table text-secondary w-100">
        <thead>     
            <tr>
            <th>Location Name</th>
            <th>Zipcode</th>
        </tr>
        </thead>
        <tbody>
            <?php foreach($locations as $location){ ?>
                <tr>
                    <td><?php echo $location['location_name']?></td>
                    <td><?php echo $location['zipcode']?></td>
                <tr>
            <?php  }?>
        </tbody>
        </table>
        </div>
    </div>
</div>