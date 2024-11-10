<?php
include('../timeOutSession.php');
session_start();
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
include('../includes/header.html');
include ('../_PartialSideBar.html');
include('../includes/footer.html');

// Kết nối cơ sở dữ liệu
$connect = mysqli_connect("localhost", "root", "", "qlbandienthoai")
OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error());

$msg = "";
$maNV = rand(10000000, 99999999);

if (isset($_POST["themMoi"])) {
    $hoTen = $_POST["hoTen"];
    $ngaySinh = $_POST["ngaySinh"];
    $gioiTinh = $_POST["gioiTinh"];
    $diaChi = $_POST["diaChi"];
    $email = $_POST["email"];
    $soDienThoai = $_POST["soDienThoai"];
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
    elseif (empty($_FILES['fileInput'])){
        $msg = "<span class='text-danger font-weight-bold'>Vui lòng thêm một hình ảnh</span>";
    }
    else{
        // Định dạng ngày sinh
        if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $ngaySinh))
            $msg = "<span class='text-danger font-weight-bold'>Ngày sinh phải đúng định dạng YYYY-MM-DD.</span>";
        // Định dạng số điện thoại
        elseif (!preg_match("/^\d{10,11}$/", $soDienThoai))
            $msg = "<span class='text-danger font-weight-bold'>Số điện thoại phải bao gồm từ 10 đến 11 chữ số.</span>";
        //Kiểm tra hình ảnh mới
        if (!empty($_FILES['fileInput']['name'])) {
            $dir = $_SERVER['DOCUMENT_ROOT'] . "/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2/Images/";
            $file = $dir . basename($_FILES["fileInput"]["name"]);
            $imageFileType = strtolower(pathinfo($file, PATHINFO_EXTENSION));

            // Kiểm tra kích thước file
            if ($_FILES["fileInput"]["size"] > 2097152) {
                $msg = "<span class='text-danger font-weight-bold'>Kích thước ảnh quá lớn 2MB.</span>";
            }
            // Kiểm tra loại file ảnh
            elseif ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                $msg = "<span class='text-danger font-weight-bold'>Chỉ chấp nhận các định dạng JPG, JPEG, PNG & GIF.</span>";
            } else {
                // Tải file lên server
                if (move_uploaded_file($_FILES["fileInput"]["tmp_name"], $file)) {
                    $hinhAnh = basename($_FILES["fileInput"]["name"]); // lưu tên file mới
                } else {
                    $msg = "<span class='text-danger font-weight-bold'>Có lỗi xảy ra khi tải ảnh lên.</span>";
                }
            }
        }
        if (empty($msg)) {
            // Kiểm tra mã nhân viên đã tồn tại
            $check_maNV = mysqli_query($connect, "SELECT * FROM nhan_vien WHERE id = '$maNV'");
            if (mysqli_num_rows($check_maNV) != 0) {
                $msg = "<span class='text-danger font-weight-bold'>Đã có mã nhân viên này. Vui lòng thử lại.</span>";
            } else {
                // Thực hiện thêm mới
                $sql = "INSERT INTO nhan_vien (id, hoTen, gioiTinh, ngaySinh, diaChi, soDienThoai, Images, email) VALUES ('$maNV', '$hoTen', '$gioiTinh', '$ngaySinh', '$diaChi', '$soDienThoai', '$hinhAnh', '$email')";
                if (mysqli_query($connect, $sql)) {
                    $_SESSION['msg'] = "<span class='text-success font-weight-bold'>Thêm mới nhân viên $hoTen thành công!</span>";
                    echo "<script>window.location.href = '$base_url/admin/nhan_vien/index.php';</script>";
                } else {
                    $_SESSION['msg'] = "<span class='text-danger font-weight-bold'>Đã xảy ra lỗi khi thêm mới!</span>";
                    echo "<script>window.location.href = '$base_url/admin/nhan_vien/index.php';</script>";
                }
            }
            // Giải phóng kết quả sau khi kiểm tra
            mysqli_free_result($check_maNV);
        }
    }
}
// Đóng kết nối sau khi hoàn tất
mysqli_close($connect);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thêm mới nhân viên</title>
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
                            <h4 class="page-title">Thêm mới nhân viên</h4>
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
                                    <a href="<?php echo $base_url?>/admin/nhan_vien/create.php">Thêm mới</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card h-100" >
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h2 class="text-center m-3" style="font-weight: bold;">THÊM MỚI NHÂN VIÊN</h2>
                                        </div>
                                        <div class="col-md-12 text-center">
                                            <div class="offset-3 col-md-6 offset-3 text-center">
                                                <div class="form-group form-group-default">
                                                    <label>Mã nhân viên <span class="text-danger">*</span></label>
                                                    <input type="text" name="maNV" class="form-control text-center" value="<?php echo $maNV; ?>" readonly/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-group-default">
                                                <label>Họ tên nhân viên <span class="text-danger">*</span></label>
                                                <input type="text" name="hoTen" placeholder="Nhập họ tên nhân viên" class="form-control" value="<?php if(isset($_POST['hoTen'])) echo $hoTen; ?>"/>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group form-group-default">
                                                        <label>Ngày sinh <span class="text-danger">*</span></label>
                                                        <input type="text" name="ngaySinh" class="form-control picker" placeholder="yyyy-mm-dd" autocomplete="off" value="<?php if(isset($_POST['ngaySinh'])) echo $ngaySinh; ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-group-default">
                                                        <label>Giới tính <span class="text-danger">*</span></label>
                                                        <select name="gioiTinh" class="custom-select form-control select">
                                                            <option value="1" <?php if(isset($_POST['gioiTinh']) && $_POST['gioiTinh'] == "1") echo 'selected'; ?>>Nam</option>
                                                            <option value="0" <?php if(isset($_POST['gioiTinh']) && $_POST['gioiTinh'] == "0") echo 'selected'; ?>>Nữ</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-group-default">
                                                <label>Hình ảnh nhân viên <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            <div class="col-md-9">
                                                                <input type="text" name="hinhAnh" id="hinhAnh" class="form-control" style="text-align: center;" readonly value="<?php if (isset($_FILES['hinhAnh'])) echo $_FILES['hinhAnh']['name']; else echo 'Chưa thêm hình ảnh'; ?>"/>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input type="file" name="fileInput" id="fileInput" accept="image/*" onchange="layAnh(event)" style="display: none;"/>
                                                                <button type="button" class="btn btn-secondary" onclick="document.getElementById('fileInput').click()">Chọn ảnh</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group form-group-default">
                                                <label>Địa chỉ <span class="text-danger">*</span></label>
                                                <input type="text" name="diaChi" placeholder="Nhập địa chỉ nhân viên" class="form-control" value="<?php if(isset($_POST['diaChi'])) echo $diaChi; ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-group-default">
                                                <label>Số điện thoại <span class="text-danger">*</span></label>
                                                <input type="text" name="soDienThoai" placeholder="Nhập số điện thoại nhân viên" class="form-control" value="<?php if(isset($_POST['soDienThoai'])) echo $soDienThoai; ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-group-default">
                                                <label>Email <span class="text-danger">*</span></label>
                                                <input type="email" name="email" placeholder="Nhập email nhân viên" class="form-control" value="<?php if(isset($_POST['email'])) echo $email; ?>"/>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group text-center">
                                        <button type="submit" name="themMoi" class="btn btn-success btnCreate">Thêm mới</button>
                                        <a href="<?php echo $base_url?>/admin/nhan_vien/index.php" class="btn btn-danger btnBack">Quay lại</a>
                                    </div>
                                    <div class="form-group text-center">
                                        <?php echo $msg?>
                                    </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- /.content -->
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
