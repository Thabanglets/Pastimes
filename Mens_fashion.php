<?php
session_start();
include("dbCon.php");

$selectedCategory = isset($_GET['category']) ? strtolower(trim($_GET['category'])) : '';

if ($selectedCategory === 'tops' || $selectedCategory === 'sweaters') {
    $result = mysqli_query(
        $link,
        "SELECT * FROM tbl_item WHERE Gender = 'Female' AND (Category = 'tops' OR Category = 'sweaters')"
    );
} else {
    $result = mysqli_query($link, "SELECT * FROM tbl_item WHERE Gender = 'Male'");
}

$userData = null;
$cartCount = 0;

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = intval($_SESSION['user_id']);

// Get logged-in user
$userQuery = mysqli_query(
    $link,
    "SELECT * FROM tbl_user WHERE user_id = $userId"
);

$userData = mysqli_fetch_assoc($userQuery);

if (!$userData) {
    session_destroy();
    header("Location: login.php");
    exit();
}

// Get cart count for this user
$cartQuery = mysqli_query(
    $link,
    "SELECT COUNT(*) AS cart
     FROM tbl_cart
     WHERE user_id = $userId"
);

$cartData = mysqli_fetch_assoc($cartQuery);
$cartCount = $cartData['cart'];

// Add to cart
if (isset($_POST['add'])) {

    $productId = intval($_POST['itemId']);
    $quantity = 1;

    $check = mysqli_query(
        $link,
        "SELECT * FROM tbl_cart
         WHERE user_id = $userId
         AND product_id = $productId"
    );

    if (mysqli_num_rows($check) > 0) {

        mysqli_query(
            $link,
            "UPDATE tbl_cart
             SET quantity = quantity + 1
             WHERE user_id = $userId
             AND product_id = $productId"
        );

    } else {

        mysqli_query(
            $link,
            "INSERT INTO tbl_cart(user_id, product_id, quantity)
             VALUES($userId, $productId, $quantity)"
        );

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pastimes || Mens Collection</title>
    
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
            --border-light: #e0e0e0;
            --bg-light: #f9f9f9;
            --accent-green: #2d3e40;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--primary-color);
            background-color: #fff;
        }

        /* --- Header Styles (Inherited from Home) --- */
        .navbar-custom {
            padding: 20px 0;
            background-color: #fff;
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
        }
        .nav-link-custom:hover { color: var(--secondary-color) !important; }

        /* --- Layout --- */
        .page-wrapper {
            padding-top: 100px; /* Space for fixed header */
            padding-bottom: 60px;
            min-height: 100vh;
        }

        /* --- Sidebar / Filter Section --- */
        .filter-sidebar {
            border-right: 1px solid var(--border-light);
        }
        .filter-group h6 {
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
            font-size: 0.85rem;
        }
        .filter-link {
            display: block;
            text-decoration: none;
            color: var(--secondary-color);
            margin-bottom: 10px;
            font-size: 0.9rem;
            transition: 0.2s;
        }
        .filter-link:hover, .filter-link.active {
            color: var(--primary-color);
            font-weight: 600;
        }

        /* --- Product Grid --- */
        .product-card {
            border: none;
            background: none;
            height: 100%;
            transition: transform 0.3s ease;
        }
        
        /* Image Styling */
        .img-wrapper {
            position: relative;
            overflow: hidden;
            background-color: var(--bg-light);
            aspect-ratio: 3/4;
            margin-bottom: 15px;
        }
        .img-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .product-card:hover .img-wrapper img {
            transform: scale(1.05);
        }

        /* Card Details */
        .product-info h5 {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 5px;
        }
        .product-info p {
            color: var(--secondary-color);
            font-size: 0.9rem;
            margin-bottom: 15px;
        }

        /* Buttons */
        .btn-add {
            width: 100%;
            padding: 10px;
            background: white;
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
            font-weight: 600;
            transition: 0.3s;
            opacity: 0; /* Hidden until hover */
            position: absolute;
            bottom: 0;
            left: 0;
        }
        
        .product-card:hover .btn-add {
            opacity: 1;
            bottom: 0;
        }

        .page-link {
            color: var(--secondary-color);
            text-decoration: none;
        }
        .page-link.active {
            color: var(--primary-color);
            font-weight: bold;
            border-bottom: 1px solid var(--primary-color);
        }
    </style>
</head>
<body>

    <!-- HEADER -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light navbar-custom fixed-top">
            <div class="container">
                <a class="navbar-brand" href="buyer-Home.php">PASTIMES</a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link-custom " href="womens_fashion.php">Women</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-custom" href="buyer-Home.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link-custom active" href="Mens_fashion.php">Men</a>
                        </li>
                    </ul>
                </div>

                <div class="d-none d-lg-flex align-items-center">
                    <a href="#profile" class="nav-link-custom">Account</a>
                    <a href="cart.php" class="nav-link-custom">
                        Cart 
                        <!-- Placeholder for Cart Count PHP -->
                        (<?php echo $cartCount; ?>)
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <div class="container page-wrapper">
        <div class="row">
            <!-- SIDEBAR FILTERS -->
            <div class="col-lg-3 mb-4">
                <div class="filter-sidebar pe-lg-4">
                    <div class="filter-group mb-4">
                        <h6>Categories</h6>
                        <a href="womens_fashion.php" class="filter-link <?php echo empty($selectedCategory) ? 'active' : ''; ?>">All Men</a>

                        <!-- <a href="womens_fashion.php?category=tops" class="filter-link <?php echo $selectedCategory === 'tops' || $selectedCategory === 'sweaters' ? 'active' : ''; ?>">Tops & Sweaters</a>

                        <a href="womens_fashion.php?category=Dresses" class="filter-link <?php echo $selectedCategory === 'Dresses'  ? 'active' : ''; ?>">Dresses</a>
                        <a href="#" class="filter-link">Pants</a> -->
                    </div>
                    
                </div>
            </div>

            <!-- PRODUCT GRID -->
            <div class="col-lg-9">
                <!-- Sort/Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    
                    <span class="text-muted small">Showing <?php echo mysqli_num_rows($result); ?> items</span>
                </div>

                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-3 g-4">
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <div class="col">
                            <form action="" method="post" class="product-card">
                                <div class="img-wrapper">
                                    <a href="productView.php?id=<?php echo $row['ItemID']; ?>">
                                        <img src="img/<?php echo $row['Image']; ?>" alt="<?php echo $row['ItemName']; ?>">
                                    </a>
                                    <!-- Hidden inputs to pass data -->
                                    <input type="hidden" name="itemId" value="<?php echo $row['ItemID']; ?>">
                                    <input type="hidden" name="image" value="<?php echo $row['Image']; ?>">
                                    <input type="hidden" name="itemName" value="<?php echo $row['ItemName']; ?>">
                                    <input type="hidden" name="sellPrice" value="<?php echo $row['Price']; ?>">
                                    
                                    <!-- Hover Button -->
                                    <button type="submit" name="add" class="btn btn-add">Add to Cart</button>
                                </div>

                                <div class="product-info">
                                    <a href="productView.php?id=<?php echo $row['ItemID']; ?>" style="text-decoration:none; color:inherit;">
                                        <h5><?php echo $row['ItemName']; ?></h5>
                                    </a>
                                    <p>R <?php echo number_format($row['Price'], 2); ?></p>
                                </div>
                            </form>
                        </div>
                    <?php } ?>
                </div>

               
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>