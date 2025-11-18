<?php
/**
 * Admin Login Page
 * Coffee CourtYard Website
 */

require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

// Redirect if already logged in
if (isAdminLoggedIn()) {
    redirect('dashboard.php');
}

$error = '';

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitizeInput($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($password)) {
        $error = 'Please enter both username and password';
    } else {
        // Initialize database
        $db = new Database();

        // Prepare statement to prevent SQL injection
        $query = "SELECT id, username, password_hash FROM admin_users WHERE username = ?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $admin = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $admin['password_hash'])) {
                // Set session variables
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_username'] = $admin['username'];

                // Update last login
                $updateQuery = "UPDATE admin_users SET last_login = NOW() WHERE id = ?";
                $updateStmt = $db->prepare($updateQuery);
                $updateStmt->bind_param("i", $admin['id']);
                $updateStmt->execute();

                // Redirect to dashboard
                redirect('dashboard.php');
            } else {
                $error = 'Invalid username or password';
            }
        } else {
            $error = 'Invalid username or password';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Coffee CourtYard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet"/>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        "primary": "#dda15e",
                        "secondary": "#283618",
                        "accent": "#bc6c25",
                        "bg-light": "#fefae0",
                    },
                    fontFamily: {
                        "display": ["Plus Jakarta Sans", "sans-serif"]
                    }
                }
            }
        }
    </script>
</head>
<body class="font-display bg-bg-light">
    <div class="min-h-screen flex items-center justify-center px-4">
        <div class="max-w-md w-full space-y-8">
            <!-- Logo and Title -->
            <div class="text-center">
                <div class="flex justify-center">
                    <span class="material-symbols-outlined text-primary text-6xl">local_cafe</span>
                </div>
                <h2 class="mt-6 text-3xl font-bold text-secondary">Coffee CourtYard</h2>
                <p class="mt-2 text-sm text-gray-600">Admin Dashboard Login</p>
            </div>

            <!-- Login Form -->
            <div class="bg-white rounded-xl shadow-lg p-8">
                <?php if ($error): ?>
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="" class="space-y-6">
                    <div>
                        <label for="username" class="block text-sm font-medium text-secondary mb-2">
                            Username
                        </label>
                        <input type="text"
                               id="username"
                               name="username"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                               placeholder="Enter your username">
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-secondary mb-2">
                            Password
                        </label>
                        <input type="password"
                               id="password"
                               name="password"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"
                               placeholder="Enter your password">
                    </div>

                    <button type="submit"
                            class="w-full bg-primary hover:bg-accent text-white font-bold py-3 px-4 rounded-lg transition-colors duration-200">
                        Login to Dashboard
                    </button>
                </form>

                <div class="mt-6 text-center text-sm text-gray-600">
                    <p>Default credentials:</p>
                    <p class="font-mono">Username: admin | Password: admin123</p>
                </div>
            </div>

            <!-- Back to Website Link -->
            <div class="text-center">
                <a href="../public/index.php" class="text-sm text-secondary hover:text-primary transition-colors">
                    ← Back to Website
                </a>
            </div>
        </div>
    </div>
</body>
</html>
