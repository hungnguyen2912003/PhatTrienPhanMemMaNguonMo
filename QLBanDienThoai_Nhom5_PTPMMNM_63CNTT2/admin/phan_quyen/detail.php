
<?php
include('../timeOutSession.php');
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
include('../includes/header.html');
include('../_PartialSideBar.html');
include('../includes/footer.html');

// Kết nối vào cơ sở dữ liệu và hiển thị thông báo lỗi nếu không kết nối được
$connect = mysqli_connect("localhost", "root", "", "qlbandienthoai") OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error());

// Lấy mã ncc từ URL
$mapq = $_GET['id'];
$msg = "";

$sql = "SELECT tk.tenTaiKhoan AS tenTaiKhoan, tk.maNV_KH AS maNV, tk.tenHienThi AS tenHienThi, tk.phanQuyen AS phanQuyen, nv.hoTen AS hoTen, tk.id AS tk_id FROM tai_khoan tk JOIN nhan_vien nv ON tk.maNV_KH = nv.id";


// Gửi truy vấn đến cơ sở dữ liệu, lưu kết quả vào biến $result
$result = mysqli_query($connect, $sql);

// Lấy kết quả từ truy vấn và lưu vào biến $nhacungcap dưới dạng mảng kết hợp
$phan_quyen = mysqli_fetch_assoc($result);

if (!$phan_quyen) {
    echo "<h4>Không tìm thấy thông tin .</h4>";// thông báo lỗi
    exit;//dừng
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết phân quyền</title>
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
                                    <a href="<?php echo $base_url?>/admin/phan_quyen/detail.php">Xem chi tiết</a>
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
                            </div>
                            <div class="form-group text-center">
                                <a href="<?php echo $base_url?>/admin/phan_quyen/edit.php?id=<?php echo $phan_quyen['tk_id']; ?>" class="btn btn-primary">Vào trang chỉnh sửa</a>
                                <a href="<?php echo $base_url?>/admin/phan_quyen/index.php" class="btn btn-danger btnBack">Quay lại</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
