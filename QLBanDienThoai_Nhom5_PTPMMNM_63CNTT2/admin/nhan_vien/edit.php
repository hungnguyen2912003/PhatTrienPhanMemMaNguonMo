<?php
ob_start(); // Bắt đầu bộ đệm đầu ra
include '../checkSession.php';
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
include('../includes/header.html');
include ('../_PartialSideBar.html');
include('../includes/footer.html');

// Kết nối cơ sở dữ liệu
$connect = mysqli_connect("localhost", "root", "", "qlbandienthoai")
OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error());

// Lấy mã nhân viên từ URL
$manv = $_GET['manv'];

$msg = "";
if (isset($_POST['capNhat']))
{
    $id = $_POST['id'];
    $hoTen = $_POST['hoTen'];
    $ngaySinh = $_POST['ngaySinh'];
    $gioiTinh = $_POST['gioiTinh'];
    $soDienThoai = $_POST['soDienThoai'];
    $diaChi = $_POST['diaChi'];
    $email = $_POST['email'];
    $hinhAnh = $_POST['hinhAnh'];

    if (!empty($hoTen) && !empty($ngaySinh) && isset($gioiTinh) && !empty($diaChi) && !empty($email) && !empty($soDienThoai) && !empty($hinhAnh)) {
        // Định dạng ngày sinh
        if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $ngaySinh)) {
            $msg = "<span class='text-danger font-weight-bold'>Ngày sinh phải đúng định dạng YYYY-MM-DD.</span>";
            // Định dạng số điện thoại
        } elseif (!preg_match("/^\d{10,11}$/", $soDienThoai)) {
            $msg = "<span class='text-danger font-weight-bold'>Số điện thoại phải bao gồm từ 10 đến 11 chữ số.</span>";
            // Hợp lệ nhập liệu: Tiến hành chỉnh sửa
        } else {
            // Cập nhật thông tin nhân viên
            $sql = "UPDATE nhan_vien SET hoTen='$hoTen', ngaySinh='$ngaySinh', gioiTinh='$gioiTinh', soDienThoai='$soDienThoai', diaChi='$diaChi', email='$email', Images='$hinhAnh' WHERE id='$id'";

            if (mysqli_query($connect, $sql)) {
                $msg = "<span class='text-success font-weight-bold'>Cập nhật thông tin nhân viên $hoTen thành công!</span>";
            } else {
                $msg = "<span class='text-danger font-weight-bold'>Đã xảy ra lỗi khi thêm mới!</span>";
            }
        }
    }
    else
        $msg = "<span class='text-danger font-weight-bold'>Các trường bắt buộc không được để trống. Vui lòng nhập đầy đủ thông tin!</span>";
}

// Truy vấn thông tin nhân viên theo mã
$sql = "SELECT * FROM nhan_vien WHERE id = $manv";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa nhân viên</title>
</head>
<body>
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="page-title">Chỉnh sửa thông tin nhân viên: <?php echo $row['hoTen']; ?></h4>
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
                                    <a href="<?php echo $base_url?>/admin/nhan_vien/edit.php">Chỉnh sửa</a>
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
                            <form action="" method="POST">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>Họ tên nhân viên</label>
                                            <input type="text" name="hoTen" class="form-control" value="<?php echo $row['hoTen']; ?>" required>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Ngày sinh</label>
                                                    <input type="date" name="ngaySinh" class="form-control" value="<?php echo $row['ngaySinh']; ?>" required>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Giới tính</label>
                                                    <div class="d-flex align-items-center ml-2">
                                                        <div class="form-check mr-3">
                                                            <input type="radio" name="gioiTinh" value="1" class="form-check-input"
                                                                <?php if($row['gioiTinh'] == 1) echo 'checked'; ?>>
                                                            <label class="form-check-label" style="margin-top: -20px">Nam</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="radio" name="gioiTinh" value="0" class="form-check-input"
                                                                <?php if($row['gioiTinh'] == 0) echo 'checked'; ?>>
                                                            <label class="form-check-label" style="margin-top: -20px">Nữ</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group form-group-default">
                                            <label>Số điện thoại</label>
                                            <input type="text" name="soDienThoai" class="form-control" value="<?php echo $row['soDienThoai']; ?>" required>
                                        </div>
                                        <div class="form-group form-group-default">
                                            <label>Địa chỉ</label>
                                            <input type="text" name="diaChi" class="form-control" value="<?php echo $row['diaChi']; ?>" required>
                                        </div>
                                        <div class="form-group form-group-default">
                                            <label>Email</label>
                                            <input type="email" name="email" class="form-control" value="<?php echo $row['email']; ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group text-center">
                                            <label>Hình ảnh nhân viên</label><br>
                                            <?php if ($row['Images']): ?>
                                                <img src='<?php echo $base_url; ?>/Images/<?php echo $row['Images']; ?>' alt='Hình ảnh đại diện' width="200" class='img-fluid mb-2'>
                                                <div>Tên hình ảnh: <strong><?php echo $row['Images']; ?></strong></div>
                                            <?php else: ?>
                                                <div>Không có hình ảnh hiện tại.</div>
                                            <?php endif; ?>
                                            <div class="input-group">
                                                <input type="file" class="form-control-file p-1" name="hinhAnh" value="<?php echo $hinhAnh; ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <button type="submit" name="capNhat" class="btn btn-primary">Cập nhật</button>
                                    <a href="<?php echo $base_url?>/admin/nhan_vien/index.php" class="btn btn-danger btnBack">Quay lại</a>
                                </div>
                                <div class="form-group text-center">
                                    <?php echo $msg?>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

<script src="<?php echo $base_url?>/Content/datepicker/jquery.datetimepicker.full.js"></script>
<script>
    $(function () {
        $('.select').select2();
    });
</script>

<script>
    $(document).ready(function () {
        $('.picker').datetimepicker({
            autoclose: true,
            timepicker: false,
            datepicker: true,
            format: "d/m/Y",
            weeks: true
        });
        $.datetimepicker.setLocale('vi');
    });
</script>
