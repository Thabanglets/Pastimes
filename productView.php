<?php
include("dbCon.php");
$_SESSION['userid'] = 1;
if (!isset($_GET['id'])) {
    die("No product selected.");
}
$id = $_GET['id'];
// Get product from database
$result = mysqli_query($link,"SELECT * FROM tbl_Item WHERE ItemID = $id");


if ($row = mysqli_fetch_assoc($result)) {
    $name = $row['ItemName'];
    $ItemDescription = $row['Description'];
    $price = $row['Price'];
    $image = $row['Image'];
} else {
    die("Product not found.");
}

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
    <title>Pastimes || Product View</title>
    
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
            --accent-color: #333;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--primary-color);
            background-color: #fff;
            padding-top: 80px;
        }

        /* --- Header Styles --- */
        .navbar-custom {
            padding: 20px 0;
            background-color: #fff;
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
        }
        .sub-nav {
            border-bottom: 1px solid var(--border-light);
            padding: 12px 0;
        }

        /* --- Breadcrumb --- */
        .breadcrumb-custom {
            margin-bottom: 30px;
        }
        .breadcrumb-custom a {
            text-decoration: none;
            color: var(--secondary-color);
            font-size: 0.9rem;
        }
        .breadcrumb-custom span {
            color: var(--primary-color);
            font-weight: 500;
        }

        /* --- Product Section --- */
        .product-wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 60px;
            align-items: center;
        }

        /* Left Image Column */
        .product-image-col {
            flex: 1;
            min-width: 300px;
            background-color: #f9f9f9;
            display: flex;
            align-items: center;
            justify-content: center;
            aspect-ratio: 3/4;
            overflow: hidden;
        }
        
        .product-image-col img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Right Details Column */
        .product-details-col {
            flex: 1;
            min-width: 300px;
        }

        .product-category {
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
            color: var(--secondary-color);
            margin-bottom: 10px;
        }

        .product-title {
            font-size: 2.5rem;
            font-weight: 300;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .product-price {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 30px;
        }

        .product-description {
            color: var(--secondary-color);
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        /* --- Options & Actions --- */
        .action-group {
            border-top: 1px solid var(--border-light);
            padding-top: 30px;
        }

        .qty-selector {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
        }

        .qty-label {
            font-size: 0.9rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .form-select-custom {
            padding: 10px 15px;
            border: 1px solid var(--border-light);
            border-radius: 0;
            width: auto;
            background-color: #fff;
        }

        .btn-add-cart {
            width: 100%;
            padding: 15px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 1px;
            transition: 0.3s;
            margin-bottom: 15px;
        }

        .btn-add-cart:hover {
            background-color: var(--secondary-color);
        }

        .link-cart {
            text-decoration: none;
            color: var(--secondary-color);
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        
        .link-cart:hover {
            color: var(--primary-color);
        }

        /* Mobile Adjustments */
        @media (max-width: 768px) {
            .product-wrapper {
                gap: 30px;
            }
            .product-title {
                font-size: 2rem;
            }
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
                        <li class="nav-item"><a class="nav-link-custom" href="womens_fashion.php">Women</a></li>
                        <li class="nav-item"><a class="nav-link-custom" href="buyer-Home.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link-custom" href="Mens_fashion.php">Men</a></li>
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

        <!-- <div class="sub-nav" style="background:#fff; padding: 12px 0; position:sticky; top:73px; z-index:998;">
            <div class="container d-flex justify-content-center gap-4">
                <a href="explore_product.php" style="text-decoration:none; color:#555; font-size:0.85rem; text-transform:uppercase;">Clothing</a>
                <a href="tops&sweaters.php" style="text-decoration:none; color:#555; font-size:0.85rem; text-transform:uppercase;">Tops & Sweaters</a>
            </div>
        </div> -->
    </header>

    <!-- MAIN PRODUCT SECTION -->
    <div class="container" style="padding-top: 40px; padding-bottom: 80px;">
        
        <!-- Breadcrumb -->
        <div class="breadcrumb-custom">
            <a href="buyer-Home.php">Home</a> / 
            <a href="explore_product.php">Products</a> / 
            <span><?php echo $name; ?></span>
        </div>

        <form action="" method="post">
            <div class="product-wrapper">
                
                <!-- Left Column: Image -->
                <div class="product-image-col">
                    <img src="img/<?php echo $image; ?>" alt="<?php echo $name; ?>">
                </div>

                <!-- Right Column: Details -->
                <div class="product-details-col">
                    
                    <!-- PHP Data Injection -->
                    <p class="product-category">CATEGORY</p>
                    
                    <h1 class="product-title"><?php echo $name; ?></h1>
                    
                    <p class="product-price">R <?php echo number_format($price, 2); ?></p>
                    
                    <p class="product-description">
                        <?php echo $ItemDescription; ?>
                    </p>

                    <!-- Hidden Inputs -->
                         <input type="hidden" name="itemId" value="<?php echo $row['ItemID']; ?>">
                            <input type="hidden" name="image" value="<?php echo $row['Image']; ?>">
                            <input type="hidden" name="itemName" value="<?php echo $row['ItemName']; ?>">
                            <input type="hidden" name="sellPrice" value="<?php echo $row['Price']; ?>">

                    <div class="action-group">
                        <div class="qty-selector">
                            <span class="qty-label">Quantity:</span>
                            <select name="quantity" class="form-select-custom">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                            </select>
                        </div>

                        <button type="submit" name="add" class="btn-add-cart">
                            Add to Cart
                        </button>

                        <a href="cart.php" class="link-cart">
                            <i class="bi bi-bag"></i> View Cart
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>