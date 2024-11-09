<?php
session_start();
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
include('../includes/header.html');
include ('../_PartialSideBar.html');
include('../includes/footer.html');

// Kết nối cơ sở dữ liệu
$connect = mysqli_connect("localhost", "root", "", "qlbandienthoai")
OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error());

// Lấy mã nhân viên từ URL
$manv = isset($_GET['manv']) ? $_GET['manv'] : "";

//biến trong truong hợp mã nhân viên bỏ trống hoặc không trùng khớp
$is_found = "";

//biến thông báo nhập liệu
$msg = "";
// Kiểm tra mã nhân viên
if (empty($manv)) {
    $msg = "<h2 class='text-center font-weight-bold text-danger'>Mã nhân viên bị để trống</h2>";
} else {
    // Truy vấn thông tin nhân viên trực tiếp
    $sql = "SELECT nv.*, tk.tenTaiKhoan, tk.tenHienThi
            FROM nhan_vien nv 
            LEFT JOIN tai_khoan tk ON nv.idTaiKhoan = tk.idTaiKhoan 
            WHERE nv.id = '$manv'";
    $result = mysqli_query($connect, $sql);
    $nhanVien = mysqli_fetch_assoc($result);

    if (!$nhanVien) {
        $is_found = "<h2 class='text-center font-weight-bold text-danger'>Không tìm thấy thông tin nhân viên có mã: " . $manv . "</h2>";
    }
}


