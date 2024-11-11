<?php
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
$title = "Trang liên hệ MEGATECH";
include('../timeOutSession.php');
?>
<?php
include('includes/header.html');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href="<?php echo $base_url; ?>/css/contactstyle.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="<?php echo $base_url; ?>/Content/assets/styles/main_styles.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="main-panel">

        <section class="contact" id="contact">
            <section class="banner">
                <h1 class="text-white" style="color: white">LIÊN HỆ VỚI CHÚNG TÔI</h1>
            </section>

            <div class="row">
                <div class="mess">
                    <p><?php echo $_SESSION['redirect_to'];?></p>
                    <form action="">
                        <h2>GỬI TIN NHẮN</h2>
                        <input type="text" placeholder="Họ và tên" class="box">
                        <input type="email" placeholder="Email" class="box">
                        <textarea name="" class="box" placeholder="Lời nhắn" id="" cols="30" rows="10"></textarea>
                        <input type="submit" value="Gửi" class="btn">
                    </form>
                </div>

                <div class="info">
                    <form action="">
                        <h2>LIÊN HỆ</h2>
                        <span class="nd">
                            Bất kỳ khi nào bạn cần, đừng ngần ngại liên hệ với chúng tôi qua email, điện thoại, biểu mẫu liên hệ trên trang web của chúng tôi.
                            <br>Chúng tôi mong được nghe từ bạn!
                        </span>
                        <div>
                            <i class='bx bx-location-plus'></i>
                            <div class="address-container">
                                <span class="label">Địa chỉ</span>
                                <span class="address">Bà Rịa - Vũng Tàu</span>
                            </div>
                        </div>
                        <div>
                            <i class='bx bx-envelope'></i>
                            <div class="address-container">
                                <span class="label">Email</span>
                                <span class="address">Megatech@gmail.com</span>
                            </div>
                        </div>
                        <div>
                            <i class='bx bx-phone-call'></i>
                            <div class="address-container">
                                <span class="label">Số điện thoại</span>
                                <span class="address">0933 428 095</span>
                            </div>
                        </div>

                        <div class="divider"></div>
                        <div class="follow">
                            <span>Theo dõi chúng tôi</span>
                            <div>
                                <i class='bx bxl-facebook-circle'></i>
                                <i class='bx bxl-instagram-alt'></i>
                                <i class='bx bxl-twitter'></i>
                                <i class='bx bxl-youtube'></i>
                            </div>

                        </div>


                    </form>
                </div>
            </div>
            <div class="map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.6923524263427!2d106.701755314287!3d10.762622792332962!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752ef3de6efb31%3A0xc1b3e5d0f3e4d88!2zUXXhuq1uIDcsIEPhu6sgU8OhY2gsIFTDom4gQ2jDrW5oIFBo4bunIFBow7osIEjDoCBB4buBdCB4buBIERp4buHbiwgVHLhuqduIFZp4buFbiBUcml!5e0!3m2!1svi!2s!4v1620218933523!5m2!1svi!2s"
                        width="100%"
                        height="300"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy">
                </iframe>
            </div>
            <div class="sub">
                <div class="gioithieu">

                    <h3>Khách hàng mới</h3>
                    <p>Đăng kí ngay để nhận voucher giảm giá lên đến 30%</p>
                </div>
                <div class="input-button">

                    <input type="text" placeholder="Nhập thông tin">

                    <button>Đăng Ký</button>
                </div>
            </div>



        </section>
    </div>
</body>
</html>

<?php include 'includes/footer.html'; ?>