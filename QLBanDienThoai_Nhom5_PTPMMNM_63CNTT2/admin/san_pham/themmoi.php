<?php
include('../thoihanSession.php');
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
include('../includes/header.html');
include('../menu.html');
include('../includes/footer.html');

// Kết nối cơ sở dữ liệu
$connect = mysqli_connect("localhost", "root", "", "qlbandienthoai")
OR die('Không thể kết nối MySQL: ' . mysqli_connect_error());
$suppliers = mysqli_query($connect, "SELECT * FROM nha_cung_cap");
$msg = "";
$tenSP = "";
$supplierID = "";
$mauSac = "";
$kichThuoc ="";
$trongLuong = "";
$Pin = "";
$congSac ="";
$RAM ="";
$boNho ="";
$soLuong = "";
$giaBan = "";
$hinhAnh = "";
$moTa = "";
$maSP = rand(10000000, 99999999);
if (isset($_POST["themMoi"])) {
    $tenSP = $_POST["ten_sp"];
    $supplierID = $_POST["ma_ncc"];
    $mauSac = $_POST["mauSac"];
    $kichThuoc = $_POST["kichThuoc"];
    $trongLuong = $_POST["trongLuong"];
    $Pin = $_POST["Pin"];
    $congSac = $_POST["congSac"];
    $RAM = $_POST["RAM"];
    $boNho = $_POST["boNho"];
    $soLuong = $_POST["soLuong"];
    $giaBan = $_POST["giaBan"];
    $moTa = $_POST["moTa"];
    $hinhAnh = $_FILES['hinhAnh']['name'];
//    // Check if file input is properly set
//    if (isset($_FILES['fileInput']) && $_FILES['fileInput']['error'] === UPLOAD_ERR_OK) {
//        $hinhAnh = $_FILES['fileInput']['name'];
//    } else {
//        $hinhAnh = ""; // Default value if no file uploaded
//    }

    // Kiểm tra các trường bắt buộc và điều kiện số lượng và giá bán
    if (!empty($tenSP) && !empty($supplierID) && !empty($mauSac)&& !empty($kichThuoc)&& !empty($trongLuong)&& !empty($Pin) && !empty($congSac)&& !empty($RAM) && !empty($boNho) && !empty($soLuong) && !empty($giaBan) && !empty($moTa) && !empty($hinhAnh)) {
        if (!(is_numeric($trongLuong) && $trongLuong > 0))
            $msg = "<span class='text-danger font-weight-bold'>Trọng lượng sản phẩm phải lớn hơn 0. Vui lòng nhập lại!</span>";
        elseif (!(ctype_digit($RAM) && $RAM > 0))
            $msg = "<span class='text-danger font-weight-bold'>RAM phải là con số nguyên lớn hơn 0. Vui lòng nhập lại!</span>";
        elseif (!(ctype_digit($boNho) && $boNho> 0))
            $msg = "<span class='text-danger font-weight-bold'>Bộ nhớ phải là con số nguyên lớn hơn 0. Vui lòng nhập lại!</span>";
        elseif (!(ctype_digit($soLuong) && $soLuong > 0))
            $msg = "<span class='text-danger font-weight-bold'>Số lượng sản phẩm phải là con số nguyên lớn hơn 0. Vui lòng nhập lại!</span>";
        elseif (!(is_numeric($giaBan) && $giaBan > 0)) {
            $msg = "<span class='text-danger font-weight-bold'>Giá bán phải là số lớn hơn 0. Vui lòng nhập lại!</span>";
        }

//        // Kiểm tra hình ảnh mới
//        if (!empty($hinhAnh)) {
//            $dir = $_SERVER['DOCUMENT_ROOT'] . "/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2/Images/";
//            $file = $dir . basename($hinhAnh);
//            $imageFileType = strtolower(pathinfo($file, PATHINFO_EXTENSION));
//
//            // Kiểm tra kích thước file
//            if ($_FILES["fileInput"]["size"] > 2097152) {
//                $msg = "<span class='text-danger font-weight-bold'>Kích thước ảnh quá lớn 2MB.</span>";
//            } elseif ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
//                $msg = "<span class='text-danger font-weight-bold'>Chỉ chấp nhận các định dạng JPG, JPEG, PNG.</span>";
//            } else {
//                // Tải file lên server
//                if (move_uploaded_file($_FILES["fileInput"]["tmp_name"], $file)) {
//                    // File uploaded successfully
//                } else {
//                    $msg = "<span class='text-danger font-weight-bold'>Có lỗi xảy ra khi tải ảnh lên.</span>";
//                }
//            }
//        }
        if (empty($msg)) {
            // Kiểm tra mã nhân viên đã tồn tại
            $check_maSP = mysqli_query($connect, "SELECT * FROM san_pham WHERE ma_sp = '$maSP'");
            if (mysqli_num_rows($check_maSP) != 0) {
                $msg = "<span class='text-danger font-weight-bold'>Đã có mã sản phẩm này rồi. Vui lòng thử lại.</span>";
            } else {
                // Kiểm tra hình ảnh
                // Lấy tên file, kích thước, đường dẫn tạm
                $file_name = $_FILES['hinhAnh']['name'];
                $file_size = $_FILES['hinhAnh']['size'];
                $file_tmp = $_FILES['hinhAnh']['tmp_name'];
                $array = explode('.', $file_name); // Tách tên file để lấy phần đuôi.
                $file_ext = strtolower(end($array)); // Lấy phần đuôi file và chuyển về chữ thường.
                $expensions = array("jpeg", "jpg", "png"); // Các đuôi file hình ảnh hợp lệ.

                if (!in_array($file_ext, $expensions)) { // Kiểm tra nếu đuôi file không hợp lệ.
                    $msg = "<span class='text-danger font-weight-bold'>Đuôi file hình ảnh không hợp lệ. Chỉ chấp nhận cái đuôi file: jpeg, jpg, png</span>"; // Thông báo lỗi.
                } elseif ($file_size > 2097152) { // Kiểm tra nếu kích thước file lớn hơn 2MB.
                    $msg = "<span class='text-danger font-weight-bold'>Hình ảnh không được quá 2MB!</span>"; // Thông báo lỗi.
                } else {
                    move_uploaded_file($file_tmp, $_SERVER['DOCUMENT_ROOT'] . "\\QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2\\Images\\" . $file_name);// Di chuyển file hình ảnh đến thư mục lưu trữ.
                    // Thực hiện thêm mới
                    $sql = "INSERT INTO san_pham (ma_sp, ma_ncc, ten_sp, mauSac, kichThuoc, trongLuong, Pin, congSac, RAM, boNho, hinhAnh, moTa, soLuong, giaBan) VALUES ('$maSP', '$supplierID', '$tenSP','$mauSac','$kichThuoc','$trongLuong','$Pin','$congSac','$RAM','$boNho','$hinhAnh', '$moTa', '$soLuong', '$giaBan')";
                    if (mysqli_query($connect, $sql)) {
                        $_SESSION['msg'] = "<span class='text-success font-weight-bold'>Thêm mới sản phẩm $tenSP thành công!</span>";
                        echo "<script>window.location.href = '$base_url/admin/san_pham/hienthi.php';</script>";
                    } else {
                        $msg = "<span class='text-danger font-weight-bold'>Đã xảy ra lỗi khi thêm mới!</span>";
                    }
                }
            }
            // Giải phóng kết quả sau khi kiểm tra
            mysqli_free_result($check_maSP);
        }
    }
    else {
        $msg = "<span class='text-danger font-weight-bold'>Các trường bắt buộc không được để trống. Vui lòng nhập đầy đủ thông tin!</span>";
    }
}
// Đóng kết nối sau khi hoàn tất
mysqli_close($connect);
?>