if (isset($_POST['capNhat']))
{
    $hoTen = $_POST["hoTen"];
    $ngaySinh = $_POST["ngaySinh"];
    $gioiTinh = $_POST["gioiTinh"];
    $diaChi = $_POST["diaChi"];
    $email = $_POST["email"];
    $soDienThoai = $_POST["soDienThoai"];
    //Nếu có hình ảnh mới
    $hinhAnh = $_FILES['hinhAnh']['name'];

    if(empty($hoTen)){
        $msg = "<span class='text-danger font-weight-bold'>Vui lòng nhập họ tên</span>";
    }
    elseif(empty($ngaySinh)){
        $msg = "<span class='text-danger font-weight-bold'>Vui lòng nhập ngày sinh</span>";
    }
    elseif(!isset($gioiTinh)){
        $msg = "<span class='text-danger font-weight-bold'>Vui lòng chọn giới tính</span>";
    }
    elseif(empty($diaChi)){
        $msg = "<span class='text-danger font-weight-bold'>Vui lòng nhập địa chỉ</span>";
    }
    elseif(empty($email)){
        $msg = "<span class='text-danger font-weight-bold'>Vui lòng nhập email</span>";
    }
    elseif(empty($soDienThoai)){
        $msg = "<span class='text-danger font-weight-bold'>Vui lòng nhập số điện thoại</span>";
    }
    elseif (empty($_FILES['hinhAnh'])) {
        $msg = "<span class='text-danger font-weight-bold'>Vui lòng thêm một hình ảnh</span>";
    }
    else{
        // Định dạng ngày sinh
        if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $ngaySinh))
            $msg = "<span class='text-danger font-weight-bold'>Ngày sinh phải đúng định dạng YYYY-MM-DD.</span>";
        // Định dạng số điện thoại
        elseif (!preg_match("/^\d{10,11}$/", $soDienThoai))
            $msg = "<span class='text-danger font-weight-bold'>Số điện thoại phải bao gồm từ 10 đến 11 chữ số.</span>";
        //Kiểm tra hình ảnh mớis
        $file_name = $_FILES['hinhAnh']['name'];
        $file_size = $_FILES['hinhAnh']['size'];
        $file_tmp = $_FILES['hinhAnh']['tmp_name'];
        $array = explode('.', $file_name);
        $file_ext = @strtolower(end($array));
        $expensions = array("jpeg", "jpg", "png");
        if (!in_array($file_ext, $expensions))
            $msg = "<span class='text-danger font-weight-bold'>Đuôi file hình ảnh không hợp lệ. Chỉ chấp nhận cái đuôi file: jpeg, jpg, png</span>";
        elseif ($file_size > 2097152)
            $msg = "<span class='text-danger font-weight-bold'>Hình ảnh không được quá 2MB!</span>";
        else
            move_uploaded_file($file_tmp, $_SERVER['DOCUMENT_ROOT'] . "\\QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2\\Images\\" . $file_name);

        if (empty($msg)) {
            // Cập nhật thông tin nhân viên
            $sql = "UPDATE nhan_vien SET hoTen='$hoTen', ngaySinh='$ngaySinh', gioiTinh='$gioiTinh', soDienThoai='$soDienThoai', diaChi='$diaChi', email='$email', Images='$hinhAnh' WHERE id='$manv'";

            if (mysqli_query($connect, $sql)) {
                $_SESSION['msg'] = "<span class='text-success font-weight-bold'>Cập nhật thông tin nhân viên $hoTen thành công!</span>";
                echo "<script>window.location.href = '$base_url/admin/nhan_vien/index.php';</script>";
            } else {
                $_SESSION['msg'] = "<span class='text-danger font-weight-bold'>Đã xảy ra lỗi khi cập nhật!</span>";
                echo "<script>window.location.href = '$base_url/admin/nhan_vien/index.php';</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa nhân viên</title>
    <link href="<?php echo $base_url?>/Content/datepicker/jquery.datetimepicker.min.css" rel="stylesheet" />
    <script>
        function layAnh(event) {
            // Get the selected file
            const fileInput = document.getElementById('fileInput');
            if (fileInput.files.length > 0) {
                // Extract the file name
                const fileName = fileInput.files[0].name;

                // Display the file name in the hinhAnh input field
                document.getElementById('hinhAnh').value = fileName;
            }
        }
    </script>
</head>
<body>
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="page-title">Chỉnh sửa thông tin nhân viên: <?php if(isset($nhanVien['hoTen'])) echo $nhanVien['hoTen']; else echo 'Không xác định';?></h4>
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
                            <?php if (!empty($is_found)): ?>
                                <?php echo $is_found; ?>
                            <?php else: ?>
                            <form action="" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo $nhanVien['id']; ?>">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2 class="text-center m-3" style="font-weight: bold;">CHỈNH SỬA THÔNG TIN NHÂN VIÊN</h2>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>Họ tên nhân viên <span class="text-danger">*</span></label>
                                            <input type="text" name="hoTen" class="form-control" value="<?php echo isset($_POST['hoTen']) ? $_POST['hoTen'] : $nhanVien['hoTen']; ?>">
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Ngày sinh <span class="text-danger">*</span></label>
                                                    <input type="text" name="ngaySinh" class="form-control picker" placeholder="yyyy/mm/dd" autocomplete="off" value="<?php echo isset($_POST['ngaySinh']) ? $_POST['ngaySinh'] : $nhanVien['ngaySinh']; ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Giới tính <span class="text-danger">*</span></label>
                                                    <select name="gioiTinh" class="custom-select form-control select">
                                                        <option value="1" <?php if(isset($nhanVien['gioiTinh']) && $nhanVien['gioiTinh'] == "1") echo 'selected'; ?>>Nam</option>
                                                        <option value="0" <?php if(isset($nhanVien['gioiTinh']) && $nhanVien['gioiTinh'] == "0") echo 'selected'; ?>>Nữ</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group form-group-default">
                                            <label>Số điện thoại <span class="text-danger">*</span></label>
                                            <input type="text" name="soDienThoai" class="form-control" value="<?php echo isset($_POST['soDienThoai']) ? $_POST['soDienThoai'] : $nhanVien['soDienThoai']; ?>">
                                        </div>
                                        <div class="form-group form-group-default">
                                            <label>Địa chỉ <span class="text-danger">*</span></label>
                                            <input type="text" name="diaChi" class="form-control" value="<?php echo isset($_POST['diaChi']) ? $_POST['diaChi'] : $nhanVien['diaChi']; ?>">
                                        </div>
                                        <div class="form-group form-group-default">
                                            <label>Email <span class="text-danger">*</span></label>
                                            <input type="email" name="email" class="form-control" value="<?php echo isset($_POST['email']) ? $_POST['email'] : $nhanVien['email']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default text-center">
                                            <label>Hình ảnh nhân viên <span class="text-danger">*</span></label><br>
                                            <?php if ($nhanVien['Images']): ?>
                                                <img src='<?php echo $base_url; ?>/Images/<?php echo $nhanVien['Images']; ?>' alt='Hình ảnh đại diện' width="200" class='img-fluid mb-2'>
                                                <div>Tên hình ảnh: <strong><?php echo $nhanVien['Images']; ?></strong></div>
                                            <?php else: ?>
                                                <div>Không có hình ảnh hiện tại.</div>
                                            <?php endif; ?>
                                            <div class="input-group mb-2 mt-2">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-9">
                                                            <input type="text" id="hinhAnh" class="form-control"
                                                                   style="text-align: center;" readonly value="<?php echo isset($_POST['hinhAnh']) ? $_POST['hinhAnh'] : $nhanVien['Images']; ?>"/>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input type="file" name="hinhAnh" id="fileInput" accept="image/*" onchange="layAnh(event)" style="display: none;" value="<?php echo isset($_POST['hinhAnh']) ? $_POST['hinhAnh'] : $nhanVien['Images']; ?>"/>
                                                            <button type="button" class="btn btn-secondary" onclick="document.getElementById('fileInput').click()">Tải ảnh</button>
                                                        </div>
                                                    </div>
                                                </div>
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
            format: "Y-m-d",
            weeks: true
        });
        $.datetimepicker.setLocale('vi');
    });
</script>
