<?php
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";

//Kết nối cơ sở dữ liệu
$connect = mysqli_connect("localhost", "root", "", "qlbandienthoai")
OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error());

$msg = "";

if (isset($_POST['doiMK'])) {
    $username = $_POST['username'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_new_pass = $_POST['confirm_new_pass'];
    //Kiểm tra tên đăng nhập, mật khẩu có để trống không?
    if (empty($username))
        $msg = "<span class='text-danger font-weight-bold'>Vui lòng nhập tên tài khoản</span>";
    elseif (empty($current_password))
        $msg = "<span class='text-danger font-weight-bold'>Vui lòng nhập mật khẩu hiện tại</span>";
    elseif (empty($new_password))
        $msg = "<span class='text-danger font-weight-bold'>Vui lòng nhập mật khẩu mới</span>";
    elseif (empty($confirm_new_pass))
        $msg = "<span class='text-danger font-weight-bold'>Vui lòng nhập xác nhận mật khẩu mới</span>";
    else{
        // Kiểm tra mật khẩu hiện tại có đúng với mật khẩu tài khoản trong cơ sở dữ liệu hay không?
        $check_current_pass = "SELECT * FROM user WHERE username = '$username' AND password = '$current_password'";
        $result_current_pass = mysqli_query($connect, $check_current_pass);
        if (mysqli_num_rows($result_current_pass) == 0)
            $msg = "<span class='text-danger font-weight-bold'>Mật khẩu hiện tại của tài khoản không hợp lệ!</span>";
        else {
            // Kiểm tra mật khẩu mới có đúng định dạng không
            if (strlen($new_password) < 6 || !preg_match('/[A-Z]/', $new_password) || !preg_match('/[0-9]/', $new_password) || !preg_match('/[\W_]/', $new_password))
                $msg = "<span class='text-danger font-weight-bold'>Mật khẩu mới phải có độ dài từ 6 ký tự trở lên, bao gồm chữ cái in hoa, chữ số và ký tự đặc biệt</span>";
            elseif ($new_password !== $confirm_new_pass)
                // Kiểm tra mật khẩu xác nhận có khớp với mật khẩu không
                $msg = "<span class='text-danger font-weight-bold'>Mật khẩu xác nhận không khớp</span>";
            else{
                // Cập nhật mật khẩu mới
                $sql = "UPDATE user SET password = '$new_password' WHERE username = '$username'";
                if (mysqli_query($connect, $sql))
                    $msg = "<span class='text-success font-weight-bold'>Cập nhật mật khẩu thành công</span>";
                else
                    $msg = "<span class='text-danger font-weight-bold'>Đã có lỗi trong quá trình đổi mật khẩu</span>";
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
    <title>Trang đổi mật khẩu</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>/Content/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>/Content/assets/dist/css/adminlte.min.css">
    <style>
        #toggle-current-password, #toggle-new-password, #toggle-confirm-new-pass{
            cursor: pointer;
        }
        body{
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: url(../Images/wallpaper.jpg) no-repeat;
            background-size: cover;
            background-position: center;
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
                    <a href="/admin" style="font-weight: bold; color: black;">MEGA<span style="color: deepskyblue;">TECH</span></a>
                </div>
                <h6 class="login-box-msg font-weight-bold">Đổi mật khẩu tài khoản</h6>
            </div>
            <form action="" method="post">
                <fieldset>
                    <div class="form-group form-group-default">
                        <label>Tên tài khoản <span class="text-danger">*</span></label>
                        <input class="form-control" placeholder="Tên đăng nhập" name="username" type="text" autofocus value="<?php echo $_POST['username'] ?? ''; ?>"/>
                    </div>
                    <div class="form-group form-group-default">
                        <label>Mật khẩu hiện tại <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input class="form-control" id="current_password" placeholder="Mật khẩu" name="current_password" type="password" value="<?php echo $_POST['current_password'] ?? ''; ?>"/>
                            <div class="input-group-append">
                                <span class="input-group-text" id="toggle-current-password" onclick="togglePassword('current_password', 'toggle-current-password')">
                                <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-default">
                        <label>Mật khẩu mới <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input class="form-control" id="new_password" placeholder="Mật khẩu mới" name="new_password" type="text" autofocus value="<?php echo $_POST['new_password'] ?? ''; ?>"/>
                            <div class="input-group-append">
                                <span class="input-group-text" id="toggle-new-password" onclick="togglePassword('new_password', 'toggle-new-password')">
                                <i class="fas fa-eye"></i>
                                </span>
                            </div>

                        </div>
                    </div>
                    <div class="form-group form-group-default">
                        <label>Xác nhận mật khẩu mới</label><span class="text-danger">*</span>
                        <div class="input-group">
                            <input class="form-control" id="confirm_new_pass" placeholder="Xác nhận mật khẩu mới" name="confirm_new_pass" type="text" autofocus value="<?php echo $_POST['confirm_new_pass'] ?? ''; ?>"/>
                            <div class="input-group-append">
                                <span class="input-group-text" id="toggle-confirm-new-pass" onclick="togglePassword('confirm_new_pass', 'toggle-confirm-new-pass')">
                                    <i class="fas fa-eye"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-group-default text-center font-weight-bold">
                        <p class="text-success"><?php echo $msg;?></p>
                    </div>
                    <!-- /.col -->
                    <div class="col-12">
                        <button type="submit" name="doiMK" class="btn btn-warning btn-block">Đổi mật khẩu</button>
                    </div>
                    <!-- /.col -->
                </fieldset>
            </form>
            <!-- /.col -->
            <!-- /.col -->
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
</body>
</html>

