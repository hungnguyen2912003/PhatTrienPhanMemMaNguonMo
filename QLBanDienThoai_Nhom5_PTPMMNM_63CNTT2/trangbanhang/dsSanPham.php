<?php
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
?>
<style>
    .add_to_cart_button a:hover {
        text-decoration: none;
        color: white;
    }

    .out-of-stock {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: rgba(255, 255, 255, 0.8); /* Màu nền trong suốt */
        color: red;
        font-weight: bold;
        padding: 15px 15px; /* Tăng độ dài ngang */
        z-index: 2; /* Đảm bảo nó hiển thị trên hình ảnh sản phẩm */
        width: 100%; /* Bề ngang mở rộng ra tận khung */
        text-align: center;
        font-size: 20px;
    }
</style>

<div class="new_arrivals">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="product-grid" data-isotope='{ "itemSelector": ".product-item", "layoutMode": "fitRows" }'>
                    <?php
                    // Kết nối cơ sở dữ liệu
                    $conn = new mysqli("localhost", "root", "", "qlbandienthoai");

                    // Kiểm tra kết nối
                    if ($conn->connect_error) {
                        die("Kết nối thất bại: " . $conn->connect_error);
                    }

                    // Truy vấn lấy thông tin sản phẩm
                    $sql = "SELECT * FROM san_pham"; // Bạn cần thay đổi tên bảng và cột cho phù hợp
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        // Lặp qua các sản phẩm
                        while ($row = $result->fetch_assoc()) {
                            $soLuong = $row['soLuong'];
                            $image = $row['hinhAnh'];
                            $tensp = $row['ten_sp'];
                            $giaBan = $row['giaBan'];
                            $maSanPham = $row['ma_sp'];
                            ?>
                            <!-- Product Item -->
                            <div class="product-item" data-quantity="<?php echo $soLuong; ?>">
                                <div class="product discount product_filter">
                                    <div class="product_image">
                                        <img src="<?php echo $base_url; ?>/Images/<?php echo $image; ?>" alt="<?php echo $tensp; ?>">
                                        <?php if ($soLuong <= 0) { ?>
                                            <div class="out-of-stock">Hết hàng</div>
                                        <?php } ?>
                                    </div>
                                    <div class="favorite favorite_left"></div>
                                    <div class="product_info">
                                        <h6 class="product_name"><a href="#"><?php echo $tensp; ?></a></h6>
                                        <div class="product_price"><?php echo number_format($giaBan, 0); ?>₫</div>
                                        <p>Số lượng còn: <?php echo $soLuong; ?></p>
                                    </div>
                                </div>
                                <?php if ($soLuong > 0) { ?>
                                    <div class="red_button add_to_cart_button"><a href="#" class="btnAddToCart" data-id="<?php echo $maSanPham; ?>">Thêm vào giỏ hàng</a></div>
                                <?php } ?>
                            </div>
                            <?php
                        }
                    } else {
                        echo "Không có sản phẩm nào.";
                    }

                    // Đóng kết nối
                    $conn->close();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
