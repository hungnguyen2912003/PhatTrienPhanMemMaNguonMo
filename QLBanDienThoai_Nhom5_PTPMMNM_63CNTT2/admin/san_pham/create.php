<?php
include '../checkSession.php';
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
include('../includes/header.html');
include('../_PartialSideBar.html');
include('../includes/footer.html');

// Kết nối cơ sở dữ liệu
$connect = mysqli_connect("localhost", "root", "", "qlbandienthoai")
OR die('Không thể kết nối MySQL: ' . mysqli_connect_error());

$msg = "";
$tenSP = "";
$supplierID = "";
$soLuong = "";
$giaBan = "";
$hinhAnh = "";
$moTa = "";

if (isset($_POST["themMoi"])) {
    $tenSP = $_POST["ten_sp"];
    $supplierID = $_POST["ma_ncc"];
    $soLuong = $_POST["soLuong"];
    $giaBan = $_POST["giaBan"];
    $moTa = $_POST["moTa"];
    $hinhAnh = $_POST["hinhAnh"];
    $maSP = rand(10000000, 99999999);

    // Kiểm tra các trường bắt buộc và điều kiện số lượng và giá bán
    if (!empty($tenSP) && !empty($supplierID) && !empty($soLuong) && !empty($giaBan) && !empty($moTa) && !empty($hinhAnh)) {
        // Kiểm tra xem số lượng và giá bán có lớn hơn 0 không
        if ($soLuong <= 0 || $giaBan <= 0) {
            $msg = "<span class='text-danger font-weight-bold'>Số lượng và giá bán phải lớn hơn 0. Vui lòng nhập lại!</span>";
        } else {
            $check_maSP = mysqli_query($connect, "SELECT * FROM san_pham WHERE ma_sp = '$maSP'");
            if (mysqli_num_rows($check_maSP) != 0) {
                $msg = "<span class='text-danger font-weight-bold'>Đã có mã sản phẩm này rồi. Vui lòng thử lại.</span>";
            } else {
                // Thực hiện truy vấn INSERT vào bảng sản phẩm
                $sql = "INSERT INTO san_pham (ma_sp, ma_ncc, ten_sp, hinhAnh, moTa, soLuong, giaBan) VALUES ('$maSP', '$supplierID', '$tenSP', '$hinhAnh', '$moTa', '$soLuong', '$giaBan')";
                if (mysqli_query($connect, $sql)) {
                    $msg = "<span class='text-success font-weight-bold'>Thêm mới sản phẩm $tenSP thành công!</span>";
                } else {
                    $msg = "<span class='text-danger font-weight-bold'>Đã xảy ra lỗi khi thêm mới!</span>";
                }
            }
        }
    } else {
        $msg = "<span class='text-danger font-weight-bold'>Các trường bắt buộc không được để trống và giá bán phải là số dương. Vui lòng nhập đầy đủ thông tin!</span>";
    }
}



$suppliers = mysqli_query($connect, "SELECT * FROM nha_cung_cap");

// Đóng kết nối sau khi hoàn tất
mysqli_close($connect);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thêm mới sản phẩm</title>
</head>
<body>

<div class="main-panel">
    <div class="page-inner">
        <div class="page-header">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="page-title">Thêm mới sản phẩm</h4>
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
                                <a href="<?php echo $base_url?>/admin/san_pham/create.php">Thêm mới</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card h-100">
                    <form action="" method="post" >
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <div class="row">
                                                <div class="col-md-12 mb-3">
                                                    <label style="font-weight: bold;">THÔNG TIN CHUNG</label>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-group-default">
                                                        <label>Tên sản phẩm <span class="text-danger">*</span></label>
                                                        <input type="text" name="ten_sp" placeholder="Nhập tên sản phẩm" class="form-control" value="<?php echo htmlspecialchars($tenSP); ?>" required />
                                                    </div>

                                                    <div class="form-group form-group-default">
                                                        <label for="SupplierID">Chọn nhà cung cấp<span class="text-danger">*</span></label>
                                                        <select id="SupplierID" name="ma_ncc" class="form-control select" required>
                                                            <option value="">Chọn nhà cung cấp</option>
                                                            <?php while ($row = mysqli_fetch_assoc($suppliers)): ?>
                                                                <option value="<?php echo $row['id']; ?>"><?php echo htmlspecialchars($row['tenNCC']); ?></option>
                                                            <?php endwhile; ?>
                                                        </select>
                                                        <span class="text-danger" id="SupplierIDError"></span>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group form-group-default">
                                                                <label>Số lượng <span class="text-danger">*</span></label>
                                                                <input type="number" name="soLuong" placeholder="Nhập số lượng" class="form-control" value="<?php echo htmlspecialchars($soLuong); ?>" min="1" step="1" required />
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group form-group-default">
                                                                <label>Giá bán <span class="text-danger">*</span></label>
                                                                <input type="text" name="giaBan" value="<?php echo htmlspecialchars($giaBan); ?>" id="giaBan" placeholder="Nhập giá bán" class="form-control auto" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="form-group form-group-default">
                                                        <label>Hình ảnh sản phẩm <span class="text-danger">*</span></label>
                                                        <div class="input-group">
                                                            <input type="file" class="form-control-file p-1" name="hinhAnh" value="<?php echo $hinhAnh; ?>"/>
                                                        </div>
                                                    </div>

                                                    <div class="form-group form-group-default">
                                                        <label>Mô tả</label>
                                                        <textarea name="moTa" placeholder="Nhập mô tả" class="form-control" rows="3"><?php echo htmlspecialchars($moTa); ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group text-center">
                                        <button type="submit" name="themMoi" class="btn btn-success">Thêm mới</button>
                                        <a href="<?php echo $base_url?>/admin/san_pham/index.php" class="btn btn-danger btnBack">Quay lại</a>
                                    </div>
                                    <div class="form-group text-center">
                                        <?php echo $msg; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.content -->
</body>
</html>
<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select').select2()
    });
</script>

<script src="<?php echo $base_url?>/Scripts/jsConvert.js"></script>

<script>
    $(document).ready(function () {
        $('.auto').autoNumeric('init'); // Khởi tạo autoNumeric cho các trường
        $('#demoPrice, #demoPriceSale, #demoOriginalPrice').on('change', function () {
            var $this = $(this);
            var demoGet = $this.autoNumeric('get'); // Get the numeric value

            // Update the corresponding hidden field
            $this.next('input[type="hidden"]').val(demoGet);

            // Set the formatted value back to the input
            $this.autoNumeric('set', demoGet);
        });

        CKEDITOR.replace('txtDetail', {
            customConfig: '/content/ckeditor/config.js',
            extraAllowedContent: 'span',
        });
        // Hàm để ẩn thông báo sau 5 giây
        function hideMessage() {
            $('.message-container').fadeOut(); // Ẩn thông báo
        }

        // Nếu có thông báo, thiết lập timeout để tự động ẩn sau 5 giây
        if ($('.message-container').length) {
            setTimeout(hideMessage, 5000); // 5000 milliseconds = 5 seconds
        }
    });
    function BrowseServer(field) {
        var finder = new CKFinder();
        finder.selectActionFunction = function (fileUrl) {
            document.getElementById(field).value = fileUrl;
        };
        finder.popup();
    }
</script>