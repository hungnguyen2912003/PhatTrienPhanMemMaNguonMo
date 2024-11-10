<?php
// Bắt đầu phiên (session)
session_start();
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
// SESSION_TIMEOUT được định nghĩa là 600 giây (10 phút)
const SESSION_TIMEOUT = 600;

//////////////////////////////////////////////////////////////////
// Kiểm tra đăng nhập
// Kiểm tra xem biến phiên $_SESSION['logged'] đã tồn tại và có giá trị true hay chưa
if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
    header("Location: $base_url/admin/login.php");
    exit;
}
/////////////////////////////////////////////////////////////////
// Kiểm tra thời gian hết hạn phiên
// $_SESSION['last_activity'] chứa thời gian hoạt động cuối cùng của người dùng
// Nếu time() - $_SESSION['last_activity'] lớn hơn SESSION_TIMEOUT (10 phút), nghĩa là người dùng đã không hoạt động trong khoảng thời gian này.
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > SESSION_TIMEOUT)) {
    // Nếu hết thời gian, chuyển hướng đến trang đăng nhập với thông báo timeout
    session_unset();
    session_destroy();
    $_SESSION['redirect_to'] = $_SERVER['REQUEST_URI'];
    header("Location: $base_url/admin/login.php?timeout=true");
    exit;
}
// Cập nhật thời gian hoạt động cuối cùng
$_SESSION['last_activity'] = time();
?>
