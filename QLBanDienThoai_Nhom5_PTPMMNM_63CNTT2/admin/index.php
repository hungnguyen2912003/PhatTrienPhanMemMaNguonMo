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
}
?>
