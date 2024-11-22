<?php
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";

//Kết nối cơ sở dữ liệu
$connect = mysqli_connect("localhost", "root", "", "qlbandienthoai")
OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error());

$msg = "";
$maKH = rand(10000000, 99999999);
$phanQuyen = "KH";

if (isset($_POST['dangKy'])) {
    $username = $_POST['username'];
    $pass = $_POST['password'];
    $pass_confirm = $_POST['confirm_password'];
    $hoTen  = $_POST['hoTen'];
    $gioitinh = $_POST['gioiTinh'];
    $diachi  = $_POST['diaChi'];
    $sodienthoai = $_POST['soDienThoai'];
    $email = $_POST['email'];
    if(empty($username))
        $msg = "<span class='text-danger font-weight-bold'>Tên đăng nhập không được để trống</span>";
    elseif(empty($pass))
        $msg = "<span class='text-danger font-weight-bold'>Mật khẩu không được để trống</span>";
    elseif(empty($pass_confirm))
        $msg = "<span class='text-danger font-weight-bold'>Mật khẩu xác nhận không được để trống</span>";
    elseif(empty($hoTen))
        $msg = "<span class='text-danger font-weight-bold'>Họ tên khách hàng không được để trống</span>";
    elseif(empty($diachi))
        $msg = "<span class='text-danger font-weight-bold'>Địa chỉ khách hàng không được để trống</span>";
    elseif(!isset($gioitinh)){
        $msg = "<span class='text-danger font-weight-bold'>Vui lòng chọn giới tính</span>";
    }
    elseif(empty($sodienthoai)){
        $msg = "<span class='text-danger font-weight-bold'>Số điện thoại không được để trống</span>";
    }
    elseif(empty($email)){
        $msg = "<span class='text-danger font-weight-bold'>Email không được để trống</span>";
    }
    else{
        // Kiểm tra mật khẩu có đúng định dạng không
        if (strlen($pass) < 6 || strlen($pass) > 10 || !preg_match('/[A-Z]/', $pass) || !preg_match('/[0-9]/', $pass) || !preg_match('/[\W_]/', $pass))
            $msg = "<span class='text-danger font-weight-bold'>Mật khẩu phải có độ dài từ 6 đến 10 ký tự, bao gồm chữ cái in hoa, chữ số và ký tự đặc biệt</span>";
        elseif ($pass !== $pass_confirm)
            // Kiểm tra mật khẩu xác nhận có khớp với mật khẩu không
            $msg = "<span class='text-danger font-weight-bold'>Mật khẩu xác nhận không khớp</span>";
        else{
            //Truy vấn tên đăng nhập trong cơ sở dữ liệu
            $check_username = "SELECT * FROM user WHERE username = '$username'";
            //Gửi truy vấn đến cơ sở dữ liệu
            $result_username = mysqli_query($connect, $check_username);
            //Kiểm tra nếu có một dòng kết quả (tức là tên tài khoản vừa nhập khớp với tên tài khoản trong cơ sở dữ liệu).
            if (mysqli_num_rows($result_username) != 0) {
                $msg = "<span class='text-danger font-weight-bold'>Tên đăng nhập đã tồn tại. Vui lòng nhập tên đăng nhập khác!</span>";
            } else {
                //Thêm thông tin khách hàng vào bảng khách hàng
                $sql_Insert_KH = "INSERT INTO khach_hang (ma_khach_hang, ten_khach_hang, gioiTinh, dia_chi, so_dien_thoai, email) VALUES ('$maKH', '$hoTen', '$gioitinh', '$diachi', '$sodienthoai', '$email')";
                mysqli_query($connect, $sql_Insert_KH);
                //Thêm mới tài khoản
                $sql = "INSERT INTO user (username, password, user_id) VALUES ('$username', '$pass', '$maKH')";
                if (mysqli_query($connect, $sql)){
                    echo "<script>
                        alert('Đăng ký tài khoản thành công');
                        window.location.href = '$base_url/trangbanhang/dangnhap.php';
                    </script>";
                }
                else
                    $msg = "<span class='text-danger font-weight-bold'>Đã có lỗi trong quá trình đăng ký</span>";
            }
        }

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trang đăng ký</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>/Content/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>/Content/assets/dist/css/adminlte.min.css">
    <style>
        body{
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: url(../Images/wallpaper3.jpg) no-repeat;
            background-size: cover;
            background-position: center;
        }
        .login-container{
            max-width: 500px;
            margin: 0 auto;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        #toggle-password{
            cursor: pointer;
        }
        #toggle-password-confirm{
            cursor: pointer;
        }
    </style>
</head>

<body class="hold-transition login-container">
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <div class="col-md-12">
                <div class="login-logo">
                    <a href="#" style="font-weight: bold; color: black;">MEGA<span style="color: deepskyblue;">TECH</span></a>
                </div>
            </div>
            <h5 class="login-box-msg font-weight-bold">Đăng ký tài khoản khách hàng</h5>
            <form action="" method="post">
                <fieldset>
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>Mã khách hàng <span class="text-danger">*</span></label>
                                            <input class="form-control" value="<?php echo $maKH; ?>" autofocus readonly/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>Tên tài khoản <span class="text-danger">*</span></label>
                                            <input class="form-control" placeholder="Tên đăng nhập" name="username" type="text" value="<?php echo $_POST['username'] ?? ''; ?>" autofocus />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>Mật khẩu <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input class="form-control" id="password" name="password" type="password" placeholder="Mật khẩu">
                                                <div class="input-group-append">
                                            <span class="input-group-text" id="toggle-password" onclick="togglePassword('password', 'toggle-password')">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-group-default">
                                            <label>Xác nhận mật khẩu <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input class="form-control" id="confirm_password" name="confirm_password" type="password" placeholder="Xác nhận mật khẩu">
                                                <div class="input-group-append">
                                            <span class="input-group-text" id="toggle-password-confirm" onclick="togglePassword('confirm_password', 'toggle-password-confirm')">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group form-group-default">
                            <label>Họ tên <span class="text-danger">*</span></label>
                            <input class="form-control" placeholder="Họ tên khách hàng" name="hoTen" type="text" autofocus value="<?php if(isset($_POST['hoTen'])) echo $hoTen; ?>"/>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label>Giới tính <span class="text-danger">*</span></label>
                                    <select name="gioiTinh" class="custom-select form-control select">
                                        <option value="1" <?php if(isset($_POST['gioiTinh']) && $_POST['gioiTinh'] == "1") echo 'selected'; ?>>Nam</option>
                                        <option value="0" <?php if(isset($_POST['gioiTinh']) && $_POST['gioiTinh'] == "0") echo 'selected'; ?>>Nữ</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label>Số điện thoại <span class="text-danger">*</span></label>
                                    <input class="form-control" placeholder="Số điện thoại" name="soDienThoai" type="text" autofocus value="<?php if(isset($_POST['soDienThoai'])) echo $sodienthoai; ?>"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label>Địa chỉ <span class="text-danger">*</span></label>
                                    <input class="form-control" placeholder="Địa chỉ" name="diaChi" type="text" autofocus value="<?php if(isset($_POST['diaChi'])) echo $diachi; ?>"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label>Email <span class="text-danger">*</span></label>
                                    <input class="form-control" placeholder="Email" name="email" type="text" autofocus value="<?php if(isset($_POST['email'])) echo $email; ?>"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-default text-center font-weight-bold">
                        <p class="text-success"><?php echo $msg;?></p>
                    </div>
                    <!-- /.col -->
                    <div class="col-12">
                        <button type="submit" name="dangKy" class="btn btn-success btn-block">Đăng ký</button>
                    </div>
                    <!-- /.col -->
                </fieldset>
            </form>
            <!-- /.col -->
            <div class="col-12 mt-3 text-center">
                <span>Bạn đã có tài khoản?</span>
                <a href="<?php echo $base_url; ?>/trangbanhang/dangnhap.php" type="submit">Đăng nhập ngay</a>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.login-card-body -->
    </div>
<!-- /.login-box -->
<!-- jQuery -->
<script src="<?php echo $base_url; ?>/Content/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo $base_url; ?>/Content/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo $base_url; ?>/Content/assets/dist/js/adminlte.min.js"></script>
    <!-- JavaScript to toggle password visibility -->
    <script>
        function togglePassword(passwordFieldId, toggleButtonId) {
            var passwordField = document.getElementById(passwordFieldId);
            var icon = document.getElementById(toggleButtonId).getElementsByTagName('i')[0];

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>

