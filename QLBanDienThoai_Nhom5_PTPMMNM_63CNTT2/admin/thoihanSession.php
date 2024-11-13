<?php
// Bắt đầu phiên (session)
session_start();
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
// Set thời gian hết hạn của Session
const SESSION_TIMEOUT = 900;

//Đặt biến báo hiệu hết thời gian session
$hetHanPhien = false;

// Kiểm tra phiên đăng nhập: Nếu chưa hoặc false thì chuyển đến login
if (!isset($_SESSION['logged']) || !$_SESSION['logged']) {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    unset($_SESSION['last_activity']);
    header("Location: $base_url/admin/dangnhap.php");
    exit;
}

// Kiểm tra thời gian hết hạn phiên
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > SESSION_TIMEOUT)) {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    $hetHanPhien = true; // Đặt cờ báo hiệu hết hạn
} else {
    // Cập nhật thời gian hoạt động nếu chưa hết hạn
    $_SESSION['last_activity'] = time();
}

// Xử lý gia hạn phiên khi người dùng chọn "Tiếp tục"
if (isset($_POST['continues'])) {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    $_SESSION['last_activity'] = time(); // Cập nhật lại thời gian hoạt động
    $hetHanPhien = false; // Reset cờ hết hạn
}

// Xử lý xóa phiên khi người dùng chọn "Không"
if (isset($_POST['cancel'])) {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    //Xóa các session liên quan đến nhân viên
    unset($_SESSION['hoTen']);
    unset($_SESSION['phanQuyen']);
    unset($_SESSION['id']);
    unset($_SESSION['logged']);
    unset($_SESSION['last_activity']);
    unset($_SESSION['welcome_shown2']);
    header("Location: $base_url/admin/dangnhap.php?timeout=true");
    exit();
}

include ('modal_hetHanPhien.php');
?>
