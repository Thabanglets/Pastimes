<?php
    include("dbCon.php");
    


    $sql ="SELECT i.Image,i.ItemName,i.Price,c.quantity,(i.Price *c.quantity) AS SubTotal 
            FROM tbl_cart c
            JOIN tbl_item i  ON c.product_id = i.ItemID";
    $totalprice = mysqli_fetch_assoc(mysqli_query($link, "SELECT SUM(i.Price *c.quantity) AS total FROM tbl_cart c JOIN tbl_item i  ON c.product_id = i.ItemID"))['total'];
    $result = mysqli_query($link, $sql);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pastimes || Checkout</title>
    
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
            --accent-blue: #3a3a3a;
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

        /* --- Layout --- */
        .checkout-wrapper {
            padding-top: 120px;
            padding-bottom: 60px;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* --- Forms --- */
        .section-title {
            font-size: 1.2rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 20px;
            border-bottom: 1px solid var(--border-light);
            padding-bottom: 10px;
        }

        .form-label-custom {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--secondary-color);
            margin-bottom: 5px;
            display: block;
        }

        .form-control-custom {
            width: 100%;
            padding: 12px;
            border: 1px solid var(--border-light);
            border-radius: 0;
            margin-bottom: 20px;
            font-family: 'Inter', sans-serif;
            transition: 0.3s;
        }

        .form-control-custom:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .form-row {
            display: flex;
            gap: 20px;
        }

        .form-col {
            flex: 1;
        }

        /* --- Order Summary Card --- */
        .summary-card {
            background-color: var(--bg-light);
            padding: 30px;
            position: sticky;
            top: 100px;
        }

        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 0.95rem;
        }

        .summary-item img {
            width: 60px;
            height: 75px;
            object-fit: cover;
            margin-right: 15px;
        }

        .item-details {
            display: flex;
            align-items: center;
        }

        .item-name {
            font-weight: 600;
            font-size: 0.9rem;
        }

        .item-qty {
            color: var(--secondary-color);
            font-size: 0.85rem;
        }

        .total-row {
            border-top: 1px solid var(--border-light);
            margin-top: 20px;
            padding-top: 20px;
            display: flex;
            justify-content: space-between;
            font-weight: 700;
            font-size: 1.2rem;
        }

        /* --- Buttons --- */
        .btn-place-order {
            width: 100%;
            padding: 15px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            text-transform: uppercase;
            font-weight: 600;
            letter-spacing: 1px;
            cursor: pointer;
            margin-top: 20px;
            transition: 0.3s;
        }

        .btn-place-order:hover {
            background-color: var(--secondary-color);
        }

        .secure-icon {
            text-align: center;
            margin-top: 15px;
            font-size: 0.8rem;
            color: var(--secondary-color);
        }

        .secure-icon i {
            margin-right: 5px;
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
                    <a href="cart.php" class="nav-link-custom">Cart</a>
                </div>
            </div>
        </nav>
    </header>

    <div class="container checkout-wrapper">
        
        <!-- Breadcrumb -->
        <div class="mb-4" style="color: var(--secondary-color);">
            <a href="buyer-Home.php" style="text-decoration:none; color:var(--secondary-color);">Home</a> / Cart / <span style="color:var(--primary-color); font-weight:600;">Checkout</span>
        </div>

        <form action="" method="post">
            <div class="row g-5">
                
                <!-- LEFT COLUMN: Forms -->
                <div class="col-lg-7">
                    
                    <!-- Contact & Shipping -->
                    <div class="mb-5">
                        <h3 class="section-title">1. Shipping Information</h3>
                        
                        <div class="form-row">
                            <div class="form-col">
                                <label class="form-label-custom">Full Name</label>
                                <input type="text" name="firstName" class="form-control-custom" required>
                            </div>
                        </div>

                        <label class="form-label-custom">Email Address</label>
                        <input type="email" name="email" class="form-control-custom" required>

                        <label class="form-label-custom">Phone Number</label>
                        <input type="tel" name="phone" class="form-control-custom" required>

                        <label class="form-label-custom">Address</label>
                        <input type="text" name="address" class="form-control-custom" required>

                        <div class="form-row">
                            <div class="form-col">
                                <label class="form-label-custom">City</label>
                                <input type="text" name="city" class="form-control-custom" required>
                            </div>
                            <div class="form-col">
                                <label class="form-label-custom">Postal Code</label>
                                <input type="text" name="postal" class="form-control-custom" required>
                            </div>
                        </div>

                        <label class="form-label-custom">Country</label>
                        <select name="country" class="form-control-custom">
                            <option value="South Africa">South Africa</option>
                            <option value="Zimbabwe">Zimbabwe</option>
                            <option value="Namibia">Namibia</option>
                            <option value="Botswana">Botswana</option>
                        </select>
                    </div>

                    <!-- Payment Details -->
                    <div class="mb-5">
                        <h3 class="section-title">2. Payment Details</h3>
                        
                        <label class="form-label-custom">Card Number</label>
                        <input type="text" name="cardNumber" class="form-control-custom" placeholder="0000 0000 0000 0000">

                        <div class="form-row">
                            <div class="form-col">
                                <label class="form-label-custom">Expiry Date</label>
                                <input type="text" name="expiry" class="form-control-custom" placeholder="MM/YY">
                            </div>
                            <div class="form-col">
                                <label class="form-label-custom">CVV</label>
                                <input type="text" name="cvv" class="form-control-custom" placeholder="123">
                            </div>
                        </div>

                        <label class="form-label-custom">Name on Card</label>
                        <input type="text" name="cardName" class="form-control-custom">
                    </div>

                </div>

                <!-- RIGHT COLUMN: Order Summary -->
                <div class="col-lg-5">
                    <div class="summary-card">
                        <h3 class="section-title" style="margin-bottom: 30px;">Order Summary</h3>
                        
                        <!-- Dynamic Cart Items -->
                        <?php 
                        // You might need to re-query the cart here to display items
                        // Assuming $result contains cart items
                        while ($row = mysqli_fetch_assoc($result)) { ?>
                            <div class="summary-item">
                                <div class="item-details">
                                    <img src="img/<?php echo $row['Image']; ?>" alt="<?php echo $row['ItemName']; ?>">
                                    <div>
                                        <div class="item-name"><?php echo $row['ItemName']; ?></div>
                                        <div class="item-qty">Qty: <?php echo $row['quantity']; ?></div>
                                    </div>
                                </div>
                                <div><?php echo number_format($row['SubTotal'], 2); ?></div>
                            </div>
                        <?php } ?>

                        <!-- Costs -->
                        <div class="summary-item" style="margin-top: 20px;">
                            <span>Subtotal</span>
                            <span>R <?php echo number_format($totalprice, 2); ?></span>
                        </div>
                        <div class="summary-item">
                            <span>Shipping</span>
                            <span>Free</span>
                        </div>
                        
                        <!-- Total -->
                        <div class="total-row">
                            <span>Total</span>
                            <span>R <?php echo number_format($totalprice, 2); ?></span>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" name="placeOrder" class="btn-place-order">
                            Place Order
                        </button>

                        <div class="secure-icon">
                            <i class="bi bi-lock-fill"></i> Secure Checkout
                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>