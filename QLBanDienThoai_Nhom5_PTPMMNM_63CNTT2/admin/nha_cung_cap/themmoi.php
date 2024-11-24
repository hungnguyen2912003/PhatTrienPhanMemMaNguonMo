<?php
include('../thoihanSession.php');
// Khai báo đường dẫn
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
// Bao gồm các file giao diện chung như header, sidebar và footer
include('../includes/header.html');
include('../menu.html');
include('../includes/footer.html');

// Kết nối cơ sở dữ liệu
$connect = mysqli_connect("localhost", "root", "", "qlbandienthoai")
OR die('Không thể kết nối MySQL: ' . mysqli_connect_error()); // Kết nối vào cơ sở dữ liệu và hiển thị thông báo lỗi nếu không kết nối được

$msg = "";
$tenNCC = "";
$email = "";
$soDienThoai = "";
$diaChi = "";
$webSite = "";
$hinhAnh = "";
$maNCC = rand(10000000, 99999999); // Tạo mã nhà cung cấp ngẫu nhiên từ 8 chữ số.

if (isset($_POST["themMoi"])) { // Kiểm tra nếu form được gửi với nút "Thêm mới" được nhấn.
    // Lấy tên ncc, email, sdt, tên file hình ảnh từ form.
    $tenNCC = $_POST["tenNhaCungCap"];
    $email = $_POST["email"];
    $soDienThoai = $_POST["soDienThoai"];
    $diaChi = $_POST["diaChi"];
    $webSite = $_POST["webSite"];
    $hinhAnh = $_FILES['Images']['name'];
    // Kiểm tra nếu các trường thông tin không trống.
    if (!empty($tenNCC) && !empty($email) && !empty($soDienThoai) && !empty($diaChi) && !empty($webSite) && !empty($hinhAnh)) {
        if (!preg_match("/^\d{8,11}$/", $soDienThoai)) { // Kiểm tra số điện thoại có đúng 8-11 chữ số.
            $msg = "<span class='text-danger font-weight-bold'>Số điện thoại phải bao gồm từ 8 đến 11 chữ số.</span>"; // Thông báo lỗi.
        } else {
            $check_maNCC = mysqli_query($connect, "SELECT * FROM nha_cung_cap WHERE id = '$maNCC'"); // Kiểm tra mã nhà cung cấp có trùng không.
            if (mysqli_num_rows($check_maNCC) != 0) { // Nếu mã nhà cung cấp đã tồn tại.
                $msg = "<span class='text-danger font-weight-bold'>Đã có mã nhà cung cấp này. Vui lòng thử lại.</span>"; // Thông báo lỗi.
            } else {
                // Kiểm tra hình ảnh
                // Lấy tên file, kích thước, đường dẫn tạm
                $file_name = $_FILES['Images']['name'];
                $file_size = $_FILES['Images']['size'];
                $file_tmp = $_FILES['Images']['tmp_name'];
                $array = explode('.', $file_name); // Tách tên file để lấy phần đuôi.
                $file_ext = strtolower(end($array)); // Lấy phần đuôi file và chuyển về chữ thường.
                $expensions = array("jpeg", "jpg", "png"); // Các đuôi file hình ảnh hợp lệ.

                if (!in_array($file_ext, $expensions)) { // Kiểm tra nếu đuôi file không hợp lệ.
                    $msg = "<span class='text-danger font-weight-bold'>Đuôi file hình ảnh không hợp lệ. Chỉ chấp nhận cái đuôi file: jpeg, jpg, png, gif</span>"; // Thông báo lỗi.
                } elseif ($file_size > 2097152) { // Kiểm tra nếu kích thước file lớn hơn 2MB.
                    $msg = "<span class='text-danger font-weight-bold'>Hình ảnh không được quá 2MB!</span>"; // Thông báo lỗi.
                } else {
                    move_uploaded_file($file_tmp, $_SERVER['DOCUMENT_ROOT'] . "\\QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2\\Images\\" . $file_name);// Di chuyển file hình ảnh đến thư mục lưu trữ.
                    $sql = "INSERT INTO nha_cung_cap (id, tenNCC, soDienThoai, email, diaChi,webSite, Images) VALUES ('$maNCC', '$tenNCC', '$soDienThoai', '$email','$diaChi', '$webSite', '$hinhAnh')"; // Chuẩn bị câu lệnh SQL để chèn dữ liệu vào cơ sở dữ liệu.
                    if (mysqli_query($connect, $sql)) { // Thực hiện câu lệnh SQL.
                        $_SESSION['msg'] = "<span class='text-success font-weight-bold'>Thêm mới nhà cung cấp $tenNCC thành công!</span>"; // Thông báo thành công.
                        echo "<script>window.location.href = '$base_url/admin/nha_cung_cap/hienthi.php';</script>"; // Chuyển hướng trang.
                    } else {
                        $msg = "<span class='text-danger font-weight-bold'>Đã xảy ra lỗi khi thêm mới: " . mysqli_error($connect) . "</span>"; // Thông báo lỗi thêm mới.
                    }
                }
            }
            mysqli_free_result($check_maNCC); // Giải phóng bộ nhớ kết quả truy vấn.
        }
    } else {
        $msg = "<span class='text-danger font-weight-bold'>Các trường bắt buộc không được để trống. Vui lòng nhập đầy đủ thông tin!</span>"; // Thông báo nếu bỏ trống thông tin.
    }
}
mysqli_close($connect); // Đóng kết nối cơ sở dữ liệu.
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
                            <h4 class="page-title">Thêm mới nhà cung cấp</h4>
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
                                    <a href="<?php echo $base_url?>/admin/nha_cung_cap/themmoi.php">Thêm mới</a>
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
                                        <h2 class="text-center m-3" style="font-weight: bold;">THÊM MỚI NHÀ CUNG CẤP</h2>
                                    </div>
                                    <div class="col-md-12 text-center">
                                        <div class="offset-3 col-md-6 offset-3 text-center">
                                            <div class="form-group form-group-default">
                                                <label>Mã nhà cung cấp <span class="text-danger">*</span></label>
                                                <input type="text" name="maNCC" class="form-control text-center" value="<?php echo $maNCC; ?>" readonly/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>Tên nhà cung cấp <span class="text-danger">*</span></label>
                                            <input type="text" name="tenNhaCungCap" placeholder="Nhập tên nhà cung cấp" class="form-control" value="<?php echo $tenNCC; ?>"/>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Hotline <span class="text-danger">*</span></label>
                                                    <input type="text" name="soDienThoai" placeholder="Nhập hotline nhà cung cấp" class="form-control" value="<?php echo $soDienThoai; ?>"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Email <span class="text-danger">*</span></label>
                                                    <input type="email" name="email" placeholder="Nhập email nhà cung cấp" class="form-control" value="<?php echo $email; ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group form-group-default">
                                            <label>Địa chỉ <span class="text-danger">*</span></label>
                                            <input type="text" name="diaChi" placeholder="Nhập địa chỉ nhà cung cấp" class="form-control" value="<?php echo $diaChi; ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>Hình ảnh nhà cung cấp <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-9">
                                                            <!-- input hiển thị tên hình ảnh, được điền giá trị bằng cách kiểm tra trạng thái của tệp đã chọn -->
                                                            <input type="text" name="hinhAnh" id="hinhAnh" class="form-control"
                                                                   value="<?php if (isset($_FILES['Images']) && $_FILES['Images']['error'] == 0) echo $_FILES['Images']['name']; else echo 'Chưa thêm hình ảnh'; ?>" style="text-align: center;" readonly />
                                                        </div>
                                                        <div class="col-md-3">
                                                            <!-- input kiểu file để người dùng chọn hình ảnh, mặc định là ẩn -->
                                                            <input type="file" id="fileInput" name="Images" accept="image/*" onchange="layAnh(event)" style="display: none;" />
                                                            <!-- Nút tải ảnh, khi nhấn trường input file ẩn để chọn hình ảnh -->
                                                            <button style="width: 80px;" type="button" class="btn btn-secondary" onclick="document.getElementById('fileInput').click()">Tải ảnh</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group form-group-default">
                                            <label>Website <span class="text-danger">*</span></label>
                                            <input type="text" name="webSite" placeholder="Nhập website nhà cung cấp" class="form-control" value="<?php echo $webSite; ?>"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 text-center">
                                    <button type="submit" name="themMoi" class="btn btn-success mt-3">Thêm mới</button>
                                    <a href="<?php echo $base_url?>/admin/nha_cung_cap/hienthi.php" class="btn btn-danger btnBack mt-3">Quay lại</a>
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