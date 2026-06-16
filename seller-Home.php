<?php
session_start();
include("dbCon.php");

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // header("Location: login.php");
    // exit();
}
$userId = $_SESSION['user_id'];

// Get logged-in user details
$userQuery = mysqli_query($link, "SELECT * FROM tbl_user WHERE user_id = '$userId'");
$user = mysqli_fetch_assoc($userQuery);

// Optional: Ensure only sellers can access
if ($user['account_type'] != 'seller') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pastimes || Seller Dashboard</title>
    
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
            --accent-blue: #007bff;
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

        .btn-new-listing:hover {
            background-color: var(--secondary-color);
        }

        /* --- Main Content --- */
        .main-content {
            margin-left: var(--sidebar-width);
            flex: 1;
            padding: 30px;
        }

        /* --- Header --- */
        .top-header {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 40px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .notification-icon {
            font-size: 1.2rem;
            cursor: pointer;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #ddd;
            background-image: url('https://via.placeholder.com/40');
            background-size: cover;
        }

        .user-name {
            font-weight: 500;
            font-size: 0.95rem;
        }

        /* --- Stats Cards --- */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            border: 1px solid var(--border-light);
        }

        .stat-label {
            font-size: 0.85rem;
            color: var(--secondary-color);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-badge {
            font-size: 0.8rem;
            font-weight: 600;
        }

        .badge-green { color: var(--accent-green); }
        .badge-blue { color: var(--accent-blue); }

        /* --- Charts & Actions Grid --- */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            margin-bottom: 40px;
        }

        .card-box {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            border: 1px solid var(--border-light);
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 20px;
        }

        /* Simple CSS Bar Chart */
        .chart-bars {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            height: 200px;
            gap: 10px;
            padding-top: 20px;
        }

        .bar-group {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
        }

        .bar {
            width: 100%;
            background-color: var(--primary-color);
            border-radius: 4px 4px 0 0;
            transition: 0.3s;
        }

        .bar:hover { opacity: 0.8; }

        .bar-label {
            margin-top: 10px;
            font-size: 0.8rem;
            color: var(--secondary-color);
        }

        /* Quick Actions */
        .actions-grid {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .btn-action {
            padding: 12px;
            background: #fff;
            border: 1px solid var(--border-light);
            border-radius: 6px;
            text-align: left;
            font-weight: 500;
            color: var(--primary-color);
            cursor: pointer;
            transition: 0.2s;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-action:hover {
            background-color: var(--bg-light);
            border-color: var(--primary-color);
        }

        /* --- Orders Table --- */
        .orders-table-container {
            background: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            border: 1px solid var(--border-light);
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            text-align: left;
            padding: 15px;
            font-size: 0.85rem;
            color: var(--secondary-color);
            text-transform: uppercase;
            letter-spacing: 1px;
            border-bottom: 2px solid var(--bg-light);
        }

        .table td {
            padding: 15px;
            border-bottom: 1px solid var(--bg-light);
            font-size: 0.95rem;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-processing { background: #fff3cd; color: #856404; }
        .status-shipped { background: #cce5ff; color: #004085; }
        .status-delivered { background: #d4edda; color: #155724; }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                width: 80px;
                padding: 20px 10px;
            }
            .sidebar .logo-section p, .sidebar .nav-link span, .sidebar .btn-new-listing {
                display: none;
            }
            .sidebar .nav-link {
                justify-content: center;
            }
            .sidebar .btn-new-listing {
                padding: 15px 0;
            }
            .main-content {
                margin-left: 80px;
            }
            .dashboard-grid {
                grid-template-columns: 1fr;
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
            <a href="seller-Home.php" class="nav-link active">
                <i class="bi bi-grid-1x2-fill"></i> <span>Dashboard</span>
            </a>
            <a href="addListing.php" class="nav-link">
                <i class="bi bi-box-seam-fill"></i> <span>Products</span>
            </a>
            <a href="orders.php" class="nav-link">
                <i class="bi bi-bag-fill"></i> <span>Orders</span>
            </a>
            <a href="message.php" class="nav-link">
                <i class="bi bi-chat-dots-fill"></i> <span>Messages</span>
            </a>
        </nav>

        <a href="addListing.php" class="btn-new-listing">
            + New Listing
        </a>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">
        
        <!-- TOP HEADER -->
        <div class="top-header">
            <div class="header-right">
                <i class="bi bi-bell notification-icon"></i>
                <div class="user-profile">
                    <div class="user-name"><?php echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Seller'; ?></div>
                    <div class="user-avatar"></div>
                </div>
            </div>
        </div>

        <!-- STATS CARDS -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Total Sales</div>
                <div class="stat-value">R5,290.00</div>
                <div class="stat-badge badge-green"><i class="bi bi-arrow-up"></i> +12.5% from last month</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Active Listings</div>
                <div class="stat-value">84</div>
                <div class="stat-badge badge-blue">Current stock</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">New Messages</div>
                <div class="stat-value">12</div>
                <div class="stat-badge">Pending reply</div>
            </div>
        </div>

        <!-- CHART & ACTIONS -->
        <div class="dashboard-grid">
            <div class="card-box">
                <h3 class="card-title">Sales Performance</h3>
                <p class="text-muted small mb-4">Monthly revenue tracking</p>
                
                <div class="chart-bars">
                    <div class="bar-group">
                        <div class="bar" style="height: 40%;"></div>
                        <div class="bar-label">Jul</div>
                    </div>
                    <div class="bar-group">
                        <div class="bar" style="height: 60%;"></div>
                        <div class="bar-label">Aug</div>
                    </div>
                    <div class="bar-group">
                        <div class="bar" style="height: 45%;"></div>
                        <div class="bar-label">Sep</div>
                    </div>
                    <div class="bar-group">
                        <div class="bar" style="height: 80%;"></div>
                        <div class="bar-label">Oct</div>
                    </div>
                    <div class="bar-group">
                        <div class="bar" style="height: 55%;"></div>
                        <div class="bar-label">Nov</div>
                    </div>
                </div>
            </div>

            <!-- QUICK ACTIONS -->
            <div class="card-box">
                <h3 class="card-title">Quick Actions</h3>
                
                <div class="actions-grid">
                    <a href="addListing.php" class="btn-action">
                        <i class="bi bi-plus-circle"></i> Add New Product
                    </a>
                    <a href="orders.php" class="btn-action">
                        <i class="bi bi-box-pack"></i> Process Orders
                    </a>
                    <!-- <button class="btn-action">
                        <i class="bi bi-calendar-event"></i> Update Schedule
                    </button> -->
                </div>
            </div>
        </div>

        <!-- RECENT ORDERS TABLE -->
        <div class="orders-table-container">
            <h3 class="card-title">Recent Orders</h3>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Price</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Example Row 1 -->
                    <!-- <tr>
                        <td>Burberry Trench</td>
                        <td>#ORD-92831</td>
                        <td>Oct 24, 2023</td>
                        <td>R450.00</td>
                        <td><span class="status-badge status-processing">Processing</span></td>
                    </tr> -->
                    
                    <!-- Example Row 2 -->
                    <!-- <tr>
                        <td>Sports Sneakers</td>
                        <td>#ORD-92755</td>
                        <td>Oct 23, 2023</td>
                        <td>R120.00</td>
                        <td><span class="status-badge status-shipped">Shipped</span></td>
                    </tr> -->
                    
                    <!-- Example Row 3 -->
                    <!-- <tr>
                        <td>Floral Dress</td>
                        <td>#ORD-92612</td>
                        <td>Oct 22, 2023</td>
                        <td>R85.00</td>
                        <td><span class="status-badge status-delivered">Delivered</span></td>
                    </tr> -->

                    
                </tbody>
            </table>
        </div>

    </main>

</div>

</body>
</html>