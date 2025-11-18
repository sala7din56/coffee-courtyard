<?php
/**
 * Menu Items Management
 * Coffee CourtYard Admin
 * CRUD operations for menu items
 */

require_once 'auth_check.php';
require_once '../includes/db.php';

$db = new Database();
$message = '';
$messageType = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add' || $action === 'edit') {
        $id = $_POST['id'] ?? null;
        $name = sanitizeInput($_POST['name'] ?? '');
        $description = sanitizeInput($_POST['description'] ?? '');
        $price = floatval($_POST['price'] ?? 0);
        $category = sanitizeInput($_POST['category'] ?? '');

        // Handle image upload
        $imagePath = $_POST['existing_image'] ?? '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = handleFileUpload($_FILES['image'], UPLOAD_DIR);
            if ($uploadResult['success']) {
                // Delete old image if editing
                if ($action === 'edit' && !empty($imagePath)) {
                    deleteUploadedFile($imagePath);
                }
                $imagePath = $uploadResult['filename'];
            } else {
                $message = 'Image upload failed: ' . $uploadResult['error'];
                $messageType = 'error';
            }
        }

        if (empty($message)) {
            if ($action === 'add') {
                $query = "INSERT INTO menu_items (name, description, price, category, image_path) VALUES (?, ?, ?, ?, ?)";
                $stmt = $db->prepare($query);
                $stmt->bind_param("ssdss", $name, $description, $price, $category, $imagePath);

                if ($stmt->execute()) {
                    $message = 'Menu item added successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Error adding menu item: ' . $stmt->error;
                    $messageType = 'error';
                }
            } else {
                $query = "UPDATE menu_items SET name = ?, description = ?, price = ?, category = ?, image_path = ? WHERE id = ?";
                $stmt = $db->prepare($query);
                $stmt->bind_param("ssdssi", $name, $description, $price, $category, $imagePath, $id);

                if ($stmt->execute()) {
                    $message = 'Menu item updated successfully!';
                    $messageType = 'success';
                } else {
                    $message = 'Error updating menu item: ' . $stmt->error;
                    $messageType = 'error';
                }
            }
        }
    } elseif ($action === 'delete') {
        $id = intval($_POST['id'] ?? 0);
        if ($id > 0) {
            // Get image path before deleting
            $query = "SELECT image_path FROM menu_items WHERE id = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $item = $result->fetch_assoc();

            // Delete from database
            $deleteQuery = "DELETE FROM menu_items WHERE id = ?";
            $deleteStmt = $db->prepare($deleteQuery);
            $deleteStmt->bind_param("i", $id);

            if ($deleteStmt->execute()) {
                // Delete image file
                if (!empty($item['image_path'])) {
                    deleteUploadedFile($item['image_path']);
                }
                $message = 'Menu item deleted successfully!';
                $messageType = 'success';
            } else {
                $message = 'Error deleting menu item';
                $messageType = 'error';
            }
        }
    }
}

// Get current action
$currentAction = $_GET['action'] ?? 'list';
$editId = intval($_GET['id'] ?? 0);

// Fetch item for editing
$editItem = null;
if ($currentAction === 'edit' && $editId > 0) {
    $query = "SELECT * FROM menu_items WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $editId);
    $stmt->execute();
    $result = $stmt->get_result();
    $editItem = $result->fetch_assoc();
}

// Fetch all menu items
$menuItems = $db->query("SELECT * FROM menu_items ORDER BY category, name")->fetch_all(MYSQLI_ASSOC);

