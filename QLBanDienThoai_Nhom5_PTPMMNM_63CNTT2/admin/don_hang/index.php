
<?php
include '../checkSession.php';
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
?>

<?php
include('../includes/header.html');
?>

<!-- Sidebar -->
<?php
include ('../_PartialSideBar.html');
?>

<div class="main-panel">
    <?php
    include('../don_hang/home.html');
    ?>
</div>
<!-- /.content -->
<!--<script src="~/Content/export/xlsx.full.min.js"></script>-->
<!--<script>-->
<!--    $(document).ready(function () {-->
<!---->
<!--        $('#export').click(function () {-->
<!--            // Clone the table to prevent modification of the original table-->
<!--            var tableClone = $('.tableHoaDon').clone();-->
<!---->
<!--            // Remove the "Chức năng" column from the cloned table-->
<!--            tableClone.find('th:nth-child(10), td:nth-child(10)').remove();-->
<!---->
<!--            // Create a workbook and add a worksheet-->
<!--            var wb = XLSX.utils.book_new();-->
<!--            var ws = XLSX.utils.table_to_sheet(tableClone[0]);-->
<!---->
<!--            // Adjust column widths-->
<!--            var colWidths = [];-->
<!--            tableClone.find('tr').eq(0).find('th').each(function () {-->
<!--                colWidths.push($(this).width() / 8); // Divide by 8 to approximate width adjustment for Excel-->
<!--            });-->
<!--            ws['!cols'] = colWidths.map(function (width) { return { width: width }; });-->
<!--            // Add worksheet to workbook-->
<!--            XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');-->
<!---->
<!--            // Save workbook as Excel file-->
<!--            XLSX.writeFile(wb, 'Danh sách đơn hàng MEGATECH.xlsx');-->
<!--        });-->
<!---->
<!--        $('body').on('change', '#SelectAll', function () {-->
<!--            var checkStatus = this.checked;-->
<!--            var checkbox = $(this).parents('.card-body').find('tr td input:checkbox');-->
<!--            checkbox.each(function () {-->
<!--                this.checked = checkStatus;-->
<!--                if (this.checked) {-->
<!--                    checkbox.attr('selected', 'checked');-->
<!--                } else {-->
<!--                    checkbox.attr('selected', '');-->
<!--                }-->
<!--            });-->
<!--        });-->
<!---->
<!--        $('body').on('click', '.btnCapNhat', function () {-->
<!--            var id = $(this).data("id");-->
<!--            var trangThai = $(this).closest('tr').find('td:eq(7)').text().trim(); // Lấy trạng thái từ cột thứ 7 trong hàng đó-->
<!---->
<!--            if (trangThai === 'Đã thanh toán') {-->
<!--                alert('Hoá đơn đã thanh toán không được chỉnh sửa.');-->
<!--            } else {-->
<!--                $('#txtOrderId').val(id);-->
<!--                $('#modal-default').modal('show');-->
<!--            }-->
<!--        });-->
<!---->
<!--        $('body').on('click', '#btnLuu', function () {-->
<!--            var id = $('#txtOrderId').val();-->
<!--            var tt = $('#ddTrangThai').val();-->
<!--            $.ajax({-->
<!--                url: '@Url.Action("UpdateTT", "Order")',-->
<!--                type: 'POST',-->
<!--                data: { id: id, trangthai: tt },-->
<!--                success: function (res) {-->
<!--                    if (res.Success) {-->
<!--                        location.reload();-->
<!--                    }-->
<!--                },-->
<!--            });-->
<!--        });-->
<!--        // Hàm để ẩn thông báo sau 5 giây-->
<!--        function hideMessage() {-->
<!--            $('.message-container').fadeOut(); // Ẩn thông báo-->
<!--        }-->
<!---->
<!--        // Nếu có thông báo, thiết lập timeout để tự động ẩn sau 5 giây-->
<!--        if ($('.message-container').length) {-->
<!--            setTimeout(hideMessage, 5000); // 5000 milliseconds = 5 seconds-->
<!--        }-->
<!--    });-->
<!---->
<!--</script>-->
<?php
include('../includes/footer.html');
?>