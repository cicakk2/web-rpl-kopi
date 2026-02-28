<?php
// admin/auth_check.php
// Include this file at the top of every admin page to ensure user is logged in

session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: ../admin-login.php');
    exit;
}

// Optional: Check for session timeout (30 minutes of inactivity)
$timeout_duration = 1800; // 30 minutes in seconds

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
    session_unset();
    session_destroy();
    header('Location: ../admin-login.php?timeout=1');
    exit;
}

$_SESSION['last_activity'] = time();

// Include database connection
require_once '../config/db_config.php';
?>
