<?php
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
//Khởi động phiên làm việc
session_start();

//Xóa các phiên làm việc của nhân viên
unset($_SESSION['hoTen']);
unset($_SESSION['phanQuyen']);
unset($_SESSION['id']);
unset($_SESSION['logged']);
unset($_SESSION['last_activity']);
unset($_SESSION['welcome_shown2']);
header("Location:".$base_url."/admin/dangnhap.php");
exit;
?>