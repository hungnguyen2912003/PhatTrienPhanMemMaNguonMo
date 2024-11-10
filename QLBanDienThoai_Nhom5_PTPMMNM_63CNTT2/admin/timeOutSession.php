<?php
session_start();
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2/admin";
define('SESSION_TIMEOUT', 600);
if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI']; // Save intended page
    header("Location: $base_url/login.php"); // Redirect to login
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