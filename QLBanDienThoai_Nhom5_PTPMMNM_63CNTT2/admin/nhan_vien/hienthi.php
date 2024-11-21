<?php
include('../thoihanSession.php');
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
include('../includes/header.html');
include('../menu.html');
include('../includes/footer.html');

//Kết nối cơ sở dữ liệu
$connect = mysqli_connect("localhost", "root", "", "qlbandienthoai")
OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error());

//Phân trang
$rowsPerPage = 5;
if (!isset($_GET['page'])) {
    $_GET['page'] = 1;
}
$offset = ($_GET['page']-1) * $rowsPerPage;

/////////////////////////////////////////////////////////////
/// Xử lý tìm kiếm
// Nếu người dùng nhấn nút tìm kiếm
if (isset($_POST['btnTimKiem'])) {
    $str = trim($_POST['searchtext']);
    if (empty($str)) {
        // Nếu input tìm kiếm rỗng, lấy tất cả nhân viên
        $_SESSION['msg'] = "<span class='text-warning font-weight-bold'>Vui lòng nhập từ khóa để tìm kiếm!</span>";
        $sql = "SELECT *,CONCAT(nhan_vien.hoNV, ' ', nhan_vien.tenlot, ' ', nhan_vien.tenNV) AS hoTen 
                FROM nhan_vien LIMIT $offset, $rowsPerPage";
        $result = mysqli_query($connect, $sql);
    } else {
        // Truy vấn tìm kiếm
        $sql = "SELECT *, CONCAT(nhan_vien.hoNV, ' ', nhan_vien.tenlot, ' ', nhan_vien.tenNV) AS hoTen 
                FROM nhan_vien 
                WHERE LOWER(CONCAT(nhan_vien.hoNV, ' ', nhan_vien.tenlot, ' ', nhan_vien.tenNV)) LIKE LOWER('%$str%')";
        $result = mysqli_query($connect, $sql);

        // Kiểm tra nếu không có kết quả tìm kiếm
        if (mysqli_num_rows($result) != 0) {
            $_SESSION['msg'] = "<span class='text-success font-weight-bold'>Tìm thấy kết quả họ tên có từ khoá: '$str'</span>";
        } else {
            $_SESSION['msg'] = "<span class='text-danger font-weight-bold'>Không tìm thấy kết quả cho từ khoá: '$str'</span>";
        }
    }
}
else {
    // Nếu không tìm kiếm thì lấy toàn bộ danh sách
    $sql = "SELECT *, CONCAT(nhan_vien.hoNV, ' ', nhan_vien.tenlot, ' ', nhan_vien.tenNV) AS hoTen FROM nhan_vien LIMIT $offset, $rowsPerPage";
    $result = mysqli_query($connect, $sql);
}

?>

