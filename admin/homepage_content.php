<?php
/**
 * Homepage Content Management
 * Coffee CourtYard Admin
 * Edit homepage sections
 */

require_once 'auth_check.php';
require_once '../includes/db.php';

$db = new Database();
$message = '';
$messageType = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sectionName = sanitizeInput($_POST['section_name'] ?? '');
    $contentText = sanitizeInput($_POST['content_text'] ?? '');

    if (!empty($sectionName)) {
        $query = "UPDATE homepage_content SET content_text = ? WHERE section_name = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("ss", $contentText, $sectionName);

        if ($stmt->execute()) {
            $message = 'Content updated successfully!';
            $messageType = 'success';
        } else {
            $message = 'Error updating content: ' . $stmt->error;
            $messageType = 'error';
        }
    }
}

// Fetch all homepage content
$content = getAllHomepageContent($db);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage Content - Coffee CourtYard Admin</title>
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
                    <a href="menu_items.php" class="flex items-center gap-3 px-4 py-3 hover:bg-white/10 rounded-lg transition">
                        <span class="material-symbols-outlined">restaurant_menu</span>
                        <span>Menu Items</span>
                    </a>
                    <a href="homepage_content.php" class="flex items-center gap-3 px-4 py-3 bg-primary/20 rounded-lg text-white">
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
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-secondary">Homepage Content</h1>
                    <p class="text-gray-600 mt-2">Manage the content displayed on your website homepage</p>
                </div>

                <!-- Messages -->
                <?php if ($message): ?>
                    <div class="alert alert-<?= $messageType ?> mb-6">
                        <?= htmlspecialchars($message) ?>
                    </div>
                <?php endif; ?>

                <!-- Content Sections -->
                <div class="space-y-6">

                    <!-- Hero Section -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="material-symbols-outlined text-primary text-3xl">image</span>
                            <h2 class="text-2xl font-bold text-secondary">Hero Section</h2>
                        </div>

                        <form method="POST" class="space-y-4">
                            <div>
                                <label class="form-label">Hero Title</label>
                                <input type="hidden" name="section_name" value="hero_title">
                                <input type="text"
                                       name="content_text"
                                       class="form-input"
                                       value="<?= htmlspecialchars($content['hero_title']['content_text'] ?? '') ?>"
                                       placeholder="Your Everyday Escape.">
                            </div>
                            <button type="submit" class="bg-primary hover:bg-accent text-white px-6 py-2 rounded-lg font-medium transition">
                                Update Title
                            </button>
                        </form>

                        <form method="POST" class="space-y-4 mt-6 pt-6 border-t">
                            <div>
                                <label class="form-label">Hero Subtitle</label>
                                <input type="hidden" name="section_name" value="hero_subtitle">
                                <input type="text"
                                       name="content_text"
                                       class="form-input"
                                       value="<?= htmlspecialchars($content['hero_subtitle']['content_text'] ?? '') ?>"
                                       placeholder="Artisan coffee, fresh pastries...">
                            </div>
                            <button type="submit" class="bg-primary hover:bg-accent text-white px-6 py-2 rounded-lg font-medium transition">
                                Update Subtitle
                            </button>
                        </form>
                    </div>

                    <!-- About Section -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="material-symbols-outlined text-primary text-3xl">info</span>
                            <h2 class="text-2xl font-bold text-secondary">About Section</h2>
                        </div>

                        <form method="POST" class="space-y-4">
                            <div>
                                <label class="form-label">About Title</label>
                                <input type="hidden" name="section_name" value="about_title">
                                <input type="text"
                                       name="content_text"
                                       class="form-input"
                                       value="<?= htmlspecialchars($content['about_title']['content_text'] ?? '') ?>"
                                       placeholder="Our Story">
                            </div>
                            <button type="submit" class="bg-primary hover:bg-accent text-white px-6 py-2 rounded-lg font-medium transition">
                                Update Title
                            </button>
                        </form>

                        <form method="POST" class="space-y-4 mt-6 pt-6 border-t">
                            <div>
                                <label class="form-label">About Text</label>
                                <input type="hidden" name="section_name" value="about_text">
                                <textarea name="content_text"
                                          rows="4"
                                          class="form-input"
                                          placeholder="Tell your story..."><?= htmlspecialchars($content['about_text']['content_text'] ?? '') ?></textarea>
                            </div>
                            <button type="submit" class="bg-primary hover:bg-accent text-white px-6 py-2 rounded-lg font-medium transition">
                                Update Text
                            </button>
                        </form>
                    </div>

                    <!-- Contact Information -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="material-symbols-outlined text-primary text-3xl">contact_mail</span>
                            <h2 class="text-2xl font-bold text-secondary">Contact Information</h2>
                        </div>

                        <form method="POST" class="space-y-4">
                            <div>
                                <label class="form-label">Address</label>
                                <input type="hidden" name="section_name" value="contact_address">
                                <input type="text"
                                       name="content_text"
                                       class="form-input"
                                       value="<?= htmlspecialchars($content['contact_address']['content_text'] ?? '') ?>"
                                       placeholder="123 Cafe Lane, Roastville, CA 90210">
                            </div>
                            <button type="submit" class="bg-primary hover:bg-accent text-white px-6 py-2 rounded-lg font-medium transition">
                                Update Address
                            </button>
                        </form>

                        <form method="POST" class="space-y-4 mt-6 pt-6 border-t">
                            <div>
                                <label class="form-label">Email</label>
                                <input type="hidden" name="section_name" value="contact_email">
                                <input type="email"
                                       name="content_text"
                                       class="form-input"
                                       value="<?= htmlspecialchars($content['contact_email']['content_text'] ?? '') ?>"
                                       placeholder="hello@coffeecourtyard.com">
                            </div>
                            <button type="submit" class="bg-primary hover:bg-accent text-white px-6 py-2 rounded-lg font-medium transition">
                                Update Email
                            </button>
                        </form>

                        <form method="POST" class="space-y-4 mt-6 pt-6 border-t">
                            <div>
                                <label class="form-label">Phone</label>
                                <input type="hidden" name="section_name" value="contact_phone">
                                <input type="text"
                                       name="content_text"
                                       class="form-input"
                                       value="<?= htmlspecialchars($content['contact_phone']['content_text'] ?? '') ?>"
                                       placeholder="(555) 123-4567">
                            </div>
                            <button type="submit" class="bg-primary hover:bg-accent text-white px-6 py-2 rounded-lg font-medium transition">
                                Update Phone
                            </button>
                        </form>
                    </div>

                    <!-- Preview Button -->
                    <div class="bg-primary/10 rounded-lg p-6 text-center">
                        <p class="text-secondary font-medium mb-4">See your changes live!</p>
                        <a href="../public/index.php" target="_blank" class="inline-flex items-center gap-2 bg-primary hover:bg-accent text-white px-8 py-3 rounded-lg font-medium transition">
                            <span class="material-symbols-outlined">visibility</span>
                            Preview Website
                        </a>
                    </div>

                </div>
            </div>
        </main>
    </div>
</body>
</html>