// Get unique categories
$categories = array_unique(array_column($menuItems, 'category'));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Items - Coffee CourtYard Admin</title>
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
                    <a href="menu_items.php" class="flex items-center gap-3 px-4 py-3 bg-primary/20 rounded-lg text-white">
                        <span class="material-symbols-outlined">restaurant_menu</span>
                        <span>Menu Items</span>
                    </a>
                    <a href="homepage_content.php" class="flex items-center gap-3 px-4 py-3 hover:bg-white/10 rounded-lg transition">
                        <span class="material-symbols-outlined">home</span>
                        <span>Homepage Content</span>
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
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h1 class="text-3xl font-bold text-secondary">Menu Items</h1>
                        <p class="text-gray-600 mt-2">Manage your coffee shop menu</p>
                    </div>
                    <?php if ($currentAction === 'list'): ?>
                        <a href="?action=add" class="bg-primary hover:bg-accent text-white px-6 py-3 rounded-lg font-medium flex items-center gap-2 transition">
                            <span class="material-symbols-outlined">add</span>
                            Add New Item
                        </a>
                    <?php else: ?>
                        <a href="menu_items.php" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium flex items-center gap-2 transition">
                            <span class="material-symbols-outlined">arrow_back</span>
                            Back to List
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Messages -->
                <?php if ($message): ?>
                    <div class="alert alert-<?= $messageType ?> mb-6">
                        <?= htmlspecialchars($message) ?>
                    </div>
                <?php endif; ?>

                <!-- Add/Edit Form -->
                <?php if ($currentAction === 'add' || $currentAction === 'edit'): ?>
                    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                        <h2 class="text-2xl font-bold text-secondary mb-6">
                            <?= $currentAction === 'add' ? 'Add New Menu Item' : 'Edit Menu Item' ?>
                        </h2>

                        <form method="POST" enctype="multipart/form-data" class="space-y-6">
                            <input type="hidden" name="action" value="<?= $currentAction ?>">
                            <?php if ($editItem): ?>
                                <input type="hidden" name="id" value="<?= $editItem['id'] ?>">
                                <input type="hidden" name="existing_image" value="<?= htmlspecialchars($editItem['image_path']) ?>">
                            <?php endif; ?>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="form-label">Item Name *</label>
                                    <input type="text"
                                           name="name"
                                           required
                                           class="form-input"
                                           value="<?= htmlspecialchars($editItem['name'] ?? '') ?>"
                                           placeholder="e.g., Cappuccino">
                                </div>

                                <div>
                                    <label class="form-label">Price * ($)</label>
                                    <input type="number"
                                           name="price"
                                           required
                                           step="0.01"
                                           min="0"
                                           class="form-input"
                                           value="<?= htmlspecialchars($editItem['price'] ?? '') ?>"
                                           placeholder="e.g., 4.50">
                                </div>
                            </div>

                            <div>
                                <label class="form-label">Category *</label>
                                <select name="category" required class="form-input">
                                    <option value="">Select a category</option>
                                    <option value="Hot Coffee" <?= ($editItem['category'] ?? '') === 'Hot Coffee' ? 'selected' : '' ?>>Hot Coffee</option>
                                    <option value="Iced Drinks" <?= ($editItem['category'] ?? '') === 'Iced Drinks' ? 'selected' : '' ?>>Iced Drinks</option>
                                    <option value="Pastries" <?= ($editItem['category'] ?? '') === 'Pastries' ? 'selected' : '' ?>>Pastries</option>
                                    <option value="Food" <?= ($editItem['category'] ?? '') === 'Food' ? 'selected' : '' ?>>Food</option>
                                    <option value="Tea" <?= ($editItem['category'] ?? '') === 'Tea' ? 'selected' : '' ?>>Tea</option>
                                </select>
                            </div>

                            <div>
                                <label class="form-label">Description</label>
                                <textarea name="description"
                                          rows="3"
                                          class="form-input"
                                          placeholder="Describe this menu item..."><?= htmlspecialchars($editItem['description'] ?? '') ?></textarea>
                            </div>

                            <div>
                                <label class="form-label">Image</label>
                                <input type="file"
                                       name="image"
                                       accept="image/*"
                                       class="form-input"
                                       onchange="previewImage(this)">
                                <p class="text-sm text-gray-600 mt-1">Recommended: Square image, max 5MB</p>

                                <?php if ($editItem && !empty($editItem['image_path'])): ?>
                                    <div class="mt-4">
                                        <p class="text-sm text-gray-600 mb-2">Current Image:</p>
                                        <img src="../public/images/uploads/<?= htmlspecialchars($editItem['image_path']) ?>"
                                             alt="Current image"
                                             class="image-preview">
                                    </div>
                                <?php endif; ?>

                                <div id="imagePreview" class="mt-4 hidden">
                                    <p class="text-sm text-gray-600 mb-2">New Image Preview:</p>
                                    <img id="previewImg" class="image-preview">
                                </div>
                            </div>

                            <div class="flex gap-4">
                                <button type="submit" class="bg-primary hover:bg-accent text-white px-8 py-3 rounded-lg font-medium transition">
                                    <?= $currentAction === 'add' ? 'Add Menu Item' : 'Update Menu Item' ?>
                                </button>
                                <a href="menu_items.php" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-8 py-3 rounded-lg font-medium transition">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>

                <!-- Menu Items List -->
                <?php if ($currentAction === 'list'): ?>
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <?php if (empty($menuItems)): ?>
                            <div class="p-12 text-center">
                                <span class="material-symbols-outlined text-gray-400 text-6xl">restaurant_menu</span>
                                <p class="text-gray-600 mt-4 text-lg">No menu items yet</p>
                                <a href="?action=add" class="inline-block mt-4 bg-primary hover:bg-accent text-white px-6 py-3 rounded-lg font-medium transition">
                                    Add Your First Item
                                </a>
                            </div>
                        <?php else: ?>
                            <table class="data-table">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Description</th>
                                        <th>Price</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($menuItems as $item): ?>
                                        <tr>
                                            <td>
                                                <?php if (!empty($item['image_path'])): ?>
                                                    <img src="../public/images/uploads/<?= htmlspecialchars($item['image_path']) ?>"
                                                         alt="<?= htmlspecialchars($item['name']) ?>"
                                                         class="w-16 h-16 object-cover rounded">
                                                <?php else: ?>
                                                    <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                                        <span class="material-symbols-outlined text-gray-400">image</span>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td class="font-medium"><?= htmlspecialchars($item['name']) ?></td>
                                            <td>
                                                <span class="badge badge-primary"><?= htmlspecialchars($item['category']) ?></span>
                                            </td>
                                            <td class="text-sm text-gray-600 max-w-xs truncate">
                                                <?= htmlspecialchars($item['description']) ?>
                                            </td>
                                            <td class="font-bold text-secondary"><?= formatPrice($item['price']) ?></td>
                                            <td>
                                                <div class="flex gap-2">
                                                    <a href="?action=edit&id=<?= $item['id'] ?>"
                                                       class="text-primary hover:text-accent"
                                                       title="Edit">
                                                        <span class="material-symbols-outlined">edit</span>
                                                    </a>
                                                    <form method="POST" onsubmit="return confirm('Are you sure you want to delete this item?')" class="inline">
                                                        <input type="hidden" name="action" value="delete">
                                                        <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                                        <button type="submit"
                                                                class="text-red-600 hover:text-red-800"
                                                                title="Delete">
                                                            <span class="material-symbols-outlined">delete</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <script>
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            const previewImg = document.getElementById('previewImg');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    preview.classList.remove('hidden');
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>
