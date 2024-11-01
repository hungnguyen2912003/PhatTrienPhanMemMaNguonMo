<?php
include('../includes/header.html');
?>

<!-- Sidebar -->
<?php
include ('../_PartialSideBar.html');
?>

<div class="main-panel">
    <?php
        include('../nhan_vien/home.html');
    ?>
</div>
<!-- /.content -->

<!--    @section scripts{-->
<!---->
<!--    <script>-->
<!--        $(document).ready(function () {-->
<!--            $('body').on('click', '#BtnTrashAll', function (e) {-->
<!--                e.preventDefault();-->
<!---->
<!--                var checkbox = $(this).parents('.card').find('tr td input:checkbox');-->
<!--                var checkedCheckbox = checkbox.filter(':checked');-->
<!---->
<!--                // Kiểm tra xem có checkbox nào được chọn không-->
<!--                if (checkedCheckbox.length === 0) {-->
<!--                    // Hiển thị cảnh báo-->
<!--                    alert('Bạn cần phải tích vào Checkbox của ít nhất một danh mục để sử dụng chức năng này!');-->
<!--                    return;-->
<!--                }-->
<!---->
<!--                var str = "";-->
<!--                var i = 0;-->
<!--                checkbox.each(function () {-->
<!--                    if (this.checked) {-->
<!--                        var _id = $(this).val();-->
<!--                        if (i === 0) {-->
<!--                            str += _id;-->
<!--                        } else {-->
<!--                            str += "," + _id;-->
<!--                        }-->
<!--                        i++;-->
<!--                    } else {-->
<!--                        checkbox.attr('selected', '');-->
<!--                    }-->
<!--                });-->
<!--                if (str.length > 0) {-->
<!--                    var conf = confirm('Bạn có muốn đưa các bản ghi này vào thùng rác hay không?');-->
<!--                    if (conf === true) {-->
<!--                        $.ajax({-->
<!--                            url: '@Url.Action("GoToTrashAll", "NhanVien")',-->
<!--                            type: 'POST',-->
<!--                            data: { ids: str },-->
<!--                            success: function (rs) {-->
<!--                                if (rs.success) {-->
<!--                                    location.reload();-->
<!--                                }-->
<!--                            }-->
<!--                        });-->
<!--                    }-->
<!--                }-->
<!--            });-->
<!--            $('body').on('change', '#SelectAll', function () {-->
<!--                var checkStatus = this.checked;-->
<!--                var checkbox = $(this).parents('.card-body').find('tr td input:checkbox');-->
<!--                checkbox.each(function () {-->
<!--                    this.checked = checkStatus;-->
<!--                    if (this.checked) {-->
<!--                        checkbox.attr('selected', 'checked');-->
<!--                    } else {-->
<!--                        checkbox.attr('selected', '');-->
<!--                    }-->
<!--                });-->
<!--            });-->
<!--            // Hàm để ẩn thông báo sau 5 giây-->
<!--            function hideMessage() {-->
<!--                $('.message-container').fadeOut(); // Ẩn thông báo-->
<!--            }-->
<!---->
<!--            // Nếu có thông báo, thiết lập timeout để tự động ẩn sau 5 giây-->
<!--            if ($('.message-container').length) {-->
<!--                setTimeout(hideMessage, 5000); // 5000 milliseconds = 5 seconds-->
<!--            }-->
<!--        });-->
<!---->
<!--    </script>-->
<!--    }-->

<?php
    include('../includes/footer.html');
?>

