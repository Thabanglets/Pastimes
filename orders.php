<?php
session_start();
include("dbCon.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = (int) $_SESSION['user_id'];

$userQuery = mysqli_query($link, "SELECT * FROM tbl_user WHERE user_id = $userId");
$user = mysqli_fetch_assoc($userQuery);

if (!$user || strtolower($user['account_type']) != 'seller') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['action']) && isset($_GET['id'])) {
    $orderId = (int) $_GET['id'];
    $action = strtolower($_GET['action']);

    if ($action === 'ship') {
        $updateQuery = "UPDATE tbl_orders SET order_status = 'shipped' WHERE order_id = $orderId";
    } elseif ($action === 'deliver') {
        $updateQuery = "UPDATE tbl_orders SET order_status = 'delivered' WHERE order_id = $orderId";
    } else {
        $updateQuery = null;
    }

    if (!empty($updateQuery)) {
        mysqli_query($link, $updateQuery);
        header("Location: orders.php");
        exit();
    }
}

$ownerColumn = '';
$ownerColumnQuery = mysqli_query(
    $link,
    "SELECT COLUMN_NAME
     FROM information_schema.columns
     WHERE TABLE_SCHEMA = DATABASE()
       AND TABLE_NAME = 'tbl_item'
       AND LOWER(COLUMN_NAME) IN ('seller_id','sellerid','user_id','userid','userid','userId','owner_id','ownerid','created_by','createdby')"
);
if ($ownerColumnQuery) {
    while ($ownerRow = mysqli_fetch_assoc($ownerColumnQuery)) {
        if (!empty($ownerRow['COLUMN_NAME'])) {
            $ownerColumn = $ownerRow['COLUMN_NAME'];
            break;
        }
    }
}

if ($ownerColumn !== '') {
    $sellerFilter = " WHERE i.$ownerColumn = $userId";
} else {
    // Fallback: when the schema does not store a seller link on items,
    // show only orders that belong to the logged-in user.
    $sellerFilter = " WHERE o.user_id = $userId";
}

$data = "SELECT DISTINCT
            o.order_id,
            u.user_name AS name,
            u.user_email AS email,
            i.ItemName,
            o.order_date,
            oi.quantity,
            oi.price,
            (oi.quantity * oi.price) AS Amount,
            o.order_status
        FROM tbl_orders o
        JOIN tbl_user u ON o.user_id = u.user_id
        JOIN tbl_order_item oi ON oi.order_id = o.order_id
        JOIN tbl_item i ON oi.product_id = i.ItemID";
if ($sellerFilter !== '') {
    $data .= $sellerFilter;
}
$data .= " ORDER BY o.order_date DESC";

$resultView = mysqli_query($link, $data);

$userQuery4 = mysqli_query(
    $link,
    "SELECT COUNT(DISTINCT o.order_id) AS totalOrders
     FROM tbl_orders o
     JOIN tbl_order_item oi ON oi.order_id = o.order_id
     JOIN tbl_item i ON oi.product_id = i.ItemID" . $sellerFilter
);

$pendingFilter = $sellerFilter;
if ($pendingFilter === '') {
    $pendingFilter = ' WHERE o.order_status IN (\'pending\', \'processing\')';
} else {
    $pendingFilter .= " AND o.order_status IN ('pending', 'processing')";
}
$userQuery3 = mysqli_query(
    $link,
    "SELECT COUNT(DISTINCT o.order_id) AS pendingOrders
     FROM tbl_orders o
     JOIN tbl_order_item oi ON oi.order_id = o.order_id
     JOIN tbl_item i ON oi.product_id = i.ItemID" . $pendingFilter
);

$shippedFilter = $sellerFilter;
if ($shippedFilter === '') {
    $shippedFilter = " WHERE o.order_status = 'shipped'";
} else {
    $shippedFilter .= " AND o.order_status = 'shipped'";
}
$userQuery2 = mysqli_query(
    $link,
    "SELECT COUNT(DISTINCT o.order_id) AS shippedOrders
     FROM tbl_orders o
     JOIN tbl_order_item oi ON oi.order_id = o.order_id
     JOIN tbl_item i ON oi.product_id = i.ItemID" . $shippedFilter
);

$deliveredFilter = $sellerFilter;
if ($deliveredFilter === '') {
    $deliveredFilter = " WHERE o.order_status = 'delivered'";
} else {
    $deliveredFilter .= " AND o.order_status = 'delivered'";
}
$userQuery1 = mysqli_query(
    $link,
    "SELECT COUNT(DISTINCT o.order_id) AS deliveredOrders
     FROM tbl_orders o
     JOIN tbl_order_item oi ON oi.order_id = o.order_id
     JOIN tbl_item i ON oi.product_id = i.ItemID" . $deliveredFilter
);