<?php if(isset($_SESSION['phanQuyen']) && $_SESSION['phanQuyen'] == 'ADMIN'):?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Quản lý nhân viên</title>
    </head>
    <body>
    <style>
        .custom-textbox {
            height: 50px;
            border: 2px solid #0094ff;
        }
        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }

        .pagination a, .pagination b {
            display: inline-block;
            padding: 6px 12px;
            margin: 5px;
            text-align: center;
            text-decoration: none;
            color: #fff;
            background-color: #007bff;
            border-radius: 20px; /* Tạo bo tròn cho nút */
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .pagination a:hover {
            background-color: #0056b3; /* Màu khi hover */
        }

        .pagination b {
            background-color: #0056b3; /* Màu của trang hiện tại */
            color: #ffffff;
        }
    </style>
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="page-header">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="page-title">Danh sách nhân viên</h4>
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
                                        <a href="<?php echo $base_url?>/admin/nhan_vien/hienthi.php">Danh sách nhân viên</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card h-100" >
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card-tools">
                                        <a href="<?php echo $base_url?>/admin/nhan_vien/themmoi.php" class="btn btn-rounded btn-primary">Thêm mới</a>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <form action="" method="post">
                                        <div class="input-group input-group-sm">
                                            <input type="text" name="searchtext" class="form-control custom-textbox" placeholder="Nhập họ tên nhân viên bạn muốn tìm kiếm" value="<?php if(isset($_POST['searchtext'])) echo $_POST['searchtext'];?>"/>
                                            <span class="input-group-append">
                                            <button type="submit" name="btnTimKiem" class="btn btn-info btn-flat">Tìm kiếm</button>
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
                                        <th>Mã nhân viên</th>
                                        <th>Họ tên nhân viên</th>
                                        <th>Hình ảnh</th>
                                        <th>Ngày sinh</th>
                                        <th>Giới tính</th>
                                        <th>Số điện thoại</th>
                                        <th>Chức năng</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $stt = $offset + 1;
                                    while($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td class='text-center'>$stt</td>";
                                        echo "<td class='text-center'>{$row['id']}</td>";
                                        echo "<td class='text-center'>{$row['hoTen']}</td>";
                                        echo "<td class='text-center'><img width='80' src='$base_url/Images/{$row['Images']}'/></td>";
                                        echo "<td class='text-center'>" . date("d/m/Y", strtotime($row['ngaySinh'])) . "</td>";
                                        echo "<td class='text-center'>" . ($row['gioiTinh'] == 1 ? 'Nam' : 'Nữ') . "</td>";
                                        echo "<td class='text-center'>{$row['soDienThoai']}</td>";
                                        echo "<td class='text-center'>
                                                <a href='$base_url/admin/nhan_vien/chitiet.php?manv={$row['id']}' class='btn btn-xs btn-warning text-white'><i class='fa-solid fa-circle-info'></i></a>
                                                <a href='$base_url/admin/nhan_vien/chinhsua.php?manv={$row['id']}' class='btn btn-xs btn-primary'><i class='fa-solid fa-pen-to-square'></i></a>
                                                <a href='$base_url/admin/nhan_vien/xoa.php?manv={$row['id']}' class='btn btn-xs btn-danger'><i class='fa-solid fa-trash-can'></i></a>
                                              </td>";
                                        echo "</tr>";
                                        $stt++;
                                    }
                                    ?>
                                    </tbody>
                                </table>
                                <?php if (!isset($_POST['btnTimKiem']) || empty($_POST['searchtext'])): ?>
                                    <div class="pagination-container">
                                        <div class="pagination">
                                            <?php
                                            $re = mysqli_query($connect, 'SELECT * FROM nhan_vien');
                                            //$numRows: Số lượng bản ghi trong cơ sở dữ liệu (toàn bộ bản ghi từ bảng nhan_vien).
                                            $numRows = mysqli_num_rows($re);
                                            $maxPage = ceil($numRows / $rowsPerPage);
                                            //Trang hiện tại mà người dùng đang xem, được lấy từ $_GET['page'].
                                            $currentPage = $_GET['page'];
                                            if ($currentPage > 1) {
                                                echo "<a href='" . $_SERVER['PHP_SELF'] . "?page=1'>Trang đầu</a>";
                                                echo "<a href='" . $_SERVER['PHP_SELF'] . "?page=" . ($currentPage - 1) . "'>Trang trước</a>";
                                            }
                                            $pagesPerSet = 5;
                                            $currentSet = ceil($_GET['page'] / $pagesPerSet);
                                            $startPage = ($currentSet - 1) * $pagesPerSet + 1;
                                            $endPage = min($startPage + $pagesPerSet - 1, $maxPage);
                                            if ($startPage > 1) {
                                                echo "<a href='" . $_SERVER['PHP_SELF'] . "?page=" . ($startPage - 1) . "'>...</a> ";
                                            }
                                            for ($i = $startPage; $i <= $endPage; $i++) {
                                                if ($i == $currentPage) {
                                                    echo "<b>$i</b> ";
                                                } else {
                                                    echo "<a href='" . $_SERVER['PHP_SELF'] . "?page=" . $i . "'>$i</a> ";
                                                }
                                            }

                                            //$endPage < $maxPage: Nếu trang cuối cùng trong nhóm không phải là trang cuối cùng toàn cục, hiển thị dấu ... để người dùng biết có thêm trang phía sau.
                                            if ($endPage < $maxPage) {
                                                echo "<a href='" . $_SERVER['PHP_SELF'] . "?page=" . ($endPage + 1) . "'>...</a> ";
                                            }

                                            // Hiển thị "Trang sau" và "Trang cuối"
                                            if ($currentPage < $maxPage) {
                                                echo "<a href='" . $_SERVER['PHP_SELF'] . "?page=" . ($currentPage + 1) . "'>Trang sau</a>";
                                                echo "<a href='" . $_SERVER['PHP_SELF'] . "?page=$maxPage'>Trang cuối</a>";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
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
                setTimeout(hideMessage, 10000); // 5000 milliseconds = 5 seconds
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
