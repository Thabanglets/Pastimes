<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <div class="container">
        <div class="side-panel">
            <img src="img/regi_img.png" alt="Background" class="bg-image">
            <div class="content-overlay">
                <h1>Shape the <br>future of <span>luxury.</span></h1>
                <p>Join an exclusive community of fashion curators and high-end buyers.</p>
            </div>
        </div>

        <div class="form-panel">
            <div class="form-wrapper">
                <h2>Create your account</h2>
                <br>
                <h4>Account Type</h4>
                <br>
                <form action="register.php" method="POST">
                   
        <div >
            <div class="radio-group">
                <label class="radio-card">
                <input type="radio" name="account_type" value="buyer">
                <span class="card-content">Buyer</span>
                </label>
                
                <label class="radio-card">
                <input type="radio" name="account_type" value="seller">
                <span class="card-content">Seller</span>
                </label>

                <label class="radio-card">
                <input type="radio" name="account_type" value="admin">
                <span class="card-content">Admin</span>
                </label>
            </div>
        </div>
        <br>
                    
                    <input type="text" placeholder="Full Name"  name="user_name">
                    <input type="email" placeholder="Email Address" name="user_email">
                    <input type="password" placeholder="Password" name="user_password">
                    
                    <button type="add"  name="add" class="primary-btn">
                        Create Account →
                    </button>
                </form>
                <br>
                <p>
                    don't have an account? <a href="login.php">Sign in</a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>

<?php 
include("dbCon.php");

if(isset($_POST['add'])){
    $fName = $_POST['user_name'];
$email = $_POST['user_email'];
$pass = md5($_POST['user_password']);
$aType = $_POST['account_type'];
$Astatus = "pending";

$sql ="INSERT INTO tbl_user(FullName,Email,user_Password,user_Role,account_status)VALUES('$fName','$email','$pass','$aType','$Astatus')";

if(mysqli_query($link,$sql)){
    echo"user added";
    header("Location:login.php");
}else{
    echo"user not added";

}
}

?>