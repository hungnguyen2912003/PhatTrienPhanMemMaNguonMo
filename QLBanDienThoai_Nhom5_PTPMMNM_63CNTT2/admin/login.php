<?php
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
//Khởi động phiên làm việc (session) để lưu trữ thông tin đăng nhập nếu người dùng đăng nhập thành công.
session_start();

$msg = "";

//Kết nối cơ sở dữ liệu
$connect = mysqli_connect("localhost", "root", "", "qlbandienthoai")
OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error());

//////////////////////////////////////////////////////////////////
/// Kiểm tra biến Session đăng nhập
/// Kiểm tra xem biến phiên $_SESSION['logged'] đã tồn tại và có giá trị true hay chưa
if (isset($_SESSION['logged']) && $_SESSION['logged'] === true) {
    $redirect_url = $_SESSION['redirect_to'] ?? $base_url . '/admin/index.php';
    // Xóa redirect_to để tránh bị lặp lại khi chuyển hướng
    unset($_SESSION['redirect_to']);
    header("Location: $redirect_url");
    exit;
}

//////////////////////////////////////////////////////////////////
/// Kiểm tra thông tin đăng nhập
if (isset($_POST['dangNhap'])) {
    // Gán giá trị từ sticky form vào các biến $user và $pass
    $username = $_POST['username'];
    $pass = $_POST['password'];

    // Kiểm tra tên đăng nhập và mật khẩu không được để trống
    if(empty($username))
        $msg = "<span class='text-danger font-weight-bold'>Vui lòng nhập tên tài khoản</span>";
    elseif(empty($pass))
        $msg = "<span class='text-danger font-weight-bold'>Vui lòng nhập mật khẩu</span>";
    else {
        // Kiểm tra tài khỏan, mật khẩu
        $sql_check_account = "SELECT * FROM user WHERE username = '$username' AND password = '$pass'";
        $result_check_account = mysqli_query($connect, $sql_check_account);
        // Kiểm tra quyền
        $sql_check_quyen = "SELECT * FROM user WHERE username = '$username' AND phanQuyen IN ('ADMIN', 'NV')";
        $result_check_quyen = mysqli_query($connect, $sql_check_quyen);

        if(mysqli_num_rows($result_check_account) == 0) {
            $msg = "<span class='text-danger font-weight-bold'>Tên tài khoản hoặc mật khẩu không hợp lệ</span>";
        }
        elseif (mysqli_num_rows($result_check_quyen) == 0) {
            $msg = "<span class='text-danger font-weight-bold'>Tài khoản của bạn không có quyền đăng nhập</span>";
        }
        // Tên đăng nhập và mật khẩu trùng khớp với tên đăng nhập và mật khẩu trong CSDL.
        if(empty($msg)){
            // Gán vào phiên $_SESSION['logged'] là true
            $_SESSION['logged'] = true;
            // Truy vấn thông tin người dùng tài khoản
            $sql = "SELECT CONCAT(nhan_vien.hoNV, ' ', nhan_vien.tenlot, ' ', nhan_vien.tenNV) AS hoTen, user.phanQuyen AS phanQuyen, user.user_id AS USERID 
                    FROM user 
                    INNER JOIN nhan_vien ON user.user_id = nhan_vien.id 
                    WHERE user.username = '$username'";
            $result = mysqli_query($connect, $sql);
            $row = mysqli_fetch_array($result);
            $_SESSION['hoTen'] = $row['hoTen'];
            $_SESSION['phanQuyen'] = $row['phanQuyen'];
            $_SESSION['id'] = $row['USERID'];
            // Chuyển hướng về trang yêu cầu sau khi đăng nhập thành công
            $redirect_url = $_SESSION['redirect_to'] ?? $base_url . '/admin/index.php';
            // Xóa redirect_to để tránh vòng lặp
            unset($_SESSION['redirect_to']);
            header("Location: $redirect_url");
            exit;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trang đăng nhập</title>

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
            background: url(../Images/wallpaper4.jpg) no-repeat;
            background-size: cover;
            background-position: center;
        }
        #toggle-password{
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
            <h5 class="login-box-msg font-weight-bold">Đăng nhập tài khoản</h5>
            <form action="" method="post">
                <fieldset>
                    <div class="form-group form-group-default">
                        <label>Tên tài khoản <span class="text-danger">*</span></label>
                        <input class="form-control" placeholder="Tên đăng nhập" name="username" type="text" autofocus value="<?php echo $_POST['username'] ?? ''; ?>"/>
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
                    <div class="form-group form-action-d-flex mb-3">
                        <div class="col-12 d-flex justify-content-between">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="rememberme">
                                <label class="custom-control-label m-0" for="rememberme">Nhớ tài khoản</label>
                            </div>
                            <div>
                                <label>
                                    <a href="<?php echo $base_url; ?>/admin/changepassword.php" class="link float-right">Đổi mật khẩu</a>
                                </label>
                            </div>
                        </div>

                    </div>
                    <div class="form-group form-group-default text-center">
                        <p class="text-danger"><?php echo $msg;?></p>
                        <?php
                            //Kiểm tra tồn tại biến timeout đã tồn tại và nó bằng true hay chưa? Để hiển thị thông báo hết phiên làm việc
                            if (isset($_GET['timeout']) && $_GET['timeout'] == 'true') {
                                echo "<span class='text-warning font-weight-bold text-center'>Phiên làm việc đã hết hạn. Vui lòng đăng nhập để tiếp tục hoạt động!</span>";
                            }
                        ?>
                    </div>
                    <!-- /.col -->
                    <div class="col-12">
                        <button id="btnDangNhap" type="submit" name="dangNhap" class="btn btn-primary btn-block">Đăng nhập</button>
                    </div>
                    <!-- /.col -->
                </fieldset>
            </form>
            <!-- /.col -->
            <div class="col-12 mt-3 text-center">
                <span>Bạn chưa có tài khoản?</span>
                <a href="<?php echo $base_url; ?>/admin/register.php" type="submit">Đăng ký ngay</a>
            </div>
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

