<?php
include '../checkSession.php';
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
include('../includes/header.html');
include('../_PartialSideBar.html');
include('../includes/footer.html');

// Kết nối cơ sở dữ liệu
$connect = mysqli_connect("localhost", "root", "", "qlbandienthoai") OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error());

// Lấy mã nhân viên từ URL
if(isset($_GET['manv'])){
    $manv = $_GET['manv'];
}

// Truy vấn thông tin nhân viên
//LEFT JOIN là để trong trường hợp nhân viên chưa có tài khoản thì chỉ hiển thị các dữ liệu của nhân viên mà thôi, các thông tin tài khoản thì không có nên không lấy.
$sql = "SELECT nv.*, tk.tenTaiKhoan, tk.tenHienThi
        FROM nhan_vien nv 
        LEFT JOIN tai_khoan tk ON nv.idTaiKhoan = tk.idTaiKhoan 
        WHERE nv.id = $manv";
$result = mysqli_query($connect, $sql);
$nhanVien = mysqli_fetch_assoc($result);

if (!$nhanVien) {
    echo "<h4>Không tìm thấy thông tin nhân viên.</h4>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết nhân viên</title>
</head>
<body>
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="page-title">Chi tiết thông tin nhân viên: <?php if(isset($nhanVien['hoTen'])) echo $nhanVien['hoTen']; ?></h4>
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
                                    <a href="<?php echo $base_url?>/admin/nhan_vien/detail.php">Xem chi tiết</a>
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
                            <div id="logins-part" class="content active dstepper-block" role="tabpanel" aria-labelledby="logins-part-trigger">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Mã nhân viên</label>
                                                    <span class="form-control"><?php if(isset($nhanVien['id'])) echo $nhanVien['id']; ?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Họ tên nhân viên</label>
                                                    <span class="form-control"><?php if(isset($nhanVien['hoTen'])) echo $nhanVien['hoTen']; ?></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Ngày sinh</label>
                                                    <span class="form-control"><?php if(isset($nhanVien['ngaySinh'])) echo date("d/m/Y", strtotime($nhanVien['ngaySinh'])); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Giới tính</label>
                                                    <span class="form-control"><?php if(isset($nhanVien['gioiTinh'])) echo ($nhanVien['gioiTinh'] == 1 ? 'Nam' : 'Nữ'); ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group form-group-default">
                                            <label>Địa chỉ</label>
                                            <span class="form-control"><?php if(isset($nhanVien['diaChi'])) echo $nhanVien['diaChi']; ?></span>
                                        </div>
                                        <div class="form-group form-group-default">
                                            <label>Số điện thoại</label>
                                            <span class="form-control"><?php if(isset($nhanVien['soDienThoai'])) echo $nhanVien['soDienThoai']; ?></span>
                                        </div>
                                        <div class="form-group form-group-default">
                                            <label>Email</label>
                                            <span class="form-control"><?php if(isset($nhanVien['email'])) echo $nhanVien['email']; ?></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default text-center">
                                            <label>Hình ảnh đại diện</label><br />
                                            <?php if (!empty($nhanVien['Images'])): ?>
                                                <img src="<?php echo $base_url; ?>/Images/<?php echo $nhanVien['Images']; ?>" alt="Hình ảnh đại diện" width="200" class="img-fluid">
                                            <?php else: ?>
                                                <span class="form-control">Chưa thêm hình ảnh cho nhân viên này</span>
                                            <?php endif; ?>
                                        </div>
                                        <label class="mb-3" style="font-weight: bold;">TÀI KHOẢN</label>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group form-group-default">
                                                    <label>Tên tài khoản</label>
                                                    <span class="form-control"><?php if(isset($nhanVien['tenTaiKhoan'])) echo $nhanVien['tenTaiKhoan']; else echo "<span class='text-warning'>Chưa thiết lập tài khoản</span>"; ?></>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group form-group-default">
                                                    <label>Tên hiển thị tài khoản</label>
                                                    <span class="form-control"><?php if(isset($nhanVien['tenHienThi'])) echo $nhanVien['tenHienThi']; else echo "<span class='text-warning'>Chưa thiết lập tài khoản</span>"; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <a href="<?php echo $base_url?>/admin/nhan_vien/edit.php?manv=<?php echo $nhanVien['id']; ?>" class="btn btn-primary">Vào trang chỉnh sửa</a>
                                <a href="<?php echo $base_url?>/admin/nhan_vien/index.php" class="btn btn-danger btnBack">Quay lại</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
