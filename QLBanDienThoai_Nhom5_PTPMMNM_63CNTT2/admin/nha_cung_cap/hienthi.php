<?php
include('../thoihanSession.php');
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
include('../includes/header.html');
include('../menu.html');
include('../includes/footer.html');

// Kết nối vào cơ sở dữ liệu
$connect = mysqli_connect("localhost", "root", "", "qlbandienthoai")
OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error());

// Kiểm tra nếu có giá trị tìm kiếm
$searchText = isset($_GET['Searchtext']) ? $_GET['Searchtext'] : '';

// Truy vấn tìm kiếm với điều kiện nếu có từ khóa tìm kiếm
$sql = "SELECT * FROM nha_cung_cap WHERE tenNCC LIKE '%$searchText%'";

// Gửi truy vấn đến cơ sở dữ liệu
$result = mysqli_query($connect, $sql);

// Xử lý tìm kiếm
$searchResult = false; // Biến kiểm tra kết quả tìm kiếm
if(isset($_POST['timKiem'])){
    $str = trim($_POST['searchtext']);
    $_SESSION['msg'] = "<span class='text-warning font-weight-bold'>Vui lòng nhập từ khóa để tìm kiếm!</span>";
    if (empty($str)) {
        // Nếu input tìm kiếm rỗng, lấy tất cả sản phẩm
        $sql = "SELECT * FROM nha_cung_cap";
        $result = mysqli_query($connect, $sql);
    } else {
        // Truy vấn tìm kiếm
        $sql = "SELECT * FROM nha_cung_cap WHERE LOWER(tenNCC) LIKE LOWER('%$str%') ";
        $result = mysqli_query($connect, $sql);

        // Kiểm tra nếu câu truy vấn thành công và có kết quả
        if ($result && mysqli_num_rows($result) > 0) {
            $_SESSION['msg'] = "<span class='text-success font-weight-bold'>Tìm thấy kết quả tên có từ khoá: '$str'</span>";
            $searchResult = true; // Đặt biến kiểm tra kết quả tìm kiếm là true
        } else {
            $_SESSION['msg'] = "<span class='text-danger font-weight-bold'>Không tìm thấy kết quả cho từ khoá: '$str'</span>";
            $searchResult = false; // Đảm bảo không hiển thị kết quả không hợp lệ
        }
    }
}
?>


<?php if(isset($_SESSION['phanQuyen']) && $_SESSION['phanQuyen'] == 'ADMIN' || isset($_SESSION['phanQuyen']) && $_SESSION['phanQuyen'] == 'NV'):?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quản lý nhà cung cấp</title>
    <style>
        .custom-textbox {
            height: 50px;
            border: 2px solid #0094ff;
        }
    </style>
</head>
<body>
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="page-title">Danh mục nhà cung cấp</h4>
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
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card h-100">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card-tools">
                                    <a href="<?php echo $base_url?>/admin/nha_cung_cap/themmoi.php" class="btn btn-rounded btn-primary">Thêm mới</a>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <form action="" method="post">
                                    <div class="input-group input-group-sm">
                                        <input type="text" name="searchtext" class="form-control custom-textbox" placeholder="Nhập thông tin nhà cung cấp bạn muốn tìm kiếm" value="<?php if(isset($_POST['searchtext'])) echo $_POST['searchtext'];?>"/>
                                        <span class="input-group-append">
                                            <button type="submit" name="timKiem" class="btn btn-info btn-flat">Tìm kiếm</button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="message-container text-center">
                            <!-- Hiển thị dòng thông báo -->
                            <?php
                            if (isset($_SESSION['msg']))
                            {
                                echo $_SESSION['msg'];
                                // Sau khi hiển thị, xóa thông báo để không hiển thị lại sau khi tải lại trang
                                unset($_SESSION['msg']);
                            }
                            ?>
                        </div>
                        <div class="table-responsive">
                            <table id="multi-filter-select" class="display table table-striped table-hover table-bordered">
                                <thead>
                                <tr class="text-center">
                                    <th>STT</th>
                                    <th>Mã nhà cung cấp</th>
                                    <th>Tên nhà cung cấp</th>
                                    <th>Hình ảnh</th>
                                    <th>Hotline</th>
                                    <th>Email</th>
                                    <th>Chức năng</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $stt = 1;
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td class='text-center'>$stt</td>";
                                    echo "<td class='text-center'>{$row['id']}</td>";
                                    echo "<td class='text-center'>{$row['tenNCC']}</td>";
                                    echo "<td class='text-center'><img width='80' src='$base_url/Images/{$row['Images']}'/></td>";
                                    echo "<td class='text-center'>{$row['soDienThoai']}</td>";
                                    echo "<td class='text-center'>{$row['email']}</td>";
                                    echo "<td class='text-center'>
                                            <a href='$base_url/admin/nha_cung_cap/chitiet.php?id={$row['id']}' class='btn btn-xs btn-warning text-white'><i class='fa-solid fa-circle-info'></i></a>
                                            <a href='$base_url/admin/nha_cung_cap/chinhsua.php?id={$row['id']}' class='btn btn-xs btn-primary'><i class='fa-solid fa-pen-to-square'></i></a>
                                            <a href='$base_url/admin/nha_cung_cap/xoa.php?id={$row['id']}' class='btn btn-xs btn-danger'><i class='fa-solid fa-trash-can'></i></a>
                                        </td>";
                                    echo "</tr>";
                                    $stt++;
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

    <script>
        $(document).ready(function () {
            // Hàm để ẩn thông báo sau 5 giây
            function hideMessage() {
                $('.message-container').fadeOut(); // Ẩn thông báo
            }
            // Nếu có thông báo, thiết lập timeout để tự động ẩn sau 5 giây
            if ($('.message-container').length) {
                setTimeout(hideMessage, 5000); // 5000 milliseconds = 5 seconds
            }
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