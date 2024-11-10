<?php
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
//Khởi động phiên làm việc
session_start();

//Xóa tất cả các biến phiên hiện có
session_unset();

//Phá hủy hoàn toàn phiên làm việc
session_destroy();

echo "<script>window.location.href = '$base_url/admin/login.php';</script>";
exit;
?>