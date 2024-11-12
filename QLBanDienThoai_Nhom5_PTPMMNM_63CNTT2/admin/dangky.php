<?php
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";

//Kết nối cơ sở dữ liệu
$connect = mysqli_connect("localhost", "root", "", "qlbandienthoai")
OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error());

$msg = "";

if (isset($_POST['dangKy'])) {
    $username = $_POST['username'];
    $pass = $_POST['password'];
    $confirm_pass = $_POST['confirm_password'];
    $maNV = $_POST['maNV'];
    //Kiểm tra tên đăng nhập, mật khẩu và mã nhân viên có để trống không?
    if (empty($username))
        $msg = "<span class='text-danger font-weight-bold'>Vui lòng nhập tên tài khoản</span>";
    elseif (empty($pass))
        $msg = "<span class='text-danger font-weight-bold'>Vui lòng nhập mật khẩu</span>";
    elseif (empty($confirm_pass))
        $msg = "<span class='text-danger font-weight-bold'>Vui lòng nhập mật khẩu xác nhận</span>";
    elseif (empty($maNV))
        $msg = "<span class='text-danger font-weight-bold'>Vui lòng nhập mã nhân viên</span>";
    else {
        // Kiểm tra mật khẩu có đúng định dạng không
        if (strlen($pass) < 6 || strlen($pass) > 10 || !preg_match('/[A-Z]/', $pass) || !preg_match('/[0-9]/', $pass) || !preg_match('/[\W_]/', $pass))
            $msg = "<span class='text-danger font-weight-bold'>Mật khẩu phải có độ dài từ 6 đến 10 ký tự, bao gồm chữ cái in hoa, chữ số và ký tự đặc biệt</span>";
        elseif ($pass !== $confirm_pass)
            // Kiểm tra mật khẩu xác nhận có khớp với mật khẩu không
            $msg = "<span class='text-danger font-weight-bold'>Mật khẩu xác nhận không khớp</span>";
        else {
            // Kiểm tra mã nhân viên trong cơ sở dữ liệu
            $check_maNV = "SELECT * FROM nhan_vien WHERE id = '$maNV'";
            $result_maNV = mysqli_query($connect, $check_maNV);
            if (mysqli_num_rows($result_maNV) == 0)
                $msg = "<span class='text-danger font-weight-bold'>Mã nhân viên không tồn tại. Vui lòng kiểm tra lại.</span>";
            else {
                // Kiểm tra tên đăng nhập đã tồn tại trong cơ sở dữ liệu chưa
                $check_username = "SELECT * FROM user WHERE username = '$username'";
                $result_username = mysqli_query($connect, $check_username);
                if (mysqli_num_rows($result_username) != 0)
                    $msg = "<span class='text-danger font-weight-bold'>Tên đăng nhập đã tồn tại. Vui lòng nhập tên đăng nhập khác!</span>";
                else {
                    // Thêm mới tài khoản
                    $sql = "INSERT INTO user (username, password, user_id) VALUES ('$username', '$pass', '$maNV')";
                    if (mysqli_query($connect, $sql))
                        echo "<script>
                            alert('Đăng ký tài khoản thành công');
                            window.location.href = '$base_url/admin/dangnhap.php';
                        </script>";
                    else
                        $msg = "<span class='text-danger font-weight-bold'>Đã có lỗi trong quá trình đăng ký</span>";
                }
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
            background: url(../Images/wallpaper2.jpg) no-repeat;
            background-size: cover;
            background-position: center;
        }
        #toggle-password{
            cursor: pointer;
        }
        #toggle-password-confirm{
            cursor: pointer;
        }
    </style>
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <div class="col-md-12">
                <div class="login-logo">
                    <a href="#" style="font-weight: bold; color: black;">MEGA<span style="color: deepskyblue;">TECH</span></a>
                </div>
            </div>
            <h5 class="login-box-msg font-weight-bold">Đăng ký tài khoản nhân viên</h5>
            <form action="" method="post">
                <fieldset>
                    <div class="form-group form-group-default">
                        <label>Tên tài khoản <span class="text-danger">*</span></label>
                        <input class="form-control" placeholder="Tên đăng nhập" name="username" type="text" value="<?php echo $_POST['username'] ?? ''; ?>" autofocus />
                    </div>
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
                    <div class="form-group form-group-default">
                        <label>Mã nhân viên <span class="text-danger">*</span></label>
                        <input class="form-control" placeholder="Mã nhân viên" name="maNV" type="text" autofocus value="<?php echo $_POST['maNV'] ?? ''; ?>"/>
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
                <a href="<?php echo $base_url; ?>/admin/dangnhap.php" type="submit">Đăng nhập ngay</a>
            </div>
            <!-- /.col -->
            <div class="col-12 mt-3 text-center">
                <a id="backButton" href="javascript:window.history.back(-1);">Quay lại</a>
            </div>
        </div>
        <!-- /.login-card-body -->
    </div>
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
<script>
    // Kiểm tra nếu có trang trước đó để quay lại
    if (!document.referrer) {
        // Nếu không có trang trước đó, ẩn nút "Quay lại"
        document.getElementById("backButton").style.display = "none";
    }
</script>
</body>
</html>


