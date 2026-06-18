<?php
include("dbCon.php");

$message = "";

if (isset($_POST['add'])) {
    $fName = trim($_POST['user_name']);
    $email = trim($_POST['user_email']);
    $pass = $_POST['user_password'];
    $aType = isset($_POST['account_type']) ? $_POST['account_type'] : '';

    if ($fName === '' || $email === '' || $pass === '' || $aType === '') {
        $message = "Please fill in all fields.";
    } else {
        $hashedPass = md5($pass);
        $Astatus = "pending";

        $sql = "INSERT INTO tbl_user (user_name, user_email, user_password, account_type, account_status)
                VALUES ('$fName', '$email', '$hashedPass', '$aType', '$Astatus')";

        if (mysqli_query($link, $sql)) {
            header("Location: login.php");
            exit();
        } else {
            $message = "User not added: " . mysqli_error($link);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/regi-style.css">
    <title>Register</title>
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
                    <div>
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

                    <input type="text" placeholder="Full Name" name="user_name">
                    <input type="email" placeholder="Email Address" name="user_email">
                    <input type="password" placeholder="Password" name="user_password">

                    <button type="submit" name="add" class="primary-btn">
                        Create Account →
                    </button>
                </form>

                <?php if ($message !== "") { ?>
                    <p style="color:red; margin-top:10px;"><?php echo $message; ?></p>
                <?php } ?>

                <br>
                <p>
                    Already have an account? <a href="login.php">Sign in</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>