<?php
include '../checkSession.php';
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
include('../includes/header.html');
include ('../_PartialSideBar.html');
include('../includes/footer.html');

$connect = mysqli_connect("localhost", "root", "", "qlbandienthoai")
OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error());

$sql = "SELECT * FROM nhan_vien";
$result = mysqli_query($connect, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quản lý nhân viên</title>
</head>
<body>
<style>
    .custom-textbox {
        height: 50px;
        border: 2px solid #0094ff;
    }
</style>
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <!-- Nội dung header -->
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <!-- Nội dung card-header -->
                    </div>
                    <div class="card-body">
                        <div class="message-container">
                            <!-- Hiển thị dòng thông báo -->
                        </div>
                        <div class="table-responsive">
                            <table id="multi-filter-select" class="display table table-striped table-hover table-bordered tableNhanVien">
                                <thead>
                                <tr class="text-center">
                                    <th><input type="checkbox" id="SelectAll" /></th>
                                    <th>STT</th>
                                    <th>Mã nhân viên</th>
                                    <th>Họ tên nhân viên</th>
                                    <th>Hình ảnh</th>
                                    <th>Ngày sinh</th>
                                    <th>Giới tính</th>
                                    <th>Số điện thoại</th>
                                    <th>Chức năng</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $stt = 1;
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td class='text-center'><input type='checkbox' /></td>";
                                    echo "<td class='text-center'>$stt</td>";
                                    echo "<td class='text-center'>{$row['id']}</td>";
                                    echo "<td class='text-center'>{$row['hoTen']}</td>";
                                    echo "<td class='text-center'><img width='80' src='$base_url/Images/{$row['Images']}'/></td>";
                                    echo "<td class='text-center'>" . date("d/m/Y", strtotime($row['ngaySinh'])) . "</td>";
                                    echo "<td class='text-center'>" . ($row['gioiTinh'] == 1 ? 'Nam' : 'Nữ') . "</td>";
                                    echo "<td class='text-center'>{$row['soDienThoai']}</td>";
                                    echo "<td class='text-center'>
                                                <a href='$base_url/admin/nhanvien/detail?manv={$row['id']}' class='btn btn-xs btn-warning text-white'><i class='fa-solid fa-circle-info'></i></a>
                                                <a href='$base_url/admin/nhanvien/edit?manv={$row['id']}' class='btn btn-xs btn-primary'><i class='fa-solid fa-pen-to-square'></i></a>
                                                <a href='$base_url/admin/nhanvien/delete?manv={$row['id']}' class='btn btn-xs btn-danger'><i class='fa-solid fa-trash-can'></i></a>
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
