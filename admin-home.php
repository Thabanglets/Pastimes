<?php
session_start();
include("dbCon.php");
$_SESSION['userid'];
$result = mysqli_query($link,"SELECT * FROM tbl_orders ");
$userQuery = mysqli_query($link, "SELECT COUNT(user_id) AS total FROM tbl_user");
$userQuery2 = mysqli_query($link, "SELECT COUNT(user_id) AS pending FROM tbl_user WHERE account_status ='pending'");
$user = mysqli_query($link, "SELECT *  FROM tbl_user WHERE account_status ='pending'");
$userQuery3 = mysqli_query($link, "SELECT COUNT(ItemId) AS totalItem FROM tbl_item");
$userQuery4 = mysqli_query($link, "SELECT COUNT(order_id) AS totalOrders FROM tbl_orders");
$userData = mysqli_fetch_assoc($userQuery);
$userPending = mysqli_fetch_assoc($userQuery2);
$totalItem = mysqli_fetch_assoc($userQuery3);
$orders = mysqli_fetch_assoc($userQuery4);

$totalUser = $userData['total'];
$pendingCount = $userPending['pending'];
$totalProducts = $totalItem['totalItem'];
$totalProducts = $totalItem['totalItem'];
$totalOrders = $orders['totalOrders'];


// $userQuery2 =$pendingCount;
// $userQuery4 = $totalOrders;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pastimes || Admin Dashboard</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                }
            }
        }
    </script>
    
    <style>
        .tab-active { @apply border-b-2 border-gray-900 text-gray-900 font-semibold; }
        .chat-bubble-received { @apply bg-white border border-gray-200 rounded-lg rounded-tl-none p-3 max-w-md; }
        .chat-bubble-sent { @apply bg-gray-900 text-white rounded-lg rounded-tr-none p-3 max-w-md; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-white border-r border-gray-200 hidden md:flex flex-col fixed h-full z-50">
        <div class="p-6 text-center border-b border-gray-100">
            <h2 class="text-xl font-bold tracking-widest text-gray-900">PASTIMES</h2>
            <p class="text-xs text-gray-500 uppercase tracking-wider mt-1">Admin Panel</p>
        </div>

        <!-- <nav class="flex-1 p-4 space-y-2">
            <a href="admin_dashboard.php" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-gray-900 text-white transition">
                <i class="bi bi-speedometer2"></i> <span class="font-medium">Dashboard</span>
            </a>
            <a href="#" onclick="document.getElementById('productsPanel').classList.remove('hidden'); document.getElementById('chatPanel').classList.add('hidden'); document.getElementById('usersPanel').classList.add('hidden');" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-500 hover:bg-gray-50 hover:text-gray-900 transition">
                <i class="bi bi-box-seam"></i> <span class="font-medium">Products</span>
            </a>
            <a href="#" onclick="document.getElementById('chatPanel').classList.remove('hidden'); document.getElementById('productsPanel').classList.add('hidden'); document.getElementById('usersPanel').classList.add('hidden');" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-500 hover:bg-gray-50 hover:text-gray-900 transition">
                <i class="bi bi-chat-dots"></i> <span class="font-medium">Chat</span>
            </a>
            <a href="#" onclick="document.getElementById('usersPanel').classList.remove('hidden'); document.getElementById('productsPanel').classList.add('hidden'); document.getElementById('chatPanel').classList.add('hidden');" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-500 hover:bg-gray-50 hover:text-gray-900 transition">
                <i class="bi bi-people"></i> <span class="font-medium">Users</span>
                <span class="ml-auto bg-orange-100 text-orange-600 text-xs px-2 py-0.5 rounded-full"><?php echo $pendingCount; ?></span>
            </a>
        </nav> -->

        <div class="p-4 border-t border-gray-100">
            <a href="login.php" class="flex items-center justify-center gap-2 w-full py-3 border border-gray-300 rounded-lg font-medium hover:bg-gray-50 transition">
                <i class="bi bi-box-arrow-left"></i> Logout
            </a>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 md:ml-64 flex flex-col min-h-screen">
        
        <!-- Top Header -->
        <header class="bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center sticky top-0 z-40">
            <div class="flex items-center gap-4">
                <button class="md:hidden text-gray-500">
                    <i class="bi bi-list text-2xl"></i>
                </button>
                <h1 class="text-xl font-bold text-gray-900">Admin Dashboard</h1>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-500">Admin: <span class="font-semibold text-gray-900"><?php echo $_SESSION['admin_name'] ?? 'Admin'; ?></span></span>
                <div class="h-8 w-8 bg-gray-900 text-white rounded-full flex items-center justify-center">
                    <i class="bi bi-person-fill"></i>
                </div>
            </div>
        </header>

        <!-- DASHBOARD OVERVIEW (Default View) -->
        <div class="p-6 space-y-6" id="dashboardPanel">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Total Users</p>
                            <p class="text-2xl font-bold text-gray-900"><?php echo $totalUser; ?></p>
                        </div>
                        <div class="h-12 w-12 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600">
                            <i class="bi bi-people text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Total Products</p>
                            <p class="text-2xl font-bold text-gray-900"><?php echo $totalProducts; ?></p>
                        </div>
                        <div class="h-12 w-12 bg-green-100 rounded-lg flex items-center justify-center text-green-600">
                            <i class="bi bi-box-seam text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Pending Approvals</p>
                            <p class="text-2xl font-bold text-orange-600"><?php echo $pendingCount; ?></p>
                        </div>
                        <div class="h-12 w-12 bg-orange-100 rounded-lg flex items-center justify-center text-orange-600">
                            <i class="bi bi-hourglass-split text-xl"></i>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500">Total Orders</p>
                            <p class="text-2xl font-bold text-gray-900"><?php echo $totalOrders; ?></p>
                        </div>
                        <div class="h-12 w-12 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600">
                            <i class="bi bi-bag text-xl"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Recent Users Needing Approval -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Users Awaiting Approval</h3>
                    <div class="space-y-3">
                        <?php while($user1 = mysqli_fetch_assoc($user)) { ?>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 bg-gray-300 rounded-full flex items-center justify-center font-semibold">
                                    <?php echo strtoupper(substr($user1['user_name'], 0, 1)); ?>
                                </div>
                                <div>
                                    <p class="font-medium text-sm"><?php echo $user1['user_name']; ?></p>
                                    <p class="text-xs text-gray-500"><?php echo $user1['user_email']; ?></p>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <a href="?approve_user=<?php echo $user1['user_id']; ?>" class="text-green-600 hover:bg-green-50 p-2 rounded"><i class="bi bi-check-lg"></i></a>
                                <a href="?reject_user=<?php echo $user1['user_id']; ?>" class="text-red-600 hover:bg-red-50 p-2 rounded"><i class="bi bi-x-lg"></i></a>
                            </div>
                        </div>
                        <?php } ?>
                        <?php if(mysqli_num_rows($userQuery2) == 0) { ?>
                        <p class="text-gray-500 text-sm text-center py-4">No pending users</p>
                        <?php } ?>
                    </div>
                </div>

                <!-- Recent Products -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Recent Products</h3>
                    <div class="space-y-3">
                        <?php mysqli_data_seek($result, 0); while($product = mysqli_fetch_assoc($result)) { ?>
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                            <img src="img/<?php echo $product['Image']; ?>" class="h-10 w-10 object-cover rounded">
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-sm truncate"><?php echo $product['ItemName']; ?></p>
                                <p class="text-xs text-gray-500">R <?php echo number_format($product['Price'], 2); ?></p>
                            </div>
                            <span class="text-xs px-2 py-1 rounded-full <?php echo ($product['Status'] == 'approved') ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'; ?>">
                                <?php echo $product['Status']; ?>
                            </span>
                        </div>
                        <?php } ?>
                    </div>
                </div>

                <!-- Quick Chat -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                    <h3 class="font-bold text-gray-900 mb-4">Quick Chat</h3>
                    <div class="space-y-2">
                        <a href="#" class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg">
                            <div class="h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center">S</div>
                            <div class="flex-1">
                                <p class="font-medium text-sm">Sellers</p>
                                <p class="text-xs text-gray-500">Chat with sellers</p>
                            </div>
                            <i class="bi bi-chevron-right text-gray-400"></i>
                        </a>
                        <a href="#" class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg">
                            <div class="h-10 w-10 bg-gray-200 rounded-full flex items-center justify-center">B</div>
                            <div class="flex-1">
                                <p class="font-medium text-sm">Buyers</p>
                                <p class="text-xs text-gray-500">Chat with buyers</p>
                            </div>
                            <i class="bi bi-chevron-right text-gray-400"></i>
                        </a>
                        <a href="#" onclick="document.getElementById('productsPanel').classList.remove('hidden'); document.getElementById('chatPanel').classList.add('hidden');" class="flex items-center gap-3 p-3 hover:bg-gray-50 rounded-lg">
                            <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center"><i class="bi bi-box text-blue-600"></i></div>
                            <div class="flex-1">
                                <p class="font-medium text-sm">Manage Products</p>
                                <p class="text-xs text-gray-500">View & Approve</p>
                            </div>
                            <i class="bi bi-chevron-right text-gray-400"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- PRODUCTS PANEL -->
        <div class="hidden p-6" id="productsPanel">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                    <h2 class="font-bold text-lg">All Products</h2>
                    <div class="flex gap-2">
                        <select class="border rounded-lg px-3 py-2 text-sm">
                            <option>All Status</option>
                            <option>Pending</option>
                            <option>Approved</option>
                            <option>Rejected</option>
                        </select>
                    </div>
                </div>
                <table class="w-full">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Product</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Seller</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Price</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <?php mysqli_data_seek($result, 0); while($p = mysqli_fetch_assoc($result)) { ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-3">
                                    <img src="img/<?php echo $p['Image']; ?>" class="h-12 w-12 object-cover rounded">
                                    <span class="font-medium"><?php echo $p['ItemName']; ?></span>
                                </div>
                            </td>
                            <td class="px-4 py-3"><?php echo $p['SellerName']; ?></td>
                            <td class="px-4 py-3">R <?php echo number_format($p['Price'], 2); ?></td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold 
                                    <?php if($p['Status']=='approved') echo 'bg-green-100 text-green-700';
                                    elseif($p['Status']=='rejected') echo 'bg-red-100 text-red-700';
                                    else echo 'bg-yellow-100 text-yellow-700'; ?>">
                                    <?php echo ucfirst($p['Status']); ?>
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <?php if($p['Status'] == 'pending') { ?>
                                <a href="?approve_product=<?php echo $p['ItemID']; ?>" class="text-green-600 hover:bg-green-50 px-3 py-1 rounded text-sm">Approve</a>
                                <a href="?reject_product=<?php echo $p['ItemID']; ?>" class="text-red-600 hover:bg-red-50 px-3 py-1 rounded text-sm">Reject</a>
                                <?php } else { ?>
                                <span class="text-gray-400 text-sm">No actions</span>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- CHAT PANEL -->
        <div class="hidden flex-1 md:flex" id="chatPanel">
            <!-- Chat List -->
            <div class="w-full md:w-1/3 border-r border-gray-200 bg-white flex flex-col">
                <div class="p-4 border-b">
                    <input type="text" placeholder="Search conversations..." class="w-full border rounded-lg px-3 py-2 text-sm">
                </div>
                <div class="flex-1 overflow-y-auto">
                    <!-- Tabs -->
                    <div class="flex border-b">
                        <button onclick="filterChat('seller')" class="flex-1 py-3 text-sm font-medium text-center hover:bg-gray-50">Sellers</button>
                        <button onclick="filterChat('buyer')" class="flex-1 py-3 text-sm font-medium text-center hover:bg-gray-50">Buyers</button>
                    </div>

                    <!-- Chat Items -->
                    <div class="divide-y" id="chatList">
                        <!-- Seller Chat -->
                        <div class="p-4 cursor-pointer hover:bg-gray-50
                        
</body>
</html>