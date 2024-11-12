<?php
// Bắt đầu phiên (session)
session_start();
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
// SESSION_TIMEOUT được định nghĩa là 600 giây (10 phút)
const SESSION_TIMEOUT = 600;

//Kiểm tra phiên đăng nhập của nhân viên: Nếu chưa hoặc false thì chuyển đến login
if (!isset($_SESSION['logged']) || !$_SESSION['logged']) {
    header("Location: $base_url/admin/login.php");
    exit;
}
else{
    // Kiểm tra thời gian hết hạn phiên của nhân viên
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > SESSION_TIMEOUT)) {
        // Nếu hết thời gian, chuyển hướng đến trang đăng nhập với thông báo timeout
        session_unset();
        session_destroy();
        header("Location: $base_url/admin/login.php?timeout=true");
        exit;
    }
    // Cập nhật thời gian hoạt động cuối cùng
    $_SESSION['last_activity'] = time();
}
?>