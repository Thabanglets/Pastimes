<?php
session_start();
include("dbCon.php");
$_SESSION['userid'] = 1;
$result = mysqli_query($link,"SELECT * FROM tbl_item ");

if(isset($_POST['add'])){

    $id = $_POST['itemId'];
    $price = $_POST['sellPrice'];
    $quan = $_POST['quantity'];

    if (!isset($_SESSION['userid'])) {
        die("User not logged in");
    }

    $userId = $_SESSION['userid'];
    $sql = "SELECT * FROM tbl_cart WHERE user_id = '$userId' AND product_id = '$id'";

    
    $check = mysqli_query($link,$sql );

    if (mysqli_num_rows($check) > 0) {

    $sql = "UPDATE tbl_cart SET quantity = quantity + $quan WHERE user_id='$userId' AND product_id='$id'";
        mysqli_query($link, $sql);

    } else {
        $sql = "INSERT INTO tbl_cart (user_id, product_id, quantity)
            VALUES ('$userId', '$id', '$quan')";
        mysqli_query($link, $sql);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pastimes || Shop All</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-color: #212121;
            --secondary-color: #757575;
            --border-color: #e0e0e0;
            --bg-light: #f8f9fa;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--primary-color);
            background-color: #fff;
        }

        /* --- Header Styles --- */
        .navbar-custom {
            background-color: #fff;
            padding: 20px 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .navbar-brand {
            font-weight: 700;
            letter-spacing: 2px;
            font-size: 1.5rem;
            text-transform: uppercase;
            color: var(--primary-color) !important;
        }

        .nav-link-custom {
            color: var(--primary-color) !important;
            text-decoration: none;
            font-size: 0.9rem;
            margin: 0 15px;
            font-weight: 500;
            transition: 0.3s;
        }

        .nav-link-custom:hover { color: var(--secondary-color) !important; }

        /* --- Layout --- */
        .container-main {
            padding-top: 120px;
            padding-bottom: 60px;
            max-width: 1400px;
        }

        /* --- Header Section --- */
        .page-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 300;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 15px;
        }

        .breadcrumb-nav {
            font-size: 0.9rem;
            color: var(--secondary-color);
        }

        .breadcrumb-nav a {
            text-decoration: none;
            color: var(--secondary-color);
            transition: 0.2s;
        }

        .breadcrumb-nav a:hover { color: var(--primary-color); }

        /* --- Filter Bar --- */
        .filter-bar {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border-color);
            flex-wrap: wrap;
        }

        .filter-link {
            text-decoration: none;
            color: var(--secondary-color);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: 0.3s;
            position: relative;
        }

        .filter-link:hover, .filter-link.active {
            color: var(--primary-color);
            font-weight: 600;
        }

        .filter-link.active::after {
            content: '';
            position: absolute;
            bottom: -21px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: var(--primary-color);
        }

        /* --- Product Grid --- */
        .product-col {
            margin-bottom: 30px;
        }

        .product-card {
            background: #fff;
            border: 1px solid transparent;
            transition: 0.3s;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            border-color: var(--border-color);
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        }

        .img-container {
            position: relative;
            overflow: hidden;
            background-color: var(--bg-light);
            aspect-ratio: 3/4;
            margin-bottom: 15px;
        }

        .img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .product-card:hover .img-container img {
            transform: scale(1.05);
        }

        .card-details {
            padding: 10px;
            text-align: center;
        }

        .product-name {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--primary-color);
            text-decoration: none;
            display: block;
        }

        .product-price {
            color: var(--secondary-color);
            font-size: 0.95rem;
            margin: 0;
        }

        /* --- Add to Cart (Hidden by default) --- */
        .add-cart-btn {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 15px;
            background: rgba(255,255,255,0.9);
            border: none;
            border-top: 1px solid var(--border-color);
            color: var(--primary-color);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.8rem;
            cursor: pointer;
            transform: translateY(100%);
            transition: all 0.3s ease;
            opacity: 0;
            backdrop-filter: blur(5px);
        }

        .product-card:hover .add-cart-btn {
            transform: translateY(0);
            opacity: 1;
        }

        .add-cart-btn:hover {
            background: var(--primary-color);
            color: #fff;
        }
    </style>
</head>
<body>

    <!-- HEADER -->
    <header class="nvbr">
        <nav class="navbar navbar-expand-lg navbar-light navbar-custom fixed-top">
            <div class="container">
                <a class="navbar-brand" href="buyer-Home.php">PASTIMES</a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link-custom" href="womens_fashion.php">Women</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-custom" href="buyer-Home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-custom" href="Mens_fashion.php">Men</a>
                        </li>
                    </ul>
                </div>

                <div class="d-none d-lg-flex align-items-center">
                    <a href="#profile" class="nav-link-custom">Account</a>
                    <a href="cart.php" class="nav-link-custom">
                        Cart 
                        <!-- Placeholder for Cart Count PHP -->
                        (<?php echo mysqli_fetch_assoc(mysqli_query($link, "SELECT COUNT(*) AS cart FROM tbl_cart"))['cart']; ?>)
                    </a>
                </div>
            </div>
        </nav>

        <!-- Sub Navigation -->
        <div style="background:#fff; padding: 12px 0; border-bottom:1px solid #eee; position:sticky; top:73px; z-index:999;">
            <div class="container d-flex justify-content-center gap-4">
                <a href="explore_product.php" style="text-decoration:none; color:#212121; font-size:0.85rem; font-weight:600; text-transform:uppercase;">Clothing</a>
                <a href="tops&sweaters.php" style="text-decoration:none; color:#757575; font-size:0.85rem; text-transform:uppercase;">Tops & Sweaters</a>
            </div>
        </div>
    </header>

    <div class="container container-main">
        
        <!-- Header Section -->
        <div class="row">
            <div class="col-12 page-header">
                <h1 class="page-title">Collection</h1>
                <div class="breadcrumb-nav">
                    <a href="buyer-Home.php">Home</a> / <span style="color:#212121;">Products</span>
                </div>
            </div>
        </div>

        <!-- Filter Bar -->
        <div class="filter-bar">
            <a href="tops&sweaters.php" class="filter-link active">All Products</a>
            <a href="tops&sweaters-women.php" class="filter-link">Women</a>
            <a href="tops&sweaters-mens.php" class="filter-link">Men</a>
        </div>

        <!-- Product Grid -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="col product-col">
                    <form action="" method="post" class="product-card">
                        <div class="img-container">
                            <a href="productView.php?id=<?php echo $row['ItemID']; ?>">
                                <img src="img/<?php echo $row['Image']; ?>" alt="<?php echo $row['ItemName']; ?>">
                            </a>
                            
                            <!-- Hidden Data -->
                            <input type="hidden" name="itemId" value="<?php echo $row['ItemID']; ?>">
                            <input type="hidden" name="image" value="<?php echo $row['Image']; ?>">
                            <input type="hidden" name="itemName" value="<?php echo $row['ItemName']; ?>">
                            <input type="hidden" name="sellPrice" value="<?php echo $row['Price']; ?>">
                            
                            <!-- Hover Button -->
                            <button type="submit" name="add" class="add-cart-btn">Add to Cart</button>
                        </div>

                        <div class="card-details">
                            <a href="productView.php?id=<?php echo $row['ItemID']; ?>" class="product-name">
                                <?php echo $row['ItemName']; ?>
                            </a>
                            <p class="product-price">R <?php echo number_format($row['Price'], 2); ?></p>
                        </div>
                    </form>
                </div>
            <?php } ?>
        </div>

        
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>