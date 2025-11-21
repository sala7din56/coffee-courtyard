<?php
require_once 'auth_check.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

$db = new Database();

// Default filter to daily
$filter = $_GET['filter'] ?? 'daily';
$period = '';

$currentDate = date('Y-m-d');
$currentMonth = date('Y-m');
$currentYear = date('Y');

$totalOrders = 0;
$totalProfit = 0.00;
$orders = [];

// Logic to fetch orders and calculate stats based on filter will go here
switch ($filter) {
    case 'daily':
        $period = $currentDate;
        // Fetch daily orders and calculate total
        $query = "SELECT SUM(total) as profit, COUNT(id) as orders_count FROM orders WHERE DATE(created_at) = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $currentDate);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $totalOrders = $result['orders_count'] ?? 0;
        $totalProfit = $result['profit'] ?? 0.00;

        $ordersQuery = "SELECT * FROM orders WHERE DATE(created_at) = ? ORDER BY created_at DESC";
        $ordersStmt = $db->prepare($ordersQuery);
        $ordersStmt->bind_param("s", $currentDate);
        $ordersStmt->execute();
        $orders = $ordersStmt->get_result()->fetch_all(MYSQLI_ASSOC);
        break;
    case 'monthly':
        $period = date('F Y');
        // Fetch monthly orders and calculate total
        $query = "SELECT SUM(total) as profit, COUNT(id) as orders_count FROM orders WHERE DATE_FORMAT(created_at, '%Y-%m') = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $currentMonth);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $totalOrders = $result['orders_count'] ?? 0;
        $totalProfit = $result['profit'] ?? 0.00;

        $ordersQuery = "SELECT * FROM orders WHERE DATE_FORMAT(created_at, '%Y-%m') = ? ORDER BY created_at DESC";
        $ordersStmt = $db->prepare($ordersQuery);
        $ordersStmt->bind_param("s", $currentMonth);
        $ordersStmt->execute();
        $orders = $ordersStmt->get_result()->fetch_all(MYSQLI_ASSOC);
        break;
    case 'yearly':
        $period = $currentYear;
        // Fetch yearly orders and calculate total
        $query = "SELECT SUM(total) as profit, COUNT(id) as orders_count FROM orders WHERE DATE_FORMAT(created_at, '%Y') = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $currentYear);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $totalOrders = $result['orders_count'] ?? 0;
        $totalProfit = $result['profit'] ?? 0.00;

        $ordersQuery = "SELECT * FROM orders WHERE DATE_FORMAT(created_at, '%Y') = ? ORDER BY created_at DESC";
        $ordersStmt = $db->prepare($ordersQuery);
        $ordersStmt->bind_param("s", $currentYear);
        $ordersStmt->execute();
        $orders = $ordersStmt->get_result()->fetch_all(MYSQLI_ASSOC);
        break;
    default:
        // Fallback to daily
        $filter = 'daily';
        $period = $currentDate;
        $query = "SELECT SUM(total) as profit, COUNT(id) as orders_count FROM orders WHERE DATE(created_at) = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $currentDate);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $totalOrders = $result['orders_count'] ?? 0;
        $totalProfit = $result['profit'] ?? 0.00;

        $ordersQuery = "SELECT * FROM orders WHERE DATE(created_at) = ? ORDER BY created_at DESC";
        $ordersStmt = $db->prepare($ordersQuery);
        $ordersStmt->bind_param("s", $currentDate);
        $ordersStmt->execute();
        $orders = $ordersStmt->get_result()->fetch_all(MYSQLI_ASSOC);
        break;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Reports - Coffee CourtYard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <link href="css/admin.css" rel="stylesheet"/>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        "primary": "#dda15e",
                        "secondary": "#283618",
                        "accent": "#bc6c25",
                        "bg-light": "#fefae0",
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-secondary text-white">
            <div class="p-6">
                <div class="flex items-center gap-2 mb-8">
                    <span class="material-symbols-outlined text-primary text-3xl">local_cafe</span>
                    <h1 class="text-xl font-bold">Coffee CourtYard</h1>
                </div>

                <nav class="space-y-2">
                    <a href="dashboard.php" class="flex items-center gap-3 px-4 py-3 hover:bg-white/10 rounded-lg transition">
                        <span class="material-symbols-outlined">dashboard</span>
                        <span>Dashboard</span>
                    </a>
                    <a href="menu_items.php" class="flex items-center gap-3 px-4 py-3 hover:bg-white/10 rounded-lg transition">
                        <span class="material-symbols-outlined">restaurant_menu</span>
                        <span>Menu Items</span>
                    </a>
                    <a href="homepage_content.php" class="flex items-center gap-3 px-4 py-3 hover:bg-white/10 rounded-lg transition">
                        <span class="material-symbols-outlined">home</span>
                        <span>Homepage Content</span>
                    </a>
                    <a href="employee_financials.php" class="flex items-center gap-3 px-4 py-3 hover:bg-white/10 rounded-lg transition">
                        <span class="material-symbols-outlined">payments</span>
                        <span>Employee Financials</span>
                    </a>
                    <a href="order_reports.php" class="flex items-center gap-3 px-4 py-3 bg-primary/20 rounded-lg text-white">
                        <span class="material-symbols-outlined">analytics</span>
                        <span>Order Reports</span>
                    </a>
                    <a href="../public/index.php" target="_blank" class="flex items-center gap-3 px-4 py-3 hover:bg-white/10 rounded-lg transition">
                        <span class="material-symbols-outlined">open_in_new</span>
                        <span>View Website</span>
                    </a>
                </nav>
            </div>

            <div class="absolute bottom-0 w-64 p-6 border-t border-white/20">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium"><?= htmlspecialchars($_SESSION['admin_username']) ?></p>
                        <p class="text-xs text-gray-400">Administrator</p>
                    </div>
                    <a href="logout.php" class="text-red-400 hover:text-red-300" title="Logout">
                        <span class="material-symbols-outlined">logout</span>
                    </a>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <div class="p-8">
                <!-- Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-secondary">Order Reports</h1>
                    <p class="text-gray-600 mt-2">Overview of orders and sales performance for <?= htmlspecialchars($period) ?>.</p>
                </div>

                <!-- Filter Buttons -->
                <div class="bg-white rounded-lg shadow-md p-4 mb-8 flex gap-4">
                    <a href="order_reports.php?filter=daily" class="px-4 py-2 rounded-lg <?= $filter === 'daily' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700' ?>">Daily</a>
                    <a href="order_reports.php?filter=monthly" class="px-4 py-2 rounded-lg <?= $filter === 'monthly' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700' ?>">Monthly</a>
                    <a href="order_reports.php?filter=yearly" class="px-4 py-2 rounded-lg <?= $filter === 'yearly' ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700' ?>">Yearly</a>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Total Orders</p>
                                <p class="text-3xl font-bold text-secondary mt-2"><?= $totalOrders ?></p>
                            </div>
                            <div class="bg-primary/10 p-3 rounded-lg">
                                <span class="material-symbols-outlined text-primary text-4xl">receipt_long</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Total Profit (Revenue)</p>
                                <p class="text-3xl font-bold text-secondary mt-2">$<?= number_format($totalProfit, 2) ?></p>
                            </div>
                            <div class="bg-accent/10 p-3 rounded-lg">
                                <span class="material-symbols-outlined text-accent text-4xl">attach_money</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders List -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-secondary mb-4">Orders for <?= htmlspecialchars($period) ?></h2>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left py-3 px-4 text-gray-600 font-medium">Order ID</th>
                                    <th class="text-left py-3 px-4 text-gray-600 font-medium">Customer Name</th>
                                    <th class="text-left py-3 px-4 text-gray-600 font-medium">Phone</th>
                                    <th class="text-left py-3 px-4 text-gray-600 font-medium">Total</th>
                                    <th class="text-left py-3 px-4 text-gray-600 font-medium">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($orders)): ?>
                                    <?php foreach ($orders as $order): ?>
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="py-3 px-4"><?= htmlspecialchars($order['id']) ?></td>
                                            <td class="py-3 px-4"><?= htmlspecialchars($order['customer_name']) ?></td>
                                            <td class="py-3 px-4"><?= htmlspecialchars($order['phone']) ?></td>
                                            <td class="py-3 px-4">$<?= htmlspecialchars(number_format($order['total'], 2)) ?></td>
                                            <td class="py-3 px-4 text-sm text-gray-600">
                                                <?= date('M d, Y H:i', strtotime($order['created_at'])) ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-8 text-gray-600">No orders found for this period.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
