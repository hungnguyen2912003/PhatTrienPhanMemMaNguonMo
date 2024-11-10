<?php
session_start();
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2/admin";
define('SESSION_TIMEOUT', 600);


if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header("Location: login.php");
    exit;
}

// Kiểm tra thời gian session
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > SESSION_TIMEOUT)) {
    //Session hết thời gian thì huỷ bỏ session
    session_unset();
    session_destroy();
    header("Location: login.php?timeout=true");
    exit;
}

// Update last activity time
$_SESSION['last_activity'] = time();
?>