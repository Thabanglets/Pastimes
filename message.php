<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pastimes || Messages</title>
    
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
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 min-h-screen flex">

    <!-- SIDEBAR -->
    <aside class="w-64 bg-white border-r border-gray-200 hidden md:flex flex-col fixed h-full">
        <div class="p-6 text-center border-b border-gray-100">
            <h2 class="text-xl font-bold tracking-widest text-gray-900">PASTIMES</h2>
            <p class="text-xs text-gray-500 uppercase tracking-wider mt-1">Seller Panel</p>
        </div>

        <nav class="flex-1 p-4 space-y-2">
            <a href="seller-Home.php" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-500 hover:bg-gray-50 hover:text-gray-900 transition">
                <i class="bi bi-grid-1x2-fill"></i> <span class="font-medium">Dashboard</span>
            </a>
            <a href="addListing.php" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-500 hover:bg-gray-50 hover:text-gray-900 transition">
                <i class="bi bi-plus-circle-fill"></i> <span class="font-medium">Add Listing</span>
            </a>
            <a href="orders.php" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-500 hover:bg-gray-50 hover:text-gray-900 transition">
                <i class="bi bi-bag-fill"></i> <span class="font-medium">Orders</span>
            </a>
            <a href="customers.php" class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-500 hover:bg-gray-50 hover:text-gray-900 transition">
                <i class="bi bi-people-fill"></i> <span class="font-medium">Customers</span>
            </a>
            <a href="message.php" class="flex items-center gap-3 px-4 py-3 rounded-lg bg-gray-900 text-white transition">
                <i class="bi bi-chat-dots-fill"></i> <span class="font-medium">Messages</span>
            </a>
        </nav>

        <div class="p-4 border-t border-gray-100">
            <a href="addListing.php" class="flex items-center justify-center gap-2 w-full py-3 bg-gray-900 text-white rounded-lg font-semibold hover:bg-gray-800 transition">
                <i class="bi bi-plus-lg"></i> New Listing
            </a>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 md:ml-64 flex flex-col h-screen">
        
        <!-- Top Header -->
        <header class="bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <button class="md:hidden text-gray-500">
                    <i class="bi bi-list text-2xl"></i>
                </button>
                <h1 class="text-xl font-bold text-gray-900">Messages</h1>
            </div>
            <div class="flex items-center gap-4">
                <div class="relative">
                    <input type="text" placeholder="Search messages..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none w-64">
                    <i class="bi bi-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                <div class="h-8 w-8 bg-gray-200 rounded-full flex items-center justify-center">
                    <i class="bi bi-person-fill text-gray-600"></i>
                </div>
            </div>
        </header>

        <!-- Messages Container -->
        <div class="flex-1 flex overflow-hidden">
            
            <!-- Conversation List -->
            <div class="w-full md:w-1/3 border-r border-gray-200 bg-white flex flex-col">
                <!-- Tabs -->
                <div class="flex border-b border-gray-100">
                    <button class="flex-1 py-3 text-sm font-semibold text-gray-900 border-b-2 border-gray-900">
                        Inbox
                    </button>
                    <button class="flex-1 py-3 text-sm font-medium text-gray-500 hover:text-gray-900">
                        Unread
                    </button>
                </div>

                <!-- List -->
                <div class="flex-1 overflow-y-auto">
                    <!-- Active Message Item -->
                    <div class="p-4 border-b border-gray-100 bg-gray-50 cursor-pointer hover:bg-gray-100 transition">
                        <div class="flex items-start gap-3">
                            <div class="h-10 w-10 rounded-full bg-gray-900 text-white flex items-center justify-center font-semibold text-sm flex-shrink-0">
                                JD
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-center mb-1">
                                    <h4 class="font-semibold text-gray-900 text-sm">John Doe</h4>
                                    <span class="text-xs text-gray-500">2m ago</span>
                                </div>
                                <p class="text-sm text-gray-900 font-medium truncate">Re: Burberry Trench Order</p>
                                <p class="text-xs text-gray-500 truncate">Hi, I'd like to know if this item comes in size...</p>
                            </div>
                            <span class="h-2 w-2 bg-blue-500 rounded-full flex-shrink-0"></span>
                        </div>
                    </div>

                    <!-- Other Message Items -->
                    <div class="p-4 border-b border-gray-100 cursor-pointer hover:bg-gray-50 transition">
                        <div class="flex items-start gap-3">
                            <div class="h-10 w-10 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-semibold text-sm flex-shrink-0">
                                AS
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-center mb-1">
                                    <h4 class="font-semibold text-gray-900 text-sm">Alice Smith</h4>
                                    <span class="text-xs text-gray-500">1h ago</span>
                                </div>
                                <p class="text-sm text-gray-500 truncate">Shipping Question</p>
                                <p class="text-xs text-gray-400 truncate">Do you ship to Zimbabwe?</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 border-b border-gray-100 cursor-pointer hover:bg-gray-50 transition">
                        <div class="flex items-start gap-3">
                            <div class="h-10 w-10 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-semibold text-sm flex-shrink-0">
                                MK
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-center mb-1">
                                    <h4 class="font-semibold text-gray-900 text-sm">Mary Kim</h4>
                                    <span class="text-xs text-gray-500">Yesterday</span>
                                </div>
                                <p class="text-sm text-gray-500 truncate">Return Request</p>
                                <p class="text-xs text-gray-400 truncate">I'd like to return the dress I bought...</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 border-b border-gray-100 cursor-pointer hover:bg-gray-50 transition">
                        <div class="flex items-start gap-3">
                            <div class="h-10 w-10 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-semibold text-sm flex-shrink-0">
                                BJ
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-center mb-1">
                                    <h4 class="font-semibold text-gray-900 text-sm">Bob Jones</h4>
                                    <span class="text-xs text-gray-500">Oct 23</span>
                                </div>
                                <p class="text-sm text-gray-500 truncate">Thank you!</p>
                                <p class="text-xs text-gray-400 truncate">Package arrived safely. Thank you...</p>
                            </div>
                        </div>
                    </div>

                    <!-- 
                    You can loop your PHP messages here:
                    <?php while ($row = mysqli_fetch_assoc($messages_result)) { ?>
                    <div class="p-4 border-b border-gray-100 cursor-pointer hover:bg-gray-50 transition">
                        <div class="flex items-start gap-3">
                            <div class="h-10 w-10 rounded-full bg-gray-300 text-gray-600 flex items-center justify-center font-semibold text-sm flex-shrink-0">
                                <?php echo strtoupper(substr($row['sender_name'], 0, 1)); ?>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex justify-between items-center mb-1">
                                    <h4 class="font-semibold text-gray-900 text-sm"><?php echo $row['sender_name']; ?></h4>
                                    <span class="text-xs text-gray-500"><?php echo date('M d', strtotime($row['timestamp'])); ?></span>
                                </div>
                                <p class="text-sm text-gray-900 font-medium truncate"><?php echo $row['subject']; ?></p>
                                <p class="text-xs text-gray-500 truncate"><?php echo substr($row['message'], 0, 50); ?>...</p>
                            </div>
                            <?php if($row['is_read'] == 0) { ?>
                            <span class="h-2 w-2 bg-blue-500 rounded-full flex-shrink-0"></span>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                    -->
                </div>
            </div>

            <!-- Message View Panel -->
            <div class="hidden md:flex flex-1 flex-col bg-gray-50">
                <!-- Message Header -->
                <div class="bg-white p-4 border-b border-gray-200 flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <div class="h-12 w-12 rounded-full bg-gray-900 text-white flex items-center justify-center font-semibold">
                            JD
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">John Doe</h3>
                            <p class="text-xs text-gray-500">john.doe@example.com</p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button class="p-2 text-gray-500 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition">
                            <i class="bi bi-trash"></i>
                        </button>
                        <button class="p-2 text-gray-500 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition">
                            <i class="bi bi-info-circle"></i>
                        </button>
                    </div>
                </div>

                <!-- Message Thread -->
                <div class="flex-1 overflow-y-auto p-6 space-y-6">
                    
                    <!-- Date Divider -->
                    <div class="flex justify-center">
                        <span class="text-xs text-gray-400 bg-gray-200 px-3 py-1 rounded-full">Today, 10:30 AM</span>
                    </div>

                    <!-- Incoming Message -->
                    <div class="flex gap-4">
                        <div class="h-8 w-8 rounded-full bg-gray-900 text-white flex items-center justify-center text-xs font-semibold flex-shrink-0">
                            JD
                        </div>
                        <div class="bg-white p-4 rounded-lg rounded-tl-none shadow-sm max-w-md">
                            <p class="text-sm text-gray-800">
                                Hi there! I'm interested in the Burberry Trench Coat you have listed. 
                                Does it come in size Medium? Also, do you have any other colors available?
                            </p>
                            <span class="text-xs text-gray-400 mt-2 block">10:30 AM</span>
                        </div>
                    </div>

                    <!-- Outgoing Reply -->
                    <div class="flex gap-4 flex-row-reverse">
                        <div class="h-8 w-8 rounded-full bg-gray-600 text-white flex items-center justify-center text-xs font-semibold flex-shrink-0">
                            ME
                        </div>
                        <div class="bg-gray-900 text-white p-4 rounded-lg rounded-tr-none shadow-sm max-w-md">
                            <p class="text-sm">
                                Hello John! Thanks for your interest. Yes, the Burberry Trench 
                                is available in Size Medium. Unfortunately, it's only available in the classic beige 
                                color at the moment. Would you like me to reserve one for you?
                            </p>
                            <span class="text-xs text-gray-400 mt-2 block">10:35 AM</span>
                        </div>
                    </div>

                    <!-- New Incoming -->
                    <div class="flex gap-4">
                        <div class="h-8 w-8 rounded-full bg-gray-900 text-white flex items-center justify-center text-xs font-semibold flex-shrink-0">
                            JD
                        </div>
                        <div class="bg-white p-4 rounded-lg rounded-tl-none shadow-sm max-w-md">
                            <p class="text-sm text-gray-800">
                                Yes please! That would be great. Is there an option for express shipping?
                            </p>
                            <span class="text-xs text-gray-400 mt-2 block">2 minutes ago</span>
                        </div>
                    </div>
                </div>

                <!-- Reply Box -->
                <div class="bg-white p-4 border-t border-gray-200">
                    <div class="flex gap-3">
                        <button class="p-2 text-gray-500 hover:text-gray-900 transition">
                            <i class="bi bi-paperclip"></i>
                        </button>
                        <input type="text" placeholder="Type your reply..." class="flex-1 border border-gray-300 rounded-lg px-4 focus:ring-2 focus:ring-gray-900 focus:border-transparent outline-none">
                        <button class="px-4 py-2 bg-gray-900 text-white rounded-lg font-semibold hover:bg-gray-800 transition">
                            Send <i class="bi bi-send ml-2"></i>
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </main>

</body>
</html>