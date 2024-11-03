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
    <title>Chi tiết nhà cung cấp</title>
</head>
<body>
<div class="main-panel">
<div class="content">
    <div class="page-inner">
        <div class="page-header">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="page-title">Chi tiết thông tin nhà cung cấp: @Model.Title</h4>
                    </div>
                    <div class="col-md-6 text-right">
                        <ul class="breadcrumbs">
                            <li class="nav-home">
                                <a href="@Url.Action("Index", "Home")">
                                <i class="flaticon-home"></i>
                                </a>
                            </li>
                            <li class="separator">
                                <i class="flaticon-right-arrow"></i>
                            </li>
                            <li class="nav-item">
                                <a href="@Url.Action("Index", "Supplier")">Danh sách nhà cung cấp</a>
                            </li>
                            <li class="separator">
                                <i class="flaticon-right-arrow"></i>
                            </li>
                            <li class="nav-item">
                                <a href="#">Xem chi tiết</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div id="logins-part" class="content active dstepper-block" role="tabpanel" aria-labelledby="logins-part-trigger">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Tên nhà cung cấp</label>
                                        <span class="form-control">@Model.Title</span>
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
                                    <div class="form-group form-group-default text-center ">
                                        <label>Hình ảnh nhà cung cấp</label><br />
                                        @if (!string.IsNullOrEmpty(Model.Image))
                                        {
                                        <img src="@Model.Image" alt="Ảnh sản phẩm" width="200" class="img-fluid">
                                        }
                                        else
                                        {
                                        <span class="form-control">Chưa thêm ảnh cho nhà cung cấp này</span>
                                        }
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="form-group text-center">
                            <a href="/admin/supplier/edit/@Model.MaNhaCungCap" class="btn btn-primary">Vào trang chỉnh sửa</a>
                            <a href="<?php echo $base_url?>/admin/nha_cung_cap/index.php" class="btn btn-danger btnBack">Quay lại</a>
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