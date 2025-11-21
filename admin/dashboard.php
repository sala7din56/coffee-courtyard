<?php
/**
 * Admin Dashboard - Main Page
 * Coffee CourtYard Website
 */

require_once 'auth_check.php';
require_once '../includes/db.php';

$db = new Database();

// Get statistics
$menuCountQuery = "SELECT COUNT(*) as count FROM menu_items";
$menuCount = $db->query($menuCountQuery)->fetch_assoc()['count'];

$contentCountQuery = "SELECT COUNT(*) as count FROM homepage_content";
$contentCount = $db->query($contentCountQuery)->fetch_assoc()['count'];

$adminCountQuery = "SELECT COUNT(*) as count FROM admin_users";
$adminCount = $db->query($adminCountQuery)->fetch_assoc()['count'];

// Get recent menu items
$recentMenuQuery = "SELECT * FROM menu_items ORDER BY created_at DESC LIMIT 5";
$recentMenu = $db->query($recentMenuQuery)->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Coffee CourtYard Admin</title>
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
                    <a href="dashboard.php" class="flex items-center gap-3 px-4 py-3 bg-primary/20 rounded-lg text-white">
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
                    <a href="order_reports.php" class="flex items-center gap-3 px-4 py-3 hover:bg-white/10 rounded-lg transition">
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
                    <h1 class="text-3xl font-bold text-secondary">Dashboard</h1>
                    <p class="text-gray-600 mt-2">Welcome back, <?= htmlspecialchars($_SESSION['admin_username']) ?>!</p>
                </div>

                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Total Menu Items</p>
                                <p class="text-3xl font-bold text-secondary mt-2"><?= $menuCount ?></p>
                            </div>
                            <div class="bg-primary/10 p-3 rounded-lg">
                                <span class="material-symbols-outlined text-primary text-4xl">restaurant_menu</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Homepage Sections</p>
                                <p class="text-3xl font-bold text-secondary mt-2"><?= $contentCount ?></p>
                            </div>
                            <div class="bg-accent/10 p-3 rounded-lg">
                                <span class="material-symbols-outlined text-accent text-4xl">home</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-gray-600 text-sm font-medium">Admin Users</p>
                                <p class="text-3xl font-bold text-secondary mt-2"><?= $adminCount ?></p>
                            </div>
                            <div class="bg-secondary/10 p-3 rounded-lg">
                                <span class="material-symbols-outlined text-secondary text-4xl">admin_panel_settings</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Menu Items -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-xl font-bold text-secondary">Recent Menu Items</h2>
                        <a href="menu_items.php" class="text-primary hover:text-accent text-sm font-medium">View All →</a>
                    </div>

                    <?php if (!empty($recentMenu)): ?>
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="border-b">
                                        <th class="text-left py-3 px-4 text-gray-600 font-medium">Name</th>
                                        <th class="text-left py-3 px-4 text-gray-600 font-medium">Category</th>
                                        <th class="text-left py-3 px-4 text-gray-600 font-medium">Price</th>
                                        <th class="text-left py-3 px-4 text-gray-600 font-medium">Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentMenu as $item): ?>
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="py-3 px-4"><?= htmlspecialchars($item['name']) ?></td>
                                            <td class="py-3 px-4"><?= htmlspecialchars($item['category']) ?></td>
                                            <td class="py-3 px-4"><?= formatPrice($item['price']) ?></td>
                                            <td class="py-3 px-4 text-sm text-gray-600">
                                                <?= date('M d, Y', strtotime($item['created_at'])) ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-gray-600 text-center py-8">No menu items yet. Add your first item!</p>
                    <?php endif; ?>
                </div>

                <!-- Quick Actions -->
                <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <a href="menu_items.php?action=add" class="bg-primary hover:bg-accent text-white rounded-lg p-6 flex items-center gap-4 transition-colors">
                        <span class="material-symbols-outlined text-5xl">add_circle</span>
                        <div>
                            <h3 class="font-bold text-lg">Add Menu Item</h3>
                            <p class="text-sm opacity-90">Create a new menu item</p>
                        </div>
                    </a>

                    <a href="homepage_content.php" class="bg-secondary hover:bg-accent text-white rounded-lg p-6 flex items-center gap-4 transition-colors">
                        <span class="material-symbols-outlined text-5xl">edit</span>
                        <div>
                            <h3 class="font-bold text-lg">Edit Homepage</h3>
                            <p class="text-sm opacity-90">Update website content</p>
                        </div>
                    </a>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
