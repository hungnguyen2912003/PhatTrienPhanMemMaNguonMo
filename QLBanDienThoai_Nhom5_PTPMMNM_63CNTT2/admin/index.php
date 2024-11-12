<?php
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
include('../timeOutSession.php');

if (!isset($_SESSION['logged']) || !$_SESSION['logged']) {
    header("Location: login.php");
    exit;
} else {
    include('includes/header.html');
    include('_PartialSideBar.html');
    echo "<div class='main-panel'>";
    include('home.html');
    echo "</div>";
    include('includes/footer.html');

    $hoTenNV = $_SESSION['hoTen'] ?? null;
    // Kiểm tra nếu thông báo chào mừng chưa hiển thị
    $showWelcome = false;
    if (isset($_SESSION['logged_kh']) && $_SESSION['logged_kh'] === true && !isset($_SESSION['welcome_shown'])) {
        $showWelcome = true;
        $_SESSION['welcome_shown'] = true; // Đánh dấu đã hiển thị thông báo
    }
}
?>
<?php if ($showWelcome): ?>
    <!-- Modal chào mừng người dùng -->
    <script>
        $(document).ready(function() {
            alert("Chào mừng <?php echo $hoTenNV; ?> đến với Shop bán điện thoại MEGATECH");
        });
    </script>
<?php endif; ?>