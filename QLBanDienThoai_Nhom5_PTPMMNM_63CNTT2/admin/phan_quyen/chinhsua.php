<?php
include('../thoihanSession.php');
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
include('../includes/header.html');
include('../menu.html');
include('../includes/footer.html');

// Kết nối cơ sở dữ liệu
$connect = mysqli_connect("localhost", "root", "", "qlbandienthoai")
OR die('Không thể kết nối MySQL: ' . mysqli_connect_error());

$matk = $_GET['id'] ?? ""; // Lấy id từ URL
$msg = "";

// Lấy thông tin tài khoản theo mã phân quyền
$sql = "SELECT user.id AS ID, user.username AS tenTaiKhoan, user.user_id AS maNV, user.phanQuyen AS phanQuyen, 
        CONCAT(nv.hoNV, ' ', nv.tenlot, ' ', nv.tenNV) AS hoTen 
        FROM user 
        JOIN nhan_vien nv ON user.user_id = nv.id
        WHERE user.id = '$matk'";

$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);

// Kiểm tra nếu không có mã phân quyền thông báo lỗi
if (!$row) {
    echo "<h2 class='text-center font-weight-bold text-danger'>Không tìm thấy thông tin phân quyền có mã: " . $matk . "</h2>";
    exit();
}

if (isset($_POST["capNhat"])) {
    // Lấy tên hiển thị, phân quyền từ form
    $phanquyen = $_POST["phanQuyen"];

    // Kiểm tra dữ liệu đầu vào
    if (empty($phanquyen)) {
        $msg = "<span class='text-danger font-weight-bold'>Tất cả các trường đều phải điền đầy đủ.</span>";
    }

    // Nếu không có lỗi thì thực hiện cập nhật
    if (empty($msg)) {
        $sql_update = "UPDATE user SET  phanQuyen='$phanquyen' WHERE id='$matk'";

        if (mysqli_query($connect, $sql_update)) {
            $_SESSION['msg'] = "<span class='text-success font-weight-bold'>Cập nhật thông tin phân quyền cho tài khoản có mã $matk thành công!</span>";
            echo "<script>window.location.href = '$base_url/admin/phan_quyen/hienthi.php';</script>";
        } else {
            $msg = "<span class='text-danger font-weight-bold'>Đã xảy ra lỗi khi cập nhật!</span>";
        }
    }
}
?>

<?php if(isset($_SESSION['phanQuyen']) && $_SESSION['phanQuyen'] == 'ADMIN'):?>
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
                                <h4 class="page-title">Cập nhật thông tin phân quyền: <?php echo $row['tenTaiKhoan']; ?></h4>
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
                                        <a href="<?php echo $base_url?>/admin/phan_quyen/hienthi.php">Danh mục phân quyền</a>
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
                            <form action="" method="post">
                                <input type="hidden" name="id" value="<?php echo $row['ID']; ?>">
                                <div class="card-body">
                                    <div class="row justify-content-center" >
                                        <div class="col-md-6">
                                            <div class="form-group form-group-default">
                                                <label>Phân quyền <span class="text-danger">*</span></label>
                                                <select class="form-control" name="phanQuyen">
                                                    <option value="ADMIN" <?php echo ($row['phanQuyen'] == 'ADMIN') ? 'selected' : ''; ?>>Admin</option>
                                                    <option value="NV" <?php echo ($row['phanQuyen'] == 'NV') ? 'selected' : ''; ?>>Nhân viên</option>
                                                </select>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group text-center">
                                        <button type="submit" name="capNhat" class="btn btn-primary">Cập nhật</button>
                                        <a href="<?php echo $base_url?>/admin/phan_quyen/hienthi.php" class="btn btn-danger btnBack">Quay lại</a>
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