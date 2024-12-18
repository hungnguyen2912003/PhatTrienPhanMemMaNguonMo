<?php
include('../thoihanSession.php');
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
include('../includes/header.html');
include('../menu.html');
include('../includes/footer.html');

// Kết nối vào cơ sở dữ liệu và hiển thị thông báo lỗi nếu không kết nối được
$connect = mysqli_connect("localhost", "root", "", "qlbandienthoai") OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error());

// Lấy mã ncc từ URL
$maNCC = $_GET['id'];
$msg = "";

// Truy vấn toàn bo thông tin nhà cung cấp theo mã NCC
$sql = "SELECT * FROM nha_cung_cap WHERE id = '$maNCC'";

// Gửi truy vấn đến cơ sở dữ liệu, lưu kết quả vào biến $result
$result = mysqli_query($connect, $sql);

// Lấy kết quả từ truy vấn và lưu vào biến $nhacungcap dưới dạng mảng kết hợp
$nhacungcap = mysqli_fetch_assoc($result);

// Kiểm tra nếu không tìm thấy nhà cung cấp với mã NCC trong cơ sở dữ liệu
if (!$nhacungcap) {
    echo "<h4>Không tìm thấy thông tin nhà cung cấp.</h4>";// thông báo lỗi
    exit;//dừng
}

?>
<?php if(isset($_SESSION['phanQuyen']) && $_SESSION['phanQuyen'] == 'ADMIN' || isset($_SESSION['phanQuyen']) && $_SESSION['phanQuyen'] == 'NV'):?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết nhà cung cấp</title>
</head>
<body>
<div class="main-panel">
<div class="content">
    <div class="page-inner">
        <div class="page-header">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="page-title">Chi tiết thông tin nhà cung cấp: <?php echo $nhacungcap['tenNCC']; ?></h4>
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
                                <a href="<?php echo $base_url?>/admin/nha_cung_cap/hienthi.php">Danh mục nhà cung cấp</a>
                            </li>
                            <li class="separator">
                                <i class="flaticon-right-arrow"></i>
                            </li>
                            <li class="nav-item">
                                <a href="#">Xem chi tiết</a>
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
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-group-default">
                                                <label>Mã nhà cung cấp</label>
                                                    <span class="form-control"><?php if(isset($nhacungcap['id'])) echo $nhacungcap['id']; ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-group-default">
                                                <label>Tên nhà cung cấp </label>
                                                <span class="form-control"><?php if(isset($nhacungcap['tenNCC'])) echo $nhacungcap['tenNCC']; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-group-default">
                                                <label>Hotline</label>
                                                <span class="form-control"><?php if(isset($nhacungcap['soDienThoai'])) echo $nhacungcap['soDienThoai']; ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-group-default">
                                                <label>Email </label>
                                                <span class="form-control"><?php if(isset($nhacungcap['email'])) echo $nhacungcap['email']; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label>Địa chỉ </label>
                                        <span class="form-control"><?php if(isset($nhacungcap['diaChi'])) echo $nhacungcap['diaChi']; ?></span>
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label>Website</label>
                                        <span class="form-control"><?php if(isset($nhacungcap['webSite'])) echo $nhacungcap['webSite']; ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-default text-center ">
                                        <label>Hình ảnh nhà cung cấp </label><br />
                                        <?php if (!empty($nhacungcap['Images'])): ?>
                                            <img src="<?php echo $base_url; ?>/Images/<?php echo $nhacungcap['Images']; ?>" alt="Hình ảnh nhà cung cấp" width="200" class="img-fluid">
                                            <div class="mt-1">Tên hình ảnh: <strong><?php echo $nhacungcap['Images']; ?></strong></div>
                                        <?php else: ?>
                                            <span class="form-control">Chưa thêm hình ảnh cho nhà cung cấp này</span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="form-group text-center">
                            <a href="<?php echo $base_url?>/admin/nha_cung_cap/chinhsua.php?id=<?php echo $nhacungcap['id']; ?>" class="btn btn-primary">Vào trang chỉnh sửa</a>
                            <a href="<?php echo $base_url?>/admin/nha_cung_cap/hienthi.php" class="btn btn-danger btnBack">Quay lại</a>
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