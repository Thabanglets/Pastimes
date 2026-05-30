<?php
include("dbCon.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];

$sql = "SELECT
        i.Image,
        i.ItemName,
        i.Price,
        c.quantity,
        (i.Price * c.quantity) AS SubTotal
    FROM tbl_cart c
    JOIN tbl_item i ON c.product_id = i.ItemID
    WHERE c.user_id = '$userId'
";
$cartQuery = mysqli_query($link, "SELECT COUNT(*) AS cart
        FROM tbl_cart
        WHERE user_id = '$userId'
    ");

    $cartData = mysqli_fetch_assoc($cartQuery);
    $cartCount = $cartData['cart'];
    
$result = mysqli_query($link, $sql);

// Total for logged-in user only
$totalQuery = mysqli_query(
    $link,
    "SELECT SUM(i.Price * c.quantity) AS total
     FROM tbl_cart c
     JOIN tbl_item i ON c.product_id = i.ItemID
     WHERE c.user_id = '$userId'"
);

$totalprice = mysqli_fetch_assoc($totalQuery)['total'] ?? 0;
?>
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pastimes || Shopping Cart</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-color: #212121;
            --secondary-color: #757575;
            --border-light: #e0e0e0;
            --bg-light: #f9f9f9;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--primary-color);
            background-color: #fff;
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

        /* --- Layout --- */
        .cart-wrapper {
            padding-top: 120px;
            padding-bottom: 60px;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* --- Cart Table --- */
        .cart-table-header {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1fr 0.5fr;
            padding: 15px 20px;
            border-bottom: 2px solid var(--primary-color);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 1px;
            color: var(--secondary-color);
        }

        .cart-item {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1fr 0.5fr;
            align-items: center;
            padding: 30px 20px;
            border-bottom: 1px solid var(--border-light);
            gap: 20px;
        }

        .product-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .product-img {
            width: 80px;
            height: 100px;
            object-fit: cover;
            background-color: var(--bg-light);
        }

        .product-name {
            font-weight: 600;
            font-size: 1rem;
            margin: 0;
        }

        .price-col, .qty-col, .subtotal-col {
            font-size: 1rem;
            color: var(--primary-color);
        }

        .delete-btn {
            color: var(--secondary-color);
            background: none;
            border: none;
            font-size: 1.2rem;
            cursor: pointer;
            transition: 0.2s;
        }

        .delete-btn:hover {
            color: #dc3545;
        }

        /* --- Summary Section --- */
        .cart-summary {
            margin-top: 40px;
            display: flex;
            justify-content: flex-end;
        }

        .summary-card {
            width: 350px;
            padding: 30px;
            background-color: var(--bg-light);
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 1rem;
        }

        .total-row {
            border-top: 1px solid #ddd;
            padding-top: 15px;
            margin-top: 15px;
            font-weight: 700;
            font-size: 1.2rem;
        }

        /* Buttons */
        .btn-continue {
            text-decoration: none;
            color: var(--primary-color);
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        
        .btn-continue:hover { color: var(--secondary-color); }

        .btn-checkout {
            width: 100%;
            padding: 15px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: 0.3s;
            margin-top: 20px;
        }

        .btn-checkout:hover {
            background-color: var(--secondary-color);
        }

        .empty-cart {
            text-align: center;
            padding: 60px 0;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .cart-table-header { display: none; }
            
            .cart-item {
                grid-template-columns: 1fr;
                grid-template-rows: auto;
                position: relative;
                gap: 10px;
            }
            
            .product-info { flex-direction: column; align-items: flex-start; }
            .product-img { width: 100%; height: 200px; }
            
            .price-col::before { content: 'Price: '; font-weight: 600; color: var(--secondary-color); }
            .qty-col::before { content: 'Qty: '; font-weight: 600; color: var(--secondary-color); }
            .subtotal-col::before { content: 'Subtotal: '; font-weight: 600; color: var(--secondary-color); }
            
            .delete-btn {
                position: absolute;
                top: 10px;
                right: 10px;
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
                        (<?php echo $cartCount; ?>)
                    </a>
                </div>
            </div>
        </nav>

        <div class="sub-nav" style="background:#fff; padding: 12px 0; position:sticky; top:73px; z-index:998;">
            <div class="container d-flex justify-content-center gap-4">
                <a href="explore_product.php" style="text-decoration:none; color:#555; font-size:0.85rem; text-transform:uppercase;">Clothing</a>
                <a href="tops&sweaters.php" style="text-decoration:none; color:#555; font-size:0.85rem; text-transform:uppercase;">Tops & Sweaters</a>
            </div>
        </div>
    </header>

    <div class="container cart-wrapper">
        
        <!-- Breadcrumb -->
        <div class="mb-4" style="color: var(--secondary-color);">
            <a href="buyer-Home.php" style="text-decoration:none; color:var(--secondary-color);">Home</a> / Shopping Cart
        </div>

        <!-- Check if cart is empty (Assuming you add logic for this) -->
        <?php if(mysqli_num_rows($result) > 0) { ?>

            <!-- Table Header -->
            <div class="cart-table-header d-none d-md-grid">
                <div>Product</div>
                <div>Price</div>
                <div>Quantity</div>
                <div>Subtotal</div>
                <div></div>
            </div>

            <!-- Cart Items Loop -->
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <div class="cart-item">
                    
                    <!-- Product Column -->
                    <div class="product-info">
                        <img src="img/<?php echo $row['Image']; ?>" class="product-img" alt="<?php echo $row['ItemName']; ?>">
                        <div>
                            <h4 class="product-name"><?php echo $row['ItemName']; ?></h4>
                        </div>
                    </div>

                    <!-- Price Column -->
                    <div class="price-col">
                        R <?php echo number_format($row['Price'], 2); ?>
                    </div>

                    <!-- Quantity Column -->
                    <div class="qty-col">
                        <?php echo $row['quantity']; ?>
                    </div>

                    <!-- Subtotal Column -->
                    <div class="subtotal-col">
                        R <?php echo number_format($row['SubTotal'], 2); ?>
                    </div>

                    <!-- Delete Action -->
                    <!-- <div>
                        <a href="delete.php?cart_id=<?php echo $row['cart_id']; ?>" 
                           onclick="return confirm('Are you sure you want to delete?')"
                           class="delete-btn">
                            <i class="bi bi-trash"></i>
                        </a>
                    </div> -->

                </div>
            <?php } ?>

            <!-- Cart Summary Section -->
            <div class="cart-summary">
                <div class="summary-card">
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>R <?php echo number_format($totalprice, 2); ?></span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping</span>
                        <span>Free</span>
                    </div>
                    <div class="summary-row total-row">
                        <span>Total</span>
                        <span>R <?php echo number_format($totalprice, 2); ?></span>
                    </div>

                    
                    <button type="button" name="checkout" class="btn-checkout" onclick="window.location.href='checkout.php'">
                             Proceed to Checkout
                        </button>
                </div>
            </div>

        <?php } else { ?>
            <!-- Empty Cart State -->
            <div class="empty-cart">
                <h3>Your cart is empty</h3>
                <a href="buyer-Home.php" class="btn-continue mt-3">Continue Shopping <i class="bi bi-arrow-right"></i></a>
            </div>
        <?php } ?>

        <!-- Continue Shopping Link -->
        <div class="mt-4">
            <a href="buyer-Home.php" class="btn-continue">
                <i class="bi bi-arrow-left"></i> Continue Shopping
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>