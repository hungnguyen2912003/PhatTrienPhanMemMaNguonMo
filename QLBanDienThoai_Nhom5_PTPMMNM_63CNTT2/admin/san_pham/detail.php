<?php
include('../timeOutSession.php');
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
include('../includes/header.html');
include('../_PartialSideBar.html');
include('../includes/footer.html');

// Kết nối cơ sở dữ liệu
$connect = mysqli_connect("localhost", "root", "", "qlbandienthoai") OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error());

// Lấy mã sản phẩm từ URL
$masp = $_GET['ma_sp'];
$msg = "";

// Truy vấn để lấy thông tin sản phẩm và tên nhà cung cấp
$sql_select = "
    SELECT sp.*, ncc.tenNCC 
    FROM san_pham sp 
    JOIN nha_cung_cap ncc ON sp.ma_ncc = ncc.id 
    WHERE sp.ma_sp = '$masp'
";
$result_select = mysqli_query($connect, $sql_select);
$sanpham = mysqli_fetch_assoc($result_select);

if (!$sanpham) {
    echo "<h4>Không tìm thấy thông tin sản phẩm.</h4>";
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
                            <h4 class="page-title">Chi tiết thông tin sản phẩm: <?php echo $sanpham['ten_sp']; ?></h4>
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
                                    <a href="<?php echo $base_url?>/admin/san_pham/index.php">Danh sách sản phẩm</a>
                                </li>
                                <li class="separator">
                                    <i class="flaticon-right-arrow"></i>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo $base_url?>/admin/san_pham/detail.php">Xem chi tiết</a>
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
                                                    <label>Mã sản phẩm</label>
                                                    <span class="form-control"><?php if(isset($sanpham['ma_sp'])) echo $sanpham['ma_sp']; ?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Tên sản phẩm</label>
                                                    <span class="form-control"><?php if(isset($sanpham['ten_sp'])) echo $sanpham['ten_sp']; ?></span>
                                                </div>
                                            </div>
                                        </div>

                                            <div class="form-group form-group-default">
                                                <label>Nhà cung cấp</label>
                                                <span class="form-control"> <?php if(isset($sanpham['tenNCC'])) echo $sanpham['tenNCC']; ?></span>
                                            </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Số lượng</label>
                                                    <span class="form-control"><?php if(isset($sanpham['soLuong'])) echo $sanpham['soLuong']; ?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Giá bán</label>
                                                    <span class="form-control"><?php if(isset($sanpham['giaBan'])) echo $sanpham['giaBan']; ?></span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default text-center ">
                                            <label>Hình ảnh sản phẩm</label><br />
                                            <?php if (!empty($sanpham['hinhAnh'])): ?>
                                                <img src="<?php echo $base_url; ?>/Images/<?php echo $sanpham['hinhAnh']; ?>" alt="Hình ảnh sản phẩm" width="200" class="img-fluid">
                                            <?php else: ?>
                                                <span class="form-control">Chưa thêm hình ảnh cho sản phẩm này</span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group form-group-default">
                                            <label>Mô tả</label>
                                            <textarea class="form-control" readonly><?php if(isset($sanpham['moTa'])) echo $sanpham['moTa']; ?></textarea>
                                        </div>


                                    </div>


                                </div>
                                <div class="form-group text-center">
                                    <a href="<?php echo $base_url?>/admin/san_pham/edit.php?ma_sp=<?php echo $sanpham['ma_sp']; ?>" class="btn btn-primary">Vào trang chỉnh sửa</a>
                                    <a href="<?php echo $base_url?>/admin/san_pham/index.php" class="btn btn-danger btnBack">Quay lại</a>
                                </div>
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