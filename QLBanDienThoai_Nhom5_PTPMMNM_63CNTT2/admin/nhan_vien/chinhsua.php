<?php
include('../thoihanSession.php');
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
include('../includes/header.html');
include('../menu.html');
include('../includes/footer.html');

// Kết nối cơ sở dữ liệu
$connect = mysqli_connect("localhost", "root", "", "qlbandienthoai")
OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error());

// Lấy mã nhân viên từ URL
$manv = $_GET['manv'] ?? "";

//biến thông báo nhập liệu
$msg = "";

//biến thông báo mã nhân viên bị trống và không tìm thấy nhân viên
$error = "";

// Kiểm tra mã nhân viên
if (empty($manv)) {
    $error = "<h2 class='text-center font-weight-bold text-danger'>Mã nhân viên bị để trống</h2>";
} else {
    // Truy vấn thông tin nhân viên trực tiếp
    $sql = "SELECT nv.*,   CONCAT(nv.hoNV, ' ', nv.tenlot, ' ', nv.tenNV) AS hoTen
            FROM nhan_vien nv
            WHERE nv.id = '$manv'";
    $result = mysqli_query($connect, $sql);
    $nhanVien = mysqli_fetch_assoc($result);

    if (!$nhanVien) {
        $error = "<h2 class='text-center font-weight-bold text-danger'>Không tìm thấy thông tin nhân viên có mã: " . $manv . "</h2>";
    }
}


