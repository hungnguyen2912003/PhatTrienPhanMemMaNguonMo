<?php
include('../thoihanSession.php');
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
include('../includes/header.html');
include('../menu.html');
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
$sql = "SELECT 
            user.id AS ID, 
            user.username AS tenTaiKhoan, 
            user.user_id AS maNV, 
            nv.phanQuyen AS phanQuyen, 
            CONCAT(nv.hoNV, ' ', nv.tenlot, ' ', nv.tenNV) AS hoTen 
        FROM user 
        JOIN nhan_vien nv ON user.user_id = nv.id
        WHERE user.id = '$mapq'";

// Gửi truy vấn đến cơ sở dữ liệu và kiểm tra kết quả
$result = mysqli_query($connect, $sql);
$phan_quyen = mysqli_fetch_assoc($result);

if (!$phan_quyen) {
    echo "<h4>Không tìm thấy thông tin phân quyền.</h4>";
    exit();
}
if(isset($_POST['deleteBtn'])){
    $sqlDelete = "DELETE FROM user WHERE id = '$mapq'";

    //Đồng thời xóa nhân viên
    $manv = $row['maNV'];
    $sql_del_nv = "DELETE FROM nhan_vien WHERE ";

    if (mysqli_query($connect, $sqlDelete)) {
        // Lưu thông báo thành công vào session
        $_SESSION['msg'] = "<span class='text-success font-weight-bold'>Xoá thành công  $mapq  </span>";
        echo "<script>window.location.href = '$base_url/admin/tai_khoan/hienthi.php';</script>";
    } else {
        $msg = "<span class='text-danger font-weight-bold'>Đã xảy ra lỗi khi xoá!</span>";
    }
}

?>
<?php if(isset($_SESSION['phanQuyen']) && $_SESSION['phanQuyen'] == 'ADMIN'):?>
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
                                <h4 class="page-title">Xóa thông tin tài khoản: <?php echo $phan_quyen['tenTaiKhoan']; ?></h4>
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
<<<<<<< HEAD
                                        <a href="<?php echo $base_url?>/admin/tai_khoan/hienthi.php">Danh mục phân quyền</a>
=======
                                        <a href="<?php echo $base_url?>/admin/tai_khoan/hienthi.php">Danh mục tài khoản</a>
>>>>>>> 0dd459305821ef80a4c26385d186a7f0d54d3220
                                    </li>
                                    <li class="separator">
                                        <i class="flaticon-right-arrow"></i>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#">Xoá tài khoản</a>
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
                                                        <label>Họ tên nhân viên </label>
                                                        <span class="form-control"><?php if(isset($phan_quyen['hoTen'])) echo $phan_quyen['hoTen']; ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-group-default">
                                                        <label>Phân quyền </label>
                                                        <span class="form-control">
                                                            <?php
                                                            if (isset($phan_quyen['phanQuyen'])){
                                                                $phanQuyen = $phan_quyen['phanQuyen'];
                                                                if ($phanQuyen == 'ADMIN') {
                                                                    $phanQuyenShow = 'Admin';
                                                                } elseif ($phanQuyen == 'NV') {
                                                                    $phanQuyenShow = 'Nhân viên';
                                                                } else {
                                                                    $phanQuyenShow = 'Chưa thiết lập';
                                                                }
                                                                echo $phanQuyenShow;
                                                            }
                                                            ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group text-center">
                                            <button type="submit" name="deleteBtn" class="btn btn-info">Xoá</button>
                                            <a href="<?php echo $base_url?>/admin/tai_khoan/hienthi.php" class="btn btn-danger btnBack">Quay lại</a>
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