if ($userQuery4) {
    $orders = mysqli_fetch_assoc($userQuery4);
    $totalOrders = (int) $orders['totalOrders'];
} else {
    $totalOrders = 0;
}

if ($userQuery3) {
    $pendingOrders = mysqli_fetch_assoc($userQuery3);
    $pendingCount = (int) $pendingOrders['pendingOrders'];
} else {
    $pendingCount = 0;
}

if ($userQuery2) {
    $shippedOrders = mysqli_fetch_assoc($userQuery2);
    $shippedCount = (int) $shippedOrders['shippedOrders'];
} else {
    $shippedCount = 0;
}

if ($userQuery1) {
    $deliveredOrders = mysqli_fetch_assoc($userQuery1);
    $deliveredCount = (int) $deliveredOrders['deliveredOrders'];
} else {
    $deliveredCount = 0;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pastimes || Orders</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-color: #212121;
            --secondary-color: #757575;
            --border-light: #e0e0e0;
            --bg-light: #f8f9fa;
            --accent-green: #28a745;
            --accent-yellow: #ffc107;
            --accent-blue: #007bff;
            --accent-red: #dc3545;
            --sidebar-width: 260px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--primary-color);
            background-color: var(--bg-light);
            margin: 0;
            padding: 0;
        }

        /* --- Layout --- */
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        /* --- Sidebar --- */
        .sidebar {
            width: var(--sidebar-width);
            background-color: #fff;
            border-right: 1px solid var(--border-light);
            position: fixed;
            height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 30px 20px;
            z-index: 100;
        }

        .logo-section {
            margin-bottom: 50px;
            text-align: center;
        }

        .logo-section h2 {
            font-weight: 700;
            letter-spacing: 2px;
            margin: 0;
            font-size: 1.5rem;
        }

        .logo-section p {
            font-size: 0.8rem;
            color: var(--secondary-color);
            margin: 5px 0 0 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sidebar-nav {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .nav-link {
            padding: 12px 15px;
            border-radius: 8px;
            color: var(--secondary-color);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-link:hover {
            background-color: var(--bg-light);
            color: var(--primary-color);
        }

        .nav-link.active {
            background-color: var(--primary-color);
            color: #fff;
        }

        .btn-new-listing {
            background-color: var(--primary-color);
            color: #fff !important;
            text-align: center;
            padding: 15px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.3s;
        }

        /* --- Main Content --- */
        .main-content {
            margin-left: var(--sidebar-width);
            flex: 1;
            padding: 30px;
        }

        /* --- Page Header --- */
        .page-header {
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
        }

        /* --- Stats Row --- */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-box {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid var(--border-light);
            text-align: center;
            cursor: pointer;
            transition: 0.3s;
        }

        .stat-box:hover {
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }

        .stat-box.active {
            background: var(--primary-color);
            color: #fff;
            border-color: var(--primary-color);
        }

        .stat-count {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* --- Filter Bar --- */
        .filter-bar {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            border: 1px solid var(--border-light);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            gap: 15px;
        }

        .search-box {
            flex: 1;
            max-width: 400px;
            position: relative;
        }

        .search-input {
            width: 100%;
            padding: 10px 15px 10px 40px;
            border: 1px solid var(--border-light);
            border-radius: 6px;
            font-family: 'Inter', sans-serif;
        }

        .search-icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--secondary-color);
        }

        .filter-actions {
            display: flex;
            gap: 10px;
        }

        .btn-filter {
            padding: 8px 16px;
            border: 1px solid var(--border-light);
            background: #fff;
            border-radius: 6px;
            font-size: 0.9rem;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-filter:hover {
            background: var(--bg-light);
        }

        /* --- Orders Table --- */
        .table-card {
            background: #fff;
            border-radius: 10px;
            border: 1px solid var(--border-light);
            overflow: hidden;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            text-align: left;
            padding: 15px 20px;
            background: var(--bg-light);
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--secondary-color);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .table td {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border-light);
            font-size: 0.95rem;
        }

        .customer-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .customer-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: #ddd;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: #fff;
            background: var(--primary-color);
        }

        .customer-info h4 {
            margin: 0;
            font-size: 0.95rem;
            font-weight: 600;
        }

        .customer-info p {
            margin: 0;
            font-size: 0.8rem;
            color: var(--secondary-color);
        }

        /* --- Status Badges --- */
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            display: inline-block;
        }

        .badge-pending { background: #fff3cd; color: #856404; }
        .badge-processing { background: #cce5ff; color: #004085; }
        .badge-shipped { background: #d1ecf1; color: #0c5460; }
        .badge-delivered { background: #d4edda; color: #155724; }
        .badge-cancelled { background: #f8d7da; color: #721c24; }

        /* --- Action Buttons --- */
        .action-btn {
            padding: 6px 12px;
            border: 1px solid var(--border-light);
            background: #fff;
            border-radius: 4px;
            font-size: 0.8rem;
            cursor: pointer;
            text-decoration: none;
            color: var(--primary-color);
            margin-right: 5px;
            transition: 0.2s;
        }

        .action-btn:hover {
            background: var(--bg-light);
            border-color: var(--primary-color);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                width: 80px;
                padding: 20px 10px;
            }
            .sidebar .logo-section p, .sidebar .nav-link span {
                display: none;
            }
            .main-content {
                margin-left: 80px;
            }
            .stats-row {
                grid-template-columns: repeat(2, 1fr);
            }
            .filter-bar {
                flex-direction: column;
                align-items: stretch;
            }
            .search-box {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="dashboard-container">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="logo-section">
            <h2>PASTIMES</h2>
            <p>Seller Panel</p>
        </div>

        <nav class="sidebar-nav">
            <a href="seller-Home.php" class="nav-link">
                <i class="bi bi-grid-1x2-fill"></i> <span>Dashboard</span>
            </a>
            <a href="addListing.php" class="nav-link">
                <i class="bi bi-plus-circle-fill"></i> <span>Add Listing</span>
            </a>
            <a href="orders.php" class="nav-link active">
                <i class="bi bi-bag-fill"></i> <span>Orders</span>
            </a>
            <!-- <a href="message.php" class="nav-link">
                <i class="bi bi-chat-dots-fill"></i> <span>Messages</span>
            </a> -->
        </nav>

        <div class="mt-5">
            <a href="login.php" class="btn btn-dark w-100">
                <i class="bi bi-box-arrow-left"></i> Logout
            </a>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">
        
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Orders Management</h1>
        </div>

        <div class="stats-row">
                        <div class="stat-box active">
                            <div class="stat-count"><?php echo $totalOrders ?></div>
                            <div class="stat-label">All Orders</div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-count"><?php echo $pendingCount ?></div>
                            <div class="stat-label">Pending</div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-count"><?php echo $shippedCount ?></div>
                            <div class="stat-label">Shipped</div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-count"><?php echo $deliveredCount ?></div>
                            <div class="stat-label">Delivered</div>
                        </div>
                    </div>
        <!-- Stats Tabs -->
        

        <!-- Filter Bar -->
        <!-- <div class="filter-bar">
            <div class="search-box">
                <i class="bi bi-search search-icon"></i>
                <input type="text" class="search-input" placeholder="Search by Order ID, Customer Name...">
            </div>
            <div class="filter-actions">
                <button class="btn-filter"><i class="bi bi-funnel"></i> Filter</button>
                <button class="btn-filter"><i class="bi bi-download"></i> Export</button>
            </div>
        </div> -->

        <!-- Orders Table -->
        <div class="table-card">
            <table class="table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Product</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($resultView && mysqli_num_rows($resultView) > 0) {
                        while ($row = mysqli_fetch_assoc($resultView)) {
                    ?>
                    <tr>
                        <td>#ORD-<?php echo (int) $row['order_id']; ?></td>
                        <td>
                            <div class="customer-cell">
                                <div class="customer-avatar"><?php echo htmlspecialchars(substr($row['name'], 0, 1)); ?></div>
                                <div class="customer-info">
                                    <h4><?php echo htmlspecialchars($row['name']); ?></h4>
                                    <p><?php echo htmlspecialchars($row['email']); ?></p>
                                </div>
                            </div>
                        </td>
                        <td><?php echo htmlspecialchars($row['ItemName']); ?></td>
                        <td><?php echo htmlspecialchars($row['order_date']); ?></td>
                        <td>R <?php echo number_format((float) $row['Amount'], 2); ?></td>
                        <td>
                            <span class="status-badge badge-<?php echo strtolower($row['order_status']); ?>">
                                <?php echo htmlspecialchars($row['order_status']); ?>
                            </span>
                        </td>
                        <td>
                            <a href="view_order.php?id=<?php echo (int) $row['order_id']; ?>" class="action-btn">View</a>

                            <?php
                            $status = strtolower($row['order_status']);
                            if ($status === 'pending' || $status === 'processing') {
                            ?>
                                <a href="orders.php?action=ship&id=<?php echo (int) $row['order_id']; ?>" class="action-btn">Ship</a>
                            <?php } elseif ($status === 'shipped') { ?>
                                <a href="orders.php?action=deliver&id=<?php echo (int) $row['order_id']; ?>" class="action-btn">Delivered</a>
                            <?php } else { ?>
                                <span class="action-btn" style="opacity:0.7; cursor:default;">Completed</span>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php
                        }
                    } else {
                    ?>
                    <tr>
                        <td colspan="7" style="text-align:center; padding:20px;">No orders found for this seller.</td>
                    </tr>
                    <?php } ?>
                </tbody>
                </tbody>
            </table>
        </div>

    </main>

</div>

</body>
</html>