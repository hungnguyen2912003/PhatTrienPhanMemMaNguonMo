<?php
include('../timeOutSession.php');
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
include('../includes/header.html');
include('../_PartialSideBar.html');
include('../includes/footer.html');

// Kết nối vào cơ sở dữ liệu và hiển thị thông báo lỗi nếu không kết nối được
$connect = mysqli_connect("localhost", "root", "", "qlbandienthoai") OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error());

// Kiểm tra và lấy mã phân quyền từ URL
if (!isset($_GET['id'])) {
    echo "<h4>Không tìm thấy mã phân quyền.</h4>";
    exit();
}
$mapq = $_GET['id'];
$msg = "";

// Lấy thông tin tài khoản theo mã phân quyền
$sql = "SELECT tk.tenTaiKhoan AS tenTaiKhoan, tk.maNV_KH AS maNV, tk.tenHienThi AS tenHienThi, tk.phanQuyen AS phanQuyen, nv.hoTen AS hoTen, tk.id AS tk_id 
        FROM tai_khoan tk 
        JOIN nhan_vien nv ON tk.maNV_KH = nv.id 
        WHERE tk.id = '$mapq'";

// Gửi truy vấn đến cơ sở dữ liệu và kiểm tra kết quả
$result = mysqli_query($connect, $sql);
$phan_quyen = mysqli_fetch_assoc($result);

if (!$phan_quyen) {
    echo "<h4>Không tìm thấy thông tin phân quyền.</h4>";
    exit();
}
if(isset($_POST['deleteBtn'])){
    // Xóa
    $sqlDelete = "DELETE FROM tai_khoan WHERE id = '$mapq'";

    if (mysqli_query($connect, $sqlDelete)) {
        // Lưu thông báo thành công vào session
        $_SESSION['msg'] = "<span class='text-success font-weight-bold'>Xoá thành công  $mapq  </span>";
        echo "<script>window.location.href = '$base_url/admin/phan_quyen/index.php';</script>";
    } else {
        $_SESSION['msg'] = "<span class='text-danger font-weight-bold'>Đã xảy ra lỗi khi xoá!</span>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Xóa phân quyền</title>
</head>
<body>
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="page-title">Chi tiết thông tin phân quyền: <?php echo $phan_quyen['tenTaiKhoan']; ?></h4>
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
                                    <a href="<?php echo $base_url?>/admin/phan_quyen/delete.php">Xoá phân quyền</a>
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
                            <div id="logins-part" class="content active dstepper-block" role="tabpanel" aria-labelledby="logins-part-trigger">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>Tên đăng nhập</label>
                                            <span class="form-control"><?php if(isset($phan_quyen['tenTaiKhoan'])) echo $phan_quyen['tenTaiKhoan']; ?></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>Mã nhân viên </label>
                                            <span class="form-control"><?php if(isset($phan_quyen['maNV'])) echo $phan_quyen['maNV']; ?></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>Tên hiển thị </label>
                                            <span class="form-control"><?php if(isset($phan_quyen['tenHienThi'])) echo $phan_quyen['tenHienThi']; ?></span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>Phân quyền </label>
                                            <span class="form-control"><?php if(isset($phan_quyen['phanQuyen'])) echo $phan_quyen['phanQuyen']; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" name="deleteBtn" class="btn btn-info">Xoá</button>
                                <a href="<?php echo $base_url?>/admin/phan_quyen/index.php" class="btn btn-danger btnBack">Quay lại</a>
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
