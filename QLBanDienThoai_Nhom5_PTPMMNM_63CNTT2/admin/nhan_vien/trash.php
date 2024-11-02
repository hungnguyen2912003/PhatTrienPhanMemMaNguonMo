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
                        <h4 class="page-title">Thùng rác nhân viên</h4>
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
                                <a href="<?php echo $base_url?>/admin/nhan_vien/trash.php">Thùng rác nhân viên</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card" style="height: 100%">
                    <div class="card-header">
                        <div class="row justify-content-between align-items-center">
                            <div class="col-md-6">
                                <a href="#" class="btn btn-info btn-rounded" id="BtnUndoAll">Phục hồi nhiều</a>
                                <a href="#" class="btn btn-danger btn-rounded" id="BtnDeleteAll">Xoá nhiều</a>
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="<?php echo $base_url?>/admin/nhan_vien/index.php" class="btn btn-rounded btn-secondary">
                                    <i class="fas fa-reply" style="font-size: 15px"></i> Quay lại
                                </a>
                            </div>
                        </div>
                    </div>


                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="multi-filter-select" class="display table table-striped table-hover table-bordered">
                                <thead>
                                <tr class="text-center">
                                    <th><input type="checkbox" id="SelectAll" /></th>
                                    <th>#</th>
                                    <th>Họ tên nhân viên</th>
                                    <th>Hình ảnh</th>
                                    <th>Ngày sinh</th>
                                    <th>Giới tính</th>
                                    <th>Số điện thoại</th>
                                    <th>Email</th>
                                    <th>Chức vụ</th>
                                    <th>Chức năng</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if (isset($model) && !empty($model)): ?>
                                    <?php $i = 1; ?>
                                    <?php foreach ($model as $item): ?>
                                        <tr id="trow_<?php echo htmlspecialchars($item->ID); ?>">
                                            <td class="text-center">
                                                <input type="checkbox" class="cbkItem" value="<?php echo htmlspecialchars($item->ID); ?>" />
                                            </td>
                                            <td class="text-center"><?php echo $i; ?></td>
                                            <td><?php echo htmlspecialchars($item->FullName); ?></td>
                                            <td class="text-center">
                                                <img src="<?php echo htmlspecialchars($item->Image); ?>" width="80" />
                                            </td>
                                            <td class="text-center"><?php echo date('d/m/Y', strtotime($item->NgaySinh)); ?></td>
                                            <td class="text-center"><?php echo $item->GioiTinh ? "Nam" : "Nữ"; ?></td>
                                            <td class="text-center"><?php echo htmlspecialchars($item->SoDienThoai); ?></td>
                                            <td class="text-center"><?php echo htmlspecialchars($item->Email); ?></td>
                                            <td class="text-center"><?php echo is_null($item->ID_ChucVu) ? "Chưa thiết lập" : htmlspecialchars($item->ChucVu->TenChucVu); ?></td>
                                            <td class="text-center">
                                                <a href="/admin/nhanvien/undo/<?php echo htmlspecialchars($item->ID); ?>" class="btn btn-warning btn-xs text-white">
                                                    <i class="fa-solid fa-undo"></i>
                                                </a>
                                                <a href="#" data-id="<?php echo htmlspecialchars($item->ID); ?>" class="btn btn-danger btn-xs btnDelete">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>

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

<!-- /.content -->
<script>
    $(document).ready(function () {
        $('body').on('click', '.btnDelete', function () {
            var id = $(this).data("id");
            var conf = confirm('Bạn có muốn xóa bản ghi này không?');
            if (conf === true) {
                $.ajax({
                    url: '@Url.Action("Delete", "NhanVien")',
                    type: 'POST',
                    data: { id: id },
                    success: function (rs) {
                        if (rs.success) {
                            $('#trow_' + id).remove();
                            location.reload();
                        }
                    }
                });
            }
        });

        $('body').on('click', '#BtnDeleteAll', function (e) {
            e.preventDefault();

            var checkbox = $(this).parents('.card').find('tr td input:checkbox');
            var checkedCheckbox = checkbox.filter(':checked');

            // Kiểm tra xem có checkbox nào được chọn không
            if (checkedCheckbox.length === 0) {
                // Hiển thị cảnh báo
                alert('Bạn cần phải tích vào Checkbox của ít nhất một danh mục để sử dụng chức năng này!');
                return;
            }

            var str = "";
            var i = 0;
            checkbox.each(function () {
                if (this.checked) {
                    var _id = $(this).val();
                    if (i === 0) {
                        str += _id;
                    } else {
                        str += "," + _id;
                    }
                    i++;
                } else {
                    checkbox.attr('selected', '');
                }
            });
            if (str.length > 0) {
                var conf = confirm('Bạn có muốn xóa các bản ghi này hay không?');
                if (conf === true) {
                    $.ajax({
                        url: '@Url.Action("DeleteAll", "NhanVien")',
                        type: 'POST',
                        data: { ids: str },
                        success: function (rs) {
                            if (rs.success) {
                                location.reload();
                            }
                        }
                    });
                }
            }
        });
        $('body').on('click', '#BtnUndoAll', function (e) {
            e.preventDefault();

            var checkbox = $(this).parents('.card').find('tr td input:checkbox');
            var checkedCheckbox = checkbox.filter(':checked');

            // Kiểm tra xem có checkbox nào được chọn không
            if (checkedCheckbox.length === 0) {
                // Hiển thị cảnh báo
                alert('Bạn cần phải tích vào Checkbox của ít nhất một danh mục để sử dụng chức năng này!');
                return;
            }

            var str = "";
            var i = 0;
            checkbox.each(function () {
                if (this.checked) {
                    var _id = $(this).val();
                    if (i === 0) {
                        str += _id;
                    } else {
                        str += "," + _id;
                    }
                    i++;
                } else {
                    checkbox.attr('selected', '');
                }
            });
            if (str.length > 0) {
                var conf = confirm('Bạn có muốn phục hồi các bản ghi này hay không?');
                if (conf === true) {
                    $.ajax({
                        url: '@Url.Action("UndoAll", "NhanVien")',
                        type: 'POST',
                        data: { ids: str },
                        success: function (rs) {
                            if (rs.success) {
                                location.reload();
                            }
                        }
                    });
                }
            }
        });
        $('body').on('change', '#SelectAll', function () {
            var checkStatus = this.checked;
            var checkbox = $(this).parents('.card-body').find('tr td input:checkbox');
            checkbox.each(function () {
                this.checked = checkStatus;
                if (this.checked) {
                    checkbox.attr('selected', 'checked');
                } else {
                    checkbox.attr('selected', '');
                }
            });
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

</script>
}