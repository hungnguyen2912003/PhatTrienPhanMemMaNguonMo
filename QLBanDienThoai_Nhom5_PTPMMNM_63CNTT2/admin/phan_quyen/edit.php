<?php
include('../timeOutSession.php');
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
include('../includes/header.html');
include('../_PartialSideBar.html');
include('../includes/footer.html');

// Kết nối cơ sở dữ liệu
$connect = mysqli_connect("localhost", "root", "", "qlbandienthoai")
OR die('Không thể kết nối MySQL: ' . mysqli_connect_error());

$mapq = $_GET['id'];

$msg = "";

// Lấy thông tin tài khoản theo mã phân quyền
$sql = "SELECT tk.tenTaiKhoan AS tenTaiKhoan, tk.maNV_KH AS maNV, tk.tenHienThi AS tenHienThi, tk.phanQuyen AS phanQuyen, nv.tenNV AS hoTen, tk.id AS tk_id 
        FROM tai_khoan tk 
        JOIN nhan_vien nv ON tk.maNV_KH = nv.id 
        WHERE tk.id = '$mapq'";

$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);

// Kiểm tra nếu không có mã phân quyền thông báo lỗi
if (!$row) {
    echo "<h2 class='text-center font-weight-bold text-danger'>Không tìm thấy thông tin phân quyền có mã: " . $mapq . "</h2>";
    exit();
}

if (isset($_POST["capNhat"])) {
    // Lấy tên hiển thị, phân quyền từ form
    $tenHT = $_POST["tenHienThi"];
    $phanquyen = $_POST["phanQuyen"];

    // Kiểm tra dữ liệu đầu vào
    if (empty($tenHT) || empty($phanquyen)) {
        $msg = "<span class='text-danger font-weight-bold'>Tất cả các trường đều phải điền đầy đủ.</span>";
    }

    // Nếu không có lỗi thì thực hiện cập nhật
    if (empty($msg)) {
        $sql_update = "UPDATE tai_khoan SET tenHienThi='$tenHT', phanQuyen='$phanquyen' WHERE id='$mapq'";

        if (mysqli_query($connect, $sql_update)) {
            $_SESSION['msg'] = "<span class='text-success font-weight-bold'>Cập nhật thông tin phân quyền thành công!</span>";
            echo "<script>window.location.href = '$base_url/admin/phan_quyen/index.php';</script>";
        } else {
            $_SESSION['msg'] = "<span class='text-danger font-weight-bold'>Đã xảy ra lỗi khi cập nhật!</span>";
            echo "<script>window.location.href = '$base_url/admin/phan_quyen/index.php';</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa phân quyền</title>
</head>
<body>
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="page-title">Cập nhật thông tin phân quyền</h4>
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
                                    <a href="<?php echo $base_url?>/admin/phan_quyen/index.php">Danh mục phân quyền</a>
                                </li>
                                <li class="separator">
                                    <i class="flaticon-right-arrow"></i>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo $base_url?>/admin/phan_quyen/edit.php">Chỉnh sửa</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card h-100">
                        <form action="" method="post">
                            <input type="hidden" name="id" value="<?php echo $row['tk_id']; ?>">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2 class="text-center m-3" style="font-weight: bold;">CẬP NHẬT THÔNG TIN PHÂN QUYỀN</h2>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>Tên hiển thị <span class="text-danger">*</span></label>
                                            <input type="text" name="tenHienThi" placeholder="Nhập tên hiển thị" class="form-control" value="<?php echo $row['tenHienThi']; ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>Phân quyền <span class="text-danger">*</span></label>
                                            <select class="form-control" name="phanQuyen">
                                                <option value="admin" <?php echo ($row['phanQuyen'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                                                <option value="nhanvien" <?php echo ($row['phanQuyen'] == 'nhanvien') ? 'selected' : ''; ?>>Nhân viên</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group text-center">
                                    <button type="submit" name="capNhat" class="btn btn-primary">Cập nhật</button>
                                    <a href="<?php echo $base_url?>/admin/phan_quyen/index.php" class="btn btn-danger btnBack">Quay lại</a>
                                </div>
                                <div class="form-group text-center">
                                    <?php echo $msg ?>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

