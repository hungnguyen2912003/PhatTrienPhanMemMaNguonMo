<?php
//Khởi động phiên làm việc
session_start();

//Xóa tất cả các biến phiên hiện có
session_unset();

//Phá hủy hoàn toàn phiên làm việc
session_destroy();

//Chuyển hướng người dùng về trang login.php. Hàm header() gửi một tiêu đề HTTP để trình duyệt thực hiện chuyển hướng
header("Location: login.php");
exit;
?>