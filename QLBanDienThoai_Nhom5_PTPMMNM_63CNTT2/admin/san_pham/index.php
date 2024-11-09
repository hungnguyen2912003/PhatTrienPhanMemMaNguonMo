<?php
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
include('../includes/header.html');
include ('../_PartialSideBar.html');
include('../includes/footer.html');

//Kết nối cơ sở dữ liệu
$connect = mysqli_connect("localhost", "root", "", "qlbandienthoai")
OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error());
$rowsPerPage = 5; //số mẩu tin trên mỗi trang
if (!isset($_GET['page']))
{
    $_GET['page'] = 1;
}
//vị trí của mẩu tin đầu tiên trên mỗi trang
$offset =($_GET['page']-1)*$rowsPerPage;

//Truy vấn toàn bộ thông tin từ bảng nhan_Vien
$sql = "SELECT * FROM san_pham LIMIT $offset, $rowsPerPage";

//Gửi truy vấn đến cơ sở dữ liệu
$result = mysqli_query($connect, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Danh mục sản phẩm</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
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
                                    <a href="<?php echo $base_url?>/admin/index.php">
                                    <i class="flaticon-home"></i>
                                    </a>
                                </li>
                                <li class="separator">
                                    <i class="flaticon-right-arrow"></i>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo $base_url?>/admin/san_pham/index.php">Danh mục sản phẩm</a>
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
                                    <a href="<?php echo $base_url?>/admin/san_pham/create.php" class="btn btn-rounded btn-primary">Thêm mới</a>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group input-group-sm">
                                    <input type="text" name="Searchtext" class="form-control custom-textbox" placeholder="Nhập thông tin sản phẩm bạn muốn tìm kiếm">
                                    <span class="input-group-append">
                                        <button type="submit" class="btn btn-info btn-flat">Tìm kiếm</button>
                                    </span>
                                </div>
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
                                                <a href='$base_url/admin/san_pham/detail.php?ma_sp={$row['ma_sp']}' class='btn btn-xs btn-warning text-white'><i class='fa-solid fa-circle-info'></i></a>
                                                <a href='$base_url/admin/san_pham/edit.php?ma_sp={$row['ma_sp']}' class='btn btn-xs btn-primary'><i class='fa-solid fa-pen-to-square'></i></a>
                                                <a href='$base_url/admin/san_pham/delete.php?ma_sp={$row['ma_sp']}' class='btn btn-xs btn-danger'><i class='fa-solid fa-trash-can'></i></a>
                                              </td>";
                                    echo "</tr>";
                                    $stt++;
                                }
                                ?>
                                </tbody>
                            </table>
                            <div class="pagination-container">
                                <div class="pagination">
                                    <?php
                                    // Get total number of rows
                                    $re = mysqli_query($connect, 'SELECT * FROM san_pham');
                                    $numRows = mysqli_num_rows($re);
                                    $maxPage = ceil($numRows / $rowsPerPage);
                                    $currentPage = $_GET['page'];

                                    // Display "Trang đầu" and "Trang trước"
                                    if ($currentPage > 1) {
                                        echo "<a href='" . $_SERVER['PHP_SELF'] . "?page=1'>Trang đầu</a> ";
                                        echo "<a href='" . $_SERVER['PHP_SELF'] . "?page=" . ($currentPage - 1) . "'>Trang trước</a> ";
                                    }

                                    $pagesPerSet = 5;
                                    $currentSet = ceil($_GET['page'] / $pagesPerSet);

                                    // Calculate start and end page for current set
                                    $startPage = ($currentSet - 1) * $pagesPerSet + 1;
                                    $endPage = min($startPage + $pagesPerSet - 1, $maxPage);

                                    // Display "..." before the pagination block if necessary
                                    if ($startPage > 1) {
                                        echo "<a href='" . $_SERVER['PHP_SELF'] . "?page=" . ($startPage - 1) . "'>...</a> ";
                                    }

                                    // Display page numbers
                                    for ($i = $startPage; $i <= $endPage; $i++) {
                                        if ($i == $currentPage) {
                                            echo "<b>$i</b> "; // Current page, bolded
                                        } else {
                                            echo "<a href='" . $_SERVER['PHP_SELF'] . "?page=" . $i . "'>$i</a> ";
                                        }
                                    }

                                    // Display "..." after the pagination block if necessary
                                    if ($endPage < $maxPage) {
                                        echo "<a href='" . $_SERVER['PHP_SELF'] . "?page=" . ($endPage + 1) . "'>...</a> ";
                                    }

                                    // Display "Trang sau" and "Trang cuối"
                                    if ($currentPage < $maxPage) {
                                        echo "<a href='" . $_SERVER['PHP_SELF'] . "?page=" . ($currentPage + 1) . "'>Trang sau</a> ";
                                        echo "<a href='" . $_SERVER['PHP_SELF'] . "?page=" . $maxPage . "'>Trang cuối</a> ";
                                    }
                                    ?>
                                </div>
                            </div>
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