if (isset($_POST['capNhat']))
{
    $hoNV = $_POST["hoNV"];
    $tenlot = $_POST["tenlot"];
    $tenNV = $_POST["tenNV"];
    $ngaySinh = $_POST["ngaySinh"];
    $gioiTinh = $_POST["gioiTinh"];
    $diaChi = $_POST["diaChi"];
    $email = $_POST["email"];
    $soDienThoai = $_POST["soDienThoai"];
    $phanquyen = $_POST["phanQuyen"];
    //Kiểm tra nhập liệu
    if(empty($hoNV)){
        $msg = "<span class='text-danger font-weight-bold'>Vui lòng nhập họ</span>";
    }
    elseif(empty($tenlot)){
        $msg = "<span class='text-danger font-weight-bold'>Vui lòng nhập tên lót</span>";
    }
    elseif(empty($tenNV)){
        $msg = "<span class='text-danger font-weight-bold'>Vui lòng nhập tên</span>";
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
    elseif (empty($_POST['hinhAnh'])){
        $msg = "<span class='text-danger font-weight-bold'>Vui lòng thêm một hình ảnh</span>";
    }
    //Khi không có ô nhập liệu nào trống thì tiến hành kiểm tra định dạng
    else{
        // Định dạng ngày sinh
        if (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $ngaySinh))
            $msg = "<span class='text-danger font-weight-bold'>Ngày sinh phải đúng định dạng YYYY-MM-DD.</span>";
        // Định dạng số điện thoại
        elseif (!preg_match("/^\d{10,11}$/", $soDienThoai))
            $msg = "<span class='text-danger font-weight-bold'>Số điện thoại phải bao gồm từ 10 đến 11 chữ số.</span>";
        //Kiểm tra hình ảnh
        $dir = $_SERVER['DOCUMENT_ROOT'] . "/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2/Images/";
        $file = $dir . basename($_FILES["fileInput"]["name"]);
        $imageFileType = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        //Hình ảnh cũ
        $hinhAnh = basename($_POST['hinhAnh']);
        //Hình ảnh mới
        if (!empty($_FILES['fileInput']['name'])) {
            // Kiểm tra loại file ảnh
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg")
            $msg = "<span class='text-danger font-weight-bold'>Chỉ chấp nhận các định dạng JPG, JPEG, PNG & GIF.</span>";
            // Kiểm tra kích thước file
            elseif ($_FILES["fileInput"]["size"] > 2097152)
                $msg = "<span class='text-danger font-weight-bold'>Kích thước ảnh quá lớn 2MB.</span>";

            //Nếu không còn báo lỗi gì nữa thì tiến hành đưa ảnh lên server
            if(empty($msg)) {
                // Tải file lên server
                if (move_uploaded_file($_FILES["fileInput"]["tmp_name"], $file)) {
                    $hinhAnh = basename($_FILES["fileInput"]["name"]); // lưu tên file mới
                } else {
                    $msg = "<span class='text-danger font-weight-bold'>Có lỗi xảy ra khi tải ảnh lên.</span>";
                }
            }
        }
        //Nếu không còn báo lỗi gì nữa thì tiến hành cập nhật nhân viên

        if (empty($msg)) {
            // Cập nhật thông tin nhân viên
            $sql = "UPDATE nhan_vien SET hoNV='$hoNV',tenlot = '$tenlot',tenNV = '$tenNV', ngaySinh='$ngaySinh', gioiTinh='$gioiTinh', soDienThoai='$soDienThoai', diaChi='$diaChi', email='$email',phanQuyen ='$phanquyen', Images='$hinhAnh' WHERE id='$manv'";
            if (mysqli_query($connect, $sql)) {
                $_SESSION['msg'] = "<span class='text-success font-weight-bold'>Cập nhật thông tin nhân viên $hoNV thành công!</span>";
                echo "<script>window.location.href = '$base_url/admin/nhan_vien/hienthi.php';</script>";
            } else {
                $msg = "<span class='text-danger font-weight-bold'>Đã xảy ra lỗi khi cập nhật!</span>";
            }
        }
    }
}
// Đóng kết nối sau khi hoàn tất
mysqli_close($connect);
?>
<?php if(isset($_SESSION['phanQuyen']) && $_SESSION['phanQuyen'] == 'ADMIN'):?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Chỉnh sửa nhân viên</title>
        <link href="<?php echo $base_url?>/Content/datepicker/jquery.datetimepicker.min.css" rel="stylesheet" />
        <script>
            function layAnh(event) {
                const fileInput = document.getElementById('fileInput');
                if (fileInput.files.length > 0) {
                    const fileName = fileInput.files[0].name;
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
                                <h4 class="page-title">Chỉnh sửa thông tin nhân viên: <?php echo $nhanVien['hoTen'] ?? 'Không xác định';?></h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <ul class="breadcrumbs">
                                    <li class="nav-home">
                                        <a href="<?php echo $base_url?>/admin/trangchu.php">
                                            <i class="flaticon-home"></i>
                                        </a>
                                    </li>
                                    <li class="separator">
                                        <i class="flaticon-right-arrow"></i>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?php echo $base_url?>/admin/nhan_vien/hienthi.php">Danh sách nhân viên</a>
                                    </li>
                                    <li class="separator">
                                        <i class="flaticon-right-arrow"></i>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#">Chỉnh sửa</a>
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
                                <?php if (!empty($error)): ?>
                                    <?php echo $error; ?>
                                <?php else: ?>
                                <form action="" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?php echo $nhanVien['id']; ?>">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <h2 class="text-center m-3" style="font-weight: bold;">CHỈNH SỬA THÔNG TIN NHÂN VIÊN</h2>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group form-group-default">
                                                        <label>Họ nhân viên <span class="text-danger">*</span></label>
                                                        <input type="text" name="hoNV" class="form-control" value="<?php echo $_POST['hoNV'] ?? $nhanVien['hoNV']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group form-group-default">
                                                        <label>Tên lót nhân viên <span class="text-danger">*</span></label>
                                                        <input type="text" name="tenlot" class="form-control" value="<?php echo $_POST['tenlot'] ?? $nhanVien['tenlot']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group form-group-default">
                                                        <label>Tên nhân viên <span class="text-danger">*</span></label>
                                                        <input type="text" name="tenNV" class="form-control" value="<?php echo $_POST['tenNV'] ?? $nhanVien['tenNV']; ?>">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group form-group-default">
                                                        <label>Ngày sinh <span class="text-danger">*</span></label>
                                                        <input type="text" name="ngaySinh" class="form-control picker" placeholder="yyyy/mm/dd" autocomplete="off" value="<?php echo $_POST['ngaySinh'] ?? $nhanVien['ngaySinh']; ?>"/>
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
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group form-group-default">
                                                        <label>Số điện thoại <span class="text-danger">*</span></label>
                                                        <input type="text" name="soDienThoai" class="form-control" value="<?php echo $_POST['soDienThoai'] ?? $nhanVien['soDienThoai']; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-group-default">
                                                        <label>Email <span class="text-danger">*</span></label>
                                                        <input type="email" name="email" class="form-control" value="<?php echo $_POST['email'] ?? $nhanVien['email']; ?>">
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="form-group form-group-default">
                                                <label>Địa chỉ <span class="text-danger">*</span></label>
                                                <input type="text" name="diaChi" class="form-control" value="<?php echo $_POST['diaChi'] ?? $nhanVien['diaChi']; ?>">
                                            </div>
                                            <div class="form-group form-group-default">
                                                <label>Phân quyền <span class="text-danger">*</span></label>
                                                <select class="form-control" name="phanQuyen">
                                                    <option value="ADMIN" <?php if(isset($nhanVien['phanQuyen']) && $nhanVien['phanQuyen'] == "ADMIN") echo 'selected'; ?>>Admin</option>
                                                    <option value="NV" <?php if(isset($nhanVien['phanQuyen']) && $nhanVien['phanQuyen'] == "NV") echo 'selected'; ?>>Nhân viên</option>
                                                </select>
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
                                                                <input type="text" name="hinhAnh" id="hinhAnh" class="form-control" style="text-align: center;" readonly value="<?php echo $_POST['fileInput'] ?? $nhanVien['Images']; ?>">
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input type="file" name="fileInput" id="fileInput" accept="image/*" onchange="layAnh(event)" style="display: none;"/>
                                                                <button type="button" class="btn btn-secondary" onclick="document.getElementById('fileInput').click()">Chọn ảnh</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group text-center">
                                        <button type="submit" name="capNhat" class="btn btn-primary">Cập nhật</button>
                                        <a href="<?php echo $base_url?>/admin/nhan_vien/hienthi.php" class="btn btn-danger btnBack">Quay lại</a>
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
<?php else: ?>
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card h-100">
                            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                                <?php echo "<h2 class='text-center font-weight-bold text-danger'>Tài khoản của bạn không đủ quyền để truy cập</h2>"?>
                                <img src="<?php echo $base_url?>/Images/norule.jpg" style="max-width: 100%; height: auto;"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

