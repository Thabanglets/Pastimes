<?php
session_start();
include("dbCon.php");

// Check if user is logged in as admin
// if (!isset($_SESSION['admin_id'])) {
//     header("Location: login.php");
//     exit();
// }

// --- Handle Actions (Approve/Reject) ---
if (isset($_GET['approve_user'])) {
    $id = intval($_GET['approve_user']);
    mysqli_query($link, "UPDATE tbl_user SET account_status = 'approved' WHERE user_id = $id");
    header("Location: admin-home.php");
    exit();
}

if (isset($_GET['decline_user'])) {
    $id = intval($_GET['decline_user']);
    mysqli_query($link, "UPDATE tbl_user SET account_status = 'declined' WHERE user_id = $id");
    header("Location: admin-home.php");
    exit();
}

if (isset($_GET['approve_product'])) {
    $id = intval($_GET['approve_product']);
    mysqli_query($link, "UPDATE tbl_item SET Status = 'approved' WHERE ItemID = $id");
    header("Location: admin_dashboard.php");
    exit();
}

if (isset($_GET['reject_product'])) {
    $id = intval($_GET['reject_product']);
    mysqli_query($link, "UPDATE tbl_item SET Status = 'rejected' WHERE ItemID = $id");
    header("Location: admin_dashboard.php");
    exit();
}

// --- Queries ---
$result = mysqli_query($link, "SELECT * FROM tbl_orders");
$userQuery = mysqli_query($link, "SELECT COUNT(user_id) AS total FROM tbl_user");
$userQuery2 = mysqli_query($link, "SELECT COUNT(user_id) AS pending FROM tbl_user WHERE account_status = 'pending'");
$user = mysqli_query($link, "SELECT * FROM tbl_user WHERE account_status = 'pending'");
$userQuery3 = mysqli_query($link, "SELECT COUNT(ItemId) AS totalItem FROM tbl_item");
$itemsResult = mysqli_query($link, "SELECT * FROM tbl_item");
$userQuery4 = mysqli_query($link, "SELECT COUNT(order_id) AS totalOrders FROM tbl_orders");

$userData = mysqli_fetch_assoc($userQuery);
$userPending = mysqli_fetch_assoc($userQuery2);
$totalItem = mysqli_fetch_assoc($userQuery3);
$orders = mysqli_fetch_assoc($userQuery4);

$totalUser = $userData['total'];
$pendingCount = $userPending['pending'];
$totalProducts = $totalItem['totalItem'];
$totalOrders = $orders['totalOrders'];
?>

<!DOCTYPE html>
<html lang="en">
```php
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pastimes || Admin Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body{
            background:#f4f6f9;
            overflow-x:hidden;
        }

        .sidebar{
            width:260px;
            min-height:100vh;
            background:#111827;
            position:fixed;
            left:0;
            top:0;
            padding-top:20px;
        }

        .sidebar .nav-link{
            color:#cbd5e1;
            padding:12px 18px;
            border-radius:10px;
            margin-bottom:8px;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active{
            background:#1f2937;
            color:#fff;
        }

        .main-content{
            margin-left:260px;
            padding:20px;
        }

        .stat-card{
            border:none;
            border-radius:20px;
            box-shadow:0 2px 10px rgba(0,0,0,0.05);
        }

        .table-card{
            border:none;
            border-radius:20px;
            box-shadow:0 2px 10px rgba(0,0,0,0.05);
        }

        .badge-approved{
            background:#d1fae5;
            color:#065f46;
        }

        .badge-pending{
            background:#fef3c7;
            color:#92400e;
        }

        .badge-rejected{
            background:#fee2e2;
            color:#991b1b;
        }

        @media(max-width:768px){

            .sidebar{
                width:100%;
                min-height:auto;
                position:relative;
            }

            .main-content{
                margin-left:0;
            }
        }
    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar p-3">
        <h3 class="text-white text-center mb-4">PASTIMES</h3>
        <p class="text-white text-center mb-4">ADMIN DASHBOARD</p>

        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="#" class="nav-link active">
                    <i class="bi bi-grid-1x2-fill me-2"></i> Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-box-seam me-2"></i> Products
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-chat-dots me-2"></i> Chat
                </a>
            </li>

            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-people me-2"></i> Users
                </a>
            </li>
        </ul>

        <div class="mt-5">
            <a href="login.php" class="btn btn-dark w-100">
                <i class="bi bi-box-arrow-left"></i> Logout
            </a>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <!-- TOPBAR -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Dashboard</h2>

            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-light position-relative">
                    <i class="bi bi-bell"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        1
                    </span>
                </button>

                <div class="bg-dark text-white rounded-circle d-flex justify-content-center align-items-center"
                     style="width:40px;height:40px;">
                    <i class="bi bi-person-fill"></i>
                </div>
            </div>
        </div>

        <!-- STATS -->
        <div class="row g-4 mb-4">

            <div class="col-md-3">
                <div class="card stat-card p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Total Users</p>
                            <h2><?php echo $totalUser; ?></h2>
                        </div>

                        <div class="bg-primary text-white p-3 rounded">
                            <i class="bi bi-people-fill"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stat-card p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Products</p>
                            <h2><?php echo $totalProducts; ?></h2>
                        </div>

                        <div class="bg-success text-white p-3 rounded">
                            <i class="bi bi-box-seam"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stat-card p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Pending</p>
                            <h2><?php echo $pendingCount; ?></h2>
                        </div>

                        <div class="bg-warning text-white p-3 rounded">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card stat-card p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1">Orders</p>
                            <h2><?php echo $totalOrders; ?></h2>
                        </div>

                        <div class="bg-dark text-white p-3 rounded">
                            <i class="bi bi-bag"></i>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- USERS TABLE -->
        <div class="card table-card mb-4">
            <div class="card-header bg-white border-0">
                <h5 class="mb-0">Pending User Approvals</h5>
            </div>

            <div class="card-body">

                <?php if(mysqli_num_rows($user) > 0): ?>

                <div class="table-responsive">
                    <table class="table align-middle">

                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Email</th>
                                <th>Account type</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>

                        <tbody>

                        <?php while($u = mysqli_fetch_assoc($user)): ?>

                            <tr>

                                <td>
                                    <?php echo $u['user_name']; ?>
                                </td>

                                <td>
                                    <?php echo $u['user_email']; ?>
                                </td>

                                <td>
                                    <?php echo $u['account_type']; ?>
                                </td>

                                <td class="text-end">

                                    <a href="?approve_user=<?php echo $u['user_id']; ?>"
                                       class="btn btn-success btn-sm"
                                       title="Approve User">
                                        <i class="bi bi-check-lg"></i> Approve
                                    </a>

                                    <a href="?decline_user=<?php echo $u['user_id']; ?>"
                                       class="btn btn-danger btn-sm"
                                       title="Decline User">
                                        <i class="bi bi-x-lg"></i> Decline
                                    </a>

                                </td>

                            </tr>

                        <?php endwhile; ?>

                        </tbody>

                    </table>
                </div>

                <?php else: ?>

                    <div class="alert alert-success">
                        No pending users found.
                    </div>

                <?php endif; ?>

            </div>
        </div>

    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
```

</html>