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
        background-color: rgba(255, 255, 255, 0.8);
        color: red;
        font-weight: bold;
        padding: 15px 15px;
        z-index: 2;
        width: 100%;
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
                    $connect = mysqli_connect("localhost", "root", "", "qlbandienthoai") OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error());

                    $sql = "SELECT * FROM san_pham";
                    $result = mysqli_query($connect, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        // Lặp qua các sản phẩm
                        while ($row = mysqli_fetch_assoc($result)) {
                            $soLuong = $row['soLuong'];
                            $image = $row['hinhAnh'];
                            $tensp = $row['ten_sp'];
                            $giaBan = $row['giaBan'];
                            ?>
                            <!-- Product Item -->
                            <div class="product-item" data-quantity="<?php echo $soLuong; ?>">
                                <div class="product discount product_filter">
                                    <div class="product_image text-center">
                                        <img src="<?php echo $base_url; ?>/Images/<?php echo $image; ?>" alt="<?php echo $tensp; ?>" style="width: auto; height: 200px;">
                                    </div>
                                    <div class="favorite favorite_left"></div>
                                    <div class="product_info">
                                        <h6 class="product_name"><a href="#"><?php echo $tensp; ?></a></h6>
                                        <div class="product_price"><?php echo number_format($giaBan, 0); ?>₫</div>
                                        <p>Số lượng còn: <?php echo $soLuong; ?></p>
                                    </div>
                                </div>
                                <div class="red_button add_to_cart_button"><a href="#" class="btnAddToCart">Thêm vào giỏ hàng</a></div>
                            </div>
                            <?php
                        }
                    } else {
                        echo "Không có sản phẩm nào.";
                    }

                    // Đóng kết nối
                    mysqli_close($connect);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
