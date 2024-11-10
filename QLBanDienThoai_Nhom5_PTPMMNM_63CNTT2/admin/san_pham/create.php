<?php
include('../timeOutSession.php');
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
$maSP = rand(10000000, 99999999);

if (isset($_POST["themMoi"])) {
    $tenSP = $_POST["ten_sp"];
    $supplierID = $_POST["ma_ncc"];
    $soLuong = $_POST["soLuong"];
    $giaBan = $_POST["giaBan"];
    $moTa = $_POST["moTa"];
    $hinhAnh = $_POST["hinhAnh"];
    // Kiểm tra các trường bắt buộc và điều kiện số lượng và giá bán
    if (!empty($tenSP) && !empty($supplierID) && !empty($soLuong) && !empty($giaBan) && !empty($moTa) && !empty($hinhAnh)) {
        if(!(ctype_digit($soLuong) || $soLuong < 0))
            $msg = "<span class='text-danger font-weight-bold'>Số lượng sản phẩm phải là con số nguyên lớn hơn 0. Vui lòng nhập lại!</span>";
        // Kiểm tra xem số lượng và giá bán có lớn hơn 0 không
        elseif (!(is_numeric($giaBan) || $giaBan < 0)) {
            $msg = "<span class='text-danger font-weight-bold'>Giá bán phải là số lớn hơn 0. Vui lòng nhập lại!</span>";
        }
        else {
            $check_maSP = mysqli_query($connect, "SELECT * FROM san_pham WHERE ma_sp = '$maSP'");
            if (mysqli_num_rows($check_maSP) != 0) {
                $msg = "<span class='text-danger font-weight-bold'>Đã có mã sản phẩm này rồi. Vui lòng thử lại.</span>";
            } else {

                // Thực hiện truy vấn INSERT vào bảng sản phẩm
                $sql = "INSERT INTO san_pham (ma_sp, ma_ncc, ten_sp, hinhAnh, moTa, soLuong, giaBan) VALUES ('$maSP', '$supplierID', '$tenSP', '$hinhAnh', '$moTa', '$soLuong', '$giaBan')";
                if (mysqli_query($connect, $sql)) {
                    $_SESSION['msg'] = "<span class='text-success font-weight-bold'>Thêm mới sản phẩm $tenSP thành công!</span>";
                    echo "<script>window.location.href = '$base_url/admin/san_pham/index.php';</script>";
                } else {
                    $_SESSION['msg'] = "<span class='text-danger font-weight-bold'>Đã xảy ra lỗi khi thêm mới!</span>";
                    echo "<script>window.location.href = '$base_url/admin/san_pham/index.php';</script>";
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

                                                <div class="form-group form-group-default">
                                                    <label>Mô tả</label>
                                                    <textarea name="moTa" placeholder="Nhập mô tả" class="form-control" style="resize: none; overflow: scroll" rows="5" ><?php echo $moTa; ?></textarea>
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