<?php
include '../checkSession.php';
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";


// Kết nối cơ sở dữ liệu
$connect = mysqli_connect("localhost", "root", "", "qlbandienthoai")
OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error());

// Lấy mã ncc từ URL
$maNCC = $_GET['id'];
$msg = "";

$sql = "DELETE FROM nha_cung_cap WHERE id = '$maNCC'";
$result = mysqli_query($connect, $sql);

if ($result) {
    echo "<script>
            alert('Xoá thành công!');
            window.location.href = '$base_url/admin/nha_cung_cap/index.php';
          </script>";
} else {
    "<script>
            alert('Xoá thất bại: ' . mysqli_error($connect));
            window.location.href = '$base_url/admin/nha_cung_cap/index.php';
    </script>";
}
?>

