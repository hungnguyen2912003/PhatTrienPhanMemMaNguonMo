<?php
include '../checkSession.php';
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
include('../includes/header.html');
include('../_PartialSideBar.html');
include('../includes/footer.html');

// Kết nối cơ sở dữ liệu
$connect = mysqli_connect("localhost", "root", "", "qlbandienthoai")
OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error());

// Lấy mã ncc từ URL
$maNCC = $_GET['id'];
$msg = "";

if (isset($_POST["capNhat"])) {
    $tenNCC = $_POST["tenNhaCungCap"];
    $email = $_POST["email"];
    $soDienThoai = $_POST["soDienThoai"];
    $hinhAnh = $_POST["hinhAnh"];
    // Kiểm tra các trường bắt buộc
    if (!empty($tenNCC) && !empty($email) && !empty($soDienThoai) && !empty($hinhAnh)) {
        if (!preg_match("/^\d{8,11}$/", $soDienThoai)) {
            $msg = "<span class='text-danger font-weight-bold'>Số điện thoại phải bao gồm từ 8 đến 11 chữ số.</span>";
        } else {
            // Cập nhật thông tin nhà cung cấp
            $sql = "UPDATE nha_cung_cap SET tenNCC='$tenNCC', soDienThoai='$soDienThoai', email='$email', Images='$hinhAnh' WHERE id='$maNCC'";
            if (mysqli_query($connect, $sql)) {
                $_SESSION['msg'] = "<span class='text-success font-weight-bold'>Cập nhật thông tin nhà cung cấp $tenNCC thành công!</span>";
                echo "<script>window.location.href = '$base_url/admin/nha_cung_cap/index.php';</script>";
            } else {
                $_SESSION['msg'] = "<span class='text-danger font-weight-bold'>Đã xảy ra lỗi khi cập nhật!</span>";
                echo "<script>window.location.href = '$base_url/admin/nha_cung_cap/index.php';</script>";
            }
        }
    } else {
        $msg = "<span class='text-danger font-weight-bold'>Các trường bắt buộc không được để trống. Vui lòng nhập đầy đủ thông tin!</span>";
    }
}

// Truy vấn thông tin nhà cung cấp theo mã
$sql = "SELECT * FROM nha_cung_cap WHERE id = $maNCC";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thêm mới nhà cung cấp</title>
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
                            <h4 class="page-title">Cập nhật thông tin nhà cung cấp</h4>
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
                                    <a href="<?php echo $base_url?>/admin/nha_cung_cap/index.php">Danh sách nhà cung cấp</a>
                                </li>
                                <li class="separator">
                                    <i class="flaticon-right-arrow"></i>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo $base_url?>/admin/nha_cung_cap/edit.php">Chỉnh sửa</a>
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
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2 class="text-center m-3" style="font-weight: bold;">CẬP NHẬT THÔNG TIN NHÀ CUNG CẤP</h2>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>Tên nhà cung cấp <span class="text-danger">*</span></label>
                                            <input type="text" name="tenNhaCungCap" placeholder="Nhập tên nhà cung cấp" class="form-control" value="<?php echo $row['tenNCC']; ?>"/>
                                        </div>
                                        <div class="form-group form-group-default">
                                            <label>Số điện thoại <span class="text-danger">*</span></label>
                                            <input type="text" name="soDienThoai" placeholder="Nhập số điện thoại nhà cung cấp" class="form-control" value="<?php echo $row['soDienThoai']; ?>"/>
                                        </div>
                                        <div class="form-group form-group-default">
                                            <label>Email <span class="text-danger">*</span></label>
                                            <input type="email" name="email" placeholder="Nhập email nhà cung cấp" class="form-control" value="<?php echo $row['email']; ?>"/>
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
                                                            <input type="text" name="hinhAnh" id="hinhAnh" class="form-control"
                                                                   value="<?php if(isset($row['Images'])) echo $row['Images']; else echo "Chưa thêm hình ảnh"?>" style="text-align: center;" readonly />
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input type="file" id="fileInput" accept="image/*" onchange="layAnh(event)" style="display: none;" />
                                                            <button style="width: 80px;" type="button" class="btn btn-secondary" onclick="document.getElementById('fileInput').click()">Tải ảnh</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group text-center">
                                    <button type="submit" name="capNhat" class="btn btn-primary">Cập nhật</button>
                                    <a href="<?php echo $base_url?>/admin/nha_cung_cap/index.php" class="btn btn-danger btnBack">Quay lại</a>
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
