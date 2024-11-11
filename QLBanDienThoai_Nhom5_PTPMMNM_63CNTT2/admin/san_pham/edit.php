<?php
include('../../timeOutSession.php');
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

// Xử lý form chỉnh sửa sản phẩm
if (isset($_POST["capNhat"])) {
    // Duy trì giá trị cũ trong trường hợp không có thay đổi
    $ten_sp = $_POST['ten_sp'] ?? $sanpham['ten_sp'];
    $ma_ncc = $_POST['ma_ncc'] ?? $sanpham['ma_ncc'];
    $soLuong = $_POST['soLuong'] ?? $sanpham['soLuong'];
    $giaBan = $_POST['giaBan'] ?? $sanpham['giaBan'];
    $moTa = $_POST['moTa'] ?? $sanpham['moTa'];
    // Check if file input is properly set
    if (isset($_FILES['fileInput']) && $_FILES['fileInput']['error'] === UPLOAD_ERR_OK) {
        $hinhAnh = $_FILES['fileInput']['name'];
    } else {
        $hinhAnh = ""; // Default value if no file uploaded
    }

    if (!empty($ten_sp) && !empty($ma_ncc) && !empty($soLuong) && !empty($giaBan) && !empty($moTa) ) {
        if (!(ctype_digit($soLuong) && $soLuong > 0)) {
            $msg = "<span class='text-danger font-weight-bold'>Số lượng sản phẩm phải là con số nguyên lớn hơn 0. Vui lòng nhập lại!</span>";
        }
        // Kiểm tra xem số lượng và giá bán có lớn hơn 0 không
        elseif (!(is_numeric($giaBan) && $giaBan > 0)) {
            $msg = "<span class='text-danger font-weight-bold'>Giá bán phải là số lớn hơn 0. Vui lòng nhập lại!</span>";
        }else {
            // Kiểm tra hình ảnh mới
            if (!empty($_FILES['fileInput']['name'])) {
                $dir = $_SERVER['DOCUMENT_ROOT'] . "/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2/Images/";
                $file = $dir . basename($hinhAnh);
                $imageFileType = strtolower(pathinfo($file, PATHINFO_EXTENSION));

                // Kiểm tra kích thước file
                if ($_FILES["fileInput"]["size"] > 2097152) {
                    $msg = "<span class='text-danger font-weight-bold'>Kích thước ảnh quá lớn 2MB.</span>";
                } elseif ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                    $msg = "<span class='text-danger font-weight-bold'>Chỉ chấp nhận các định dạng JPG, JPEG, PNG.</span>";
                } else {
                    // Tải file lên server
                    if (move_uploaded_file($_FILES["fileInput"]["tmp_name"], $file)) {
                        // File uploaded successfully
                    }
                    else {
                        $msg = "<span class='text-danger font-weight-bold'>Có lỗi xảy ra khi tải ảnh lên.</span>";
                    }
                }
            }
            if (empty($msg)) {
                $sql = "UPDATE san_pham SET ten_sp = '$ten_sp', ma_ncc = '$ma_ncc', soLuong = '$soLuong', giaBan = '$giaBan', moTa = '$moTa', hinhAnh = '$hinhAnh' WHERE ma_sp = '$masp'";

                if (mysqli_query($connect, $sql)) {
                    $_SESSION['msg'] = "<span class='text-success font-weight-bold'>Cập nhật thông tin sản phẩm $ten_sp thành công!</span>";
                } else {
                    $_SESSION['msg'] = "<span class='text-danger font-weight-bold'>Đã xảy ra lỗi khi cập nhật!</span>";
                }
                // Redirect về trang index
                echo "<script>window.location.href = '$base_url/admin/san_pham/index.php';</script>";
            }
        }
    } else {
        $msg = "<span class='text-danger font-weight-bold'>Các trường bắt buộc không được để trống. Vui lòng nhập đầy đủ thông tin!</span>";
    }
}
$suppliers = mysqli_query($connect, "SELECT * FROM nha_cung_cap");
// Truy vấn thông tin nhà cung cấp theo mã
?>
<?php if(isset($_SESSION['phanQuyen']) && $_SESSION['phanQuyen'] == 'ADMIN'):?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh sửa sản phẩm</title>
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
                            <h4 class="page-title">Chỉnh sửa sản phẩm: <?php echo $sanpham['ten_sp']; ?></h4>
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
                                    <a href="<?php echo $base_url?>/admin/san_pham/edit.php">Chỉnh sửa</a>
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
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Tên sản phẩm <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" name="ten_sp" value="<?php echo $sanpham['ten_sp']; ?>">
                                                </div>
                                        <div class="form-group form-group-default">
                                            <label>Nhà cung cấp <span class="text-danger">*</span></label>
                                            <select class="form-control" name="ma_ncc">
                                                <option value="<?php echo $sanpham['ma_ncc']; ?>" selected><?php echo $sanpham['tenNCC']; ?></option>
                                                <?php
                                                // Lấy danh sách nhà cung cấp
                                                $sql_ncc = "SELECT * FROM nha_cung_cap";
                                                $result_ncc = mysqli_query($connect, $sql_ncc);
                                                while ($ncc = mysqli_fetch_assoc($result_ncc)) {
                                                    echo "<option value='".$ncc['id']."'>".$ncc['tenNCC']."</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group form-group-default">
                                            <label>Số lượng <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" name="soLuong" value="<?php echo $sanpham['soLuong']; ?>">
                                        </div>
                                        <div class="form-group form-group-default">
                                            <label>Giá bán <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" name="giaBan" value="<?php echo $sanpham['giaBan']; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default text-center">
                                            <label>Hình ảnh sản phẩm <span class="text-danger">*</span></label>
                                            <?php if ($sanpham['hinhAnh']): ?>
                                                <img src='<?php echo $base_url; ?>/Images/<?php echo $sanpham['hinhAnh']; ?>' alt='Hình ảnh đại diện' width="200" class='img-fluid mb-2'>
                                                <div>Tên hình ảnh: <strong><?php echo $sanpham['hinhAnh']; ?></strong></div>
                                            <?php else: ?>
                                                <div>Không có hình ảnh hiện tại.</div>
                                            <?php endif; ?>
                                            <div class="input-group ">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-9">
                                                            <input type="text" name="hinhAnh" id="hinhAnh" class="form-control" style="text-align: center;" readonly value="<?php if (isset($_FILES['hinhAnh'])) echo $_FILES['hinhAnh']['name']; else echo $sanpham['hinhAnh']; ?>"/>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input type="file" name="fileInput" id="fileInput" accept="image/*" onchange="layAnh(event)" style="display: none;"/>
                                                            <button type="button" class="btn btn-secondary" onclick="document.getElementById('fileInput').click()">Chọn ảnh</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group form-group-default">
                                            <label>Mô tả sản phẩm <span class="text-danger">*</span></label>
                                            <textarea class="form-control" name="moTa" rows="3"><?php echo $sanpham['moTa']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group text-center mt-4">
                                    <button type="submit" class="btn btn-primary" name="capNhat">Cập nhật</button>
                                    <a href="<?php echo $base_url?>/admin/san_pham/index.php" class="btn btn-danger btnBack">Quay lại</a>
                                </div>
                            </form>
                            <div class="form-group text-center">
                                <?php echo $msg; ?>
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