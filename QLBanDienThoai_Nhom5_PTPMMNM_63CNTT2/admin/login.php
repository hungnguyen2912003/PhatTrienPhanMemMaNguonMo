<?php
$base_url = "/PhatTrienPhanMemMaNguonMo/QLBanDienThoai_Nhom5_PTPMMNM_63CNTT2";
//Khởi động phiên làm việc (session) để lưu trữ thông tin đăng nhập nếu người dùng đăng nhập thành công.
session_start();

//Kết nối cơ sở dữ liệu
$connect = mysqli_connect("localhost", "root", "", "qlbandienthoai")
OR die ('Không thể kết nối MySQL: ' . mysqli_connect_error());

//Kiểm tra đã login chưa?
if (isset($_SESSION['logged']) && $_SESSION['logged'] === true) {
    header("Location: index.php");
    exit;
}

$error = "";

if (isset($_POST['dangNhap'])) {
    //Kiểm tra tên đăng nhập và mật khẩu không được để trống
    if(!empty($_POST['username']) && !empty($_POST['password'])) {
        //Gán giá trị từ sticky form vào các biến $user và $pass
        $user = mysqli_real_escape_string($connect, $_POST['username']);
        $pass = mysqli_real_escape_string($connect, $_POST['password']);
        //Truy vấn tài khoản và mật khẩu
        $query = "SELECT * FROM tai_khoan WHERE tenTaiKhoan = '$user' AND matKhau = '$pass'";

        //Gửi truy vấn đến cơ sở dữ liệu, và kết quả được lưu vào $result
        $result = mysqli_query($connect, $query);

        //Kiểm tra nếu có một dòng kết quả (tức là tài khoản và mật khẩu khớp với một tài khoản trong cơ sở dữ liệu).
        if (mysqli_num_rows($result) == 1) {

            //mysqli_fetch_assoc: lấy một hàng dữ liệu từ kết quả của truy vấn
            $user_data = mysqli_fetch_assoc($result);
            $_SESSION['logged'] = true;
            $_SESSION['username'] = $user_data['tenTaiKhoan'];
            $_SESSION['tenhienthi'] = $user_data['tenHienThi'];

            //Kiểm tra xem có biến phiên redirect_to không?
            //Nếu có, sẽ chuyển hướng đến trang mà người dùng muốn truy cập trước khi đăng nhập;
            //Nếu không, chuyển hướng mặc định đến index.php
            $redirect_to = isset($_SESSION['redirect_to']) ? $_SESSION['redirect_to'] : 'index.php';
            //Xóa biến redirect_to để tránh ảnh hưởng đến các lần đăng nhập tiếp theo.
            unset($_SESSION['redirect_to']);
            header("Location: $redirect_to");
            exit;
        } else {
            //Sai tài khoản hoặc mật khẩu
            $error = "Tên đăng nhập hoặc mật khẩu không chính xác.";
        }
    }
    else
        $error = "Tài khoản và mật khẩu không được để trống";
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
    <link rel="stylesheet" href="<?php echo $base_url; ?>/Content/assets/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>/Content/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>/Content/assets/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="/admin" style="font-weight: bold; color: black;">MEGA<span style="color: deepskyblue;">TECH</span></a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Đăng nhập vào trang quản trị viên</p>
            <form action="" method="post">
                <fieldset>
                    <div class="form-group form-group-default">
                        <label>Tên tài khoản</label>
                        <input class="form-control" placeholder="Tên đăng nhập" name="username" type="text" autofocus />
                    </div>
                    <div class="form-group form-group-default">
                        <label>Mật khẩu</label>
                        <input class="form-control" placeholder="Mật khẩu" name="password" type="password" value="" />
                    </div>
                    <div class="form-group form-action-d-flex mb-3">
                        <div class="col-12 d-flex justify-content-between">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="rememberme">
                                <label class="custom-control-label m-0" for="rememberme">Nhớ tài khoản</label>
                            </div>
                            <div>
                                <label>
                                    <a href="<?php echo $base_url; ?>/admin/changepassword.php" class="link float-right">Quên mật khẩu?</a>
                                </label>
                            </div>
                        </div>

                    </div>
                    <div class="form-group form-group-default">
                        <p class="text-danger"><?php echo $error;?></p>
                        <?php
                            if (isset($_GET['timeout']) && $_GET['timeout'] == 'true') {
                                echo "<p class='text-danger' style='text-align: center;'>Bạn cần đăng nhập lại để tiếp tục hoạt động!</p>";
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
</body>
</html>

