<?php
include '../checkSession.php';
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
include('../includes/header.html');
include ('../_PartialSideBar.html');
include('../includes/footer.html');

//Kết nối cơ sở dữ liệu
$connect = mysqli_connect("localhost", "root", "", "qlbandienthoai")
OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error());

//Truy vấn toàn bộ thông tin từ bảng nhan_Vien
$sql = "SELECT * FROM san_pham";

//Gửi truy vấn đến cơ sở dữ liệu
$result = mysqli_query($connect, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Danh mục sản phẩm</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
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
                        <div class="table-responsive">
                            <table id="multi-filter-select" class="display table table-striped table-hover table-bordered tableSanPham">
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
                                $stt = 1;
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
