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
    <title>Quản lý nhân viên</title>
</head>

<body>
<style>
    .custom-textbox {
        height: 50px;
        border: 2px solid #0094ff
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
                                    <a href="<?php echo $base_url?>/admin/index.php">
                                        <i class="flaticon-home"></i>
                                    </a>
                                </li>
                                <li class="separator">
                                    <i class="flaticon-right-arrow"></i>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo $base_url?>/admin/nhan_vien/index.php">Danh sách nhân viên</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card-tools">
                                    <a href="#" class="btn btn-rounded btn-primary">Thêm mới</a>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="input-group input-group-sm">

                                    <input type="text" name="Searchtext" class="form-control custom-textbox" placeholder="Nhập thông tin nhân viên bạn muốn tìm kiếm">
                                    <span class="input-group-append">
                                        <button type="submit" class="btn btn-info btn-flat">Tìm kiếm</button>
                                  </span>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card-tools text-right">
                                    <a href="#" class="btn btn-rounded btn-danger"><i class="fa fa-trash" style="font-size: 15px;"></i> Thùng rác</a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <div class="message-container">
                            <!--Hiển thị dòng thông báo-->
                        </div>
                        <div class="table-responsive">
                            <table id="multi-filter-select" class="display table table-striped table-hover table-bordered tableNhanVien">
                                <thead>
                                <tr class="text-center">
                                    <th><input type="checkbox" id="SelectAll" /></th>
                                    <th>#</th>
                                    <th>Mã nhân viên</th>
                                    <th>Họ tên nhân viên</th>
                                    <th>Hình ảnh</th>
                                    <th>Ngày sinh</th>
                                    <th>Giới tính</th>
                                    <th>Số điện thoại</th>
                                    <th>Chức vụ</th>
                                    <th>Chức năng</th>
                                </tr>
                                </thead>
                                <tbody>

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

