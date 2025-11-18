<?php
/**
 * Authentication Check for Admin Pages
 * Include this file at the top of all admin pages
 */

require_once '../includes/config.php';
require_once '../includes/functions.php';

// Check if user is logged in
if (!isAdminLoggedIn()) {
    redirect('login.php');
    exit();
}
?>
