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

// Kiểm tra xem có dữ liệu từ form gửi lên không
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Lấy dữ liệu từ form
    $id = $_POST['id'];
    $hoTen = $_POST['hoTen'];
    $ngaySinh = $_POST['ngaySinh'];
    $gioiTinh = $_POST['gioiTinh'];
    $soDienThoai = $_POST['soDienThoai'];

    // Xử lý hình ảnh
    $imagePath = $_POST['current_image']; // Giữ lại đường dẫn hình ảnh hiện tại
    if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
        // Thêm kiểm tra tên file hình ảnh và định dạng nếu cần
        $uploadDir = '../Images/'; // Thư mục lưu trữ hình ảnh
        $imagePath = $uploadDir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $imagePath);
    }

    // Cập nhật thông tin nhân viên
    $sql = "UPDATE nhan_vien SET hoTen='$hoTen', ngaySinh='$ngaySinh', gioiTinh='$gioiTinh', soDienThoai='$soDienThoai', Images='$imagePath' WHERE id='$id'";

    if (mysqli_query($connect, $sql)) {
        // Chuyển hướng về danh sách nhân viên sau khi cập nhật thành công
        header("Location: $base_url/admin/nhan_vien/index.php");
        exit();
    } else {
        echo "Lỗi: " . mysqli_error($connect);
    }
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
                            <form action="" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <input type="hidden" name="current_image" value="<?php echo $row['Images']; ?>">
                                <div class="form-group">
                                    <label>Họ tên nhân viên</label>
                                    <input type="text" name="hoTen" class="form-control" value="<?php echo $row['hoTen']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Ngày sinh</label>
                                    <input type="date" name="ngaySinh" class="form-control" value="<?php echo $row['ngaySinh']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Giới tính</label>
                                    <select name="gioiTinh" class="form-control" required>
                                        <option value="1" <?php echo $row['gioiTinh'] == 1 ? 'selected' : ''; ?>>Nam</option>
                                        <option value="0" <?php echo $row['gioiTinh'] == 0 ? 'selected' : ''; ?>>Nữ</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Số điện thoại</label>
                                    <input type="text" name="soDienThoai" class="form-control" value="<?php echo $row['soDienThoai']; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Hình ảnh nhân viên</label><br>
                                    <?php if ($row['Images']): ?>
                                        <img src="<?php echo $base_url; ?>/Images/<?php echo $row['Images']; ?>" alt="Hình ảnh đại diện" width="200" class="img-fluid">
                                    <?php endif; ?>
                                    <input type="file" name="image" class="form-control" accept="image/*">
                                </div>
                                <button type="submit" class="btn btn-primary">Cập nhật</button>
                                <a href="<?php echo $base_url?>/admin/nhan_vien/index.php" class="btn btn-secondary">Quay lại</a>
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

        CKEDITOR.replace('txtDetail', {
            customConfig: '/content/ckeditor/config.js',
            extraAllowedContent: 'span',
        });
    });
    function BrowseServer(field) {
        var finder = new CKFinder();
        finder.selectActionFunction = function (fileUrl) {
            document.getElementById(field).value = fileUrl;
        };
        finder.popup();
    }
</script>
