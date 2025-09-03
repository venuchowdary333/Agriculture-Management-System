<?php include("head.php") ?>
<?php include("dbConn.php") ?>

<div class="row">
    <div class="w-10"></div>
    <div class="w-30">
        <div class="card mt-100 p-15 bg-secondary">
            <div class="text-center text-secondary h5">Admin Login</div>
            <form action="admin_login_action.php" method="POST">
                <div class="form-group mt-20">
                    <input type="text" name="userName" id="userName" class="form-control p-5 bg-secondary" placeholder="" required>
                    <label for="UserName" class="form-label p-5">UserName</label>
                    <div class="middle"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16"><path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/><path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/></svg></div>
                </div>
                <div class="form-group mt-25">
                    <input type="password" name="password" id="password" class="form-control p-5 bg-secondary" placeholder="" required>
                    <label for="UserName" class="form-label p-5">Password</label>
                    <div class="middle"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye-slash-fill" viewBox="0 0 16 16"><path d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7 7 0 0 0 2.79-.588M5.21 3.088A7 7 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474z"/><path d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12z"/></svg></div>
                </div>
                <input type="submit" value="Login" class="btn bg-primary text-white p-5 mt-15">
            </form>
        </div>
    </div>
    <div class="w-60">

    </div>
</div>





<!-- 
<div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-4 mt-5">
        <div class="card p-5 mt-5">
            <div class="text-center"><h3>Admin Login</h1></div>
            <form action="alogin1.php" method="POST">
                <div class="form-group">
                    <div class="middle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                        <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                        </svg>
                    </div>
                    <input type="text" name="userName" id="userName" class="form-control p-5 bg-info">
                    <label for="UserName" class="form-label p-5">UserName</label>
                </div>
                <input type="submit" value="Login" class="btn bg-primary text-white p-10">
            </div>
        </div>
    </form>
</div> -->