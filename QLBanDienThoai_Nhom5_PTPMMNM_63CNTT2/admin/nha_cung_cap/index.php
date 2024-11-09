<?php
// Khai báo đường dẫn
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
// Bao gồm các file giao diện chung như header, sidebar và footer
include('../includes/header.html');
include('../_PartialSideBar.html');
include('../includes/footer.html');

// Kết nối vào cơ sở dữ liệu và hiển thị thông báo lỗi nếu không kết nối được
$connect = mysqli_connect("localhost", "root", "", "qlbandienthoai")
OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error()); // Kết nối vào cơ sở dữ liệu và hiển thị thông báo lỗi nếu không kết nối được

// Truy vấn toàn bộ thông tin từ bảng nha_cung_cap
$sql = "SELECT * FROM nha_cung_cap";

// Gửi truy vấn đến cơ sở dữ liệu, lưu kết quả vào biến $result
$result = mysqli_query($connect, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quản lý nhà cung cấp</title>
    <style>
        .custom-textbox {
            height: 50px;
            border: 2px solid #0094ff;
        }
    </style>
</head>
<body>
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="page-title">Danh mục nhà cung cấp</h4>
                        </div>
                        <div class="col-md-6 text-right">
                            <ul class="breadcrumbs">
                                <li class="nav-home">
                                    <a href="<?php echo $base_url?>/admin/index.php">
                                        <i class="flaticon-home"></i>
                                    </a>
                                </li>
                                <li class="separator">
                                    <i class="flaticon-right-arrow"></i>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo $base_url?>/admin/nha_cung_cap/index.php">Danh mục nhà cung cấp</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card h-100">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card-tools">
                                    <a href="<?php echo $base_url?>/admin/nha_cung_cap/create.php" class="btn btn-rounded btn-primary">Thêm mới</a>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group input-group-sm">
                                    <input type="text" name="Searchtext" class="form-control custom-textbox" placeholder="Nhập thông tin nhà cung cấp bạn muốn tìm kiếm">
                                    <span class="input-group-append">
                                        <button type="submit" class="btn btn-info btn-flat">Tìm kiếm</button>
                                  </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="message-container text-center">
                            <?php
                            if (isset($_SESSION['msg'])) // Kiểm tra xem có thông báo nào trong session không
                            {
                                echo $_SESSION['msg']; // Hiển thị thông báo
                                unset($_SESSION['msg']); // Xóa thông báo khỏi session sau khi hiển thị
                            }
                            ?>
                        </div>
                        <div class="table-responsive">
                            <table id="multi-filter-select" class="display table table-striped table-hover table-bordered">
                                <thead>
                                <tr class="text-center">
                                    <th>STT</th>
                                    <th>Mã nhà cung cấp</th>
                                    <th>Tên nhà cung cấp</th>
                                    <th>Hình ảnh</th>
                                    <th>Số điện thoại</th>
                                    <th>Email</th>
                                    <th>Chức năng</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $stt = 1; // Bắt đầu STT từ 1
                                while($row = mysqli_fetch_assoc($result)) { // Lặp qua các hàng dữ liệu từ kết quả truy vấn
                                    echo "<tr>";
                                    echo "<td class='text-center'>$stt</td>"; // Hiển thị STT
                                    echo "<td class='text-center'>{$row['id']}</td>"; // Hiển thị mã nhà cung cấp
                                    echo "<td class='text-center'>{$row['tenNCC']}</td>"; // Hiển thị tên nhà cung cấp
                                    echo "<td class='text-center'><img width='80' src='$base_url/Images/{$row['Images']}'/></td>"; // Hiển thị hình ảnh nhà cung cấp
                                    echo "<td class='text-center'>{$row['soDienThoai']}</td>"; // Hiển thị số điện thoại nhà cung cấp
                                    echo "<td class='text-center'>{$row['email']}</td>"; // Hiển thị email nhà cung cấp
                                    echo "<td class='text-center'>
                                                <a href='$base_url/admin/nha_cung_cap/detail.php?id={$row['id']}' class='btn btn-xs btn-warning text-white'><i class='fa-solid fa-circle-info'></i></a> <!-- Nút xem chi tiết -->
                                                <a href='$base_url/admin/nha_cung_cap/edit.php?id={$row['id']}' class='btn btn-xs btn-primary'><i class='fa-solid fa-pen-to-square'></i></a> <!-- Nút chỉnh sửa -->
                                                <a href='$base_url/admin/nha_cung_cap/delete.php?id={$row['id']}' class='btn btn-xs btn-danger'><i class='fa-solid fa-trash-can'></i></a> <!-- Nút xóa -->
                                              </td>";
                                    echo "</tr>";
                                    $stt++; // Tăng STT cho dòng tiếp theo
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
