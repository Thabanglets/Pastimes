<?php
session_start();
include("dbCon.php");
$_SESSION['userid'];


$sql = "SELECT * FROM tbl_orders";
$result = mysqli_query($link,$sql);
$totalOrders = mysqli_query($link,"SELECT COUNT(*) FROM tbl_orders ");
$totalOrder = mysqli_fetch_assoc($totalOrders);
$totalpending = mysqli_query($link,"SELECT COUNT(*) FROM tbl_orders WHERE order_status = 'pending' ");


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
            <a href="seller_Dashboard.php" class="nav-link">
                <i class="bi bi-grid-1x2-fill"></i> <span>Dashboard</span>
            </a>
            <a href="addListing.php" class="nav-link">
                <i class="bi bi-plus-circle-fill"></i> <span>Add Listing</span>
            </a>
            <a href="orders.php" class="nav-link active">
                <i class="bi bi-bag-fill"></i> <span>Orders</span>
            </a>
            <a href="messages.php" class="nav-link">
                <i class="bi bi-chat-dots-fill"></i> <span>Messages</span>
            </a>
        </nav>

        <a href="addListing.php" class="btn-new-listing">
            + New Listing
        </a>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">
        
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Orders Management</h1>
        </div>

        <?php 
            if(mysqli_num_rows($result)>0){?>

                <?php 
                    while($row = mysqli_fetch_assoc($result)){?>
                    <div class="stats-row">
                        <div class="stat-box active">
                            <div class="stat-count"><?php echo $totalOrder ?></div>
                            <div class="stat-label">All Orders</div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-count">4</div>
                            <div class="stat-label">Pending</div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-count">6</div>
                            <div class="stat-label">Shipped</div>
                        </div>
                        <div class="stat-box">
                            <div class="stat-count">2</div>
                            <div class="stat-label">Delivered</div>
                        </div>
                    </div>


                   <?php }?>

           <?php }
        
        ?>
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
                    <!-- Example Data Row 1 -->
                    <tr>
                        <td>#ORD-92831</td>
                        <td>
                            <div class="customer-cell">
                                <div class="customer-avatar">JD</div>
                                <div class="customer-info">
                                    <h4>John Doe</h4>
                                    <p>john@example.com</p>
                                </div>
                            </div>
                        </td>
                        <td>Burberry Trench Coat</td>
                        <td>Oct 24, 2023</td>
                        <td>R450.00</td>
                        <td><span class="status-badge badge-processing">Processing</span></td>
                        <td>
                            <button class="action-btn">View</button>
                            <button class="action-btn">Ship</button>
                        </td>
                    </tr>

                    <!-- Example Data Row 2 -->
                    <tr>
                        <td>#ORD-92755</td>
                        <td>
                            <div class="customer-cell">
                                <div class="customer-avatar">AS</div>
                                <div class="customer-info">
                                    <h4>Alice Smith</h4>
                                    <p>alice@example.com</p>
                                </div>
                            </div>
                        </td>
                        <td>Running Sneakers</td>
                        <td>Oct 23, 2023</td>
                        <td>R120.00</td>
                        <td><span class="status-badge badge-shipped">Shipped</span></td>
                        <td>
                            <button class="action-btn">View</button>
                            <button class="action-btn">Track</button>
                        </td>
                    </tr>

                    <!-- Example Data Row 3 -->
                    <tr>
                        <td>#ORD-92612</td>
                        <td>
                            <div class="customer-cell">
                                <div class="customer-avatar">BJ</div>
                                <div class="customer-info">
                                    <h4>Bob Jones</h4>
                                    <p>bob@example.com</p>
                                </div>
                            </div>
                        </td>
                        <td>Floral Summer Dress</td>
                        <td>Oct 22, 2023</td>
                        <td>R85.00</td>
                        <td><span class="status-badge badge-delivered">Delivered</span></td>
                        <td>
                            <button class="action-btn">View</button>
                            <button class="action-btn">Invoice</button>
                        </td>
                    </tr>

                    <!-- Example Data Row 4 -->
                    <tr>
                        <td>#ORD-92500</td>
                        <td>
                            <div class="customer-cell">
                                <div class="customer-avatar">MK</div>
                                <div class="customer-info">
                                    <h4>Mary Kim</h4>
                                    <p>mary@example.com</p>
                                </div>
                            </div>
                        </td>
                        <td>Denim Jacket</td>
                        <td>Oct 21, 2023</td>
                        <td>R200.00</td>
                        <td><span class="status-badge badge-cancelled">Cancelled</span></td>
                        <td>
                            <button class="action-btn">View</button>
                        </td>
                    </tr>

                    <!-- 
                    You can uncomment and loop your PHP rows here:
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td>#ORD-<?php echo $row['order_id']; ?></td>
                        <td>
                            <div class="customer-cell">
                                <div class="customer-avatar"><?php echo substr($row['customer_name'], 0, 1); ?></div>
                                <div class="customer-info">
                                    <h4><?php echo $row['customer_name']; ?></h4>
                                    <p><?php echo $row['customer_email']; ?></p>
                                </div>
                            </div>
                        </td>
                        <td><?php echo $row['ItemName']; ?></td>
                        <td><?php echo $row['order_date']; ?></td>
                        <td>R <?php echo number_format($row['total_price'], 2); ?></td>
                        <td>
                            <span class="status-badge badge-<?php echo strtolower($row['status']); ?>">
                                <?php echo $row['status']; ?>
                            </span>
                        </td>
                        <td>
                            <a href="view_order.php?id=<?php echo $row['order_id']; ?>" class="action-btn">View</a>
                            <?php if($row['status'] == 'Processing') { ?>
                            <a href="ship_order.php?id=<?php echo $row['order_id']; ?>" class="action-btn">Ship</a>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?> 
                    -->
                </tbody>
            </table>
        </div>

    </main>

</div>

</body>
</html>