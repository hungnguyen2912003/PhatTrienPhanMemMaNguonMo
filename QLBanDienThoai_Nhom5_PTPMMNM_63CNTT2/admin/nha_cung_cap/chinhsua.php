<?php
include('../thoihanSession.php');
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
include('../includes/header.html');
include('../menu.html');
include('../includes/footer.html');

// Kết nối cơ sở dữ liệu
$connect = mysqli_connect("localhost", "root", "", "qlbandienthoai")
OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error());

// Lấy mã NCC từ URL và kiểm tra sự tồn tại của tham số 'id'
if (isset($_GET['id'])) {
    $maNCC = $_GET['id'];
} else {
    echo "Mã nhà cung cấp không hợp lệ!";
    exit();
}

$msg = "";


// Truy vấn thông tin nhà cung cấp theo mã
$sql = "SELECT * FROM nha_cung_cap WHERE id = '$maNCC'";

// Gửi truy vấn đến cơ sở dữ liệu, lưu kết quả vào biến $result
$result = mysqli_query($connect, $sql);

// Lấy kết quả từ truy vấn và lưu vào biến $row dưới dạng mảng kết hợp
$row = mysqli_fetch_assoc($result);

// kiểm tra nếu không có mã ncc, thông báo lỗi
if (!$row) {
    $is_found = "<h2 class='text-center font-weight-bold text-danger'>Không tìm thấy thông tin nhà cung cấp có mã: " . $maNCC . "</h2>";
}

