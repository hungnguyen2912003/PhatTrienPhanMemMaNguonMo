<?php
include '../checkSession.php';
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
include('../includes/header.html');
include ('../_PartialSideBar.html');
include('../includes/footer.html');

//Kết nối cơ sở dữ liệu
$connect = mysqli_connect("localhost", "root", "", "qlbandienthoai")
OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error());

$msg = "";
$hoTen = "";
$ngaySinh = "";
$gioiTinh = "";
$hinhAnh = "";
$diaChi = "";
$email = "";
$soDienThoai = "";

if (isset($_POST["themMoi"])) {
    $hoTen = $_POST["hoTen"];
    $ngaySinh = $_POST["ngaySinh"];
    $gioiTinh = $_POST["gioiTinh"];
    $diaChi = $_POST["diaChi"];
    $email = $_POST["email"];
    $soDienThoai = $_POST["soDienThoai"];
    $hinhAnh = $_POST['hinhAnh'];

    // Check required fields
    if (!empty($hoTen) && !empty($ngaySinh) && !empty($gioiTinh) && !empty($diaChi) && !empty($email) && !empty($soDienThoai) && !empty($hinhAnh)) {
        // Validate date and phone format
        if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $ngaySinh)) {
            $msg = "<span class='text-danger font-weight-bold'>Ngày sinh phải đúng định dạng YYYY-MM-DD.</span>";
        } elseif (!preg_match("/^\d{10}$/", $soDienThoai)) {
            $msg = "<span class='text-danger font-weight-bold'>Số điện thoại phải bao gồm 10 chữ số.</span>";
        } else {
            $maNV = rand(10000000, 99999999);
            $sql = "INSERT INTO nhan_vien (id, hoTen, gioiTinh, ngaySinh, diaChi, soDienThoai, Images, email) VALUES ('$maNV', '$hoTen', '$gioiTinh', '$ngaySinh', '$diaChi', '$soDienThoai', '$hinhAnh', '$email')";
            if (mysqli_query($connect, $sql)) {
                $msg = "<span class='text-success font-weight-bold'>Thêm mới nhân viên $hoTen thành công!</span>";
            } else {
                $msg = "<span class='text-danger font-weight-bold'>Đã xảy ra lỗi khi thêm mới!</span>";
            }
        }
    } else {
        $msg = "<span class='text-danger font-weight-bold'>Các trường bắt buộc không được để trống. Vui lòng nhập đầy đủ thông tin!</span>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thêm mới nhân viên</title>
    <link href="<?php echo $base_url?>/Content/datepicker/jquery.datetimepicker.min.css" rel="stylesheet" />
    <script>
        function chonHinhanh(event) {
            // Lấy file đã chọn
            const fileInput = document.getElementById('fileInput');
            const filePath = fileInput.value.split('\\').pop(); // Lấy tên file từ đường dẫn

            // Hiển thị tên file trong ô input hinhAnh
            document.getElementById('hinhAnh').value = filePath;
        }
    </script>
</head>
<body>
<div class="main-panel">
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
                            <div id="logins-part" class="content active dstepper-block" role="tabpanel" aria-labelledby="logins-part-trigger">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2 class="text-center m-3" style="font-weight: bold;">THÔNG TIN NHÂN VIÊN</h2>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>Họ tên nhân viên <span class="text-danger">*</span></label>
                                            <input type="text" name="hoTen" placeholder="Nhập họ tên nhân viên" class="form-control" value="<?php echo $hoTen; ?>"/>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Ngày sinh <span class="text-danger">*</span></label>
                                                    <input type="text" name="ngaySinh" class="form-control picker" placeholder="Nhập ngày sinh nhân viên" autocomplete="off" value="<?php echo $ngaySinh; ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Giới tính <span class="text-danger">*</span></label>
                                                    <div class="d-flex align-items-center ml-2">
                                                        <div class="form-check mr-3">
                                                            <input type="radio" name="gioiTinh" value="1" class="form-check-input" <?php if(isset($_POST['gioiTinh'])&&($_POST['gioiTinh'])=="1") echo 'checked="checked"'?>>
                                                            <label style="margin-top: -20px" class="form-check-label">Nam</label>
                                                        </div>
                                                        <div class="form-check" >
                                                            <input  type="radio" name="gioiTinh" value="0" class="form-check-input" <?php if(isset($_POST['gioiTinh'])&&($_POST['gioiTinh'])=="0") echo 'checked="checked"'?>>
                                                            <label  style="margin-top: -20px" class="form-check-label" >Nữ</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>Hình ảnh nhân viên <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="text" id="hinhAnh" name="hinhAnh" readonly style="width: 80%;" />
                                                <input type="file" id="fileInput" style="display:none;" onchange="chonHinhanh(event)" />
                                                <button style="width: 80px;" type="button" onclick="document.getElementById('fileInput').click()">Tải ảnh</button>
                                            </div>
                                        </div>
                                        <div class="form-group form-group-default">
                                            <label>Địa chỉ <span class="text-danger">*</span></label>
                                            <input type="text" name="diaChi" placeholder="Nhập địa chỉ nhân viên" class="form-control" value="<?php echo $diaChi; ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>Số điện thoại <span class="text-danger">*</span></label>
                                            <input type="text" name="soDienThoai" placeholder="Nhập số điện thoại nhân viên" class="form-control" value="<?php echo $soDienThoai; ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>Email <span class="text-danger">*</span></label>
                                            <input type="email" name="email" placeholder="Nhập email nhân viên" class="form-control" value="<?php echo $email; ?>"/>
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
                        </div>
                    </form>
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
