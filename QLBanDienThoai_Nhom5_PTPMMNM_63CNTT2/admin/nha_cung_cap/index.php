
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
    include('../nha_cung_cap/home.html');
    ?>
</div>
<!-- /.content -->
<!--<script>-->
<!--    $(document).ready(function () {-->
<!--        $('#export').click(function () {-->
<!--            // Clone the table to prevent modification of the original table-->
<!--            var tableClone = $('.tableSupplier').clone();-->
<!---->
<!--            // Remove the "Chức năng" column from the cloned table-->
<!--            tableClone.find('th:nth-child(3), td:nth-child(3), th:nth-child(7), td:nth-child(7)').remove();-->
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
<!---->
<!--            // Add worksheet to workbook-->
<!--            XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');-->
<!---->
<!--            // Save workbook as Excel file-->
<!--            XLSX.writeFile(wb, 'Danh sách nhà cung cấp MEGATECH.xlsx');-->
<!--        });-->
<!---->
<!--        $('body').on('click', '#BtnTrashAll', function (e) {-->
<!--            e.preventDefault();-->
<!---->
<!--            var checkbox = $(this).parents('.card').find('tr td input:checkbox');-->
<!--            var checkedCheckbox = checkbox.filter(':checked');-->
<!---->
<!--            // Kiểm tra xem có checkbox nào được chọn không-->
<!--            if (checkedCheckbox.length === 0) {-->
<!--                // Hiển thị cảnh báo-->
<!--                alert('Bạn cần phải tích vào Checkbox của ít nhất một danh mục để sử dụng chức năng này!');-->
<!--                return;-->
<!--            }-->
<!---->
<!--            var str = "";-->
<!--            var i = 0;-->
<!--            checkbox.each(function () {-->
<!--                if (this.checked) {-->
<!--                    var _id = $(this).val();-->
<!--                    str += (i === 0 ? _id : "," + _id);-->
<!--                    i++;-->
<!--                }-->
<!--            });-->
<!--            if (str.length > 0) {-->
<!--                var conf = confirm('Bạn có muốn đưa các bản ghi này vào thùng rác hay không?');-->
<!--                if (conf === true) {-->
<!--                    $.ajax({-->
<!--                        url: '@Url.Action("GoToTrashAll", "Supplier")',-->
<!--                        type: 'POST',-->
<!--                        data: { ids: str },-->
<!--                        success: function (rs) {-->
<!--                            if (rs.success) {-->
<!--                                location.reload();-->
<!--                            }-->
<!--                        }-->
<!--                    });-->
<!--                }-->
<!--            }-->
<!--        });-->
<!---->
<!--        $('body').on('change', '#SelectAll', function () {-->
<!--            var checkStatus = this.checked;-->
<!--            var checkbox = $(this).parents('.card-body').find('tr td input:checkbox');-->
<!--            checkbox.each(function () {-->
<!--                this.checked = checkStatus;-->
<!--            });-->
<!--        });-->
<!---->
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
<!--</script>-->
<?php
include('../includes/footer.html');
?>