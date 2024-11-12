<?php
include('../thoihanSession.php');
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
include('../includes/header.html');
include('../includes/footer.html');

// Kết nối cơ sở dữ liệu
$connect = mysqli_connect("localhost", "root", "", "qlbandienthoai")
OR die('Không thể kết nối MySQL: ' . mysqli_connect_error());

// Lấy mã sản phẩm từ URL và kiểm tra
$masp = isset($_GET['ma_sp']) ? $_GET['ma_sp'] : '';
$msg = "";

if (isset($_POST['deleteBtn']) && !empty($masp)) {
    // Xóa sản phẩm theo mã sản phẩm
    $sqlDelete = "DELETE FROM san_pham WHERE ma_sp = '$masp'";

    if (mysqli_query($connect, $sqlDelete)) {
        $_SESSION['msg'] = "<span class='text-success font-weight-bold'>Xoá thành công sản phẩm có mã $masp</span>";
        echo "<script>window.location.href = '$base_url/admin/san_pham/trangchu.php';</script>";
        exit();
    } else {
        $_SESSION['msg'] = "<span class='text-danger font-weight-bold'>Đã xảy ra lỗi khi xoá: " . mysqli_error($connect) . "</span>";
    }
}

// Truy vấn chi tiết sản phẩm để hiển thị thông tin
$sql = "
    SELECT sp.*, ncc.tenNCC 
    FROM san_pham sp 
    JOIN nha_cung_cap ncc ON sp.ma_ncc = ncc.id 
    WHERE sp.ma_sp = '$masp'
";
$result = mysqli_query($connect, $sql);
$sanpham = mysqli_fetch_assoc($result);
?>
<?php if(isset($_SESSION['phanQuyen']) && $_SESSION['phanQuyen'] == 'ADMIN'):?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Xóa thông tin sản phẩm</title>
</head>
<body>
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="page-title">Xóa thông tin sản phẩm: <?php echo isset($sanpham['ten_sp']) ? $sanpham['ten_sp'] : ''; ?></h4>
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
                                    <a href="<?php echo $base_url?>/admin/san_pham/hienthi.php">Danh sách sản phẩm</a>
                                </li>
                                <li class="separator">
                                    <i class="flaticon-right-arrow"></i>
                                </li>
                                <li class="nav-item">
                                    <a href="#">Xóa sản phẩm</a>
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
                            <form action="" method="POST">
                                <div id="logins-part" class="content active dstepper-block" role="tabpanel" aria-labelledby="logins-part-trigger">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group form-group-default">
                                                        <label>Mã sản phẩm</label>
                                                        <span class="form-control"><?php echo isset($sanpham['ma_sp']) ? $sanpham['ma_sp'] : ''; ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-group-default">
                                                        <label>Tên sản phẩm</label>
                                                        <span class="form-control"><?php echo isset($sanpham['ten_sp']) ? $sanpham['ten_sp'] : ''; ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group form-group-default">
                                                <label>Nhà cung cấp</label>
                                                <span class="form-control"> <?php echo isset($sanpham['tenNCC']) ? $sanpham['tenNCC'] : ''; ?></span>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group form-group-default">
                                                        <label>Số lượng</label>
                                                        <span class="form-control"><?php echo isset($sanpham['soLuong']) ? $sanpham['soLuong'] : ''; ?></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-group-default">
                                                        <label>Giá bán</label>
                                                        <span class="form-control"><?php echo isset($sanpham['giaBan']) ? $sanpham['giaBan'] : ''; ?></span>
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
                                                <textarea class="form-control" readonly><?php echo isset($sanpham['moTa']) ? $sanpham['moTa'] : ''; ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group text-center">
                                        <button type="submit" name="deleteBtn" class="btn btn-info">Xoá</button>
                                        <a href="<?php echo $base_url?>/admin/san_pham/hienthi.php" class="btn btn-danger btnBack">Quay lại</a>
                                    </div>
                                    <div class="form-group text-center">
                                        <?php echo $msg?>
                                    </div>
                                </div>
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