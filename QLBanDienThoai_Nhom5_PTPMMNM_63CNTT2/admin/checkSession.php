<?php
session_start();
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2/admin";
define('SESSION_TIMEOUT', 600);

// Check if the user is logged in
if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
    header("Location: $base_url/login.php");
    exit;
}

// Check if the session has timed out
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > SESSION_TIMEOUT)) {
    // Session has expired, destroy it and redirect to login
    session_unset();
    session_destroy();
    header("Location: $base_url/login.php?timeout=true");
    exit;
}

// Update last activity time
$_SESSION['last_activity'] = time();
?>