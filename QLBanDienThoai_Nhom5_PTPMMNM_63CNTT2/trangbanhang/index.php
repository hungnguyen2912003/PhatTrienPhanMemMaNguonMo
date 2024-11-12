<?php
include('../timeOutSession.php');
$title = "Trang bán hàng MEGATECH";
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
$hoTenKH = $_SESSION['hoTenKH'] ?? null;
$hoTenNV = $_SESSION['hoTenNV'] ?? null;

// Kiểm tra nếu thông báo chào mừng chưa hiển thị
$showWelcome = false;
if (isset($_SESSION['logged_kh']) && $_SESSION['logged_kh'] === true && !isset($_SESSION['welcome_shown'])) {
    $showWelcome = true;
    $_SESSION['welcome_shown'] = true; // Đánh dấu đã hiển thị thông báo
}
?>

<?php include('includes/header.html'); ?>

<div class="main-panel">
    <?php include ('home.html'); ?>
</div>

<?php include 'includes/footer.html'; ?>

<?php if ($showWelcome): ?>
    <!-- Modal chào mừng người dùng -->
    <script>
        $(document).ready(function() {
            <?php if ($hoTenKH): ?>
            alert("Chào mừng <?php echo $hoTenKH; ?> đến với Shop bán điện thoại MEGATECH");
            <?php elseif ($hoTenNV): ?>
            alert("Chào mừng <?php echo $hoTenNV; ?> đến với Shop bán điện thoại MEGATECH");
            <?php endif; ?>
        });
    </script>
<?php endif; ?>
