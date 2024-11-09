<?php
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
include('../includes/header.html');
include('../_PartialSideBar.html');
include('../includes/footer.html');

// Kết nối cơ sở dữ liệu
$connect = mysqli_connect("localhost", "root", "", "qlbandienthoai") OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error());

// Lấy mã ncc từ URL
$maNCC = $_GET['id'];
$msg = "";

// Truy vấn thông tin nhà cung cấp
$sql = "SELECT * FROM nha_cung_cap WHERE id = '$maNCC'";
$result = mysqli_query($connect, $sql);
$nhacungcap = mysqli_fetch_assoc($result);

if (!$nhacungcap) {
    echo "<h4>Không tìm thấy thông tin nhà cung cấp.</h4>";
    exit;
}

?>
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
                                <a href="<?php echo $base_url?>/admin/index.php">
                                    <i class="flaticon-home"></i>
                                </a>
                            </li>
                            <li class="separator">
                                <i class="flaticon-right-arrow"></i>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo $base_url?>/admin/nha_cung_cap/index.php">Danh mục nhà cung cấp</a>
                            </li>
                            <li class="separator">
                                <i class="flaticon-right-arrow"></i>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo $base_url?>/admin/nha_cung_cap/detail.php">Xem chi tiết</a>
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
                                    <div class="form-group form-group-default">
                                        <label>Số điện thoại </label>
                                        <span class="form-control"><?php if(isset($nhacungcap['soDienThoai'])) echo $nhacungcap['soDienThoai']; ?></span>
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label>Email </label>
                                        <span class="form-control"><?php if(isset($nhacungcap['email'])) echo $nhacungcap['email']; ?></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-default text-center ">
                                        <label>Hình ảnh nhà cung cấp </label><br />
                                        <?php if (!empty($nhacungcap['Images'])): ?>
                                            <img src="<?php echo $base_url; ?>/Images/<?php echo $nhacungcap['Images']; ?>" alt="Hình ảnh nhà cung cấp" width="200" class="img-fluid">
                                        <?php else: ?>
                                            <span class="form-control">Chưa thêm hình ảnh cho nhà cung cấp này</span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="form-group text-center">
                            <a href="<?php echo $base_url?>/admin/nha_cung_cap/edit.php?id=<?php echo $nhacungcap['id']; ?>" class="btn btn-primary">Vào trang chỉnh sửa</a>
                            <a href="<?php echo $base_url?>/admin/nha_cung_cap/index.php" class="btn btn-danger btnBack">Quay lại</a>
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