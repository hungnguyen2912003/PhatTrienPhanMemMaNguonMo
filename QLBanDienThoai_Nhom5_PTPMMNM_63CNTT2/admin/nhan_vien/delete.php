<?php
include('../../timeOutSession.php');
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
include('../includes/header.html');
include('../_PartialSideBar.html');
include('../includes/footer.html');

// Kết nối cơ sở dữ liệu
$connect = mysqli_connect("localhost", "root", "", "qlbandienthoai")
OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error());

// Lấy mã nhân viên từ URL
$manv = isset($_GET['manv']) ? $_GET['manv'] : "";

//Biến thông báo
$msg = "";

// Kiểm tra mã nhân viên
if (empty($manv)) {
    $msg = "<h2 class='text-center font-weight-bold text-danger'>Mã nhân viên bị để trống</h2>";
} else {
    // Truy vấn thông tin nhân viên trực tiếp
    $sql = "SELECT nv.*, tk.tenTaiKhoan, tk.tenHienThi
            FROM nhan_vien nv 
             LEFT JOIN tai_khoan tk ON nv.id = tk.maNV_KH 
            WHERE nv.id = '$manv'";
    $result = mysqli_query($connect, $sql);
    $nhanVien = mysqli_fetch_assoc($result);

    if (!$nhanVien) {
        $msg = "<h2 class='text-center font-weight-bold text-danger'>Không tìm thấy thông tin nhân viên có mã: " . $manv . "</h2>";
    }
}

if(isset($_POST['deleteBtn'])){
    // Xóa nhân viên theo mã nhân viên
    $sqlDelete = "DELETE FROM nhan_vien WHERE id = '$manv'";

    if (mysqli_query($connect, $sqlDelete)) {
        // Lưu thông báo thành công vào session
        $_SESSION['msg'] = "<span class='text-success font-weight-bold'>Xoá thành công nhân viên có mã $manv</span>";
        echo "<script>window.location.href = '$base_url/admin/nhan_vien/index.php';</script>";
    } else {
        $_SESSION['msg'] = "<span class='text-danger font-weight-bold'>Đã xảy ra lỗi khi xoá!</span>";
    }
}

?>
<?php if(isset($_SESSION['phanQuyen']) && $_SESSION['phanQuyen'] == 'ADMIN'):?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Xoá thông tin nhân viên</title>
    </head>
    <body>
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="page-header">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="page-title">Xoá thông tin nhân viên: <?php if(isset($nhanVien['tenNV'])) echo $nhanVien['tenNV']; else echo 'Không xác định';?></h4>
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
                                        <a href="<?php echo $base_url?>/admin/nhan_vien/index.php">Danh sách nhân viên</a>
                                    </li>
                                    <li class="separator">
                                        <i class="flaticon-right-arrow"></i>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo $base_url?>/admin/nhan_vien/delete.php">Xoá nhân viên</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card h-100">
                            <div class="card-body">
                                <?php if (!empty($msg)): ?>
                                    <?php echo $msg; ?>
                                <?php else: ?>
                                <form action="" method="POST">
                                    <div class="row">
                                            <div class="col-md-12">
                                                <label class="mb-3" style="font-weight: bold;">THÔNG TIN CHUNG</label>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Mã nhân viên</label>
                                                    <span class="form-control"><?php if(isset($nhanVien['id'])) echo $nhanVien['id']; ?></span>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group form-group-default">
                                                            <label>Họ nhân viên</label>
                                                            <span class="form-control"><?php if(isset($nhanVien['hoNV'])) echo $nhanVien['hoNV']; ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group form-group-default">
                                                            <label>Tên nhân viên</label>
                                                            <span class="form-control"><?php if(isset($nhanVien['tenNV'])) echo $nhanVien['tenNV']; ?></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group form-group-default">
                                                    <label>Ngày sinh</label>
                                                    <span class="form-control"><?php if(isset($nhanVien['ngaySinh'])) echo date("d/m/Y", strtotime($nhanVien['ngaySinh'])); ?></span>
                                                </div>
                                                <div class="form-group form-group-default">
                                                    <label>Giới tính</label>
                                                    <span class="form-control"><?php echo ($nhanVien['gioiTinh'] == 1 ? 'Nam' : 'Nữ'); ?></span>
                                                </div>
                                                <div class="form-group form-group-default">
                                                    <label>Địa chỉ</label>
                                                    <span class="form-control"><?php if(isset($nhanVien['diaChi'])) echo $nhanVien['diaChi']; ?></span>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group form-group-default">
                                                            <label>Số điện thoại</label>
                                                            <span class="form-control"><?php if(isset($nhanVien['soDienThoai'])) echo $nhanVien['soDienThoai']; ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group form-group-default">
                                                            <label>Email</label>
                                                            <span class="form-control"><?php if(isset($nhanVien['email'])) echo $nhanVien['email']; ?></span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default text-center">
                                                    <label>Hình ảnh đại diện</label>
                                                    <?php if (!empty($nhanVien['Images'])): ?>
                                                        <img src="<?php echo $base_url; ?>/Images/<?php echo $nhanVien['Images']; ?>" alt="Hình ảnh đại diện" width="250" class="img-fluid p-2">
                                                        <div class="mt-1">Tên hình ảnh: <strong><?php echo $nhanVien['Images']; ?></strong></div>
                                                    <?php else: ?>
                                                        <span class="form-control">Chưa thêm hình ảnh cho nhân viên này</span>
                                                    <?php endif; ?>
                                                </div>

                                                <label class="mb-3" style="font-weight: bold;">TÀI KHOẢN</label>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group form-group-default">
                                                            <label>Tên tài khoản</label>
                                                            <span class="form-control text-warning"><?php echo $nhanVien['tenTaiKhoan'] ?? 'Chưa thiết lập tài khoản'; ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group form-group-default">
                                                            <label>Tên hiển thị tài khoản</label>
                                                            <span class="form-control text-warning"><?php echo $nhanVien['tenHienThi'] ?? 'Chưa thiết lập tài khoản'; ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <div class="form-group text-center">
                                        <button type="submit" name="deleteBtn" class="btn btn-info">Xoá</button>
                                        <a href="<?php echo $base_url?>/admin/nhan_vien/index.php" class="btn btn-danger btnBack">Quay lại</a>
                                    </div>
                                    <div class="form-group text-center">
                                        <?php echo $msg?>
                                    </div>
                                </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </body>
    </html>
<?php endif; ?>