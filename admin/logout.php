<?php
/**
 * Admin Logout
 * Coffee CourtYard Website
 */

require_once '../includes/config.php';

// Destroy session
session_destroy();

// Clear session variables
$_SESSION = array();

// Redirect to login page
header("Location: login.php");
exit();
?>