<?php if(isset($_SESSION['phanQuyen']) && $_SESSION['phanQuyen'] == 'ADMIN'):?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thêm mới sản phẩm</title>
    <script>
        function layAnh(event) {
            // Get the selected file
            const fileInput = document.getElementById('fileInput');
            if (fileInput.files.length > 0) {
                // Extract the file name
                const fileName = fileInput.files[0].name;

                // Display the file name in the hinhAnh input field
                document.getElementById('hinhAnh').value = fileName;
            }
        }
    </script>
</head>
<body>
<div class="main-panel">
    <div class="content">
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
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h2 class="text-center m-3" style="font-weight: bold;">THÊM MỚI SẢN PHẨM</h2>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Tên sản phẩm <span class="text-danger">*</span></label>
                                                    <input type="text" name="ten_sp" placeholder="Nhập tên sản phẩm" class="form-control" value="<?php echo $tenSP; ?>" />
                                                </div>

                                                <div class="form-group form-group-default">
                                                    <label for="SupplierID">Nhà cung cấp<span class="text-danger">*</span></label>
                                                    <label>
                                                        <select name="ma_ncc" class="form-control select">
                                                            <option value="">Chọn nhà cung cấp</option>
                                                            <?php while ($row = mysqli_fetch_assoc($suppliers)): ?>
                                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['tenNCC']; ?></option>
                                                            <?php endwhile; ?>
                                                        </select>
                                                    </label>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <div class="form-group form-group-default">
                                                            <label>Màu sắc <span class="text-danger">*</span></label>
                                                            <input type="text" name="mauSac" placeholder="Nhập màu sắc" class="form-control" value="<?php echo $mauSac; ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group form-group-default">
                                                            <label>Kích thước <span class="text-danger">*</span></label>
                                                            <input type="text" name="kichThuoc" placeholder="Nhập kích thước" class="form-control" value="<?php echo $kichThuoc; ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group form-group-default">
                                                            <label>Trọng lượng <span class="text-danger">*</span></label>
                                                            <input type="text" name="trongLuong" placeholder="Nhập trọng lượng" class="form-control" value="<?php echo $trongLuong; ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group form-group-default">
                                                            <label>Pin <span class="text-danger">*</span></label>
                                                            <input type="text" name="Pin" placeholder="Nhập Pin" class="form-control" value="<?php echo $Pin; ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group form-group-default">
                                                            <label>Cổng sạc<span class="text-danger">*</span></label>
                                                            <input type="text" name="congSac" placeholder="Nhập cổng sạc" class="form-control" value="<?php echo $congSac; ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group form-group-default">
                                                            <label>RAM <span class="text-danger">*</span></label>
                                                            <input type="text" name="RAM" placeholder="Nhập RAM" class="form-control" value="<?php echo $RAM; ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group form-group-default">
                                                            <label>Bộ nhớ <span class="text-danger">*</span></label>
                                                            <input type="text" name="boNho" placeholder="Nhập bộ nhớ" class="form-control" value="<?php echo $boNho; ?>" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group form-group-default">
                                                            <label>Số lượng <span class="text-danger">*</span></label>
                                                            <input type="text" name="soLuong" placeholder="Nhập số lượng" class="form-control" value="<?php echo $soLuong; ?>"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group form-group-default">
                                                            <label>Giá bán <span class="text-danger">*</span></label>
                                                            <input type="text" name="giaBan" value="<?php echo $giaBan; ?>" placeholder="Nhập giá bán" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Hình ảnh sản phẩm <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-md-9">
                                                                    <input type="text" name="hinhAnh" id="hinhAnh" class="form-control"
                                                                    value="<?php if (isset($_FILES['hinhAnh']) && $_FILES['hinhAnh']['error'] == 0) echo $_FILES['hinhAnh']['name']; else echo 'Chưa thêm hình ảnh'; ?>" style="text-align: center;" readonly />
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <input type="file" name="hinhAnh" id="fileInput" accept="image/*" onchange="layAnh(event)" style="display: none;"/>
                                                                    <button type="button" class="btn btn-secondary" onclick="document.getElementById('fileInput').click()">Chọn ảnh</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group form-group-default">
                                                    <label>Mô tả<span class="text-danger">*</span></label>
                                                    <textarea name="moTa" placeholder="Nhập mô tả" class="form-control" style="resize: none; overflow: scroll" rows="5" ><?php echo $moTa; ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group text-center">
                                            <button type="submit" name="themMoi" class="btn btn-success">Thêm mới</button>
                                            <a href="<?php echo $base_url?>/admin/san_pham/hienthi.php" class="btn btn-danger btnBack">Quay lại</a>
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