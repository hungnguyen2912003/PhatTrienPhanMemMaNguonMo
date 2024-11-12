<?php
include('../thoihanSession.php');
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
include('../includes/header.html');
include('../menu.html');
include('../includes/footer.html');

//Kết nối cơ sở dữ liệu
$connect = mysqli_connect("localhost", "root", "", "qlbandienthoai")
OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error());

//Mỗi trang hiển thị 5 dữ liệu
$rowsPerPage = 5;

//Nếu tham số page trong URL chưa được set, nó sẽ được gán giá trị mặc định là 1, tức là trang đầu tiên.
if (!isset($_GET['page']))
{
    $_GET['page'] = 1;
}
//Xác định vị trí của bản ghi đầu tiên trong câu truy vấn SQL. Nó tính toán dựa trên số trang hiện tại và số bản ghi trên mỗi trang.
$offset =($_GET['page']-1)*$rowsPerPage;

// Lọc sản phẩm theo nhà cung cấp nếu có
if (isset($_POST['nha_cung_cap']) && !empty($_POST['nha_cung_cap'])) {
    $nhaCungCapId = $_POST['nha_cung_cap'];
    $sql = "SELECT * FROM san_pham WHERE ma_ncc = '$nhaCungCapId' LIMIT $offset, $rowsPerPage";
    $result = mysqli_query($connect, $sql);
} else {
    // Nếu không có nhà cung cấp được chọn thì lấy tất cả sản phẩm
    $sql = "SELECT * FROM san_pham LIMIT $offset, $rowsPerPage";
    $result = mysqli_query($connect, $sql);
}

