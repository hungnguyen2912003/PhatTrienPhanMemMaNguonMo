<?php
// Khai báo đường dẫn
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
include('../thoihanSession.php');
include('../includes/header.html');
include('../menu.html');
include('../includes/footer.html');

//Phân trang
$rowsPerPage = 10;
if (!isset($_GET['page'])) {
    $_GET['page'] = 1;
}
$offset = ($_GET['page']-1) * $rowsPerPage;

// Kết nối vào cơ sở dữ liệu
$connect = mysqli_connect("localhost", "root", "", "qlbandienthoai")
OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error());

// Kiểm tra xem có tìm kiếm hay không
if (isset($_POST['btnTimKiem'])) {
    $str = trim($_POST['searchtext']); // Lấy nội dung từ ô tìm kiếm
    if (!empty($str)) {
        // Nếu tìm kiếm không rỗng, chạy truy vấn tìm kiếm
        $sql = "SELECT 
                    user.id AS ID, 
                    user.username AS tenTaiKhoan, 
                    user.user_id AS maNV, 
                    nv.phanQuyen AS phanQuyen, 
                    CONCAT(nv.hoNV, ' ', nv.tenlot, ' ', nv.tenNV) AS hoTen 
                FROM user 
                JOIN nhan_vien nv ON user.user_id = nv.id 
                WHERE LOWER(CONCAT(nv.hoNV, ' ', nv.tenlot, ' ', nv.tenNV)) LIKE '%$str%'
                   OR LOWER(user.username) LIKE '%$str%'
                   OR LOWER(user.user_id) LIKE '%$str%'
                   OR LOWER(nv.phanQuyen) LIKE '%$str%'";
        $result = mysqli_query($connect, $sql);

        // Hiển thị thông báo
        if (mysqli_num_rows($result) > 0) {
            $_SESSION['msg'] = "<span class='text-success font-weight-bold'>Tìm thấy kết quả có từ khóa: '$str'</span>";
        } else {
            $_SESSION['msg'] = "<span class='text-danger font-weight-bold'>Không tìm thấy kết quả cho từ khóa: '$str'</span>";
        }
    } else {
        // Nếu ô tìm kiếm rỗng, sử dụng truy vấn phân trang
        $_SESSION['msg'] = "<span class='text-warning font-weight-bold'>Vui lòng nhập từ khóa để tìm kiếm!</span>";
        $sql = "SELECT 
                    user.id AS ID, 
                    user.username AS tenTaiKhoan, 
                    user.user_id AS maNV, 
                    nv.phanQuyen AS phanQuyen, 
                    CONCAT(nv.hoNV, ' ', nv.tenlot, ' ', nv.tenNV) AS hoTen 
                FROM user 
                JOIN nhan_vien nv ON user.user_id = nv.id 
                LIMIT $offset, $rowsPerPage";
        $result = mysqli_query($connect, $sql);
    }
} else {
    // Không nhấn nút tìm kiếm, sử dụng truy vấn phân trang mặc định
    $sql = "SELECT 
                user.id AS ID, 
                user.username AS tenTaiKhoan, 
                user.user_id AS maNV, 
                nv.phanQuyen AS phanQuyen, 
                CONCAT(nv.hoNV, ' ', nv.tenlot, ' ', nv.tenNV) AS hoTen 
            FROM user 
            JOIN nhan_vien nv ON user.user_id = nv.id 
            LIMIT $offset, $rowsPerPage";
    $result = mysqli_query($connect, $sql);
}


?>
<?php if(isset($_SESSION['phanQuyen']) && $_SESSION['phanQuyen'] == 'ADMIN'):?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Quản lý phân quyền</title>
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
    </head>
    <body>
    <div class="main-panel">
        <div class="content">
            <div class="page-inner">
                <div class="page-header">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="page-title">Danh mục tài khoản</h4>
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
                                        <a href="<?php echo $base_url?>/admin/tai_khoan/hienthi.php">Danh mục tài khoản</a>
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
                                <div class="col-md-6">

                                </div>
                                <div class="offset-3 col-md-6">
                                    <form action="" method="post">
                                        <div class="input-group input-group-sm">
                                            <input type="text" name="searchtext" class="form-control custom-textbox" placeholder="Nhập thông tin tài khoản bạn muốn tìm kiếm" value="<?php if(isset($_POST['searchtext'])) echo $_POST['searchtext'];?>"/>
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
                                        <th>Tên đăng nhập</th>
                                        <th>Mã nhân viên</th>
                                        <th>Họ tên nhân viên</th>
                                        <th>Phân quyền</th>
                                        <th>Chức năng</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $stt = $offset + 1;
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr>";
                                        echo "<td class='text-center'>$stt</td>";
                                        echo "<td class='text-center'>{$row['tenTaiKhoan']}</td>";
                                        echo "<td class='text-center'>{$row['maNV']}</td>";
                                        echo "<td class='text-center'>{$row['hoTen']}</td>";
                                        // Kiểm tra phân quyền và hiển thị tương ứng
                                        $phanQuyen = $row['phanQuyen'];
                                        if ($phanQuyen == 'ADMIN')
                                            $phanQuyenShow = 'Admin';
                                        elseif ($phanQuyen == 'NV')
                                            $phanQuyenShow = 'Nhân viên';
                                        echo "<td class='text-center'>$phanQuyenShow</td>";
                                        echo "<td class='text-center'>
                                            <a href='$base_url/admin/tai_khoan/chitiet.php?id={$row['ID']}' class='btn btn-xs btn-warning text-white'><i class='fa-solid fa-circle-info'></i></a>
                                            <a href='$base_url/admin/tai_khoan/chinhsua.php?id={$row['ID']}' class='btn btn-xs btn-primary'><i class='fa-solid fa-pen-to-square'></i></a>
                                            <a href='$base_url/admin/tai_khoan/xoa.php?id={$row['ID']}' class='btn btn-xs btn-danger'><i class='fa-solid fa-trash-can'></i></a>
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
                                            $re = mysqli_query($connect, "SELECT user.id 
                                                FROM user 
                                                JOIN nhan_vien nv ON user.user_id = nv.id");
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
            function hideMessage() {
                $('.message-container').fadeOut(); // Ẩn thông báo sau khi hiển thị một thời gian
            }
            if ($('.message-container').length) { // Nếu có thông báo
                setTimeout(hideMessage, 5000); // Đặt thời gian ẩn thông báo sau 5 giây
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