<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
// ... rest of code
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pastimes || Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="image-panel">
            <div class="overlay-text">
                <p class="tag">NEW SEASON</p>
                <h1>Curated Excellence</h1>
                <h2>PASTIMES</h2>
                <p>Empowering the next generation of fashion curators with surgical precision and artistic soul.</p>
            </div>
        </div>

        <div class="form-panel">
            <div class="form-content">
                <h1>Welcome back</h1>
                <p>Please enter your details to access your curator dashboard.</p>
                
                <!-- <div class="social-buttons">
                    <button class="btn-outline">Google</button>
                    <button class="btn-outline">Apple</button>
                </div> -->
                
                <div class="divider"></div>
                
                <form method="POST" action="">
                    <label>EMAIL ADDRESS</label>
                    <input type="email" placeholder="curator@theatelier.com" name="email">
                    
                    <label>PASSWORD</label>
                    <input type="password" placeholder="••••••••" name="pass">
                    
                    <div class="form-options">
                        <a href="#">Forgot password?</a>
                    </div>
                    
                    <button type="submit" name="login" class="btn-primary">
                        Sign In →
                    </button>
                </form>
                
                <p class="footer-text">Don't have an account? <a href="register.php">Create an account</a></p>
            </div>
        </div>
    </div>
</body>
</html>

<?php
include("dbCon.php");

$error = "";

if (isset($_POST['login'])) {

    $email = $_POST['email'] ?? '';
    $password = md5($_POST['pass'] ?? '');

    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        $sql = "SELECT userID, Email, user_Password, user_Role, account_status FROM tbl_user WHERE Email = '$email'";
        $result = mysqli_query($link, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            
            if ($password == $row['user_Password']) {
                
                // DEBUG: Check what value is in the database
                echo "Debug: account_status = '" . $row['account_status'] . "'<br>";
                
                if ($row['account_status'] == 'active') {
                    
                    $_SESSION['user_id'] = $row['userID'];
                    $_SESSION['email'] = $row['Email'];
                    $_SESSION['role'] = $row['user_Role'];
                    
                    echo "Debug: Everything OK, trying to redirect...";
                    
                    header("Location: buyer-Home.php");
                    exit();
                    
                } else {
                    $error = "Account is disabled.";
                }
            } else {
                $error = "Invalid password.";
            }
            
        } else {
            $error = "User not found.";
        }
        
    }
}
?>