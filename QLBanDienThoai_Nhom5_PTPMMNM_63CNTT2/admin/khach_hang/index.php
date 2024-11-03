
<?php
include '../checkSession.php';
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
include('../includes/header.html');
include ('../_PartialSideBar.html');
include('../includes/footer.html');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quản lý khách hàng</title>
    <style>
        .custom-textbox {
            height: 50px;
            border: 2px solid #0094ff;
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
                            <h4 class="page-title">Danh sách khách hàng</h4>
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
                                    <a href="<?php echo $base_url?>/admin/khach_hang/index.php">Danh sách khách hàng</a>
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

                            </div>
                            <div class="col-md-5">
                                <div class="input-group input-group-sm">
                                    <input type="text" name="Searchtext" class="form-control custom-textbox" placeholder="Nhập thông tin khách hàng bạn muốn tìm kiếm">
                                    <span class="input-group-append">
                                    <button type="submit" class="btn btn-info btn-flat">Tìm kiếm</button>
                                </span>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="message-container">
                            <!--Hiển thị dòng thông báo-->
                        </div>
                        <div class="table-responsive">
                            <table id="multi-filter-select" class="display table table-striped table-hover table-bordered tableKhachHang">
                                <thead>
                                <tr class="text-center">
                                    <th><input type="checkbox" id="SelectAll" /></th>
                                    <th>#</th>
                                    <th>Mã khách hàng</th>
                                    <th>Họ tên khách hàng</th>
                                    <th>Giới tính</th>
                                    <th>Số điện thoại</th>
                                    <th>Email</th>
                                    <th>Địa chỉ</th>

                                </tr>
                                </thead>
                                <tbody>
                                <!-- Dữ liệu khách hàng sẽ được thêm vào đây -->
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

