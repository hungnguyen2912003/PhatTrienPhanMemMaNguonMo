<?php
include '../checkSession.php';
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";

// Kết nối cơ sở dữ liệu
$connect = mysqli_connect("localhost", "root", "", "qlbandienthoai")
OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error());

// Lấy mã sản phẩm từ URL
$masp = $_GET['ma_sp'];
$msg = "";

// Sử dụng ma_sp thay vì id
$sql = "DELETE FROM san_pham WHERE ma_sp = '$masp'";
$result = mysqli_query($connect, $sql);

if ($result) {
    echo "<script>
            alert('Xoá thành công!');
            window.location.href = '$base_url/admin/san_pham/index.php';
          </script>";
} else {
    echo "<script>
            alert('Xoá thất bại: " . mysqli_error($connect) . "');
            window.location.href = '$base_url/admin/san_pham/index.php';
          </script>";
}

// Đóng kết nối
mysqli_close($connect);
?>