<?php
include("dbCon.php");
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = (int) $_SESSION['user_id'];

$ordersQuery = mysqli_query(
    $link,
    "SELECT o.order_id, o.total_price, o.order_status, o.order_date,
            COUNT(oi.product_id) AS item_count,
            SUM(oi.quantity) AS total_quantity
     FROM tbl_orders o
     LEFT JOIN tbl_order_item oi ON o.order_id = oi.order_id
     WHERE o.user_id = $userId
     GROUP BY o.order_id
     ORDER BY o.order_date DESC"
);

$cartQuery = mysqli_query(
    $link,
    "SELECT COUNT(*) AS cart_count FROM tbl_cart WHERE user_id = $userId"
);
$cartCount = 0;
if ($cartQuery) {
    $cartRow = mysqli_fetch_assoc($cartQuery);
    $cartCount = isset($cartRow['cart_count']) ? (int) $cartRow['cart_count'] : 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pastimes || Track Orders</title>
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

        .track-wrapper {
            padding-top: 140px;
            padding-bottom: 60px;
            max-width: 1100px;
            margin: 0 auto;
        }

        .page-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .page-subtitle {
            color: var(--secondary-color);
            margin-bottom: 30px;
        }

        .order-card {
            border: 1px solid var(--border-light);
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 20px;
            background: #fff;
        }

        .order-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
            flex-wrap: wrap;
            margin-bottom: 18px;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 999px;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: capitalize;
        }

        .status-pending { background: #fff7db; color: #b8860b; }
        .status-shipped { background: #e8f3ff; color: #0d6efd; }
        .status-delivered { background: #e8f7ee; color: #198754; }
        .status-cancelled { background: #fdeaea; color: #dc3545; }

        .order-meta {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
            margin-bottom: 18px;
        }

        .meta-box {
            background: var(--bg-light);
            padding: 14px;
            border-radius: 8px;
        }

        .meta-label {
            font-size: 0.8rem;
            color: var(--secondary-color);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .meta-value {
            font-weight: 600;
            margin-top: 4px;
        }

        .progress-track {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 18px;
        }

        .progress-step {
            flex: 1;
            height: 6px;
            background: #e5e5e5;
            border-radius: 999px;
            position: relative;
        }

        .progress-step.active {
            background: var(--primary-color);
        }

        .progress-labels {
            display: flex;
            justify-content: space-between;
            color: var(--secondary-color);
            font-size: 0.8rem;
        }

        .item-list {
            border-top: 1px solid var(--border-light);
            padding-top: 16px;
        }

        .item-row {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            padding: 10px 0;
            border-bottom: 1px solid var(--border-light);
        }

        .item-row:last-child {
            border-bottom: none;
        }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
            background: var(--bg-light);
            border-radius: 12px;
        }

        @media (max-width: 768px) {
            .order-meta {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
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
                    <a href="track_order.php" class="nav-link-custom">Track Orders</a>
                    <a href="cart.php" class="nav-link-custom">Cart (<?php echo $cartCount; ?>)</a>
                </div>
            </div>
        </nav>
    </header>

    <div class="container track-wrapper">
        <div class="mb-4" style="color: var(--secondary-color);">
            <a href="buyer-Home.php" style="text-decoration:none; color:var(--secondary-color);">Home</a> /
            <span style="color:var(--primary-color); font-weight:600;">Track Orders</span>
        </div>

        <h2 class="page-title">My Orders</h2>
        <p class="page-subtitle">Track your latest purchases and delivery status.</p>

        <?php if (mysqli_num_rows($ordersQuery) > 0) { ?>
            <?php while ($order = mysqli_fetch_assoc($ordersQuery)) { 
                $orderId = (int) $order['order_id'];
                $status = strtolower($order['order_status']);
                $statusClass = 'status-' . $status;

                $itemsQuery = mysqli_query(
                    $link,
                    "SELECT item_name, quantity, price
                     FROM tbl_order_item
                     WHERE order_id = $orderId"
                );
            ?>
                <div class="order-card">
                    <div class="order-top">
                        <div>
                            <!-- <h5 class="mb-1">Order #<?php echo $orderId; ?></h5> -->
                            <small class="text-muted">Placed on <?php echo date('d M Y, h:i A', strtotime($order['order_date'])); ?></small>
                        </div>
                        <span class="status-badge <?php echo $statusClass; ?>"><?php echo ucfirst($status); ?></span>
                    </div>

                    <div class="order-meta">
                        <div class="meta-box">
                            <div class="meta-label">Total</div>
                            <div class="meta-value">R <?php echo number_format($order['total_price'], 2); ?></div>
                        </div>
                        <div class="meta-box">
                            <div class="meta-label">Items</div>
                            <div class="meta-value"><?php echo (int) $order['total_quantity']; ?> item(s)</div>
                        </div>
                        <div class="meta-box">
                            <div class="meta-label">Payment</div>
                            <div class="meta-value">Paid</div>
                        </div>
                    </div>

                    <div class="progress-track">
                        <div class="progress-step <?php echo in_array($status, ['pending', 'shipped', 'delivered']) ? 'active' : ''; ?>"></div>
                        <div class="progress-step <?php echo in_array($status, ['shipped', 'delivered']) ? 'active' : ''; ?>"></div>
                        <div class="progress-step <?php echo $status === 'delivered' ? 'active' : ''; ?>"></div>
                    </div>
                    <div class="progress-labels">
                        <span>Ordered</span>
                        <span>Shipped</span>
                        <span>Delivered</span>
                    </div>

                    <div class="item-list">
                        <?php while ($item = mysqli_fetch_assoc($itemsQuery)) { ?>
                            <div class="item-row">
                                <div>
                                    <strong><?php echo htmlspecialchars($item['item_name']); ?></strong>
                                    <div class="text-muted">Qty: <?php echo (int) $item['quantity']; ?></div>
                                </div>
                                <div>R <?php echo number_format($item['price'] * $item['quantity'], 2); ?></div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <div class="empty-state">
                <h4>No orders found</h4>
                <p class="text-muted">Your order history will appear here once you place an order.</p>
                <a href="buyer-Home.php" class="btn btn-dark mt-3">Continue Shopping</a>
            </div>
        <?php } ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
