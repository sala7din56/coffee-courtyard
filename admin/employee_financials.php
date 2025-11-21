<?php
require_once 'auth_check.php';
require_once '../includes/db.php';
require_once '../includes/functions.php';

$db = new Database();
$message = '';
$message_type = '';
$is_editing = false;
$employee_to_edit = null;

// Handle GET request for editing
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'edit_employee' && isset($_GET['id'])) {
    $is_editing = true;
    $query = "SELECT * FROM employees WHERE id = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $_GET['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $employee_to_edit = $result->fetch_assoc();
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'add_employee') {
        try {
            $query = "INSERT INTO employees (full_name, position, hourly_wage, hire_date) VALUES (?, ?, ?, ?)";
            $stmt = $db->prepare($query);
            $stmt->bind_param(
                "ssds",
                $_POST['full_name'],
                $_POST['position'],
                $_POST['hourly_wage'],
                $_POST['hire_date']
            );
            $stmt->execute();
            $message = "Employee added successfully!";
            $message_type = 'success';
        } catch (Exception $e) {
            $message = "Error adding employee: " . $e->getMessage();
            $message_type = 'error';
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'update_employee') {
        try {
            $query = "UPDATE employees SET full_name = ?, position = ?, hourly_wage = ?, hire_date = ? WHERE id = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param(
                "ssdsi",
                $_POST['full_name'],
                $_POST['position'],
                $_POST['hourly_wage'],
                $_POST['hire_date'],
                $_POST['employee_id']
            );
            $stmt->execute();
            $message = "Employee updated successfully!";
            $message_type = 'success';
        } catch (Exception $e) {
            $message = "Error updating employee: " . $e->getMessage();
            $message_type = 'error';
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'delete_employee') {
        try {
            $query = "DELETE FROM employees WHERE id = ?";
            $stmt = $db->prepare($query);
            $stmt->bind_param("i", $_POST['employee_id']);
            $stmt->execute();
            $message = "Employee deleted successfully!";
            $message_type = 'success';
        } catch (Exception $e) {
            $message = "Error deleting employee: " . $e->getMessage();
            $message_type = 'error';
        }
    }
}

// Fetch all employees
$employees = $db->query("SELECT * FROM employees ORDER BY full_name")->fetch_all(MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Financials - Coffee CourtYard Admin</title>
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
        function confirmDelete() {
            return confirm('Are you sure you want to delete this employee?');
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
                    <a href="employee_financials.php" class="flex items-center gap-3 px-4 py-3 bg-primary/20 rounded-lg text-white">
                        <span class="material-symbols-outlined">payments</span>
                        <span>Employee Financials</span>
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
                    <h1 class="text-3xl font-bold text-secondary">Employee Financial Management</h1>
                    <p class="text-gray-600 mt-2">Manage employee details and payroll.</p>
                </div>

                <?php if ($message): ?>
                    <div class="mb-4 p-4 rounded-md <?= $message_type === 'success' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                        <?= htmlspecialchars($message) ?>
                    </div>
                <?php endif; ?>

                <!-- Add/Edit Employee Form -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                    <h2 class="text-xl font-bold text-secondary mb-4"><?= $is_editing ? 'Edit Employee' : 'Add New Employee' ?></h2>
                    <form action="employee_financials.php" method="POST" class="space-y-4">
                        <input type="hidden" name="action" value="<?= $is_editing ? 'update_employee' : 'add_employee' ?>">
                        <?php if ($is_editing): ?>
                            <input type="hidden" name="employee_id" value="<?= htmlspecialchars($employee_to_edit['id']) ?>">
                        <?php endif; ?>
                        <div>
                            <label for="full_name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" name="full_name" id="full_name" value="<?= $is_editing ? htmlspecialchars($employee_to_edit['full_name']) : '' ?>" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                        </div>
                        <div>
                            <label for="position" class="block text-sm font-medium text-gray-700">Position</label>
                            <input type="text" name="position" id="position" value="<?= $is_editing ? htmlspecialchars($employee_to_edit['position']) : '' ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                        </div>
                        <div>
                            <label for="hourly_wage" class="block text-sm font-medium text-gray-700">Monthly Salary</label>
                            <input type="number" name="hourly_wage" id="hourly_wage" value="<?= $is_editing ? htmlspecialchars($employee_to_edit['hourly_wage']) : '' ?>" step="0.01" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                        </div>
                        <div>
                            <label for="hire_date" class="block text-sm font-medium text-gray-700">Hire Date</label>
                            <input type="date" name="hire_date" id="hire_date" value="<?= $is_editing ? htmlspecialchars($employee_to_edit['hire_date']) : '' ?>" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm">
                        </div>
                        <div>
                            <button type="submit" class="bg-primary hover:bg-accent text-white font-bold py-2 px-4 rounded-lg transition-colors">
                                <?= $is_editing ? 'Update Employee' : 'Add Employee' ?>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Employee List -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-secondary mb-4">Employee List</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b">
                                    <th class="text-left py-3 px-4 text-gray-600 font-medium">Name</th>
                                    <th class="text-left py-3 px-4 text-gray-600 font-medium">Position</th>
                                    <th class="text-left py-3 px-4 text-gray-600 font-medium">Monthly Salary</th>
                                    <th class="text-left py-3 px-4 text-gray-600 font-medium">Hire Date</th>
                                    <th class="text-left py-3 px-4 text-gray-600 font-medium">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($employees)): ?>
                                    <?php foreach ($employees as $employee): ?>
                                        <tr class="border-b hover:bg-gray-50">
                                            <td class="py-3 px-4"><?= htmlspecialchars($employee['full_name']) ?></td>
                                            <td class="py-3 px-4"><?= htmlspecialchars($employee['position']) ?></td>
                                            <td class="py-3 px-4">$<?= htmlspecialchars(number_format($employee['hourly_wage'], 2)) ?></td>
                                            <td class="py-3 px-4"><?= htmlspecialchars($employee['hire_date']) ?></td>
                                            <td class="py-3 px-4 flex items-center">
                                                <a href="employee_financials.php?action=edit_employee&id=<?= $employee['id'] ?>" class="text-primary hover:text-accent">Edit</a>
                                                <form action="employee_financials.php" method="POST" class="inline ml-4" onsubmit="return confirm('Are you sure you want to delete this employee?');">
                                                    <input type="hidden" name="action" value="delete_employee">
                                                    <input type="hidden" name="employee_id" value="<?= $employee['id'] ?>">
                                                    <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center py-8 text-gray-600">No employees found.</td>
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
