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
    <title>Chi tiết nhân viên</title>
</head>
<body>
<div class="main-panel">
<div class="content">
    <div class="page-inner">
        <div class="page-header">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="page-title">Chi tiết thông tin nhân viên: @Model.FullName </h4>
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
                                <a href="<?php echo $base_url?>/admin/nhan_vien/detail.php">Xem chi tiết</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card h-100" >
                    <div class="card-body">
                        <div id="logins-part" class="content active dstepper-block" role="tabpanel" aria-labelledby="logins-part-trigger">
                            <div class="row">
                                <div class="col-md-6">

                                    <div class="form-group form-group-default">
                                        <label>Họ tên nhân viên</label>
                                        <span class="form-control">@Model.FullName</span>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-group-default">
                                                <label>Ngày sinh</label>
                                                <span class="form-control">@Model.NgaySinh.ToString("dd'/'MM'/'yyyy")</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-group-default">
                                                <label>Giới tính</label>
                                                <span class="form-control">@(Model.GioiTinh == true ? "Nam" : "Nữ")</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label>Địa chỉ</label>
                                        <span class="form-control">@Model.DiaChi</span>
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label>Số điện thoại</label>
                                        <span class="form-control">@Model.SoDienThoai</span>
                                    </div>

                                    <div class="form-group form-group-default">
                                        <label>Email</label>
                                        <span class="form-control">@Model.Email</span>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-default text-center " >
                                        <label>Hình ảnh đại diện</label><br />
                                        @if (!string.IsNullOrEmpty(Model.Image))
                                        {
                                        <img src="@Model.Image" alt="Hình ảnh đại diện" width="200" class="img-fluid">
                                        }
                                        else
                                        {
                                        <span class="form-control">Chưa thêm hình ảnh cho nhân viên này</span>
                                        }
                                    </div>
                                    <label class="mb-3" style="font-weight: bold;">TÀI KHOẢN</label>
                                    <div class="form-group form-group-default">
                                        <label>Tên tài khoản</label>
                                        <span class="form-control">@Model.TenDangNhap</span>
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label>Mật khẩu tài khoản</label>
                                        <span class="form-control">@Model.MatKhau</span>
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label>Tên hiển thị tài khoản</label>
                                        <span class="form-control">@Model.TenHienThi</span>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <a href="<?php echo $base_url?>/admin/nhan_vien/edit.php" class="btn btn-primary">Vào trang chỉnh sửa</a>
                            <a href="<?php echo $base_url?>/admin/nhan_vien/index.php" class="btn btn-danger btnBack">Quay lại</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</body>
</html>

