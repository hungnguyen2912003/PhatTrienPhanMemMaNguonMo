<?php
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
//Khởi động phiên làm việc
session_start();

//Xóa các phiên của khách hàng
unset($_SESSION['logged_kh']);
unset($_SESSION['hoTenKH']);
unset($_SESSION['hoTenNV']);
unset($_SESSION['last_activity_kh']);
unset($_SESSION['welcome_shown']);
header("Location:".$base_url."/trangbanhang/trangchu.php");

exit;
?>