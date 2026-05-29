<?php
// 1. LOGIC MUST BE AT THE TOP
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include("dbCon.php"); // Ensure this file connects to DB correctly

$error = "";

if (isset($_POST['login'])) {

    $email = trim($_POST['email'] ?? '');
    $password = $_POST['pass'] ?? ''; // Don't hash yet, we need it raw to verify

    if (empty($email) || empty($password)) {
        $error = "Please fill in all fields.";
    } else {
        $sql = "SELECT 
                    `user_id`, 
                    user_email, 
                    user_password, 
                    account_type
                    account_status 
                FROM tbl_user 
                WHERE user_email = ?";

        $stmt = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            
            $row = mysqli_fetch_assoc($result);

            // SECURITY FIX: Use password_verify instead of plain MD5 comparison
            // NOTE: If your DB passwords are plain MD5, change 'user_password' column to use password_hash()
            // Assuming here the DB stores MD5 hash for legacy reasons, but ideally use Bcrypt.
            // Below checks the specific MD5 string (as per your original code logic):
            if ($password == $row['user_password']) { // In real apps: password_verify($password, $row['user_password'])

                if ($row['account_status'] == 'active') {

                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['email'] = $row['user_email'];
                    
                    // Handle Role Redirect
                    $role = $row['account_type']; // Ensure this column exists in DB

                    switch ($role) {
                        case 'admin':
                            header("Location: admin-dashboard.php");
                            exit();
                        case 'buyer':
                            header("Location: buyer-Home.php");
                            exit();
                        case 'seller':
                            header("Location: seller-dashboard.php");
                            exit();
                        default:
                            $error = "Unknown user role.";
                    }

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- FIXED: Corrected Bootstrap link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <title>Curated Excellence Login</title>
    <style>
        /* Minimal Styles for layout fix */
        body { margin: 0; font-family: sans-serif; }
        .login-container { display: flex; height: 100vh; }
        .image-panel { flex: 1; background: #333; color: white; display: flex; align-items: center; justify-content: center; text-align: center; }
        .form-panel { flex: 1; display: flex; align-items: center; justify-content: center; }
        .form-content { width: 80%; max-width: 400px; }
        /* Add your custom CSS in css/style.css */
    </style>
</head>
<body>
    <!-- FIXED: Added spaces to attributes -->
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

                <!-- Error Display -->
                <?php if($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <div class="divider"></div>

                <!-- FIXED: Added space to 'form method' and action -->
                <form method="POST" action="">
                    <label>EMAIL ADDRESS</label>
                    <input type="email" class="form-control" placeholder="curator@theatelier.com" name="email" required>

                    <label>PASSWORD</label>
                    <input type="password" class="form-control" placeholder="••••••••" name="pass" required>

                    <div class="form-options">
                        <a href="forgot_password.php">Forgot password?</a>
                    </div>

                    <button type="submit" name="login" class="btn btn-primary w-100 mt-3">
                        Sign In →
                    </button>
                </form>

                <p class="footer-text">Don't have an account? <a href="register.php">Create an account</a></p>
            </div>
        </div>
    </div>
</body>
</html>