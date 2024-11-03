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
    <title>Thêm mới sản phẩm</title>
</head>
<body>

<div class="main-panel">
    <div class="page-inner">
        <div class="page-header">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="page-title">Thêm mới sản phẩm</h4>
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
                                <a href="<?php echo $base_url?>/admin/san_pham/index.php">Danh sách sản phẩm</a>
                            </li>
                            <li class="separator">
                                <i class="flaticon-right-arrow"></i>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo $base_url?>/admin/san_pham/create.php">Thêm mới</a>
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
                    <div class="row">
                        <div class="col-md-12">
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="row">
                                            <div class="col-md-12 mb-3">
                                                <label style="font-weight: bold;">THÔNG TIN CHUNG</label>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Tên sản phẩm <span class="text-danger">*</span></label>
                                                    <input type="text" name="hoTen" placeholder="Nhập tên sản phẩm" class="form-control"/>
                                                </div>
                                                <div class="form-group form-group-default">
                                                    <label for="SupplierID">Chọn nhà cung cấp</label>
                                                    <select id="SupplierID" name="SupplierID" class="form-control select">
                                                        <option value="">Chọn nhà cung cấp</option>
                                                    </select>
                                                    <span class="text-danger" id="SupplierIDError"></span>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group form-group-default">
                                                            <label>Số lượng <span class="text-danger">*</span></label>
                                                            <input type="number" name="soLuong" placeholder="Nhập số lượng" class="form-control" min="1" step="1"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group form-group-default">
                                                            <label>Giá bán <span class="text-danger">*</span></label>
                                                            <input type="text" name="demoOriginalPrice" value="" id="demoOriginalPrice" placeholder="Nhập giá bán" data-a-sign="VND " class="form-control auto">
                                                        </div>
                                                    </div>
                                                </div>



                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group form-group-default">
                                                    <label>Hình ảnh sản phẩm</label>
                                                    <div class="input-group ">
                                                        <div class="custom-file">
                                                            <input type="file" class="form-control" style="text-align: center;" id="customFile" readonly/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group form-group-default">
                                                    <label>Mô tả</label>
                                                    <div class="form-group form-group-default">
                                                        <textarea name="moTa" placeholder="Nhập mô tả" class="form-control" rows="3"></textarea>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <button type="submit" class="btn btn-success">Thêm mới</button>
                                    <a href="<?php echo $base_url?>/admin/san_pham/index.php" class="btn btn-danger btnBack">Quay lại</a>
                                </div>
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
<script>
    $(function () {
        //Initialize Select2 Elements
        $('.select').select2()
    });
</script>

<script src="<?php echo $base_url?>/Scripts/jsConvert.js"></script>

<script>
    $(document).ready(function () {
        $('.auto').autoNumeric('init'); // Khởi tạo autoNumeric cho các trường
        $('#demoPrice, #demoPriceSale, #demoOriginalPrice').on('change', function () {
            var $this = $(this);
            var demoGet = $this.autoNumeric('get'); // Get the numeric value

            // Update the corresponding hidden field
            $this.next('input[type="hidden"]').val(demoGet);

            // Set the formatted value back to the input
            $this.autoNumeric('set', demoGet);
        });

        CKEDITOR.replace('txtDetail', {
            customConfig: '/content/ckeditor/config.js',
            extraAllowedContent: 'span',
        });
        // Hàm để ẩn thông báo sau 5 giây
        function hideMessage() {
            $('.message-container').fadeOut(); // Ẩn thông báo
        }

        // Nếu có thông báo, thiết lập timeout để tự động ẩn sau 5 giây
        if ($('.message-container').length) {
            setTimeout(hideMessage, 5000); // 5000 milliseconds = 5 seconds
        }
    });
    function BrowseServer(field) {
        var finder = new CKFinder();
        finder.selectActionFunction = function (fileUrl) {
            document.getElementById(field).value = fileUrl;
        };
        finder.popup();
    }
</script>
