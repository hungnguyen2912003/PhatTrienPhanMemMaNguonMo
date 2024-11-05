<?php
include '../checkSession.php';
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";


// Kết nối cơ sở dữ liệu
$connect = mysqli_connect("localhost", "root", "", "qlbandienthoai")
OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error());

// Lấy mã nhân viên từ URL
if(isset($_GET['manv'])){
    $manv = $_GET['manv'];
}

$sql = "DELETE FROM nhan_vien WHERE id = '$manv'";
$result = mysqli_query($connect, $sql);

if ($result) {
    echo "<script>
            alert('Xoá thành công!');
            window.location.href = '$base_url/admin/nhan_vien/index.php';
          </script>";
} else {
    "<script>
            alert('Xoá thất bại: ' . mysqli_error($connect));
            window.location.href = '$base_url/admin/nhan_vien/index.php';
    </script>";
}
?>
dfgfdgdfg
