<?php
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
include('thoihanSession.php');

if (!isset($_SESSION['logged']) || !$_SESSION['logged']) {
    header("Location: dangnhap.php");
    exit;
} else {
    include('includes/header.html');
    include('menu.html');
    echo "<div class='main-panel'>";
    include('home.html');
    echo "</div>";
    include('includes/footer.html');

    $hoTenNV = $_SESSION['hoTen'] ?? null;
    // Kiểm tra nếu thông báo chào mừng chưa hiển thị
    $showWelcome = false;
    if (isset($_SESSION['logged']) && $_SESSION['logged'] === true && !isset($_SESSION['welcome_shown2'])) {
        $showWelcome = true;
        $_SESSION['welcome_shown2'] = true; // Đánh dấu đã hiển thị thông báo
    }
}
?>
<?php if ($showWelcome): ?>
    <!-- Modal chào mừng người dùng -->
    <script>
        $(document).ready(function() {
            alert("Chào mừng <?php echo $hoTenNV; ?> đến với trang quản trị viên MEGATECH");
        });
    </script>
<?php endif; ?>