// Kiểm tra nếu form được gửi với nút "Cập nhật" được nhấn.
if (isset($_POST["capNhat"])) {
    // Lấy tên ncc, email, sdt, từ form.
    $tenNCC = $_POST["tenNCC"];
    $email = $_POST["email"];
    $soDienThoai = $_POST["soDienThoai"];
    //Hình ảnh cũ
    $hinhAnh = basename($_POST['hinhAnh']);
    // Kiểm tra các trường bắt buộc
    if (empty($tenNCC) || empty($email) || empty($soDienThoai) || empty($hinhAnh)) {
        $msg = "<span class='text-danger font-weight-bold'>Tất cả các trường đều phải điền đầy đủ.</span>";
    } else {
        // Kiểm tra số điện thoại
        if (!preg_match("/^\d{8,11}$/", $soDienThoai))
            $msg = "<span class='text-danger font-weight-bold'>Số điện thoại phải bao gồm từ 8 đến 11 chữ số.</span>";
        //Kiểm tra hình ảnh
        $dir = $_SERVER['DOCUMENT_ROOT'] . "/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2/Images/";
        $file = $dir . basename($_FILES["fileInput"]["name"]);
        $imageFileType = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        //Hình ảnh mới
        if (!empty($_FILES['fileInput']['name'])) {
            // Kiểm tra loại file ảnh
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg")
                $msg = "<span class='text-danger font-weight-bold'>Chỉ chấp nhận các định dạng JPG, JPEG, PNG & GIF.</span>";
            // Kiểm tra kích thước file
            elseif ($_FILES["fileInput"]["size"] > 2097152)
                $msg = "<span class='text-danger font-weight-bold'>Kích thước ảnh quá lớn 2MB.</span>";

            //Nếu không còn báo lỗi gì nữa thì tiến hành đưa ảnh lên server
            if(empty($msg)) {
                // Tải file lên server
                if (move_uploaded_file($_FILES["fileInput"]["tmp_name"], $file)) {
                    $hinhAnh = basename($_FILES["fileInput"]["name"]); // lưu tên file mới
                } else {
                    $msg = "<span class='text-danger font-weight-bold'>Có lỗi xảy ra khi tải ảnh lên.</span>";
                }
            }
        }
        //Nếu không còn báo lỗi gì nữa thì tiến hành cập nhật nhân viên
        if (empty($msg)) {
            // Cập nhật thông tin nhân viên
            $sql = "UPDATE nha_cung_cap SET tenNCC='$tenNCC', soDienThoai='$soDienThoai', email='$email', Images='$hinhAnh' WHERE id='$maNCC'";
            if (mysqli_query($connect, $sql)) {
                $_SESSION['msg'] = "<span class='text-success font-weight-bold'>Cập nhật thông tin nhà cung cấp $tenNCC thành công!</span>";
                echo "<script>window.location.href = '$base_url/admin/nha_cung_cap/hienthi.php';</script>";
            } else {
                $msg = "<span class='text-danger font-weight-bold'>Đã xảy ra lỗi khi cập nhật!</span>";
            }
        }
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
    <title>Thêm mới nhà cung cấp</title>
    <script>
        // Hàm lấy tên file khi người dùng chọn tệp
        function layAnh(event) {
            // Lấy phần tử <input> có id là 'fileInput' (đây là phần tử cho phép người dùng chọn file)
            const fileInput = document.getElementById('fileInput');
            // Kiểm tra xem có tệp nào được chọn không
            if (fileInput.files.length > 0) {
                // Nếu có tệp, lấy tên của tệp đầu tiên (tệp được chọn) và lưu vào biến fileName
                const fileName = fileInput.files[0].name;

                // Gán tên tệp vào phần tử <input> có id là 'hinhAnh'
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
                            <h4 class="page-title">Cập nhật thông tin nhà cung cấp</h4>
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
                                    <a href="<?php echo $base_url?>/admin/nha_cung_cap/hienthi.php">Danh sách nhà cung cấp</a>
                                </li>
                                <li class="separator">
                                    <i class="flaticon-right-arrow"></i>
                                </li>
                                <li class="nav-item">
                                    <a href="#">Chỉnh sửa</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card h-100">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2 class="text-center m-3" style="font-weight: bold;">CẬP NHẬT THÔNG TIN NHÀ CUNG CẤP</h2>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>Tên nhà cung cấp <span class="text-danger">*</span></label>
                                            <input type="text" name="tenNCC" placeholder="Nhập tên nhà cung cấp" class="form-control" value="<?php echo $_POST['tenNCC'] ?? $row['tenNCC']; ?>"/>
                                        </div>
                                        <div class="form-group form-group-default">
                                            <label>Số điện thoại <span class="text-danger">*</span></label>
                                            <input type="text" name="soDienThoai" placeholder="Nhập số điện thoại nhà cung cấp" class="form-control" value="<?php echo $_POST['soDienThoai'] ?? $row['soDienThoai']; ?>"/>
                                        </div>
                                        <div class="form-group form-group-default">
                                            <label>Email <span class="text-danger">*</span></label>
                                            <input type="email" name="email" placeholder="Nhập email nhà cung cấp" class="form-control" value="<?php echo $_POST['email'] ?? $row['email']; ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default text-center">
                                            <label>Hình ảnh nhà cung cấp<span class="text-danger">*</span></label>
                                            <?php if ($row['Images']): ?>
                                                <img src='<?php echo $base_url; ?>/Images/<?php echo $row['Images']; ?>' alt='Hình ảnh đại diện' width="200" class='img-fluid mb-3 mt-3'>
                                                <div>Tên hình ảnh: <strong><?php echo $row['Images']; ?></strong></div>
                                            <?php else: ?>
                                                <div>Không có hình ảnh hiện tại.</div>
                                            <?php endif; ?>
                                            <div class="input-group">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-9">
                                                            <!-- input hiển thị tên hình ảnh, được điền giá trị bằng cách kiểm tra trạng thái của tệp đã chọn -->
                                                            <input type="text" name="hinhAnh" id="hinhAnh" class="form-control" style="text-align: center;" readonly value="<?php echo $_POST['fileInput'] ?? $row['Images']; ?>">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <!-- input kiểu file để người dùng chọn hình ảnh, mặc định là ẩn -->
                                                            <input type="file" name="fileInput" id="fileInput" accept="image/*" onchange="layAnh(event)" style="display: none;"/>
                                                            <!-- Nút tải ảnh, khi nhấn trường input file ẩn để chọn hình ảnh -->

                                                            <button type="button" class="btn btn-secondary" onclick="document.getElementById('fileInput').click()">Chọn ảnh</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group text-center">
                                    <button type="submit" name="capNhat" class="btn btn-primary">Cập nhật</button>
                                    <a href="<?php echo $base_url?>/admin/nha_cung_cap/hienthi.php" class="btn btn-danger btnBack">Quay lại</a>
                                </div>
                                <div class="form-group text-center">
                                    <?php echo $msg ?>
                                </div>
                            </div>
                        </form>
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