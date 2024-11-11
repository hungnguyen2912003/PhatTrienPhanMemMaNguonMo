<?php
// Khai báo đường dẫn
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
include('../../timeOutSession.php');
include('../includes/header.html');
include('../_PartialSideBar.html');
include('../includes/footer.html');

// Kết nối vào cơ sở dữ liệu
$connect = mysqli_connect("localhost", "root", "", "qlbandienthoai")
OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error());

$sql = "SELECT user.id AS ID, user.username AS tenTaiKhoan, user.user_id AS maNV, user.phanQuyen AS phanQuyen, CONCAT(nv.hoNV, ' ', nv.tenlot, ' ', nv.tenNV) AS hoTen FROM user JOIN nhan_vien nv ON user.user_id = nv.id";

// Gửi truy vấn đến cơ sở dữ liệu
$result = mysqli_query($connect, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quản lý phân quyền</title>
</head>
<body>
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="page-title">Danh mục phân quyền</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="multi-filter-select" class="display table table-striped table-hover table-bordered">
                                <thead>
                                <tr class="text-center">
                                    <th>STT</th>
                                    <th>Tên đăng nhập</th>
                                    <th>Mã nhân viên</th>
                                    <th>Họ tên nhân viên</th>
                                    <th>Phân quyền</th>
                                    <th>Chức năng</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $stt = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td class='text-center'>$stt</td>";
                                    echo "<td class='text-center'>{$row['tenTaiKhoan']}</td>";
                                    echo "<td class='text-center'>{$row['maNV']}</td>";
                                    echo "<td class='text-center'>{$row['hoTen']}</td>";
                                    // Kiểm tra phân quyền và hiển thị tương ứng
                                    $phanQuyen = $row['phanQuyen'];
                                    if ($phanQuyen == 'ADMIN') {
                                        $phanQuyenShow = 'Admin';
                                    } elseif ($phanQuyen == 'NV') {
                                        $phanQuyenShow = 'Nhân viên';
                                    } else {
                                        $phanQuyenShow = 'Chưa thiết lập';
                                    }
                                    echo "<td class='text-center'>$phanQuyenShow</td>";
                                    echo "<td class='text-center'>
                                            <a href='$base_url/admin/phan_quyen/detail.php?id={$row['ID']}' class='btn btn-xs btn-warning text-white'><i class='fa-solid fa-circle-info'></i></a>
                                            <a href='$base_url/admin/phan_quyen/edit.php?id={$row['ID']}' class='btn btn-xs btn-primary'><i class='fa-solid fa-pen-to-square'></i></a>
                                            <a href='$base_url/admin/phan_quyen/delete.php?id={$row['ID']}' class='btn btn-xs btn-danger'><i class='fa-solid fa-trash-can'></i></a>
                                        </td>";
                                    echo "</tr>";
                                    $stt++;
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<script>
    $(document).ready(function () {
        function hideMessage() {
            $('.message-container').fadeOut(); // Ẩn thông báo sau khi hiển thị một thời gian
        }
        if ($('.message-container').length) { // Nếu có thông báo
            setTimeout(hideMessage, 5000); // Đặt thời gian ẩn thông báo sau 5 giây
        }
    });
</script>