// Xử lý tìm kiếm
$searchResult = false; // Biến kiểm tra kết quả tìm kiếm
if (isset($_POST['btnTimKiem'])) {
    $str = trim($_POST['searchtext']);
    if (empty($str)) {
        // Nếu input tìm kiếm rỗng, lấy tất cả sản phẩm
        $sql = "SELECT * FROM san_pham LIMIT $offset, $rowsPerPage";
        $result = mysqli_query($connect, $sql);
    } else {
        // Truy vấn tìm kiếm
        $sql = "SELECT * FROM san_pham WHERE LOWER(ten_sp) LIKE LOWER('%$str%') LIMIT $offset, $rowsPerPage";
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
    <title>Quản lý sản phẩm</title>
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
    <!-- Main content -->
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="page-title">Danh sách sản phẩm</h4>
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
                                    <a href="<?php echo $base_url?>/admin/san_pham/hienthi.php">Danh mục sản phẩm</a>
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
                            <div class="col-md-2">
                                <div class="card-tools">
                                    <a href="<?php echo $base_url?>/admin/san_pham/themmoi.php" class="btn btn-rounded btn-primary">Thêm mới</a>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <form action="" method="post">
                                    <select name="nha_cung_cap" id="nha_cung_cap" class="form-control p-2" >
                                        <option value="">Chọn nhà cung cấp</option>
                                        <?php
                                        // Truy vấn dữ liệu nhà cung cấp từ cơ sở dữ liệu
                                        $sqlNhaCungCap = "SELECT * FROM nha_cung_cap";
                                        $resultNhaCungCap = mysqli_query($connect, $sqlNhaCungCap);

                                        // Lặp qua các nhà cung cấp và tạo các option
                                        while($rowNCC = mysqli_fetch_assoc($resultNhaCungCap)) {
                                            echo "<option value='{$rowNCC['id']}'>{$rowNCC['tenNCC']}</option>";
                                        }
                                        ?>
                                    </select>
                                </form>
                            </div>
                            <div class="col-md-5">
                                <form action="" method="post">
                                    <div class="input-group input-group-sm">
                                        <input type="text" name="searchtext" class="form-control custom-textbox" placeholder="Nhập thông tin sản phẩm bạn muốn tìm kiếm" value="<?php if(isset($_POST['searchtext'])) echo $_POST['searchtext'];?>"/>
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
                                    <th>Mã sản phẩm</th>
                                    <th>Tên sản phẩm</th>
                                    <th>Hình ảnh</th>
                                    <th>Số lượng</th>
                                    <th>Giá bán</th>
                                    <th>Chức năng</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $stt = $offset + 1;
                                // Lặp qua các hàng dữ liệu từ kết quả truy vấn
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td class='text-center'>$stt</td>";
                                    echo "<td class='text-center'>{$row['ma_sp']}</td>";
                                    echo "<td class='text-center'>{$row['ten_sp']}</td>";
                                    echo "<td class='text-center'><img width='80' src='$base_url/Images/{$row['hinhAnh']}'/></td>";
                                    echo "<td class='text-center'>{$row['soLuong']}</td>";
                                    echo "<td class='text-center'>{$row['giaBan']}</td>";
                                    echo "<td class='text-center'>
                                                <a href='$base_url/admin/san_pham/chitiet.php?ma_sp={$row['ma_sp']}' class='btn btn-xs btn-warning text-white'><i class='fa-solid fa-circle-info'></i></a>
                                                <a href='$base_url/admin/san_pham/chinhsua.php?ma_sp={$row['ma_sp']}' class='btn btn-xs btn-primary'><i class='fa-solid fa-pen-to-square'></i></a>
                                                <a href='$base_url/admin/san_pham/xoa.php?ma_sp={$row['ma_sp']}' class='btn btn-xs btn-danger'><i class='fa-solid fa-trash-can'></i></a>
                                              </td>";
                                    echo "</tr>";
                                    $stt++;
                                }
                                ?>
                                </tbody>
                            </table>
                            <?php if (!$searchResult) { // Ẩn phân trang nếu có kết quả tìm kiếm ?>
                                <div class="pagination-container">
                                    <div class="pagination">
                                        <?php
                                        $re = mysqli_query($connect, 'SELECT * FROM san_pham');
                                        //$numRows: Số lượng bản ghi trong cơ sở dữ liệu (toàn bộ bản ghi từ bảng san_pham).
                                        $numRows = mysqli_num_rows($re);
                                        //$maxPage: Số lượng trang tối đa, được tính bằng cách chia tổng số bản ghi cho số bản ghi trên mỗi trang, sau đó làm tròn lên bằng hàm ceil().
                                        $maxPage = ceil($numRows / $rowsPerPage);
                                        //Trang hiện tại mà người dùng đang xem, được lấy từ $_GET['page'].
                                        $currentPage = $_GET['page'];

                                        //Nếu trang hiện tại không phải là trang đầu tiên (tức là $currentPage > 1), sẽ hiển thị liên kết đến trang đầu và trang trước. Khi người dùng nhấn vào, họ sẽ được chuyển tới trang đầu tiên hoặc trang trước.
                                        if ($currentPage > 1) {
                                            echo "<a href='" . $_SERVER['PHP_SELF'] . "?page=1'>Trang đầu</a>";
                                            echo "<a href='" . $_SERVER['PHP_SELF'] . "?page=" . ($currentPage - 1) . "'>Trang trước</a>";
                                        }
                                        //$pagesPerSet: Số lượng trang hiển thị tối đa trong một nhóm. Trong trường hợp này, bạn muốn hiển thị tối đa 5 trang.
                                        $pagesPerSet = 5;
                                        //$currentSet: Xác định nhóm hiện tại dựa trên trang hiện tại. Ví dụ: Nếu bạn ở trang 6, nhóm hiện tại sẽ là nhóm thứ 2 (vì mỗi nhóm chứa tối đa 5 trang).
                                        $currentSet = ceil($_GET['page'] / $pagesPerSet);
                                        //$startPage: Xác định trang đầu tiên trong nhóm hiện tại.
                                        //(currentSet - 1): Trừ đi 1 vì nhóm đầu tiên bắt đầu từ trang 1 (chứ không phải từ trang 0).
                                        //($currentSet - 1) * $pagesPerSet: Phép tính này xác định số trang đã được hiển thị ở các nhóm trước đó.
                                        //Ví dụ: Nếu bạn đang ở nhóm 2 (tức $currentSet = 2), phép tính sẽ là (2 - 1) * 5 = 5, có nghĩa là đã có 5 trang ở nhóm 1.
                                        //($currentSet - 1) * $pagesPerSet + 1: Sau khi tính toán số trang đã hiển thị ở các nhóm trước đó, bạn cộng thêm 1 để bắt đầu trang đầu tiên trong nhóm hiện tại.
                                        //Ví dụ: Nếu bạn đang ở nhóm 2 (tức $currentSet = 2), trang đầu tiên trong nhóm này sẽ là trang số 6.
                                        $startPage = ($currentSet - 1) * $pagesPerSet + 1;
                                        //$endPage: Xác định trang cuối cùng trong nhóm hiện tại.
                                        //$startPage + $pagesPerSet - 1: Tính trang cuối cùng trong nhóm.
                                        //Ví dụ, nếu $startPage = 6 (tức là trang đầu tiên trong nhóm 2) và bạn muốn hiển thị tối đa 5 trang trong nhóm, thì trang cuối cùng trong nhóm này sẽ là 6 + 5 - 1 = 10.
                                        //min($startPage + $pagesPerSet - 1, $maxPage): Hàm min() sẽ đảm bảo rằng trang cuối cùng trong nhóm không vượt quá tổng số trang ($maxPage). Nếu số trang trong nhóm vượt quá số trang tối đa ($maxPage), nó sẽ tự động gán trang cuối cùng bằng $maxPage để không bị vượt qua.
                                        $endPage = min($startPage + $pagesPerSet - 1, $maxPage);

                                        //$startPage > 1: Nếu trang đầu tiên trong nhóm không phải là trang đầu tiên toàn cục (ví dụ, khi người dùng ở nhóm 2, nhóm 3,...), hiển thị dấu ... để người dùng biết có các trang bị ẩn.
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
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content -->
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