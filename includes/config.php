<?php
/**
 * Database Configuration File
 * Coffee CourtYard Website
 *
 * This file contains database connection settings
 * Make sure XAMPP is running on port 8080
 */

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'coffee_courtyard_db');
define('DB_PORT', '3306'); // MySQL default port

// Set timezone
date_default_timezone_set('America/Los_Angeles');

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Base URL configuration
define('BASE_URL', 'http://localhost:8080/CoffeeCourtyard');
define('ADMIN_URL', BASE_URL . '/admin');

// Upload directory
define('UPLOAD_DIR', __DIR__ . '/../public/images/uploads/');
define('UPLOAD_URL', BASE_URL . '/public/images/uploads/');

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
