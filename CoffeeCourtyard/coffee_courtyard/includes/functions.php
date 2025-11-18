<?php
/**
 * Helper Functions
 * Coffee CourtYard Website
 *
 * Contains utility functions used throughout the application
 */

/**
 * Sanitize user input
 * @param string $data
 * @return string
 */
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Validate email address
 * @param string $email
 * @return bool
 */
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Format price for display
 * @param float $price
 * @return string
 */
function formatPrice($price) {
    return '$' . number_format($price, 2);
}

/**
 * Check if user is logged in as admin
 * @return bool
 */
function isAdminLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

/**
 * Redirect to a specific URL
 * @param string $url
 */
function redirect($url) {
    header("Location: " . $url);
    exit();
}

/**
 * Display success message
 * @param string $message
 * @return string
 */
function showSuccess($message) {
    return '<div class="alert alert-success">' . htmlspecialchars($message) . '</div>';
}

/**
 * Display error message
 * @param string $message
 * @return string
 */
function showError($message) {
    return '<div class="alert alert-error">' . htmlspecialchars($message) . '</div>';
}

/**
 * Handle file upload
 * @param array $file
 * @param string $targetDir
 * @return array ['success' => bool, 'filename' => string, 'error' => string]
 */
function handleFileUpload($file, $targetDir) {
    $result = ['success' => false, 'filename' => '', 'error' => ''];

    // Check if file was uploaded
    if (!isset($file['tmp_name']) || empty($file['tmp_name'])) {
        $result['error'] = 'No file uploaded';
        return $result;
    }

    // Check for upload errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $result['error'] = 'Upload error: ' . $file['error'];
        return $result;
    }

    // Validate file size (5MB max)
    $maxSize = 5 * 1024 * 1024;
    if ($file['size'] > $maxSize) {
        $result['error'] = 'File size exceeds 5MB limit';
        return $result;
    }

    // Get file extension
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

    // Validate file type
    if (!in_array($fileExtension, $allowedExtensions)) {
        $result['error'] = 'Invalid file type. Only JPG, PNG, GIF, and WebP allowed';
        return $result;
    }

    // Generate unique filename
    $filename = uniqid() . '_' . time() . '.' . $fileExtension;
    $targetPath = $targetDir . $filename;

    // Create directory if it doesn't exist
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        $result['success'] = true;
        $result['filename'] = $filename;
    } else {
        $result['error'] = 'Failed to move uploaded file';
    }

    return $result;
}

/**
 * Delete file from uploads directory
 * @param string $filename
 * @return bool
 */
function deleteUploadedFile($filename) {
    $filepath = UPLOAD_DIR . $filename;
    if (file_exists($filepath)) {
        return unlink($filepath);
    }
    return false;
}

/**
 * Get menu items by category
 * @param Database $db
 * @param string $category
 * @return array
 */
function getMenuItemsByCategory($db, $category = '') {
    if (empty($category)) {
        $query = "SELECT * FROM menu_items ORDER BY category, name";
        $stmt = $db->prepare($query);
    } else {
        $query = "SELECT * FROM menu_items WHERE category = ? ORDER BY name";
        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $category);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_all(MYSQLI_ASSOC);
}

/**
 * Get homepage content by section
 * @param Database $db
 * @param string $section
 * @return array|null
 */
function getHomepageContent($db, $section) {
    $query = "SELECT * FROM homepage_content WHERE section_name = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $section);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

/**
 * Get all homepage content
 * @param Database $db
 * @return array
 */
function getAllHomepageContent($db) {
    $query = "SELECT * FROM homepage_content";
    $result = $db->query($query);
    $content = [];
    while ($row = $result->fetch_assoc()) {
        $content[$row['section_name']] = $row;
    }
    return $content;
}
?>
