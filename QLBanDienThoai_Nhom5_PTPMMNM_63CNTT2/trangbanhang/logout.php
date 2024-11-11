<?php
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
//Khởi động phiên làm việc
session_start();

//Xóa tất cả các biến phiên hiện có
session_unset();

//Phá hủy hoàn toàn phiên làm việc
session_destroy();

$_SESSION['logged_kh'] = false;
header("Location:".$base_url."/trangbanhang/index.php");

exit;
?>