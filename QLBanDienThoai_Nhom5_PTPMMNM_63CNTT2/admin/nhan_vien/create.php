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
    <title>Thêm mới nhân viên</title>
    <link href="<?php echo $base_url?>/Content/datepicker/jquery.datetimepicker.min.css" rel="stylesheet" />
</head>
<body>
<div class="main-panel">
    <div class="page-inner">
        <div class="page-header">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="page-title">Thêm mới nhân viên</h4>
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
                            <li class="separator">
                                <i class="flaticon-right-arrow"></i>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo $base_url?>/admin/nhan_vien/create.php">Thêm mới</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card" style="height: 100%">
                    <form action="" method="post">
                        <div class="card-body">
                            <div id="logins-part" class="content active dstepper-block" role="tabpanel" aria-labelledby="logins-part-trigger">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h2 class="text-center m-3" style="font-weight: bold;">THÔNG TIN NHÂN VIÊN</h2>
                                    </div>
                                    <div class="col-md-12">
                                        <h4 class="m-3" style="font-weight: bold;">THÔNG TIN CHUNG</h4>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>Họ tên nhân viên <span class="text-danger">*</span></label>
                                            <input type="text" name="hoTen" placeholder="Nhập họ tên nhân viên" class="form-control"/>
                                        </div>
                                        <div class="form-group form-group-default">
                                            <label>Ngày sinh <span class="text-danger">* Nhân viên phải có độ tuổi từ 18 đến 40.</span></label>
                                            <input type="text" name="ngSinh" class="form-control picker" placeholder="Nhập ngày sinh nhân viên" autocomplete="off"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default" style="height: 200px;">
                                            <label>Hình ảnh nhân viên</label>
                                            <div class="input-group mt-5">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input form-control" style="text-align: center;" id="customFile" readonly/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>Giới tính <span class="text-danger">*</span></label>
                                            <select name="gioiTinh" class="form-control">
                                                <option value="Nam">Nam</option>
                                                <option value="Nữ">Nữ</option>
                                            </select>
                                        </div>
                                        <div class="form-group form-group-default">
                                            <label>Địa chỉ <span class="text-danger">*</span></label>
                                            <input type="text" name="diaChi" placeholder="Nhập địa chỉ nhân viên" class="form-control"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>Số điện thoại <span class="text-danger">*</span></label>
                                            <input type="text" name="soDienThoai" placeholder="Nhập số điện thoại nhân viên" class="form-control"/>
                                        </div>
                                        <div class="form-group form-group-default">
                                            <label>Email <span class="text-danger">*</span></label>
                                            <input type="email" name="email" placeholder="Nhập email nhân viên" class="form-control"/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <h4 class="m-3" style="font-weight: bold;">THÔNG TIN TÀI KHOẢN</h4>
                                        <div class="form-group form-group-default">
                                            <label>Tên đăng nhập <span class="text-danger">*</span></label>
                                            <input type="text" name="tenTaiKhoan" placeholder="Nhập tên đăng nhập tài khoản nhân viên" class="form-control"/>
                                        </div>
                                        <div class="form-group form-group-default">
                                            <label>Mật khẩu <span class="text-danger">*</span></label>
                                            <input type="password" name="matKhau" placeholder="Nhập mật khẩu tài khoản nhân viên" class="form-control"/>
                                        </div>
                                        <div class="form-group form-group-default">
                                            <label>Tên hiển thị tài khoản <span class="text-danger">*</span></label>
                                            <input type="text" name="tenhienThi" placeholder="Nhập tên hiển thị tài khoản nhân viên" class="form-control"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-success btnCreate">Thêm mới</button>
                                    <a href="<?php echo $base_url?>/admin/nhan_vien/index.php" class="btn btn-danger btnBack">Quay lại</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- /.content -->
</body>
</html>

<script src="<?php echo $base_url?>/Content/datepicker/jquery.datetimepicker.full.js"></script>
<script>
    $(function () {
        // Initialize Select2 Elements
        $('.select').select2();
    });
</script>

<script>
    $(document).ready(function () {
        $('.picker').datetimepicker({
            autoclose: true,
            timepicker: false,
            datepicker: true,
            format: "d/m/Y",
            weeks: true
        });
        $.datetimepicker.setLocale('vi');
    });
</script>