<?php
include '../checkSession.php';
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
include('../includes/header.html');
include('../_PartialSideBar.html');
include('../includes/footer.html');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Thêm mới nhà cung cấp</title>
</head>
<body>
<div class="main-panel">
    <div class="page-inner">
        <div class="page-header">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="page-title">Thêm mới nhà cung cấp</h4>
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
                                <a href="<?php echo $base_url?>/admin/nha_cung_cap/index.php">Danh sách nhà cung cấp</a>
                            </li>
                            <li class="separator">
                                <i class="flaticon-right-arrow"></i>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo $base_url?>/admin/nha_cung_cap/create.php">Thêm mới</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card" style="height: 100%">
                    <div class="card-body">
                        <div id="logins-part" class="content active dstepper-block" role="tabpanel" aria-labelledby="logins-part-trigger">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-group-default">
                                        <label>Tên nhà cung cấp <span class="text-danger">*</span></label>
                                        <input type="text" name="tenNhaCungCap" placeholder="Nhập tên nhà cung cấp" class="form-control"/>
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label>Alias</label>
                                        <input type="text" name="alias" placeholder="Nhập alias" class="form-control"/>
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label>Số điện thoại <span class="text-danger">*</span></label>
                                        <input type="text" name="soDienThoai" placeholder="Nhập số điện thoại" class="form-control"/>
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label>Email <span class="text-danger">*</span></label>
                                        <input type="email" name="email" placeholder="Nhập email" class="form-control"/>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-group-default" style="height: 200px;">
                                        <label>Hình ảnh nhà cung cấp</label>
                                        <div class="input-group mt-5">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input form-control" id="customFile" readonly/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label>Seo Title</label>
                                        <input type="text" name="seoTitle" placeholder="Nhập Seo Title" class="form-control"/>
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label>Seo Description</label>
                                        <input type="text" name="seoDescription" placeholder="Nhập Seo Description" class="form-control"/>
                                    </div>
                                    <div class="form-group form-group-default">
                                        <label>Seo Keywords</label>
                                        <input type="text" name="seoKeywords" placeholder="Nhập Seo Keywords" class="form-control"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-success">Thêm mới</button>
                                <a href="<?php echo $base_url?>/admin/nha_cung_cap/index.php" class="btn btn-danger btnBack">Quay lại</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.content -->
</body>
</html>

<script src="<?php echo $base_url?>/Scripts/jsConvert.js"></script>
<script>
    $(document).ready(function () {
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