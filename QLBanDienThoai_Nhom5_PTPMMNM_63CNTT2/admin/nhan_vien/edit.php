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
    <title>Chỉnh sửa nhân viên</title>
</head>
<body>
<div class="main-panel">
<div class="content">
    <div class="page-inner">
        <div class="page-header">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="page-title">Chỉnh sửa thông tin nhân viên: @Model.FullName</h4>
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
                                <a href="<?php echo $base_url?>/admin/nhan_vien/edit.php">Chỉnh sửa</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card h-100">
                    <div class="card-body">
<!--                        @using (Html.BeginForm("Edit", "NhanVien", FormMethod.Post, new { }))-->
<!--                        {-->
<!--                        @Html.AntiForgeryToken()-->
<!--                        @Html.ValidationSummary(true)-->
<!--                        @Html.HiddenFor(x => x.ID)-->
<!--                        @Html.HiddenFor(x => x.FullName)-->
<!--                        @Html.HiddenFor(x => x.TenDangNhap)-->
<!--                        @Html.HiddenFor(x => x.Status)-->
<!--                        @Html.HiddenFor(x => x.CreatedBy)-->
<!--                        @Html.HiddenFor(x => x.CreatedDate)-->
                        <!-- your steps content here -->
                        <div id="logins-part" class="content active dstepper-block" role="tabpanel" aria-labelledby="logins-part-trigger">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Họ tên nhân viên <span class="text-danger">*</span></label>
                                        @Html.TextBoxFor(x => x.FullName, new { @class = "form-control", @readonly = "readonly" })
                                        @Html.ValidationMessageFor(model => model.FullName, "", new { @class = "text-danger" })
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-group-default">
                                                <label>Ngày sinh <span class="text-danger">*</span></label>
                                                @Html.TextBoxFor(x => x.NgaySinh, new { @class = "form-control picker", @autocomplete = "off", @placeholder = "Nhập ngày sinh nhân viên" })
                                                @Html.ValidationMessageFor(x => x.NgaySinh, "", new { @class = "text-danger" })
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-group-default">
                                                <label>Giới tính <span class="text-danger">*</span></label>
                                                @Html.DropDownListFor(model => model.GioiTinh, (SelectList)ViewBag.Gender, "-- Chọn giới tính --", new { @class = "form-control" })
                                                @Html.ValidationMessageFor(x => x.GioiTinh, "", new { @class = "text-danger" })
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Email <span class="text-danger">*</span></label>
                                        @Html.TextBoxFor(x => x.Email, new { @class = "form-control", @placeholder = "Nhập Email nhân viên" })
                                        @Html.ValidationMessageFor(x => x.Email, "", new { @class = "text-danger" })
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label>Số điện thoại <span class="text-danger">*</span></label>
                                        @Html.TextBoxFor(x => x.SoDienThoai, new { @class = "form-control", @placeholder = "Nhập số điện thoại nhân viên" })
                                        @Html.ValidationMessageFor(x => x.SoDienThoai, "", new { @class = "text-danger" })
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label>Địa chỉ <span class="text-danger">*</span></label>
                                        @Html.TextBoxFor(x => x.DiaChi, new { @class = "form-control", @placeholder = "Nhập địa chỉ nhân viên" })
                                        @Html.ValidationMessageFor(x => x.DiaChi, "", new { @class = "text-danger" })
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Hình ảnh nhân viên</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                @Html.TextBoxFor(x => x.Image, new { @id = "txtImage", @class = "form-control", @readonly = "readonly" })
                                            </div>
                                            <div class="input-group-append col-md-2">
                                                <input type="button" value="Tải ảnh" onclick="BrowseServer('txtImage');" />
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary">Chỉnh sửa</button>
                                <a href="<?php echo $base_url?>/admin/nhan_vien/index.php" class="btn btn-danger btnBack">Quay lại</a>
                            </div>
                        </div>
                        }
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</body>
</html>
<!-- /.content -->
<script src="<?php echo $base_url?>/Content/datepicker/jquery.datetimepicker.full.js"></script>
<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select').select2()
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

        CKEDITOR.replace('txtDetail', {
            customConfig: '/content/ckeditor/config.js',
            extraAllowedContent: 'span',
        });
    });
    function BrowseServer(field) {
        var finder = new CKFinder();
        finder.selectActionFunction = function (fileUrl) {
            document.getElementById(field).value = fileUrl;
        };
        finder.popup();
    }
</script>
}

