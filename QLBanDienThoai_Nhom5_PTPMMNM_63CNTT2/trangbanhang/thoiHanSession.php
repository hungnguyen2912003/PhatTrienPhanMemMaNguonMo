<?php
session_start();
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
const SESSION_TIMEOUT = 1800;

$session_expired = false;

// Kiểm tra thời gian hết hạn phiên
if (isset($_SESSION['last_activity_kh']) && (time() - $_SESSION['last_activity_kh'] > SESSION_TIMEOUT)) {
    $session_expired = true; // Đặt cờ báo hiệu hết hạn
} else {
    // Cập nhật thời gian hoạt động nếu chưa hết hạn
    $_SESSION['last_activity_kh'] = time();
}

// Xử lý gia hạn phiên khi người dùng chọn "Tiếp tục"
if (isset($_POST['continues'])) {
    $_SESSION['last_activity_kh'] = time(); // Cập nhật lại thời gian hoạt động
    $session_expired = false; // Reset cờ hết hạn
}

// Xử lý xóa phiên khi người dùng chọn "Không"
if (isset($_POST['cancel'])) {
    unset($_SESSION['logged_kh']);
    unset($_SESSION['hoTenKH']);
    unset($_SESSION['hoTenNV']);
    unset($_SESSION['last_activity_kh']);
    unset($_SESSION['welcome_shown']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

include ('modal_hetHanPhien.php');
?>



